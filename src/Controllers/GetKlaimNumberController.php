<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

class GetKlaimNumberController extends Controller
{
    public function handle()
    {
        $json = [
            "metadata" => [
                "method"        => 'generate_claim_number'
            ],
        ];

        return EklaimService::send($json);
    }
}
