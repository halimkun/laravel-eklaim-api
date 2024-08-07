<?php

namespace Halim\EKlaim\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendBulkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_dt'    => 'required|date|date_format:Y-m-d',
            'stop_dt'     => 'required|date|date_format:Y-m-d',
            'jenis_rawat' => 'required|string|in:1,2,3',        // 1: Rawat Jalan, 2: Rawat Inap, 3: Rawat Inap & Jalan
            'date_type'   => 'required|string|in:1,2',          // 1: Tanggal Pulang, 2: Tanggal Grouping
        ];
    }
}
