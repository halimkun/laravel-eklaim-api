<?php

namespace FaisalHalim\LaravelEklaimApi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use FaisalHalim\LaravelEklaimApi\Services\EklaimService;

class NewKlaimController extends Controller
{
    protected $eklaimService;

    public function __construct(EklaimService $eklaimService)
    {
        $this->eklaimService = $eklaimService;
    }

    public function handle(Request $request)
    {

    }


}
