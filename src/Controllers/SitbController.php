<?php

namespace Halim\EKlaim\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Halim\EKlaim\Builders\BodyBuilder;
use Halim\EKlaim\Services\EklaimService;

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

        try {
            $res = EklaimService::send(BodyBuilder::prepared());
            
            if ($res->getStatusCode() != 200) {
                $res = $res->getData();
                throw new \Exception($res->metadata->message);
            }
            
            $res = $res->getData();
            if (!$res->response->validation) {
                throw new \Exception($res->response->status . " - " . $res->response->detail);
            }

            return $res;
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function inValidateSitb($sep)
    {
        // RE-EDIT FIRST
        BodyBuilder::setMetadata('reedit_claim');
        BodyBuilder::setData(["nomor_sep" => $sep]);

        EklaimService::send(BodyBuilder::prepared())->then(function ($response) use ($sep) {
            Log::channel(config('eklaim.log_channel'))->info("RE-EDIT FROM SITB", [
                "sep"      => $sep,
                "response" => $response,
            ]);
        });

        // SITB INVALIDATE
        BodyBuilder::setMetadata('sitb_invalidate');
        BodyBuilder::setData([
            'nomor_sep'           => $sep
        ]);

        try {
            $res = EklaimService::send(BodyBuilder::prepared());

            if ($res->getStatusCode() != 200) {
                $res = $res->getData();
                throw new \Exception($res->metadata->message);
            }

            return $res->getData();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
