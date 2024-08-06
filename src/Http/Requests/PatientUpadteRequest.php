<?php

namespace FaisalHalim\LaravelEklaimApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientUpadteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "nomor_kartu"   => "required",
            "nama_pasien"   => "required",
            "tgl_lahir"     => "required|date_format:Y-m-d H:i:s",
            "gender"        => "required|in:1,2",                       // 1: Laki-laki, 2: Perempuan
        ];
    }
}
