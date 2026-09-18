<?php

namespace Database\Seeders;

use App\Models\ChecksheetMaster;
use Illuminate\Database\Seeder;

class ChecksheetMasterSeeder extends Seeder
{
    public function run(): void
    {
        foreach (ChecksheetMaster::PALLET_TYPES as $name) {
            ChecksheetMaster::updateOrCreate(
                ['category' => ChecksheetMaster::CATEGORY_PALLET, 'name' => $name],
                ['is_active' => true]
            );
        }

        foreach (['Ultra Milk', 'Susu Shift', 'Galon Ron 88', 'Snack'] as $name) {
            ChecksheetMaster::updateOrCreate(
                ['category' => ChecksheetMaster::CATEGORY_PRODUCT, 'name' => $name],
                ['is_active' => true]
            );
        }
    }
}
