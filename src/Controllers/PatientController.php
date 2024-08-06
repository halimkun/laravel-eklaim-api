<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;
use FaisalHalim\LaravelEklaimApi\Builders\BodyBuilder;
use FaisalHalim\LaravelEklaimApi\Http\Requests\PatientUpadteRequest;

class PatientController extends Controller
{
    /**
     * Update patient information.
     *
     * @param string $no_rekam_medis
     * @param \FaisalHalim\LaravelEklaimApi\Http\Requests\PatientUpadteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($no_rekam_medis, PatientUpadteRequest $request)
    {
        BodyBuilder::setMetadata('update_patient', ["nomor_rm" => $no_rekam_medis]);
        BodyBuilder::setData([
            "nomor_kartu"   => $request->nomor_kartu,
            "nomor_rm"      => $no_rekam_medis,
            "nama_pasien"   => $request->nama_pasien,
            "tgl_lahir"     => $request->tgl_lahir,
            "gender"        => $request->gender
        ]);

        return EklaimService::send(BodyBuilder::prepared());
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

        BodyBuilder::setMetadata('delete_patient');
        BodyBuilder::setData([
            "nomor_rm"      => $no_rekam_medis,
            "coder_nik"     => $coders->random()->no_ik
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }
}
