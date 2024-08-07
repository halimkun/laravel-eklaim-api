<?php

namespace Halim\EKlaim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewKlaimRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "nomor_kartu"   => "required|numeric",
            "nomor_sep"     => "alpha_num",
            "nomor_rm"      => "required|numerci",
            "nama_pasien"   => "required|string",
            "tgl_lahir"     => "required|date_format:Y-m-d H:i:s",
            "gender"        => "required|in:1,2",                       // 1: Laki-laki, 2: Perempuan
        ];
    }
}
