<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoiceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    public function __construct(private Collection $invoices)
    {
    }

    public function collection(): Collection
    {
        return $this->invoices;
    }

    public function headings(): array
    {
        return [
            'No Invoice',
            'Bisnis Internal',
            'No SO',
            'No PO',
            'Tipe',
            'Tanggal',
            'Total Nilai',
            'Total PPN',
            'Total Nilai + PPN',
        ];
    }

    public function map($invoice): array
    {
        $subtotal = $invoice->items->sum('subtotal');
        $hasPPN = in_array($invoice->tipe, ['PO', 'NON_PO', 'MESIN_VENDING']);
        $ppn = $hasPPN ? $subtotal * 0.11 : 0;
        $totalWithPpn = $hasPPN ? $subtotal + $ppn : $subtotal;

        // Prefer explicit `tipe_bisnis` (form input) when present; otherwise
        // fall back to parsed `internal_business` (from `no_po_manual` or invoice number).
        $bisnisInternal = $invoice->tipe_bisnis
            ? strtoupper($invoice->tipe_bisnis)
            : ($invoice->internal_business ? strtoupper($invoice->internal_business) : '-');

        $noPo = $invoice->display_po;

        return [
            $invoice->no_invoice,
            $bisnisInternal,
            $invoice->no_so ?? '-',
            $noPo,
            $invoice->tipe,
            $invoice->tanggal_invoice ? ExcelDate::stringToExcel($invoice->tanggal_invoice->toDateString()) : '',
            $subtotal,
            $hasPPN ? $ppn : '',
            $hasPPN ? $totalWithPpn : '',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F2F2F2'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
}
