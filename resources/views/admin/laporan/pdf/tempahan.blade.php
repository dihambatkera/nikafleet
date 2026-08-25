<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <title>Laporan Tempahan — NikaFleet</title>
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
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .summary-card {
            width: 22%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        .summary-card-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
        }
        .summary-card-value {
            font-size: 18px;
            font-weight: bold;
            margin-top: 4px;
            color: #0f172a;
        }
        .card-revenue { background-color: #ecfdf5; border-color: #a7f3d0; color: #065f46; }
        .card-completed { background-color: #eff6ff; border-color: #bfdbfe; color: #1e40af; }
        .card-cancelled { background-color: #fef2f2; border-color: #fecaca; color: #991b1b; }
        .card-total { background-color: #f8fafc; border-color: #cbd5e1; color: #334155; }

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
        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-confirmed { background-color: #dbeafe; color: #1e40af; }
        .badge-active { background-color: #d1fae5; color: #065f46; }
        .badge-completed { background-color: #e2e8f0; color: #475569; }
        .badge-cancelled { background-color: #fee2e2; color: #991b1b; }
        .badge-refunded { background-color: #f3e8ff; color: #6b21a8; }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <p class="logo-text">NikaFleet</p>
            <p class="logo-sub">Sistem Pengurusan Fleet & Kewangan</p>
        </div>
        <div class="report-title">
            <h1>Laporan Tempahan</h1>
            <p>Tarikh Penjanaan: {{ now()->format('d/m/Y h:i A') }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <div style="margin-bottom: 15px;">
        <span style="font-size: 11px; color: #475569;">
            <strong>Tempoh Laporan:</strong> {{ $period_label }}
        </span>
    </div>

    <table class="summary-table">
        <tr>
            <td class="summary-card card-total">
                <div class="summary-card-label">Jumlah Tempahan</div>
                <div class="summary-card-value">{{ $total_bookings }}</div>
            </td>
            <td style="width: 3%;"></td>
            <td class="summary-card card-completed">
                <div class="summary-card-label">Selesai</div>
                <div class="summary-card-value">{{ $completed }}</div>
            </td>
            <td style="width: 3%;"></td>
            <td class="summary-card card-cancelled">
                <div class="summary-card-label">Dibatalkan</div>
                <div class="summary-card-value">{{ $cancelled }}</div>
            </td>
            <td style="width: 3%;"></td>
            <td class="summary-card card-revenue">
                <div class="summary-card-label">Hasil Penjanaan</div>
                <div class="summary-card-value">RM {{ number_format($revenue_generated, 2) }}</div>
            </td>
        </tr>
    </table>

    <div class="section-title">Senarai Rekod Tempahan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Kod</th>
                <th>Pelanggan</th>
                <th>Telefon</th>
                <th>Kereta</th>
                <th>Mula</th>
                <th>Tamat</th>
                <th class="text-center">Hari</th>
                <th class="text-right">Kadar</th>
                <th class="text-right">Jumlah (RM)</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td class="font-bold">{{ $booking->booking_code }}</td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ $booking->customer_phone }}</td>
                    <td class="font-bold">{{ $booking->car ? $booking->car->name : 'N/A' }}</td>
                    <td>{{ $booking->start_date ? $booking->start_date->format('d/m/Y') : '' }}</td>
                    <td>{{ $booking->end_date ? $booking->end_date->format('d/m/Y') : '' }}</td>
                    <td class="text-center">{{ $booking->total_days }}</td>
                    <td class="text-right">{{ number_format($booking->price_per_day, 2) }}</td>
                    <td class="text-right font-bold">{{ number_format($booking->total_amount, 2) }}</td>
                    <td class="text-center">
                        <span class="badge badge-{{ $booking->status }}">
                            {{ strtoupper($booking->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center" style="padding: 20px; color: #94a3b8;">
                        Tiada rekod tempahan ditemui untuk tempoh ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
