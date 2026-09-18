<?php

if (!function_exists('terbilang')) {
    /**
     * Convert number to Indonesian words
     * 
     * @param int|float $number
     * @return string
     */
    function terbilang($number)
    {
        $number = abs($number);
        $words = [
            '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima',
            'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh',
            'Sebelas'
        ];

        if ($number < 12) {
            return $words[$number];
        }

        if ($number < 20) {
            return $words[$number - 10] . ' Belas';
        }

        if ($number < 100) {
            return $words[(int)($number / 10)] . ' Puluh ' . $words[$number % 10];
        }

        if ($number < 200) {
            return 'Seratus ' . terbilang($number - 100);
        }

        if ($number < 1000) {
            return $words[(int)($number / 100)] . ' Ratus ' . terbilang($number % 100);
        }

        if ($number < 2000) {
            return 'Seribu ' . terbilang($number - 1000);
        }

        if ($number < 1000000) {
            return terbilang((int)($number / 1000)) . ' Ribu ' . terbilang($number % 1000);
        }

        if ($number < 1000000000) {
            return terbilang((int)($number / 1000000)) . ' Juta ' . terbilang($number % 1000000);
        }

        if ($number < 1000000000000) {
            return terbilang((int)($number / 1000000000)) . ' Miliar ' . terbilang($number % 1000000000);
        }

        return terbilang((int)($number / 1000000000000)) . ' Triliun ' . terbilang($number % 1000000000000);
    }
}

if (!function_exists('getRomanMonth')) {
    /**
     * Convert month number to Roman numerals
     * 
     * @param int $month
     * @return string
     */
    function getRomanMonth($month = null)
    {
        if ($month === null) {
            $month = date('n');
        }

        $romanMonths = [
            'I', 'II', 'III', 'IV', 'V', 'VI',
            'VII', 'VIII', 'IX', 'X', 'XI', 'XII'
        ];

        return $romanMonths[$month - 1] ?? '';
    }
}

if (!function_exists('generateInvoiceNumber')) {
    /**
     * Generate invoice number automatically
     * Sequence resets to 001 every month for ALL invoice types
     *
     * New desired format when manual/odoo part is provided:
     *   INV/YYYY/ODOO/SEQ/ROMAN_MONTH
     * If no manual part provided, fallback to:
     *   INV/YYYY/SEQ/ROMAN_MONTH
     *
     * MESIN_VENDING uses KOPKAR prefix instead of INV.
     *
     * @param string $type PO, NON_PO, PASCABAYAR, MESIN_VENDING, PULSA_MODEM, VOUCHER
     * @param string|null $customPart Manual/odoo part to include between year and sequence
     * @return string
     */
    function generateInvoiceNumber($type = 'PO', $customPart = null)
    {
        $year = date('Y');
        $month = getRomanMonth();
        $currentMonth = date('n');
        
        // Get the last invoice number for this type, year, and current month
        // Sequence resets to 001 every month
        $lastInvoice = \App\Models\Invoice::where('tipe', $type)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $currentMonth)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = 1;
        if ($lastInvoice) {
            // Extract sequence from last invoice
            // Formats handled:
            // - INV/YYYY/SEQ/MONTH (PO/NON_PO)
            // - INV/YYYY/CUSTOM/SEQ/MONTH (PO with Odoo)
            // - INV/YYYY/SEQ/TYPE/MONTH (PASCABAYAR, VOUCHER, PULSA_MODEM)
            // - KOPKAR/YYYY/SEQ/MONTH or KOPKAR/YYYY/CUSTOM/SEQ/MONTH (VENDING)
            
            // Try to find sequence pattern: look for 3-digit number followed by either /LETTER or /ROMAN/LETTER
            if (preg_match('/\/(\d{3})(?:\/[A-Z]+){1,2}$/', $lastInvoice->no_invoice, $matches)) {
                $sequence = (int)$matches[1] + 1;
            }
        }

        $seq = str_pad($sequence, 3, '0', STR_PAD_LEFT);

        // Special format for MESIN_VENDING
        if ($type === 'MESIN_VENDING') {
            if ($customPart) {
                return "KOPKAR/{$year}/{$customPart}/{$seq}/{$month}";
            }

            return "KOPKAR/{$year}/{$seq}/{$month}";
        }

        // Special format for VOUCHER (auto-generated, no manual part)
        if ($type === 'VOUCHER') {
            return "INV/{$year}/{$seq}/VOUCHER/{$month}";
        }

        // Special format for PASCABAYAR (auto-generated, no manual part)
        if ($type === 'PASCABAYAR') {
            return "INV/{$year}/{$seq}/PASCA/{$month}";
        }

        // Special format for PULSA_MODEM (auto-generated, with IT marker)
        if ($type === 'PULSA_MODEM') {
            return "INV/{$year}/{$seq}/IT/{$month}";
        }

        // If a manual/odoo part is provided, put it between year and sequence
        if ($customPart) {
            return "INV/{$year}/{$customPart}/{$seq}/{$month}";
        }

        return "INV/{$year}/{$seq}/{$month}";
    }
}
