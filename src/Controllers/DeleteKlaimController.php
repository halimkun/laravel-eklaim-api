<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

class DeleteKlaimController extends Controller
{
    
    
    public function handle($sep)
    {
        $coders = \App\Models\RsiaCoderNik::all();

        $json = [
            "metadata" => [
                "method"        => 'delete_claim'
            ],
            "data" => [
                "nomor_sep"     => $sep,
                "coder_nik"     => $coders->random()->no_ik
            ]
        ];

        return EklaimService::post($json);
    }
}
