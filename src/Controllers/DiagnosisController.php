<?php

namespace Halim\EKlaim\Controllers;

use App\Http\Controllers\Controller;
use Halim\EKlaim\Builders\BodyBuilder;
use Halim\EKlaim\Http\Requests\DiagnosisRequest;
use Halim\EKlaim\Services\EklaimService;

class DiagnosisController extends Controller
{
    /**
     * Search diagnosis.
     * 
     * @param \Halim\EKlaim\Http\Requests\DiagnosisRequest $request
     * @return \Illuminate\Http\Response
     * */
    public function search(DiagnosisRequest $request)
    {
        BodyBuilder::setMetadata('search_diagnosis');
        BodyBuilder::setData([
            "keyword" => $request->input('search.value')
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }

    /**
     * Search diagnosis ina grouper.
     * 
     * @param \Halim\EKlaim\Http\Requests\DiagnosisRequest $request
     * @return \Illuminate\Http\Response
     * */
    public function searchIna(DiagnosisRequest $request)
    {
        BodyBuilder::setMetadata('search_diagnosis_inagrouper');
        BodyBuilder::setData([
            "keyword" => $request->input('search.value')
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }
}
