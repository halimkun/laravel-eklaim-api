<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

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
class NewKlaimController extends Controller
{
    public function handle(Request $request)
    {
        $request->validate([
            "nomor_kartu"   => "required",
            "nomor_sep"     => "required",
            "nomor_rm"      => "required",
            "nama_pasien"   => "required",
            "tgl_lahir"     => "required|date_format:Y-m-d H:i:s",
            "gender"        => "required|in:1,2",                       // 1: Laki-laki, 2: Perempuan
        ]);

        $json = [
            "metadata" => [
                "method"        => 'new_claim'
            ],
            "data" => [
                "nomor_kartu"   => $request->nomor_kartu,
                "nomor_sep"     => $request->nomor_sep,
                "nomor_rm"      => $request->nomor_rm,
                "nama_pasien"   => $request->nama_pasien,
                "tgl_lahir"     => $request->tgl_lahir,
                "gender"        => $request->gender
            ]
        ];

        return EklaimService::send($json);
    }
}
