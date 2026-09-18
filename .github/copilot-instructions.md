# Copilot Instructions for simkop-project

Overview
- Laravel 12 monolithic app (PHP 8.2). Controller-driven, Blade admin UI under resources/views/admin.
- Main domains: Purchase Orders, Invoices, Cash Daily, Vendor Tracking, Reports, and internal admin messaging/chat.

Quick commands
- Project setup: `composer setup` (installs deps, creates .env, runs migrations, builds frontend).
- Development: `composer dev` (runs `php artisan serve`, queue worker, and `npm run dev` via concurrently).
- Frontend build: `npm run build`.
- Tests: `composer test` or `php artisan test`.

Architecture & conventions
- Controllers + FormRequests are the primary boundary; avoid introducing a global service layer.
- Shared helpers are autoloaded via `composer.json` `autoload.files` (see `app/Helpers/helpers.php`).
- Routes and authorization live in `routes/web.php` using middleware groups (admin / superadmin).
- Eager-load relations for list views (example: `Invoice::with(['purchaseOrder','items'])`).

Invoice-specific conventions (practical examples)
- Central logic: `app/Http/Controllers/InvoiceController.php`. Routes use named prefixes (e.g. `invoices.create-po`, `invoices.store-po`).
- Number generation: `generateInvoiceNumber($type, $customPart)` in `app/Helpers/helpers.php`.
  - Sequence resets monthly; formats: `INV/YYYY/SEQ/ROMAN_MONTH` or `KOPKAR/...` for `MESIN_VENDING`.
  - `customPart` (manual/odoo) is inserted between year and sequence when present.
- PO flow: `storePO` (in `InvoiceController`) creates `Invoice`, inserts `InvoiceItem`s, increments `PurchaseOrder->used_qty`, then calls `refreshStatus()` on the PO.
- Validation: use `app/Http/Requests/StoreInvoicePORequest.php` — it performs post-validation checks (e.g. total qty <= PO remaining, PO not closed).

Exports & PDF
- Excel export uses `App\\Exports\\InvoiceExport` and `Maatwebsite\\Excel::download(...)`.
- PDF generation follows existing pattern with `Barryvdh\\DomPDF\\Facade\\Pdf` (see `InvoiceController` for examples).

Developer patterns to follow
- Put request validation in FormRequests under `app/Http/Requests` when present; only use inline validation for small or exceptional flows.
- Prefer database-level ordering/aggregation for reports (see `InvoiceController::showNonPO` / `showPO` grouping queries).
- Update PO quantities atomically inside DB transactions where controller already does (see `storePO` wrapping with `DB::beginTransaction()` / `commit()` / `rollBack()`).

Integration points & external deps
- Uses `maatwebsite/excel` for exports and `barryvdh/laravel-dompdf` for PDFs (declared in `composer.json`).
- Frontend assets built via `npm` and Vite; `composer dev` orchestrates a dev environment with `concurrently`.

Key files to inspect for changes
- routes/web.php
- app/Http/Controllers/InvoiceController.php
- app/Helpers/helpers.php (invoice number rules)
- app/Models/PurchaseOrder.php (methods: `remainingQty()`, `refreshStatus()`)
- app/Http/Requests/StoreInvoicePORequest.php
- app/Exports/InvoiceExport.php
- resources/views/admin/invoices/ (blade templates)

Do / Don't (project-specific)
- Do: Preserve route names and middleware groups; respect existing FormRequest validation and transaction boundaries.
- Do: Use `generateInvoiceNumber()` for invoice numbering—do not hardcode invoice formats.
- Don't: Add a global service layer or change invoice-number reset logic or `User->role` constants without tests and a migration plan.

If unclear or you need examples, ask which area (invoices, PO, exports, auth) to expand with file references and code snippets.

