<?php

namespace Halim\EKlaim\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Halim\EKlaim\Builders\BodyBuilder;
use Halim\EKlaim\Services\EklaimService;
use Halim\EKlaim\Helpers\ClaimDataParser;

/**
 * Menangani permintaan untuk membuat klaim baru dengan API E-KLAIM.
 * 
 * Validasi dilakukan pada data permintaan untuk memastikan semua
 * informasi yang diperlukan ada dan dalam format yang benar. Setelah
 * validasi berhasil, data dikemas dalam format JSON dan dikirim ke
 * API E-KLAIM menggunakan layanan EklaimService.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\Response
 */
class KlaimController extends Controller
{
    public function new(\Halim\EKlaim\Http\Requests\NewKlaimRequest $request)
    {
        BodyBuilder::setMetadata('new_claim');
        BodyBuilder::setData([
            "nomor_kartu"   => $request->nomor_kartu,
            "nomor_sep"     => $request->nomor_sep,
            "nomor_rm"      => $request->nomor_rm,
            "nama_pasien"   => $request->nama_pasien,
            "tgl_lahir"     => $request->tgl_lahir,
            "gender"        => $request->gender
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }

    public function get($sep)
    {
        BodyBuilder::setMetadata('get_claim_data');
        BodyBuilder::setData([
            "nomor_sep" => $sep
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }

    public function set($sep, \Halim\EKlaim\Http\Requests\SetKlaimDataRequest $request)
    {
        // ==================================================== PARSE MANDATORY DATA
        
        $required = [
            "nomor_sep"     => $sep,
            "coder_nik"     => $request->coder_nik,
            "payor_id"      => $request->payor_id,
            "payor_cd"      => $request->payor_cd
        ];

        // ==================================================== PARSE OTHERS DATA
        
        $data = array_merge($required, ClaimDataParser::parse($request));

        // ==================================================== FINALIZE

        BodyBuilder::setMetadata('set_claim_data', ["nomor_sep"     => $sep]);
        BodyBuilder::setData($data);
        
        return EklaimService::send(BodyBuilder::prepared());
    }

    public function delete($sep, \Halim\EKlaim\Http\Requests\DeleteKlaimRequest $request)
    {
        BodyBuilder::setMetadata('delete_claim');
        BodyBuilder::setData([
            "nomor_sep" => $sep,
            "coder_nik" => $request->coder_nik
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }

    public function sendBulk(\Halim\EKlaim\Http\Requests\SendBulkRequest $request)
    {
        BodyBuilder::setMetadata('send_claim');
        BodyBuilder::setData([
            "start_dt"    => $request->start_dt,
            "stop_dt"     => $request->stop_dt,
            "jenis_rawat" => $request->jenis_rawat,
            "date_type"   => $request->date_type
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }

    public function send($sep)
    {
        BodyBuilder::setMetadata('send_claim_individual');
        BodyBuilder::setData([
            "nomor_sep" => $sep
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }

    public function final(\Halim\EKlaim\Http\Requests\FinalKlaimRequest $request)
    {
        BodyBuilder::setMetadata('claim_final');
        BodyBuilder::setData([
            "nomor_sep" => $request->nomor_sep,
            "coder_nik" => $request->coder_nik
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }

    public function getStatus($sep)
    {
        BodyBuilder::setMetadata('get_claim_status');
        BodyBuilder::setData([
            "nomor_sep" => $sep
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }

    public function reEdit($sep)
    {
        BodyBuilder::setMetadata('reedit_claim');
        BodyBuilder::setData([
            "nomor_sep" => $sep
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }

    public function generateNumber()
    {
        BodyBuilder::setMetadata('generate_claim_number');
        return EklaimService::send(BodyBuilder::prepared());
    }

    public function print($sep)
    {
        BodyBuilder::setMetadata('claim_print');
        BodyBuilder::setData([
            "nomor_sep" => $sep
        ]);

        return EklaimService::send(BodyBuilder::prepared());

        // $d = EklaimService::post($json);
        // $pdf = $d->getData()->data;

        // // pdf is base64 encoded, so we need to decode it and render it
        // $pdf = base64_decode($pdf);

        // return response($pdf)->header('Content-Type', 'application/pdf');
    }
}
