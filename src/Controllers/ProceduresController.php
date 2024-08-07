<?php

namespace Halim\EKlaim\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Halim\EKlaim\Http\Requests\ProcedureRequest;
use Halim\EKlaim\Services\EklaimService;

class ProceduresController extends Controller
{
    public function search(ProcedureRequest $request)
    {
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

    public function searchIna(ProcedureRequest $request)
    {
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
