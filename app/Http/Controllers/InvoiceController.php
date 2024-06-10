<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;

class InvoiceController extends Controller
{
    public function generateInvoice(Request $request)
    {
        $items = $request->input('items');

        $lineItems = [];
        foreach ($items as $item) {
            $unitAmount = (int)($item['price'] * 100);
            $lineItems[] = [
                'description' => $item['name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
            ];
        }

        $invoiceData = [
            'invoice_number' => 'INV-' . $request->input('invNo'),
            'date' => $request->input('date'),
            'bill_to' => [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ],
            'items' => $lineItems,
            'notes' => 'Thank you for your business!',
        ];

        $totals = $this->calculateTotals($invoiceData['items']);

        $html = view('invoice', compact('invoiceData', 'totals'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('invoice.pdf');
    }

    private function calculateTotals($items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }
        return ['total' => $total];
    }
}
