<?php

namespace Halim\EKlaim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiagnosisRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "search.value" => "required|string"
        ];
    }
}
