<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Builders\BodyBuilder;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;
use Illuminate\Http\Request;

class GroupKlaimController extends Controller
{
    /**
     * Menangani tahap pertama dari proses grouping.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function stage1(Request $request)
    {
        $request->validate([
            "nomor_sep" => "required|string",
        ]);

        BodyBuilder::setMetadata('grouper', ["stage" => 1]);
        BodyBuilder::setData([
            "nomor_sep" => $request->nomor_sep,
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }

    /**
     * Menangani tahap kedua dari proses grouping.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function stage2(Request $request)
    {
        $request->validate([
            "nomor_sep" => "required|string",
            "special_cmg" => "array",
        ]);

        BodyBuilder::setMetadata('grouper', ["stage" => 2]);
        BodyBuilder::setData([
            "nomor_sep" => $request->nomor_sep,
            "special_cmg" => $request->special_cmg,
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }
}
