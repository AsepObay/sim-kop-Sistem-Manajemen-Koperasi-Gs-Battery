<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecksheetMaster extends Model
{
    protected $fillable = [
        'category',
        'name',
        'tanggal',
        'tanggal_kedatangan',
        'quantity',
        'is_active',
        'is_archived',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_archived' => 'boolean',
        'tanggal' => 'date',
        'tanggal_kedatangan' => 'date',
        'quantity' => 'integer',
    ];

    public const CATEGORY_PALLET = 'pallet';
    public const CATEGORY_PRODUCT = 'produk';
    public const PALLET_TYPES = ['E3', 'GSN', 'Box'];
    public const PRODUCT_ITEM_OPTIONS = [
        'Ultra Milk' => ['Ultra Milk'],
        'Susu Shift' => ['Susu Yasukata', 'Smart'],
        'Galon Ron 88' => ['Air Galon'],
        'Snack' => ['Snack Intan', 'Snack Halim', 'Snack Fmily', 'Snack Ummi'],
    ];

    public function getCategoryLabelAttribute(): string
    {
        return $this->category === self::CATEGORY_PALLET ? 'Jenis Pallet' : 'Produk';
    }
}
