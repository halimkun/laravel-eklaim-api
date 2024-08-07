<?php

namespace Halim\EKlaim\Controllers;

use App\Http\Controllers\Controller;
use Halim\EKlaim\Builders\BodyBuilder;
use Halim\EKlaim\Services\EklaimService;
use Illuminate\Http\Request;

class SitbController extends Controller
{
    public function validateSitb(Request $request)
    {
        $request->validate([
            'nomor_sep'           => 'required|string',
            'nomor_register_sitb' => 'required|string',
        ]);

        BodyBuilder::setMetadata('sitb_validate');
        BodyBuilder::setData([
            'nomor_sep'           => $request->nomor_sep,
            'nomor_register_sitb' => $request->nomor_register_sitb,
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }

    public function inValidateSitb($sep)
    {
        BodyBuilder::setMetadata('sitb_invalidate');
        BodyBuilder::setData([
            'nomor_sep'           => $sep
        ]);

        return EklaimService::send(BodyBuilder::prepared());
    }
}
