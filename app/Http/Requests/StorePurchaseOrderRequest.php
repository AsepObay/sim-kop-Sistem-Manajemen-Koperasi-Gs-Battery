<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'no_po' => 'required|string|max:255',
            'jenis_po' => 'required|string|max:255',
            'tanggal_po' => 'required|date',
            'total_qty' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'no_po.required' => 'Nomor PO wajib diisi',
            'jenis_po.required' => 'Jenis PO wajib diisi',
            'tanggal_po.required' => 'Tanggal PO wajib diisi',
            'total_qty.required' => 'Total Quantity wajib diisi',
            'total_qty.min' => 'Total Quantity minimal harus 1',
        ];
    }
}
