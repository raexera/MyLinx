<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class PublicInvoiceController extends Controller
{
    public function show(string $token): Response
    {
        $order = Order::where('public_token', $token)
            ->with(['tenant.profilUsaha', 'orderItems.produk', 'invoice'])
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.invoice', [
            'order' => $order,
            'tenant' => $order->tenant,
            'profil' => $order->tenant->profilUsaha,
            'invoice' => $order->invoice,
        ])->setPaper('a4');

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Invoice-'.$order->invoice->nomor_invoice.'.pdf"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
