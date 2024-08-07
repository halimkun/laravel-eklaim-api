<?php

namespace Halim\EKlaim\Helpers;

use Illuminate\Http\Request;

class ClaimDataParser
{
    /**
     * Memproses data klaim dari request dan mengembalikan array data yang sudah diproses.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public static function parse(Request $request)
    {
        $data = [];

        self::parseOptionalData($request, $data);
        self::handleKelarRawatData($request, $data);
        self::handleUpgradeClassData($request, $data);
        self::handleIcuData($request, $data);
        self::handleDiagnosisAndProcedureData($request, $data);
        self::handleTarifRsData($request, $data);
        self::handlePelayananDarahData($request, $data);
        self::handlePersalinanData($request, $data);

        return $data;
    }

    /**
     * Memproses data optional dari request dan menyimpannya dalam array data.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $data
     * @return void
     */
    protected static function parseOptionalData(Request $request, array &$data)
    {
        $optionalFields = [
            'tgl_masuk', 'tgl_pulang', 'cara_masuk', 'jenis_rawat',
            'adl_sub_acute', 'adl_chronic', 'birth_weight', 'sistole',
            'diastole',  'discharge_status', 'terapi_konvalesen',
            'tarif_poli_eks', 'nama_dokter', 'kode_tarif'
        ];

        foreach ($optionalFields as $field) {
            if ($request->has($field)) {
                $data[$field] = $request->input($field);
            }
        }
    }

    /**
     * Menangani data terkait dengan jenis rawat dan melakukan validasi jika diperlukan.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $data
     * @return void
     */
    protected static function handleKelarRawatData(Request $request, array &$data)
    {
        if ($request->has('jenis_rawat')) {
            if ($request->jenis_rawat == 2) {
                $request->validate([
                    "kelas_rawat" => "in:1,3"
                ]);
            }
        }

        $data['kelas_rawat'] = $request->kelas_rawat;
    }

    /**
     * Menangani data upgrade class dan melakukan validasi jika diperlukan.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $data
     * @return void
     */
    protected static function handleUpgradeClassData(Request $request, array &$data)
    {
        $upgradeFields = ['upgrade_class_ind', 'upgrade_class_class', 'upgrade_class_los', 'add_payment_pct', 'upgrade_class_payor'];
        if ($request->hasAny($upgradeFields)) {
            $validationRules = array_fill_keys($upgradeFields, 'required');
            $request->validate($validationRules);

            foreach ($upgradeFields as $field) {
                $data[$field] = $request->input($field);
            }
        }
    }

    /**
     * Menangani data ICU dan ventilator, serta menghitung jam ventilator jika diperlukan.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $data
     * @return void
     */
    protected static function handleIcuData(Request $request, array &$data)
    {
        if ($request->icu_indikator == 1) {
            $request->validate([
                "icu_los" => "required|numeric",
            ]);

            $data['icu_los'] = $request->icu_los;

            // Handle ventilator data
            $ventilatorFields = ['use_ind', 'start_dttm', 'stop_dttm'];
            if ($request->hasAny($ventilatorFields)) {
                $validationRules = array_fill_keys($ventilatorFields, 'required');
                $request->validate($validationRules);

                foreach ($ventilatorFields as $field) {
                    $data['ventilator'][$field] = $request->input($field);
                }
            }

            // Calculate ventilator hours
            if (isset($data['ventilator']['start_dttm']) && isset($data['ventilator']['stop_dttm'])) {
                $start = new \DateTime($data['ventilator']['start_dttm']);
                $stop = new \DateTime($data['ventilator']['stop_dttm']);
                $diff = $start->diff($stop);
                $data['ventilator_hour'] = ceil($diff->h + ($diff->i / 60));
            }
        } else {
            $data['icu_indikator'] = 0;
            $data['icu_los'] = 0;
        }
    }

    /**
     * Menangani data diagnosis dan prosedur dengan menggabungkan nilai-nilai menjadi satu string.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $data
     * @return void
     */
    protected static function handleDiagnosisAndProcedureData(Request $request, array &$data)
    {
        $procedureFields = ['diagnosa', 'diagnosa_inagrouper', 'procedure', 'procedure_inagrouper'];
        foreach ($procedureFields as $field) {
            if ($request->has($field)) {
                $imploded = implode('#', $request->input($field));
                $data[$field] = $imploded;
            }
        }
    }

    /**
     * Menangani data tarif RS dengan mengumpulkan nilai-nilai tarif dalam array.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $data
     * @return void
     */
    protected static function handleTarifRsData(Request $request, array &$data)
    {
        $tarifRsFields = ['prosedur_non_bedah', 'prosedur_bedah', 'konsultasi', 'tenaga_ahli', 'keperawatan', 'penunjang', 'radiologi', 'laboratorium', 'pelayanan_darah', 'rehabilitasi', 'kamar', 'rawat_intensif', 'obat', 'obat_kronis', 'obat_kemoterapi', 'alkes', 'bmhp', 'sewa_alat'];
        foreach ($tarifRsFields as $trs) {
            if ($request->has($trs)) {
                $data['tarif_rs'][$trs] = $request->input($trs);
            }
        }
    }

    /**
     * Menangani data pelayanan darah dengan memvalidasi dan menyimpan jumlah kantong darah jika diperlukan.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $data
     * @return void
     */
    protected static function handlePelayananDarahData(Request $request, array &$data)
    {
        if ($request->has('pelayanan_darah') && $request->pelayanan_darah > 0) {
            $request->validate([
                'kantong_darah' => 'required|numeric',
            ]);

            $data['kantong_darah'] = $request->kantong_darah;
        }
    }

    /**
     * Menangani data persalinan dengan mengumpulkan nilai-nilai persalinan ke dalam array.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $data
     * @return void
     */
    protected static function handlePersalinanData(Request $request, array &$data)
    {
        $persalinanFields = ['usia_kehamilan', 'gravida', 'partus', 'abortus', 'onset_kontraksi'];
        foreach ($persalinanFields as $pf) {
            if ($request->has($pf)) {
                $data['persalinan'][$pf] = $request->input($pf);
            }
        }
    }
}
