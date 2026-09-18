<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $invoice->no_invoice }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        @page {
            size: A4 portrait;
            margin-top: 22mm;
            margin-right: 16mm;
            margin-bottom: 18mm;
            margin-left: 16mm;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #000;
            position: relative;
            padding: 0;
        }

        .page-wrapper {
            width: auto;
            padding: 4mm 7mm 5mm 6mm;
        }
        
        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(0, 0, 0, 0.05);
            font-weight: bold;
            z-index: -1;
            letter-spacing: 10px;
        }
        
        /* Header Section */
        .header-table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            table-layout: fixed;
        }
        
        .header-table td {
            vertical-align: top;
            padding: 5px 8px;
        }
        
        .logo-section {
            width: 60%;
            padding-right: 10px;
        }
        
        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 5px;
        }
        
        .company-name {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 3px;
        }
        
        .company-info {
            font-size: 10px;
            line-height: 1.4;
        }
        
        .invoice-section {
            width: 40%;
            padding-left: 12px;
            padding-right: 14px;
            text-align: right;
        }
        
        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #000000ff;
            margin-bottom: 10px;
            letter-spacing: 1px;
            padding-right: 4px;
        }
        
        .invoice-details {
            font-size: 11px;
            line-height: 1.8;
        }
        
        .invoice-details strong {
            display: inline-block;
            width: 80px;
            text-align: left;
        }

        .invoice-meta-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-left: auto;
        }

        .invoice-meta-table td {
            padding-top: 5px;
            padding-bottom: 5px;
            vertical-align: top;
        }

        .invoice-meta-label {
            width: 36%;
            padding-right: 10px;
            text-align: right;
            font-weight: bold;
            color: #555;
            white-space: nowrap;
        }

        .invoice-meta-value {
            width: 64%;
            padding-left: 8px;
            text-align: left;
            color: #000;
            word-break: break-word;
        }
        
        /* Address Box */
        .address-box {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }
        
        .address-box strong {
            display: block;
            margin-bottom: 5px;
        }
        
        /* Items Table */
        .items-table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            table-layout: fixed;
        }
        
        .items-table th {
            background-color: #fff;
            color: #000;
            font-weight: bold;
            padding: 8px 5px;
            border: 1px solid #000;
            text-align: center;
            font-size: 11px;
        }
        
        .items-table td {
            border: 1px solid #000;
            padding: 6px 5px;
            font-size: 10px;
        }
        
        .items-table .text-center {
            text-align: center;
        }
        
        .items-table .text-right {
            text-align: right;
        }
        
        .items-table .text-left {
            text-align: left;
        }
        
        /* Total Section */
        .total-section {
            width: 100%;
            margin-bottom: 20px;
        }
        
        .total-table {
            float: right;
            width: 300px;
            border-collapse: collapse;
        }
        
        .total-table td {
            padding: 5px 10px;
            border: 1px solid #353535ff;
        }
        
        .total-table .label {
            background-color: #f0f0f0;
            font-weight: bold;
            width: 150px;
        }
        
        .total-table .value {
            text-align: right;
            width: 150px;
        }
        
        .total-table .grand-total-label {
            background-color: #fff;
            color: #000;
            font-weight: bold;
            font-size: 12px;
        }

        .total-table .grand-total-value {
            background-color: #fff;
            color: #000;
            font-weight: bold;
            font-size: 12px;
        }
        
        /* Terbilang */
        .terbilang-box {
            clear: both;
            border: 1px solid #000;
            padding: 8px;
            margin-bottom: 20px;
            background-color: #fffef0;
            font-style: italic;
        }
        
        /* Footer Section */
        .footer-section {
            width: 100%;
            margin-top: 30px;
        }
        
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .footer-table td {
            vertical-align: top;
            padding: 0 10px;
        }
        
        .bank-box {
            border: 1px solid #000;
            padding: 10px;
            background-color: #f9f9f9;
        }
        
        .bank-box strong {
            display: block;
            margin-bottom: 5px;
        }
        
        .bank-info {
            line-height: 1.6;
        }
        
        .signature-box {
            text-align: center;
        }
        
        .signature-space {
            height: 60px;
        }
        
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
        
        /* Utility Classes */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
    <!-- Watermark -->
    <div class="watermark">INVOICE</div>
    
    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td class="logo-section">
                <!-- Logo Koperasi -->
                <img src="{{ public_path('assets/images/kopkar.png') }}" 
                     style="width: 80px; height: auto; max-height: 80px; margin-bottom: 5px; display: block;" 
                     alt="Logo Koperasi">
                
                <div class="company-name">KOPERASI KARYAWAN</div>
                <div class="company-name">PT. GS BATTERY – KARAWANG</div>
                
                <div class="company-info">
                    <strong>Badan Hukum:</strong>88H/BH/KWK/10/IV/1998<br>
                    Jl. Surya Utama kav. I.3 – I.4 Teluk Jambe – Karawang 41361<br>
                    Phones : (0267) 440961 – 64 ( Ext 3414 ) Telpon : 0896 7143 22243<br>
                    NPWP : 01.951.061.9-433.000
                </div>
            </td>
            
            <td class="invoice-section">
                <div class="invoice-title">INVOICE</div>
                
                <table class="invoice-meta-table" style="font-size: 11px;">
                    <tr>
                        <td class="invoice-meta-label">No Invoice:</td>
                        <td class="invoice-meta-value" style="font-weight: bold;">{{ $invoice->no_invoice }}</td>
                    </tr>
                    <tr>
                        <td class="invoice-meta-label">Tanggal:</td>
                        <td class="invoice-meta-value">{{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->isoFormat('D MMMM Y') }}</td>
                    </tr>
                    <tr>
                        <td class="invoice-meta-label">No PO:</td>
                        <td class="invoice-meta-value">{{ $invoice->display_po }}</td>
                    </tr>
                    <tr>
                        <td class="invoice-meta-label">No SO:</td>
                        <td class="invoice-meta-value">{{ $invoice->no_so ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="invoice-meta-label">Type Bisnis Internal:</td>
                        <td class="invoice-meta-value">{{ $invoice->tipe_bisnis ?? ($invoice->internal_business ? strtoupper($invoice->internal_business) : '-') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <!-- Address Section -->
    <div class="address-box">
        Kepada Yth : PT GS BATTERY Karawang Plant<br>
        Kawasan Industri Suryacipta<br>
        Jll. Surya Utama Kav. I.3 - I.4 Ciampel - Karawang
    </div>
    
    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 32%;">Item Barang</th>
                <th style="width: 8%;">Qty</th>
                <th style="width: 8%;">Unit</th>
                <th style="width: 15%;">Harga</th>
                <th style="width: 24%;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_item)->format('d/m/Y') }}</td>
                <td class="text-left">{{ $item->nama_item }}</td>
                <td class="text-center">{{ $item->qty }}</td>
                <td class="text-center">{{ $item->unit }}</td>
                <td class="text-right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Total Section -->
    <div class="total-section clearfix">
        <table class="total-table">
            <tr>
                <td class="label">Sub Total Qty Barang</td>
                <td class="value">{{ number_format($subtotalQty ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Subtotal</td>
                <td class="value">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            @if(!in_array($invoice->tipe, ['PULSA_MODEM', 'VOUCHER']))
            <tr>
                <td class="label">PPN {{ $invoice->tipe === 'PASCABAYAR' ? '0%' : '11%' }}</td>
                <td class="value">Rp {{ number_format($ppn, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($invoice->tipe === 'MESIN_VENDING')
            <tr>
                <td class="label">PPh -10%</td>
                <td class="value">- Rp {{ number_format($pph ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr>
                <td class="label grand-total-label">GRAND TOTAL</td>
                <td class="value grand-total-value">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    
    <!-- Terbilang -->
    <div class="terbilang-box">
        <strong>Terbilang:</strong> 
        <span style="text-transform: capitalize;">{{ ucwords(strtolower(terbilang($grandTotal))) }} Rupiah</span>
    </div>
    
    <!-- Footer Section -->
    <table class="footer-table">
        <tr>
            <td style="width: 50%;">
                <div class="bank-box">
                    <strong>Transfer Ke Rekening:</strong>
                    <div class="bank-info">
                        A/N         : KOPKAR PT GS BATTERY INC<br>
                        Bank        : BNI<br>
                        No. Rekening: 0001921088<br>
                    </div>
                </div>
            </td>
            
            <td style="width: 50%;">
                <div class="signature-box">
                    <div style="margin-bottom: 5px;"><strong>Hormat Kami,</strong></div>
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $signedBy->name ?? 'Asep Obay Badilah' }}</div>
                    <div style="font-size: 9px; margin-top: 3px;">Koperasi Karyawan PT GS Battery</div>
                </div>
            </td>
        </tr>
    </table>
    
    <!-- Page Footer -->
    <div style="margin-top: 30px; text-align: center; font-size`: 9px; color: #666; border-top: 1px solid #ccc; padding-top: 10px;">
        Invoice ini dicetak secara otomatis dan sah tanpa tanda tangan<br>
        Dicetak pada: {{ now()->isoFormat('dddd, D MMMM Y HH:mm') }} WIB
    </div>
    </div>
</body>
</html>
