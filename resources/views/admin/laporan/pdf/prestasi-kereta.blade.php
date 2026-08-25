<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <title>Laporan Prestasi Kereta — NikaFleet</title>
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
            <h1>Laporan Prestasi Kereta</h1>
            <p>Tarikh Penjanaan: {{ now()->format('d/m/Y h:i A') }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <div style="margin-bottom: 15px;">
        <span style="font-size: 11px; color: #475569;">
            <strong>Tempoh Laporan:</strong> {{ $period_label }}
        </span>
    </div>

    <div class="section-title">Pecahan Prestasi Setiap Kenderaan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama Kereta</th>
                <th>No. Pendaftaran</th>
                <th class="text-center">Hari Tersedia</th>
                <th class="text-center">Hari Disewa</th>
                <th class="text-center">Kadar Penginapan %</th>
                <th class="text-right">Pendapatan (RM)</th>
                <th class="text-right">Perbelanjaan (RM)</th>
                <th class="text-right">Sumbangan Bersih (RM)</th>
                <th class="text-center">Bilangan Sewaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($performanceData as $row)
                <tr>
                    <td class="font-bold">{{ $row['name'] }}</td>
                    <td>{{ $row['plate_number'] }}</td>
                    <td class="text-center">{{ $row['days_available'] }}</td>
                    <td class="text-center">{{ $row['days_rented'] }}</td>
                    <td class="text-center font-bold" style="color: {{ $row['occupancy_rate'] > 50 ? '#10b981' : '#f59e0b' }};">
                        {{ number_format($row['occupancy_rate'], 1) }}%
                    </td>
                    <td class="text-right">{{ number_format($row['revenue'], 2) }}</td>
                    <td class="text-right" style="color: #ef4444;">{{ number_format($row['expense'], 2) }}</td>
                    <td class="text-right font-bold" style="color: {{ $row['net'] >= 0 ? '#10b981' : '#ef4444' }};">
                        {{ number_format($row['net'], 2) }}
                    </td>
                    <td class="text-center">{{ $row['rentals_count'] }} sewaan</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px; color: #94a3b8;">
                        Tiada data prestasi kereta ditemui.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
