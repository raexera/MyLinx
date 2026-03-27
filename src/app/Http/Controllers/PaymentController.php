<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Display the list of invoices for the current tenant.
     *
     * Fetches invoices through the orders relationship:
     * Invoice → belongsTo Order → where tenant_id matches.
     *
     * Eager-loads the order for displaying order code and buyer info.
     */
    public function index(): View
    {
        $invoices = Invoice::whereHas('order', function ($query) {
                $query->where('tenant_id', auth()->user()->tenant_id);
            })
            ->with(['order' => fn ($q) => $q->select('id', 'kode_order', 'nama_pembeli', 'total_harga', 'status')])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('payment.index', compact('invoices'));
    }
}
