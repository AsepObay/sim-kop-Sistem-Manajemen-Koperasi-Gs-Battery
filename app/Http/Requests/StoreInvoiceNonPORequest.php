<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceNonPORequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'no_so' => 'nullable|string|max:100',
            'tipe_bisnis' => 'nullable|string|max:100',
            'tanggal_invoice' => 'required|date',
            
            'items' => 'required|array|min:1',
            'items.*.tanggal_item' => 'required|date',
            'items.*.nama_item' => 'required|string|max:255',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.harga' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'no_invoice.required' => 'Nomor invoice wajib diisi.',
            'no_invoice.unique' => 'Nomor invoice sudah digunakan.',
            'tanggal_invoice.required' => 'Tanggal invoice wajib diisi.',
            
            'items.required' => 'Minimal harus ada 1 item.',
            'items.min' => 'Minimal harus ada 1 item.',
            'items.*.tanggal_item.required' => 'Tanggal item wajib diisi.',
            'items.*.nama_item.required' => 'Nama item wajib diisi.',
            'items.*.qty.required' => 'Qty item wajib diisi.',
            'items.*.qty.min' => 'Qty item minimal 1.',
            'items.*.unit.required' => 'Unit item wajib diisi.',
            'items.*.harga.required' => 'Harga item wajib diisi.',
            'items.*.harga.min' => 'Harga item tidak boleh negatif.',
            'tipe_bisnis.max' => 'Bisnis Internal maksimal 100 karakter.',
        ];
    }
}
