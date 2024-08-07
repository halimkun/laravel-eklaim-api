<?php

namespace Halim\EKlaim\Http\Requests;

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
            "nomor_sep" => "required|alpha_num",
        ];
    }
}
