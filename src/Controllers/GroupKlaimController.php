<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Builders\BodyBuilder;
use FaisalHalim\LaravelEklaimApi\Http\Requests\GroupingStage1Request;
use FaisalHalim\LaravelEklaimApi\Http\Requests\GroupingStage2Request;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;
use Illuminate\Http\Request;

class GroupKlaimController extends Controller
{
    /**
     * Menangani tahap pertama dari proses grouping.
     *
     * @param \FaisalHalim\LaravelEklaimApi\Http\Requests\GroupingStage1Request $request
     * @return \Illuminate\Http\Response
     */
    public function stage1(GroupingStage1Request $request)
    {
        BodyBuilder::setMetadata('grouper', ["stage" => 1]);
        BodyBuilder::setData([
            "nomor_sep" => $request->nomor_sep,
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }

    /**
     * Menangani tahap kedua dari proses grouping.
     *
     * @param \FaisalHalim\LaravelEklaimApi\Http\Requests\GroupingStage2Request $request
     * @return \Illuminate\Http\Response
     */
    public function stage2(GroupingStage2Request $request)
    {
        BodyBuilder::setMetadata('grouper', ["stage" => 2]);
        BodyBuilder::setData([
            "nomor_sep" => $request->nomor_sep,
            "special_cmg" => $request->special_cmg,
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }
}
