<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

class DiagnosisController extends Controller
{
    public function handle(Request $request)
    {
        $request->validate([
            'search.value' => 'required|string',
        ]);

        $json = [
            "metadata" => [
                "method" => 'search_diagnosis'
            ],
            "data" => [
                "keyword" => $request->input('search.value')
            ]
        ];

        return EklaimService::send($json);
    }
}
