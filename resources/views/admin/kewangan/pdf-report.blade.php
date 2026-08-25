<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <title>Laporan Untung & Rugi — NikaFleet</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #333333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .logo-sub {
            font-size: 11px;
            color: #666666;
            margin-top: 2px;
        }
        .report-title {
            text-align: right;
            float: right;
            margin-top: -45px;
        }
        .report-title h1 {
            font-size: 18px;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }
        .report-title p {
            font-size: 11px;
            color: #475569;
            margin: 4px 0 0 0;
        }
        .clear {
            clear: both;
        }
        
        /* Summary Grid */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .summary-card {
            width: 31%;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        .summary-card-label {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
        }
        .summary-card-value {
            font-size: 20px;
            font-weight: bold;
            margin-top: 6px;
            color: #0f172a;
        }
        .summary-card-sub {
            font-size: 10px;
            color: #94a3b8;
            margin-top: 4px;
        }
        
        /* Color themes */
        .card-revenue { background-color: #ecfdf5; border-color: #a7f3d0; color: #065f46; }
        .card-expense { background-color: #fef2f2; border-color: #fecaca; color: #991b1b; }
        .card-profit { background-color: #eff6ff; border-color: #bfdbfe; color: #1e40af; }
        .card-loss { background-color: #fffbeb; border-color: #fde68a; color: #854d0e; }

        /* Tables style */
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 6px;
            margin-bottom: 12px;
            margin-top: 20px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .data-table th {
            background-color: #f8fafc;
            border-bottom: 1px solid #cbd5e1;
            padding: 8px 10px;
            font-size: 11px;
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
            text-align: left;
        }
        .data-table td {
            border-bottom: 1px solid #f1f5f9;
            padding: 8px 10px;
            font-size: 12px;
            color: #334155;
        }
        .data-table tr.total-row td {
            font-weight: bold;
            border-top: 1px solid #cbd5e1;
            border-bottom: 2px double #475569;
            background-color: #f8fafc;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }
        
        /* Two-column layout */
        .column-left {
            width: 48%;
            float: left;
        }
        .column-right {
            width: 48%;
            float: right;
        }
        
        /* Insights */
        .insights-box {
            background-color: #f1f5f9;
            border-left: 4px solid #475569;
            padding: 12px 15px;
            border-radius: 4px;
            margin-top: 15px;
        }
        .insights-box h3 {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #1e293b;
            text-transform: uppercase;
        }
        .insights-item {
            margin-bottom: 6px;
            font-size: 11.5px;
            color: #334155;
        }
        .insights-item:last-child {
            margin-bottom: 0;
        }
        
        /* Page breaks */
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div>
            <p class="logo-text">NikaFleet</p>
            <p class="logo-sub">Sistem Pengurusan Fleet & Kewangan</p>
        </div>
        <div class="report-title">
            <h1>Laporan Untung & Rugi</h1>
            <p>Tarikh Penjanaan: {{ now()->format('d/m/Y h:i A') }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <!-- Period & Metadata -->
    <div style="margin-bottom: 20px;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="padding: 0; font-size: 12px; color: #475569;">
                    <strong>Tempoh Penyata:</strong> {{ $period_label }}
                </td>
                <td style="padding: 0; font-size: 12px; color: #475569; text-align: right;">
                    <strong>Status Operasi:</strong> AKTIF
                </td>
            </tr>
        </table>
    </div>

    <!-- Summary Row -->
    <table class="summary-table">
        <tr>
            <td class="summary-card card-revenue">
                <div class="summary-card-label">Jumlah Pendapatan</div>
                <div class="summary-card-value">RM {{ number_format($total_revenue, 2) }}</div>
                <div class="summary-card-sub">{{ $revenue_count }} Transaksi</div>
            </td>
            <td style="width: 3%; padding: 0;"></td>
            <td class="summary-card card-expense">
                <div class="summary-card-label">Jumlah Perbelanjaan</div>
                <div class="summary-card-value">RM {{ number_format($total_expense, 2) }}</div>
                <div class="summary-card-sub">{{ $expense_count }} Item Belanja</div>
            </td>
            <td style="width: 3%; padding: 0;"></td>
            @php
                $isProfit = $net_profit >= 0;
                $netClass = $isProfit ? 'card-profit' : 'card-loss';
                $statusText = $isProfit ? 'UNTUNG BERSIH' : 'RUGI BERSIH';
            @endphp
            <td class="summary-card {{ $netClass }}">
                <div class="summary-card-label">{{ $statusText }}</div>
                <div class="summary-card-value">RM {{ number_format($net_profit, 2) }}</div>
                <div class="summary-card-sub">Margin: {{ number_format($profit_margin, 1) }}%</div>
            </td>
        </tr>
    </table>

    <!-- Stacked Revenue and Expense Breakdown Tables -->
    <div>
        <div class="column-left">
            <div class="section-title">Pecahan Pendapatan</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Sumber Pendapatan</th>
                        <th class="text-right">Jumlah (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pendapatan Sewa</td>
                        <td class="text-right">{{ number_format($revenue_breakdown['rental'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Deposit Dikutip</td>
                        <td class="text-right">{{ number_format($revenue_breakdown['deposit'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Penalti</td>
                        <td class="text-right">{{ number_format($revenue_breakdown['penalty'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Lain-lain / Refund</td>
                        <td class="text-right">{{ number_format($revenue_breakdown['other_refund'], 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td>JUMLAH PENDAPATAN</td>
                        <td class="text-right">{{ number_format($total_revenue, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="column-right">
            <div class="section-title">Pecahan Perbelanjaan</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th class="text-right">Jumlah (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expense_breakdown as $label => $amount)
                        <tr>
                            <td>{{ $label }}</td>
                            <td class="text-right">{{ number_format($amount, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td>JUMLAH PERBELANJAAN</td>
                        <td class="text-right">{{ number_format($total_expense, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="clear"></div>
    </div>

    <!-- Page Break for Per-Car & Insights -->
    <div class="page-break"></div>

    <div class="header">
        <div>
            <p class="logo-text">NikaFleet</p>
            <p class="logo-sub">Sistem Pengurusan Fleet & Kewangan</p>
        </div>
        <div class="report-title">
            <h1>Laporan Kewangan Kereta</h1>
            <p>Lampiran Prestasi Kenderaan</p>
        </div>
        <div class="clear"></div>
    </div>

    <!-- Per-Car Profitability Table -->
    <div class="section-title">Prestasi Keuntungan Mengikut Kenderaan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama Kereta</th>
                <th>No. Pendaftaran</th>
                <th class="text-right">Pendapatan</th>
                <th class="text-right">Perbelanjaan</th>
                <th class="text-right">Untung Bersih</th>
                <th class="text-right">Margin %</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($car_profitability as $car)
                <tr>
                    <td style="font-weight: bold;">{{ $car['name'] }}</td>
                    <td>{{ $car['plate'] }}</td>
                    <td class="text-right">{{ number_format($car['revenue'], 2) }}</td>
                    <td class="text-right" style="color: #ef4444;">{{ number_format($car['expense'], 2) }}</td>
                    <td class="text-right" style="font-weight: bold; color: {{ $car['net'] >= 0 ? '#10b981' : '#ef4444' }};">
                        {{ number_format($car['net'], 2) }}
                    </td>
                    <td class="text-right" style="font-weight: bold;">{{ number_format($car['margin'], 1) }}%</td>
                    <td class="text-center" style="font-weight: bold; color: {{ $car['net'] >= 0 ? '#10b981' : '#ef4444' }};">
                        {{ $car['status'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Smart Insights Box -->
    <div class="insights-box">
        <h3>Analisis & Ulasan Perniagaan (Insights)</h3>
        @foreach($insights as $insight)
            <div class="insights-item">
                - {!! strip_tags($insight, '<strong><span>') !!}
            </div>
        @endforeach
    </div>

    <!-- Signature Footer -->
    <div style="margin-top: 60px; font-size: 11px; color: #64748b;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="padding: 0; width: 40%;">
                    <p style="margin: 0; border-bottom: 1px solid #cbd5e1; height: 50px;"></p>
                    <p style="margin: 5px 0 0 0; font-weight: bold;">Disediakan Oleh,</p>
                    <p style="margin: 2px 0 0 0;">Pengurusan Kewangan NikaFleet</p>
                </td>
                <td style="padding: 0; width: 20%;"></td>
                <td style="padding: 0; width: 40%; text-align: right;">
                    <p style="margin: 0; border-bottom: 1px solid #cbd5e1; height: 50px;"></p>
                    <p style="margin: 5px 0 0 0; font-weight: bold;">Disahkan Oleh,</p>
                    <p style="margin: 2px 0 0 0;">Pengarah Eksekutif NikaFleet</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
