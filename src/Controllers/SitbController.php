<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimBodyService;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;
use Illuminate\Http\Request;

class SitbController extends Controller
{
    public function validateSitb(Request $request)
    {
        $request->validate([
            'nomor_sep'           => 'required|string',
            'nomor_register_sitb' => 'required|string',
        ]);

        EklaimBodyService::setMetadata('sitb_validate');
        EklaimBodyService::setData([
            'nomor_sep'           => $request->nomor_sep,
            'nomor_register_sitb' => $request->nomor_register_sitb,
        ]);

        return EklaimService::send(EklaimBodyService::prepared());
    }

    public function inValidateSitb($sep)
    {
        EklaimBodyService::setMetadata('sitb_invalidate');
        EklaimBodyService::setData([
            'nomor_sep'           => $sep
        ]);

        return EklaimService::send(EklaimBodyService::prepared());
    }
}
