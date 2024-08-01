<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

class PrintKlaimController extends Controller
{
    public function handle($sep)
    {
        $json = [
            "metadata" => [
                "method" => "claim_print"
            ],
            "data" => [
                "nomor_sep" => $sep
            ]
        ];

        return EklaimService::post($json);

        // $d = EklaimService::post($json);
        // $pdf = $d->getData()->data;

        // // pdf is base64 encoded, so we need to decode it and render it
        // $pdf = base64_decode($pdf);

        // return response($pdf)->header('Content-Type', 'application/pdf');
    }
}
