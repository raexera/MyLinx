<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Display the list of invoices for the current tenant.
     *
     * Supports query params:
     * - ?search=INV-2026     → filters by nomor_invoice or kode_order
     * - ?status=paid         → filters by status_pembayaran
     */
    public function index(): View
    {
        $tenantId = auth()->user()->tenant_id;

        // Aggregate stats from DB (not from paginated collection)
        $stats = [
            'total_revenue' => Order::where('tenant_id', $tenantId)
                ->whereHas('invoice', fn ($q) => $q->where('status_pembayaran', 'paid'))
                ->sum('total_harga'),

            'paid_count' => Invoice::whereHas('order', fn ($q) => $q->where('tenant_id', $tenantId))
                ->where('status_pembayaran', 'paid')
                ->count(),

            'unpaid_count' => Invoice::whereHas('order', fn ($q) => $q->where('tenant_id', $tenantId))
                ->where('status_pembayaran', 'unpaid')
                ->count(),

            'cancelled_count' => Invoice::whereHas('order', fn ($q) => $q->where('tenant_id', $tenantId))
                ->where('status_pembayaran', 'cancelled')
                ->count(),

            'total_count' => Invoice::whereHas('order', fn ($q) => $q->where('tenant_id', $tenantId))
                ->count(),

            // Unpaid amount (revenue at risk)
            'unpaid_amount' => Order::where('tenant_id', $tenantId)
                ->whereHas('invoice', fn ($q) => $q->where('status_pembayaran', 'unpaid'))
                ->sum('total_harga'),
        ];

        $invoices = Invoice::whereHas('order', fn ($q) => $q->where('tenant_id', $tenantId))
            ->when(request('search'), function ($q, $term) {
                $q->where(function ($sub) use ($term) {
                    $sub->where('nomor_invoice', 'ilike', "%{$term}%")
                        ->orWhereHas('order', fn ($o) => $o->where('kode_order', 'ilike', "%{$term}%")
                            ->orWhere('nama_pembeli', 'ilike', "%{$term}%"));
                });
            })
            ->when(request('status'), fn ($q, $status) => $q->where('status_pembayaran', $status))
            ->with(['order' => fn ($q) => $q->select('id', 'kode_order', 'nama_pembeli', 'total_harga', 'status')])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('payment.index', compact('invoices', 'stats'));
    }

    /**
     * Export filtered invoices to CSV for accounting / tax reporting.
     */
    public function export(): StreamedResponse
    {
        $tenantId = auth()->user()->tenant_id;

        $invoices = Invoice::whereHas('order', fn ($q) => $q->where('tenant_id', $tenantId))
            ->when(request('search'), function ($q, $term) {
                $q->where(function ($sub) use ($term) {
                    $sub->where('nomor_invoice', 'ilike', "%{$term}%")
                        ->orWhereHas('order', fn ($o) => $o->where('kode_order', 'ilike', "%{$term}%")
                            ->orWhere('nama_pembeli', 'ilike', "%{$term}%"));
                });
            })
            ->when(request('status'), fn ($q, $status) => $q->where('status_pembayaran', $status))
            ->with('order')
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'invoices-' . now()->format('Y-m-d-His') . '.csv';

        $callback = function () use ($invoices) {
            $out = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility (penting untuk karakter Rupiah)
            fputs($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'Nomor Invoice',
                'Tanggal Terbit',
                'Kode Order',
                'Nama Pembeli',
                'Jumlah (Rp)',
                'Status Pembayaran',
                'Status Order',
            ]);

            foreach ($invoices as $invoice) {
                fputcsv($out, [
                    $invoice->nomor_invoice,
                    $invoice->created_at->format('Y-m-d H:i'),
                    $invoice->order->kode_order ?? '-',
                    $invoice->order->nama_pembeli ?? '-',
                    $invoice->order->total_harga ?? 0,
                    $invoice->status_pembayaran,
                    $invoice->order->status ?? '-',
                ]);
            }

            // Summary row for accountant convenience
            fputcsv($out, []);
            fputcsv($out, ['--- RINGKASAN ---']);
            fputcsv($out, ['Total invoice', $invoices->count()]);
            fputcsv($out, ['Total terbayar (Rp)', $invoices->where('status_pembayaran', 'paid')->sum(fn ($i) => $i->order->total_harga ?? 0)]);
            fputcsv($out, ['Total belum dibayar (Rp)', $invoices->where('status_pembayaran', 'unpaid')->sum(fn ($i) => $i->order->total_harga ?? 0)]);
            fputcsv($out, ['Periode export', now()->format('Y-m-d H:i')]);

            fclose($out);
        };

        return response()->stream($callback, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
