<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

class PatientController extends Controller
{
    public function update($no_rekam_medis, Request $request)
    {
        $request->validate([
            "nomor_kartu"   => "required",
            "nama_pasien"   => "required",
            "tgl_lahir"     => "required|date_format:Y-m-d H:i:s",
            "gender"        => "required|in:1,2",                       // 1: Laki-laki, 2: Perempuan
        ]);

        $json = [
            "metadata" => [
                "method"        => 'update_patient',
                "nomor_rm"      => $no_rekam_medis
            ],
            "data" => [
                "nomor_kartu"   => $request->nomor_kartu,
                "nomor_rm"      => $no_rekam_medis,
                "nama_pasien"   => $request->nama_pasien,
                "tgl_lahir"     => $request->tgl_lahir,
                "gender"        => $request->gender
            ]
        ];

        return EklaimService::post($json);
    }

    public function delete($no_rekam_medis, $coder)
    {
        $json = [
            "metadata" => [
                "method"        => 'delete_patient'
            ],
            "data" => [
                "nomor_rm"      => $no_rekam_medis,
                "coder_nik"     => $coder
            ]
        ];

        return EklaimService::post($json);
    }
}
