<?php

namespace FaisalHalim\LaravelEklaimApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupingStage1Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "nomor_sep" => "required|string",
        ];
    }
}
