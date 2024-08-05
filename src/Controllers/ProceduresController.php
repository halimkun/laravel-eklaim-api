<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

class ProceduresController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'search.value' => 'required|string',
        ]);

        $json = [
            "metadata" => [
                "method" => 'search_procedures'
            ],
            "data" => [
                "keyword" => $request->input('search.value')
            ]
        ];

        return EklaimService::send($json);
    }

    public function searchIna(Request $request)
    {
        $request->validate([
            'search.value' => 'required|string',
        ]);

        $json = [
            "metadata" => [
                "method" => 'search_procedures_inagrouper'
            ],
            "data" => [
                "keyword" => $request->input('search.value')
            ]
        ];

        return EklaimService::send($json);
    }
}
