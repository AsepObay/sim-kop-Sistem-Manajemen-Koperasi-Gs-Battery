<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PurchaseOrder;

class StoreInvoicePORequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'manual_invoice_part' => 'nullable|string|max:100',
            'no_so' => 'nullable|string|max:100',
            'tipe_bisnis' => 'nullable|string|max:100',
            'tanggal_invoice' => 'required|date',
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            
            'items' => 'required|array|min:1',
            'items.*.tanggal_item' => 'required|date',
            'items.*.nama_item' => 'required|string|max:255',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.harga' => 'required|numeric|min:0',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validate total qty tidak melebihi sisa qty PO
            $poId = $this->input('purchase_order_id');
            $items = $this->input('items', []);
            
            if ($poId && !empty($items)) {
                $po = PurchaseOrder::find($poId);
                
                if ($po) {
                    // Check if PO is closed
                    if ($po->status === 'closed') {
                        $validator->errors()->add('purchase_order_id', 'PO sudah ditutup, tidak bisa menambahkan invoice.');
                        return;
                    }
                    
                    $totalQty = array_sum(array_column($items, 'qty'));
                    $remaining = $po->remainingQty();
                    
                    if ($totalQty > $remaining) {
                        $validator->errors()->add('items', "Total qty invoice ($totalQty) melebihi sisa qty PO ($remaining).");
                    }
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'no_invoice.required' => 'Nomor invoice wajib diisi.',
            'no_invoice.unique' => 'Nomor invoice sudah digunakan.',
            'tanggal_invoice.required' => 'Tanggal invoice wajib diisi.',
            'purchase_order_id.required' => 'Purchase Order wajib dipilih.',
            'purchase_order_id.exists' => 'Purchase Order tidak ditemukan.',
            
            'items.required' => 'Minimal harus ada 1 item.',
            'items.min' => 'Minimal harus ada 1 item.',
            'items.*.tanggal_item.required' => 'Tanggal item wajib diisi.',
            'items.*.nama_item.required' => 'Nama item wajib diisi.',
            'items.*.qty.required' => 'Qty item wajib diisi.',
            'items.*.qty.min' => 'Qty item minimal 1.',
            'items.*.unit.required' => 'Unit item wajib diisi.',
            'items.*.harga.required' => 'Harga item wajib diisi.',
            'items.*.harga.min' => 'Harga item tidak boleh negatif.',
        ];
    }
}
