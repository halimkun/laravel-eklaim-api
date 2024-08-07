<?php

namespace Halim\EKlaim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupingStage2Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "nomor_sep"   => "required|alpha_num",
            "special_cmg" => "array",
        ];
    }
}
