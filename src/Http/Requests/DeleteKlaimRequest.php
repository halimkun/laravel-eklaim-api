<?php

namespace FaisalHalim\LaravelEklaimApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteKlaimRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "coder_nik" => "required|numeric|digits:16"
        ];
    }
}
