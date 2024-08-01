<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

class SetKlaimDataController extends Controller
{
    public function handle($sep, Request $request)
    {
        $request->validate([
            "coder_nik"                 => "required|numeric|digits:16",        // mandatory

            "tgl_masuk"                 => "date_format:Y-m-d H:i:s",
            "tgl_pulang"                => "date_format:Y-m-d H:i:s",
            "cara_masuk"                => "in:gp,hosp-trans,mp,outp,inp,emd,born,nursing,psych,rehab,other",
            "jenis_rawat"               => "numeric|in:1,2,3",                          // 1: Rawat Inap, 2: Rawat Jalan, 3: Rawat IGD
            "kelas_rawat"               => "numeric|in:1,2,3",
            
            "adl_sub_acute"             => "numeric|between:12,60",
            "adl_chronic"               => "numeric|between:12,60",
            
            "icu_indikator"             => "numeric|in:0,1",
            "icu_los"                   => "numeric",
            // "ventilator_hour"           => "numeric",
            
            // ==== ventilator
            "use_ind"                   => "numeric|in:0,1",
            "start_dttm"                => "date_format:Y-m-d H:i:s",
            "stop_dttm"                 => "date_format:Y-m-d H:i:s",
            // ==== / end ventilator

            "upgrade_class_ind"         => "numeric|in:0,1",
            "upgrade_class_class"       => "in:kelas_1,kelas_2,vip,vvip",
            "upgrade_class_los"         => "numeric",
            "add_payment_pct"           => "numeric",
            "upgrade_class_payor"       => "in:peserta,pemberi_kerja,asuransi_tambahan",

            "birth_weight"              => "numeric",
            
            "sistole"                   => "numeric",
            "diastole"                  => "numeric",
            
            "discharge_status"          => "numeric|in:1,2,3,4,5",                  // 1: Atas persetujuan dokter, 2: Dirujuk, 3: Atas permintaan sendiri, 4: Meninggal, 5: Lain-lain

            "diagnosa"                  => "string",                                // INFO : dobel cek dokumentasi
            "procedure"                 => "string",                                // INFO : dobel cek dokumentasi
            "diagnosa_inagrouper"       => "string",                                // INFO : dobel cek dokumentasi
            "procedure_inagrouper"      => "string",                                // INFO : dobel cek dokumentasi

            // ==== tarif_rs
            "prosedur_non_bedah"        => "numeric",
            "prosedur_bedah"            => "numeric",
            "konsultasi"                => "numeric",
            "tenaga_ahli"               => "numeric",
            "keperawatan"               => "numeric",
            "penunjang"                 => "numeric",
            "radiologi"                 => "numeric",
            "laboratorium"              => "numeric",
            "pelayanan_darah"           => "numeric",
            "rehabilitasi"              => "numeric",
            "kamar"                     => "numeric",
            "rawat_intensif"            => "numeric",
            "obat"                      => "numeric",
            "obat_kronis"               => "numeric",
            "obat_kemoterapi"           => "numeric",
            "alkes"                     => "numeric",
            "bmhp"                      => "numeric",
            "sewa_alat"                 => "numeric",
            // ==== / end tarif_rs

            // "pemulasaraan_jenazah"      => "numeric|in:0,1",
            // "kantong_jenazah"           => "numeric|in:0,1",
            // "peti_jenazah"              => "numeric|in:0,1",
            // "plastik_erat"              => "numeric|in:0,1",
            // "desinfektan_jenazah"       => "numeric|in:0,1",
            // "mobil_jenazah"             => "numeric|in:0,1",
            // "desinfektan_mobil_jenazah" => "numeric|in:0,1",

            // "covid19_status_cd"         => "in:1,2,3,4,5",
            // "nomor_kartu_t"             => "string",
            // "episodes"                  => "array",
            // "covid19_cc_ind"            => "numeric|in:0,1",
            // "covid19_rs_darurat_ind"    => "numeric|in:0,1",
            // "covid19_co_insidense_ind"  => "numeric|in:0,1",

            // ==== covid19_penunjang_pengurang
            // "lab_asam_laktat"           => "numeric|in:0,1",
            // "lab_procalcitonin"         => "numeric|in:0,1",
            // "lab_crp"                   => "numeric|in:0,1",
            // "lab_kultur"                => "numeric|in:0,1",
            // "lab_d_dimer"               => "numeric|in:0,1",
            // "lab_pt"                    => "numeric|in:0,1",
            // "lab_aptt"                  => "numeric|in:0,1",
            // "lab_waktu_pendarahan"      => "numeric|in:0,1",
            // "lab_anti_hiv"              => "numeric|in:0,1",
            // "lab_analisa_gas"           => "numeric|in:0,1",
            // "lab_albumin"               => "numeric|in:0,1",
            // "rad_thorax_ap_pa"          => "numeric|in:0,1",
            // ==== / end covid19_penunjang_pengurang

            "terapi_konvalesen"         => "numeric",

            // INFO : Tidak diperlukan per 1 Oktober 2021 (Manual Web Service 5.8.3b)
            // "akses_naat"                => "in:0,1",
            
            "isoman_ind"                => "numeric|in:0,1",

            "bayi_lahir_status_cd"      => "in:1,2",

            "dializer_single_use"       => "numeric|in:0,1",
            "kantong_darah"             => "numeric",

            // ==== apgar
            // ==== / end apgar
            
            // ==== persalinan
            "usia_kehamilan"            => "numeric",
            "gravida"                   => "numeric",
            "partus"                    => "numeric",
            "abortus"                   => "numeric",
            "onset_kontraksi"           => "in:spontan,induksi,non_spontan_non_induksi",
            
            // ==== delivery
            // ==== / end delivery

            // ==== / end persalinan

            "tarif_poli_eks"            => "numeric",
            "nama_dokter"               => "string",
            "kode_tarif"                => "string|in:AP,AS,BP,BS,CP,CS,DP,DS,RSCM,RSJP,RSD,RSAB",
            
            "payor_id"                  => "required|numeric",
            "payor_cd"                  => "required",
        ]);

        // ==================================================== PARSE MANDATORY DATA

        $metadata = [
            "method"        => 'set_claim_data',
            "nomor_sep"     => $sep
        ];

        $data = [
            "nomor_sep"     => $sep,
            "coder_nik"     => $request->coder_nik,
            "payor_id"      => $request->payor_id,
            "payor_cd"      => $request->payor_cd
        ];

        // ==================================================== PARSE OPTIONAL DATA

        if ($request->has('tgl_masuk')) {
            $data['tgl_masuk'] = $request->tgl_masuk;
        }

        if ($request->has('tgl_pulang')) {
            $data['tgl_pulang'] = $request->tgl_pulang;
        }

        if ($request->has('cara_masuk')) {
            $data['cara_masuk'] = $request->cara_masuk;
        }

        if ($request->has('jenis_rawat')) {
            $data['jenis_rawat'] = $request->jenis_rawat;

            if ($request->jenis_rawat == 2) {
                $request->validate([
                    "kelas_rawat" => "in:1,3"
                ]);
            }
        }

        if ($request->has('kelas_rawat')) {
            $data['kelas_rawat'] = $request->kelas_rawat;
        }

        $adlFields = ['adl_sub_acute', 'adl_chronic'];
        foreach ($adlFields as $field) {
            if ($request->has($field)) {
                $data[$field] = $request->input($field);
            }
        }

        if ($request->has('icu_indikator')) {
            $data['icu_indikator'] = $request->icu_indikator;

            if ($request->icu_indikator == 1) {
                $request->validate([
                    "icu_los" => "required|numeric"
                ]);

                $data['icu_los'] = $request->icu_los;

                // ventilator
                $ventilatorFields = ['use_ind', 'start_dttm', 'stop_dttm'];
                if ($request->hasAny($ventilatorFields)) {
                    $validationRules = array_fill_keys($ventilatorFields, 'required');
                    $request->validate($validationRules);

                    foreach ($ventilatorFields as $field) {
                        $data['ventilator'][$field] = $request->input($field);
                    }

                    // ventilator_hour is round up hour difference between start_dttm and stop_dttm
                    $start = new \DateTime($data['ventilator']['start_dttm']);
                    $stop  = new \DateTime($data['ventilator']['stop_dttm']);

                    $diff = $start->diff($stop);
                    $data['ventilator_hour'] = ceil($diff->h + ($diff->i / 60));
                }
            }
        } else {
            $data['icu_indikator'] = 0;
            $data['icu_los'] = 0;
        }

        $upgradeFields = ['upgrade_class_ind', 'upgrade_class_class', 'upgrade_class_los', 'add_payment_pct', 'upgrade_class_payor'];
        if ($request->hasAny($upgradeFields)) {
            $validationRules = array_fill_keys($upgradeFields, 'required');
            $request->validate($validationRules);

            foreach ($upgradeFields as $field) {
                $data[$field] = $request->input($field);
            }
        }

        if ($request->has('birth_weight')) {
            $data['birth_weight'] = $request->birth_weight;
        }

        if ($request->hasAny(['sistole', 'diastole'])) {
            $request->validate([
                "sistole"  => "required",
                "diastole" => "required"
            ]);

            $data['sistole']  = $request->sistole;
            $data['diastole'] = $request->diastole;
        }

        if ($request->has('discharge_status')) {
            $data['discharge_status'] = $request->discharge_status;
        }

        $procedureDiagnosa = ['diagnosa', 'procedure', 'diagnosa_inagrouper', 'procedure_inagrouper'];
        foreach ($procedureDiagnosa as $pd) {
            if ($request->has($pd)) {
                $data[$pd] = $request->input($pd);
            }
        }

        $tarif_rs = ['prosedur_non_bedah', 'prosedur_bedah', 'konsultasi', 'tenaga_ahli', 'keperawatan', 'penunjang', 'radiologi', 'laboratorium', 'pelayanan_darah', 'rehabilitasi', 'kamar', 'rawat_intensif', 'obat', 'obat_kronis', 'obat_kemoterapi', 'alkes', 'bmhp', 'sewa_alat'];
        foreach ($tarif_rs as $trs) {
            if ($request->has($trs)) {
                $data['tarif_rs'][$trs] = $request->input($trs);
            }
        }

        // $jenazaFields = ['pemulasaraan_jenazah', 'kantong_jenazah', 'peti_jenazah', 'plastik_erat', 'desinfektan_jenazah', 'mobil_jenazah', 'desinfektan_mobil_jenazah'];
        // foreach ($jenazaFields as $jf) {
        //     if ($request->has($jf)) {
        //         $data[$jf] = $request->input($jf);
        //     }
        // }

        // $covid19Fields = ['covid19_status_cd', 'nomor_kartu_t', 'episodes', 'covid19_cc_ind', 'covid19_rs_darurat_ind', 'covid19_co_insidense_ind'];
        // foreach ($covid19Fields as $cf) {
        //     if ($request->has($cf)) {
        //         $data[$cf] = $request->input($cf);
        //     }
        // }

        // $covid19PenunjangPengurang = ['lab_asam_laktat', 'lab_procalcitonin', 'lab_crp', 'lab_kultur', 'lab_d_dimer', 'lab_pt', 'lab_aptt', 'lab_waktu_pendarahan', 'lab_anti_hiv', 'lab_analisa_gas', 'lab_albumin', 'rad_thorax_ap_pa'];
        // foreach ($covid19PenunjangPengurang as $cpp) {
        //     if ($request->has($cpp)) {
        //         $data['covid19_penunjang_pengurang'][$cpp] = $request->input($cpp);
        //     }
        // }

        if ($request->has('terapi_konvalesen')) {
            $data['terapi_konvalesen'] = $request->terapi_konvalesen;
        }

        // if ($request->has('akses_naat')) {
        //     $data['akses_naat'] = $request->akses_naat;
        // }

        // if ($request->has('isoman_ind')) {
        //     $data['isoman_ind'] = $request->isoman_ind;
        // }

        // if ($request->has('bayi_lahir_status_cd')) {
        //     $data['bayi_lahir_status_cd'] = $request->bayi_lahir_status_cd;
        // }

        // if ($request->has('dializer_single_use')) {
        //     $data['dializer_single_use'] = $request->dializer_single_use;
        // }
        
        if ($request->has('pelayanan_darah')) {
            if ($request->pelayanan_darah > 0) {
                $request->validate([
                    "kantong_darah" => "required|numeric"
                ]);

                $data['kantong_darah'] = $request->kantong_darah;
            }
        }

        // !==== Apgar

        $persalinanFields = ['usia_kehamilan', 'gravida', 'partus', 'abortus', 'onset_kontraksi'];
        foreach ($persalinanFields as $pf) {
            if ($request->has($pf)) {
                $data['persalinan'][$pf] = $request->input($pf);
            }
        }

        if ($request->has('tarif_poli_eks')) {
            $data['tarif_poli_eks'] = $request->tarif_poli_eks;
        }

        if ($request->has('nama_dokter')) {
            $data['nama_dokter'] = $request->nama_dokter;
        }

        if ($request->has('kode_tarif')) {
            $data['kode_tarif'] = $request->kode_tarif;
        }

        // ==================================================== FINALIZE

        $postData = [
            "metadata" => $metadata,
            "data"     => $data
        ];

        dd($postData);

        return EklaimService::post($postData);
    }
}
