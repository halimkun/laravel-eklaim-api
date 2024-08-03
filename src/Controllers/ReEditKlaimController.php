<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;
use Illuminate\Http\Request;

class ReEditKlaimController extends Controller
{
    public function handle($sep)
    {
        $json = [
            "metadata" => [
                "method" => "reedit_claim"
            ],
            "data" => [
                "nomor_sep" => $sep
            ]
        ];

        return EklaimService::send($json);
    }
}
