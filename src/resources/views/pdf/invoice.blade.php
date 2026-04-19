<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Invoice {{ $invoice->nomor_invoice }}</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: "Helvetica", "Arial", sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            margin: 0;
            padding: 0;
        }
        .sheet {
            padding: 36px 40px;
        }
        .header {
            border-bottom: 2px solid #1a1a1a;
            padding-bottom: 18px;
            margin-bottom: 24px;
        }
        .header h1 {
            font-size: 28px;
            font-weight: normal;
            letter-spacing: -0.5px;
            margin: 0;
        }
        .header .sub {
            color: #666;
            font-size: 11px;
            margin-top: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .two-col td {
            width: 50%;
            vertical-align: top;
            padding-bottom: 12px;
        }
        .label {
            font-size: 8.5px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .value {
            font-size: 12px;
            color: #1a1a1a;
        }
        .muted {
            color: #666;
        }
        .items {
            margin-top: 28px;
        }
        .items th {
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 8px;
            font-weight: normal;
        }
        .items td {
            padding: 14px 8px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: top;
        }
        .items td.num {
            text-align: right;
            white-space: nowrap;
        }
        .totals {
            margin-top: 20px;
            width: 280px;
            margin-left: auto;
        }
        .totals td {
            padding: 6px 8px;
            font-size: 12px;
        }
        .totals .final {
            border-top: 2px solid #1a1a1a;
            font-size: 14px;
            padding-top: 12px;
        }
        .status-badge {
            display: inline-block;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 4px 10px;
            border-radius: 12px;
        }
        .status-paid {
            background: #dcfce7;
            color: #15803d;
        }
        .status-unpaid {
            background: #fef3c7;
            color: #92400e;
        }
        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }
        .footer {
            margin-top: 48px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            font-size: 10px;
            color: #999;
            text-align: center;
        }
        .shipping-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px 14px;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="header">
            <table>
                <tr>
                    <td style="width: 65%">
                        <h1>INVOICE</h1>
                        <div class="sub">{{ $invoice->nomor_invoice }}</div>
                    </td>
                    <td style="width: 35%; text-align: right">
                        @php
                        $payStatus = $invoice->status_pembayaran;
                        $statusCls = 'status-' . $payStatus;
                        $statusLbl = match($payStatus) {
                            'paid' => 'Lunas',
                            'cancelled' => 'Dibatalkan',
                            default => 'Belum Dibayar',
                        };
                    @endphp
                        <span
                            class="status-badge {{ $statusCls }}"
                            >{{ $statusLbl }}</span
                        >
                        <div
                            class="muted"
                            style="margin-top: 6px; font-size: 10px"
                        >
                            {{ $order->created_at->translatedFormat('d F Y') }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <table class="two-col">
            <tr>
                <td>
                    <div class="label">Dari</div>
                    <div class="value" style="font-weight: bold">
                        {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                    </div>
                    @if ($profil?->alamat)
                        <div class="muted" style="margin-top: 4px">
                            {{ $profil->alamat }}
                        </div>
                    @endif
                    @if ($profil?->no_hp)
                        <div class="muted" style="margin-top: 2px">
                            WA: {{ $profil->no_hp }}
                        </div>
                    @endif
                </td>
                <td>
                    <div class="label">Untuk</div>
                    <div class="value" style="font-weight: bold">
                        {{ $order->nama_pembeli }}
                    </div>
                    <div class="muted" style="margin-top: 4px">
                        {{ $order->email_pembeli }}
                    </div>
                    @if ($order->no_hp_pembeli)
                        <div class="muted">WA: {{ $order->no_hp_pembeli }}</div>
                    @endif
                </td>
            </tr>
        </table>
        <table class="two-col" style="margin-top: 8px">
            <tr>
                <td>
                    <div class="label">Kode Order</div>
                    <div class="value" style="font-family: Courier, monospace">
                        {{ $order->kode_order }}
                    </div>
                </td>
                <td>
                    <div class="label">Status Pesanan</div>
                    <div class="value">{{ ucfirst($order->status) }}</div>
                </td>
            </tr>
        </table>
        <table class="items">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th style="text-align: center; width: 60px">Qty</th>
                    <th class="num" style="width: 110px">Harga Satuan</th>
                    <th class="num" style="width: 110px">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>
                            <div style="font-weight: bold">
                                {{ $item->produk->nama_produk }}
                            </div>
                            @if ($item->varian)
                                <div
                                    class="muted"
                                    style="margin-top: 2px; font-size: 10px"
                                >
                                    {{ $item->produk->varian_label ?? 'Varian' }}: {{ $item->varian }}
                                </div>
                            @endif
                        </td>
                        <td style="text-align: center">{{ $item->jumlah }}</td>
                        <td class="num">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </td>
                        <td class="num">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="totals">
            <tr>
                <td class="muted">Subtotal</td>
                <td style="text-align: right">
                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="muted">Ongkos Kirim</td>
                <td style="text-align: right" class="muted">Via WhatsApp</td>
            </tr>
            <tr>
                <td class="final" style="font-weight: bold">Total Produk</td>
                <td class="final" style="text-align: right; font-weight: bold">
                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                </td>
            </tr>
        </table>
        @if ($order->nomor_resi)
            <div class="shipping-box">
                <div class="label">Informasi Pengiriman</div>
                <div class="value" style="margin-top: 4px">
                    <strong>{{ $order->ekspedisi }}</strong> · No. Resi:
                    <span
                        style="font-family: Courier, monospace"
                        >{{ $order->nomor_resi }}</span
                    >
                </div>
                @if ($order->shipped_at)
                    <div class="muted" style="margin-top: 4px; font-size: 10px">
                        Dikirim {{ $order->shipped_at->translatedFormat('d F Y, H:i') }} WIB
                    </div>
                @endif
            </div>
        @endif
        @if ($order->alamat_pengiriman)
            <div style="margin-top: 24px">
                <div class="label">Alamat Pengiriman</div>
                <div
                    class="value muted"
                    style="margin-top: 4px; line-height: 1.5"
                >
                    {{ $order->alamat_pengiriman }}
                </div>
            </div>
        @endif
        @if ($order->catatan_pembeli)
            <div style="margin-top: 16px">
                <div class="label">Catatan Pembeli</div>
                <div
                    class="value muted"
                    style="
                        margin-top: 4px;
                        line-height: 1.5;
                        font-style: italic;
                    "
                >
                    "{{ $order->catatan_pembeli }}"
                </div>
            </div>
        @endif
        <div class="footer">
            Dokumen ini dibuat otomatis oleh MyLinx. Untuk pertanyaan, hubungi
            penjual via WhatsApp.
        </div>
    </div>
</body>
</html>
