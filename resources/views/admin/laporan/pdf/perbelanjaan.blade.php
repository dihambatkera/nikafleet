<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <title>Laporan Perbelanjaan — NikaFleet</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header {
            border-bottom: 2px solid #2563eb;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .logo-text {
            font-size: 22px;
            font-weight: bold;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .logo-sub {
            font-size: 10px;
            color: #666666;
            margin-top: 2px;
        }
        .report-title {
            text-align: right;
            float: right;
            margin-top: -42px;
        }
        .report-title h1 {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }
        .report-title p {
            font-size: 10px;
            color: #475569;
            margin: 3px 0 0 0;
        }
        .clear {
            clear: both;
        }
        .summary-card {
            width: 30%;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #fee2e2;
            background-color: #fef2f2;
            color: #991b1b;
            margin-bottom: 20px;
        }
        .summary-card-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .summary-card-value {
            font-size: 20px;
            font-weight: bold;
            margin-top: 4px;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 10px;
            margin-top: 15px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th {
            background-color: #f8fafc;
            border-bottom: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 10px;
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
            text-align: left;
        }
        .data-table td {
            border-bottom: 1px solid #f1f5f9;
            padding: 6px 8px;
            font-size: 10px;
            color: #334155;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }
        .font-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <p class="logo-text">NikaFleet</p>
            <p class="logo-sub">Sistem Pengurusan Fleet & Kewangan</p>
        </div>
        <div class="report-title">
            <h1>Laporan Perbelanjaan</h1>
            <p>Tarikh Penjanaan: {{ now()->format('d/m/Y h:i A') }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <div style="margin-bottom: 15px;">
        <span style="font-size: 11px; color: #475569;">
            <strong>Tempoh Laporan:</strong> {{ $period_label }}
        </span>
    </div>

    <div class="summary-card">
        <div class="summary-card-label">Jumlah Perbelanjaan</div>
        <div class="summary-card-value">RM {{ number_format($total_expense, 2) }}</div>
    </div>

    <div class="section-title">Senarai Rekod Perbelanjaan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Tarikh</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Kereta</th>
                <th class="text-right">Jumlah (RM)</th>
                <th>Vendor</th>
                <th>Dibayar Oleh</th>
            </tr>
        </thead>
        <tbody>
            @php
                $categoriesMap = \App\Models\Expense::categories();
            @endphp
            @forelse($expenses as $expense)
                <tr>
                    <td>{{ $expense->expense_date ? $expense->expense_date->format('d/m/Y') : '' }}</td>
                    <td class="font-bold">{{ $categoriesMap[$expense->category] ?? $expense->category }}</td>
                    <td>{{ $expense->description }}</td>
                    <td class="font-bold">{{ $expense->car ? $expense->car->name : 'Operasi Umum' }}</td>
                    <td class="text-right font-bold" style="color: #ef4444;">
                        {{ number_format($expense->amount, 2) }}
                    </td>
                    <td>{{ $expense->vendor ?? 'N/A' }}</td>
                    <td>{{ $expense->paid_by ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px; color: #94a3b8;">
                        Tiada data perbelanjaan ditemui untuk tempoh ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
