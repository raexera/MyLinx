<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class PublicInvoiceController extends Controller
{
    /**
     * Render invoice PDF inline in browser.
     * Accessed via unguessable public_token — used in WA-shared links.
     */
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

        return $pdf->stream('Invoice-'.$order->invoice->nomor_invoice.'.pdf');
    }
}
