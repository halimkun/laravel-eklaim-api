<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;
use FaisalHalim\LaravelEklaimApi\Services\EklaimBodyService;

class PatientController extends Controller
{
    /**
     * Update patient information.
     *
     * @param string $no_rekam_medis
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update($no_rekam_medis, Request $request)
    {
        $request->validate([
            "nomor_kartu"   => "required",
            "nama_pasien"   => "required",
            "tgl_lahir"     => "required|date_format:Y-m-d H:i:s",
            "gender"        => "required|in:1,2",                       // 1: Laki-laki, 2: Perempuan
        ]);

        EklaimBodyService::setMetadata('update_patient', [ "nomor_rm" => $no_rekam_medis ]);
        EklaimBodyService::setData([
            "nomor_kartu"   => $request->nomor_kartu,
            "nomor_rm"      => $no_rekam_medis,
            "nama_pasien"   => $request->nama_pasien,
            "tgl_lahir"     => $request->tgl_lahir,
            "gender"        => $request->gender
        ]);

        return EklaimService::send(EklaimBodyService::prepared());
    }

    /**
     * Delete patient information.
     *
     * @param string $no_rekam_medis
     * @return \Illuminate\Http\Response
     */
    public function delete($no_rekam_medis)
    {
        $coders = \App\Models\RsiaCoderNik::all();
        
        EklaimBodyService::setMetadata('delete_patient');
        EklaimBodyService::setData([
            "nomor_rm"      => $no_rekam_medis,
            "coder_nik"     => $coders->random()->no_ik
        ]);

        return EklaimService::send(EklaimBodyService::prepared());
    }
}
