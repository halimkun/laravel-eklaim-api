<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

class GetKlaimDataController extends Controller
{
    public function handle($sep)
    {
        $json = [
            "metadata" => [
                "method"        => 'get_claim_data'
            ],
            "data" => [
                "nomor_sep"     => $sep
            ]
        ];

        return EklaimService::send($json);
    }
}
