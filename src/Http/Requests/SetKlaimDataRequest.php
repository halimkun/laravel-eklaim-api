<?php

namespace Halim\EKlaim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetKlaimDataRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "coder_nik"                 => "numeric|digits:16",                                                     // mandatory

            "tgl_masuk"                 => "date",
            "tgl_pulang"                => "date",
            "cara_masuk"                => "in:gp,hosp-trans,mp,outp,inp,emd,born,nursing,psych,rehab,other",
            "jenis_rawat"               => "numeric|in:1,2,3",                                                      // 1: Rawat Inap, 2: Rawat Jalan, 3: Rawat IGD
            "kelas_rawat"               => "numeric|in:1,2,3",

            "adl_sub_acute"             => "numeric|between:12,60",
            "adl_chronic"               => "numeric|between:12,60",

            "icu_indikator"             => "numeric|in:0,1",
            "icu_los"                   => "numeric",
            // "ventilator_hour"           => "numeric",

            // ==== ventilator
            "use_ind"                   => "numeric|in:0,1",
            "start_dttm"                => "date",
            "stop_dttm"                 => "date",
            // ==== / end ventilator

            "add_payment_pct"           => "numeric",
            "upgrade_class_ind"         => "numeric|in:0,1",
            "upgrade_class_class"       => "in:kelas_1,kelas_2,vip,vvip",
            "upgrade_class_los"         => "numeric",
            "upgrade_class_payor"       => "in:1,2,3",                                                              // 1: Peserta, 2: Pemberi Kerja, 3: Asuransi Tambahan

            "birth_weight"              => "numeric",

            "sistole"                   => "numeric",
            "diastole"                  => "numeric",

            "discharge_status"          => "nullable|in:1,2,3,4,5",                                                 // 1: Atas persetujuan dokter, 2: Dirujuk, 3: Atas permintaan sendiri, 4: Meninggal, 5: Lain-lain

            "diagnosa"                  => "array",
            "procedure"                 => "array",
            "diagnosa_inagrouper"       => "array",
            "procedure_inagrouper"      => "array",

            // ==== tarif_rs
            "prosedur_non_bedah"        => "numeric|min:0",
            "prosedur_bedah"            => "numeric|min:0",
            "konsultasi"                => "numeric|min:0",
            "tenaga_ahli"               => "numeric|min:0",
            "keperawatan"               => "numeric|min:0",
            "penunjang"                 => "numeric|min:0",
            "radiologi"                 => "numeric|min:0",
            "laboratorium"              => "numeric|min:0",
            "pelayanan_darah"           => "numeric|min:0",
            "rehabilitasi"              => "numeric|min:0",
            "kamar"                     => "numeric|min:0",
            "rawat_intensif"            => "numeric|min:0",
            "obat"                      => "numeric|min:0",
            "obat_kronis"               => "numeric|min:0",
            "obat_kemoterapi"           => "numeric|min:0",
            "alkes"                     => "numeric|min:0",
            "bmhp"                      => "numeric|min:0",
            "sewa_alat"                 => "numeric|min:0",
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

            "terapi_konvalesen"         => "nullable|numeric",

            // "akses_naat"                => "in:0,1",

            "isoman_ind"                => "nullable|numeric|in:0,1",

            "bayi_lahir_status_cd"      => "nullable|in:1,2",

            "dializer_single_use"       => "nullable|numeric|in:0,1",
            "kantong_darah"             => "nullable|numeric",

            // ==== sitb
            "jkn_sitb_checked_ind"      => "nullable|numeric|in:0,1",
            "jkn_sitb_noreg"            => "nullable|string",
            // ==== / end sitb

            // ==== apgar
            // ==== / end apgar

            // ==== persalinan
            "usia_kehamilan"            => "nullable|numeric",
            "gravida"                   => "nullable|numeric",
            "partus"                    => "nullable|numeric",
            "abortus"                   => "nullable|numeric",
            "onset_kontraksi"           => "nullable|in:spontan,induksi,non_spontan_non_induksi",

            // ==== delivery
            // ==== / end delivery

            // ==== / end persalinan

            "tarif_poli_eks"            => "nullable|numeric",
            "nama_dokter"               => "string",
            "kode_tarif"                => "string|in:AP,AS,BP,BS,CP,CS,DP,DS,RSCM,RSJP,RSD,RSAB",

            "payor_id"                  => "required|numeric",
            "payor_cd"                  => "required",
        ];
    }
}
