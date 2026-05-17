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
        .watermark {
            position: absolute;
            top: 30%;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 110px;
            color: #16a34a;
            opacity: 0.08;
            transform: rotate(-30deg);
            z-index: -999;
            font-weight: bold;
            letter-spacing: 8px;
        }
        .sheet {
            padding: 36px 40px;
            position: relative;
            z-index: 1;
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
            border: 1px solid #bbf7d0;
        }
        .status-unpaid {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
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
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px 14px;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    @if ($invoice->status_pembayaran === 'paid')
        <div class="watermark">LUNAS</div>
    @endif

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
                                'paid' => 'LUNAS',
                                'cancelled' => 'DIBATALKAN',
                                default => 'BELUM DIBAYAR',
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
                        <div
                            class="muted"
                            style="margin-top: 4px; padding-right: 20px"
                        >
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
                    <div class="label">Untuk Ditagihkan Kepada</div>
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

        <table class="two-col" style="margin-top: 16px">
            <tr>
                <td>
                    <div class="label">Kode Order</div>
                    <div
                        class="value"
                        style="
                            font-family: Courier, monospace;
                            font-weight: bold;
                        "
                    >
                        {{ $order->kode_order }}
                    </div>
                </td>
                <td>
                    <div class="label">Alamat Pengiriman</div>
                    @if ($order->alamat_pengiriman)
                        <div class="value muted" style="line-height: 1.4">
                            {{ $order->alamat_pengiriman }}
                        </div>
                    @else
                        <div class="value muted">-</div>
                    @endif
                </td>
            </tr>
        </table>

        @if ($order->nomor_resi)
            <div class="shipping-box">
                <div class="label" style="color: #0369a1; font-weight: bold">
                    Informasi Pengiriman (Pesanan Dikirim)
                </div>
                <div class="value" style="margin-top: 6px">
                    Ekspedisi:
                    <strong
                        style="text-transform: uppercase"
                        >{{ $order->ekspedisi ?? 'Kurir Internal' }}</strong
                    >
                    &nbsp;|&nbsp; No. Resi:
                    <strong
                        style="
                            font-family: Courier, monospace;
                            color: #0284c7;
                            font-size: 13px;
                        "
                        >{{ $order->nomor_resi }}</strong
                    >
                </div>
                @if ($order->shipped_at)
                    <div class="muted" style="margin-top: 6px; font-size: 10px">
                        Tanggal Dikirim: {{ $order->shipped_at->translatedFormat('d F Y, H:i') }} WIB
                    </div>
                @endif
            </div>
        @endif

        <table class="items">
            <thead>
                <tr>
                    <th>Deskripsi Produk</th>
                    <th style="text-align: center; width: 50px">Qty</th>
                    <th class="num" style="width: 100px">Harga Satuan</th>
                    <th class="num" style="width: 100px">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>
                            <div style="font-weight: bold; font-size: 11.5px">
                                {{ $item->produk->nama_produk }}
                            </div>
                            @if ($item->varian)
                                <div
                                    class="muted"
                                    style="margin-top: 3px; font-size: 10px"
                                >
                                    Varian: {{ $item->varian }}
                                </div>
                            @endif
                        </td>
                        <td style="text-align: center; font-weight: bold">
                            {{ $item->jumlah }}
                        </td>
                        <td class="num">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </td>
                        <td class="num" style="font-weight: bold">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals">
            <tr>
                <td class="muted">Subtotal Produk</td>
                <td style="text-align: right">
                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="muted">Ongkos Kirim</td>
                <td style="text-align: right" class="muted">
                    Diinfokan via WA
                </td>
            </tr>
            <tr>
                <td class="final" style="font-weight: bold">TOTAL TAGIHAN</td>
                <td class="final" style="text-align: right; font-weight: bold">
                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        @if ($order->catatan_pembeli)
            <div style="margin-top: 32px">
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
            Dokumen ini adalah bukti transaksi yang sah yang di-generate oleh
            sistem. <br />
            Jika ada pertanyaan, silakan hubungi penjual via WhatsApp.
        </div>
    </div>
</body>
</html>
