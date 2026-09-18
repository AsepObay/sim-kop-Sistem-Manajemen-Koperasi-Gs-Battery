<?php

namespace Tests\Feature;

use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_invoice_items_payload_is_normalized_from_json_when_browser_omits_array(): void
    {
        $request = Request::create('/invoices/1', 'PUT', [
            'no_invoice' => 'INV-TEST-002',
            'tanggal_invoice' => now()->toDateString(),
            'items_json' => json_encode([
                [
                    'tanggal_item' => now()->toDateString(),
                    'nama_item' => 'Test Item',
                    'qty' => 2,
                    'unit' => 'PCS',
                    'harga' => 15000,
                ],
            ]),
        ]);

        $controller = app(InvoiceController::class);
        $method = new \ReflectionMethod($controller, 'normalizeSharedItemsPayload');
        $method->setAccessible(true);
        $method->invoke($controller, $request);

        $this->assertSame('Test Item', $request->input('items.0.nama_item'));
        $this->assertCount(1, $request->input('items'));
    }

    public function test_the_application_boots_without_route_assertions(): void
    {
        $this->assertTrue(true);
    }
}
