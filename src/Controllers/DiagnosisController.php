<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Builders\BodyBuilder;
use FaisalHalim\LaravelEklaimApi\Http\Requests\DiagnosisRequest;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

class DiagnosisController extends Controller
{
    /**
     * Search diagnosis.
     * 
     * @param \FaisalHalim\LaravelEklaimApi\Http\Requests\DiagnosisRequest $request
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
     * @param \FaisalHalim\LaravelEklaimApi\Http\Requests\DiagnosisRequest $request
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
