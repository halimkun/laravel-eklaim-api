<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

class SendKlaimIndividualController extends Controller
{
    public function handle($sep)
    {
        $json = [
            "metadata" => [
                "method" => "send_claim_individual"
            ],
            "data" => [
                "nomor_sep" => $sep
            ]
        ];

        return EklaimService::send($json);
    }
}
