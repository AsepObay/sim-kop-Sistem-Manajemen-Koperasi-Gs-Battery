@props(['invoice'])

<style>
/* Invoice Detail design system (shared) */
.invoice-shell { background:#f7f9fb; padding:18px 0; }
.invoice-card { background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 6px 16px rgba(2,6,23,0.03); overflow:hidden }
.invoice-card-header{ padding:14px 18px; border-bottom:1px solid #eef2f6 }
.invoice-card-header h2{ margin:0; font-size:18px; color:#0b2545 }
.invoice-card-sub{ font-size:13px; color:#6b7280; margin-top:6px }
.invoice-info-body{ padding:16px 18px }
.invoice-grid{ display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px 18px }
.invoice-field-label{ display:block; font-size:12px; color:#6b7280; margin-bottom:6px }
.invoice-field-value{ font-size:14px; color:#0f172a }
.invoice-summary-badge{ display:inline-flex; align-items:center; gap:8px; padding:8px 10px; border-radius:10px; background:#f1f5f9; color:#0f172a; font-weight:600 }
.invoice-summary-sub{ font-size:12px; color:#475569 }
.invoice-items-card{ margin-top:16px }
.invoice-table{ width:100%; border-collapse:collapse }
.invoice-table thead th{ background:#fbfdfe; color:#475569; font-size:13px; font-weight:600; padding:10px; border-bottom:1px solid #eef2f6 }
.invoice-table tbody td, .invoice-table tfoot td{ padding:10px; color:#334155; border-bottom:1px solid #f1f5f9 }
.invoice-table tbody tr:hover{ background:#fbfbfd }
.invoice-table tfoot tr td{ background:transparent; border-top:1px solid #eef2f6 }
.invoice-table tfoot tr:last-child td{ font-weight:700; font-size:15px; color:#0b2545 }
.text-end{ text-align:right }
.text-center{ text-align:center }

@media (max-width: 768px){
  .invoice-grid{ grid-template-columns: 1fr }
}
</style>

<!-- Breadcrumb + Title -->
<div class="page-header invoice-shell">
  <div class="page-block">
    <div class="row align-items-center">
      <div class="col-md-12">
        @include('layouts.dashboard-breadcrumb', ['current' => 'Detail Invoice'])
      </div>
      <div class="col-md-12 mt-2">
        <div class="invoice-card">
          <div class="invoice-card-header">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h2>Detail Invoice</h2>
                <div class="invoice-card-sub">Informasi lengkap invoice dan item tagihan</div>
              </div>
              <div class="text-end">
                <span class="invoice-summary-badge">{{ $invoice->tipe }}</span>
                <div class="invoice-summary-sub mt-1">@if($invoice->tipe === 'PASCABAYAR') Rekap tanpa PPN @elseif($invoice->tipe === 'PO') Rekap pivot dihitung per invoice ini. @else Ringkasan invoice @endif</div>
              </div>
            </div>
          </div>

          <div class="invoice-info-body">
            <div class="invoice-grid">
              <div>
                <label class="invoice-field-label">No Invoice</label>
                <div class="invoice-field-value">{{ $invoice->no_invoice }}</div>

                <label class="invoice-field-label mt-2">No SO</label>
                <div class="invoice-field-value">{{ $invoice->no_so ?? '-' }}</div>

                <label class="invoice-field-label mt-2">Tanggal Invoice</label>
                <div class="invoice-field-value">{{ optional($invoice->tanggal_invoice)->format('d/m/Y') ?? '-' }}</div>
              </div>

              <div>
                <label class="invoice-field-label">Tipe</label>
                <div class="invoice-field-value"><span class="badge bg-light text-dark">{{ $invoice->tipe }}</span></div>

                <label class="invoice-field-label mt-2">Bisnis Internal</label>
                <div class="invoice-field-value">{{ $invoice->tipe_bisnis ?? ($invoice->internal_business ? strtoupper($invoice->internal_business) : '-') }}</div>

                <label class="invoice-field-label mt-2">No PO</label>
                <div class="invoice-field-value">{{ $invoice->no_po_manual ?? ($invoice->purchaseOrder->no_po ?? '-') }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
