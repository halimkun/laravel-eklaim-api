<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

class DiagnosisInaController extends Controller
{
    public function handle(Request $request)
    {
        $request->validate([
            'search.value' => 'required|string',
        ]);

        $json = [
            "metadata" => [
                "method" => 'search_diagnosis_inagrouper'
            ],
            "data" => [
                "keyword" => $request->input('search.value')
            ]
        ];

        return EklaimService::post($json);
    }
}
