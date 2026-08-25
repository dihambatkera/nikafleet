<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Resit Tempahan - {{ $rental->booking_code }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #333333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            border-bottom: 2px solid #3B82F6;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .company-logo {
            float: left;
            font-size: 24px;
            font-weight: bold;
            color: #1E293B;
            letter-spacing: 1px;
            margin: 0;
        }
        .company-logo span {
            color: #3B82F6;
        }
        .company-info {
            float: right;
            text-align: right;
            font-size: 11px;
            color: #64748B;
        }
        .clear {
            clear: both;
        }
        .title-block {
            text-align: center;
            margin-bottom: 30px;
        }
        .title-block h1 {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1E293B;
            margin: 0 0 5px 0;
            letter-spacing: 1px;
        }
        .title-block p {
            font-size: 12px;
            color: #64748B;
            margin: 0;
        }
        .details-grid {
            width: 100%;
            margin-bottom: 30px;
        }
        .details-grid td {
            width: 50%;
            vertical-align: top;
        }
        .details-box {
            background-color: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 15px;
            margin-right: 10px;
        }
        .details-box.last {
            margin-right: 0;
            margin-left: 10px;
        }
        .details-box h3 {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748B;
            margin: 0 0 10px 0;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #E2E8F0;
            padding-bottom: 5px;
        }
        .details-row {
            margin-bottom: 6px;
        }
        .details-label {
            font-weight: 600;
            color: #475569;
            display: inline-block;
            width: 120px;
        }
        .details-value {
            color: #1E293B;
        }
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .receipt-table th {
            background-color: #F1F5F9;
            border-bottom: 2px solid #CBD5E1;
            color: #475569;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            padding: 10px;
            text-align: left;
        }
        .receipt-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #E2E8F0;
            color: #334155;
        }
        .pricing-block {
            float: right;
            width: 280px;
            margin-bottom: 30px;
        }
        .pricing-table {
            width: 100%;
            border-collapse: collapse;
        }
        .pricing-table td {
            padding: 6px 0;
        }
        .pricing-table .label {
            color: #64748B;
            text-align: left;
        }
        .pricing-table .value {
            color: #1E293B;
            font-weight: 600;
            text-align: right;
        }
        .pricing-table .total-row td {
            border-top: 1px solid #CBD5E1;
            padding-top: 10px;
            font-weight: bold;
        }
        .pricing-table .total-row .label {
            color: #1E293B;
            font-size: 14px;
        }
        .pricing-table .total-row .value {
            color: #EF4444;
            font-size: 16px;
        }
        .payment-status-box {
            float: left;
            width: 250px;
            background-color: #ECFDF5;
            border: 1px solid #A7F3D0;
            border-radius: 8px;
            padding: 15px;
            color: #065F46;
        }
        .payment-status-box.unpaid {
            background-color: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
        }
        .payment-status-box h4 {
            margin: 0 0 5px 0;
            font-size: 12px;
            font-weight: bold;
        }
        .payment-status-box p {
            margin: 0;
            font-size: 11px;
            line-height: 1.3;
        }
        .thank-you {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            color: #1E293B;
            margin: 40px 0 30px 0;
            font-style: italic;
        }
        .footer {
            border-top: 1px solid #E2E8F0;
            padding-top: 15px;
            font-size: 10px;
            color: #94A3B8;
            text-align: center;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Company info header -->
        <div class="header">
            <div class="company-logo">Nika<span>Fleet</span></div>
            <div class="company-info">
                <strong>{{ \App\Models\Setting::get('company_name', 'NikaFleet') }}</strong><br>
                Telefon: {{ \App\Models\Setting::get('phone', '+60 11-6824 7599') }}<br>
                Emel: {{ \App\Models\Setting::get('email', 'admin@nikafleet.com') }}<br>
                Lokasi: {{ \App\Models\Setting::get('location', 'Rawang, Selangor') }}
            </div>
            <div class="clear"></div>
        </div>

        <!-- Receipt Title -->
        <div class="title-block">
            <h1>Resit Rasmi Pembayaran</h1>
            <p>Kod Tempahan: <strong>{{ $rental->booking_code }}</strong> &bull; Tarikh: {{ now()->format('d/m/Y') }}</p>
        </div>

        <!-- Details Grid -->
        <table class="details-grid">
            <tr>
                <td>
                    <div class="details-box">
                        <h3>Maklumat Pelanggan</h3>
                        <div class="details-row">
                            <span class="details-label">Nama:</span>
                            <span class="details-value">{{ $rental->customer_name }}</span>
                        </div>
                        <div class="details-row">
                            <span class="details-label">Telefon:</span>
                            <span class="details-value">{{ $rental->customer_phone }}</span>
                        </div>
                        <div class="details-row">
                            <span class="details-label">Status Sewa:</span>
                            <span class="details-value" style="text-transform: uppercase; font-weight: bold; color: #3B82F6;">{{ $rental->status }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="details-box last">
                        <h3>Butiran Tempahan</h3>
                        <div class="details-row">
                            <span class="details-label">Mula Sewa:</span>
                            <span class="details-value">{{ $rental->start_date ? $rental->start_date->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div class="details-row">
                            <span class="details-label">Tamat Sewa:</span>
                            <span class="details-value">{{ $rental->end_date ? $rental->end_date->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div class="details-row">
                            <span class="details-label">Jumlah Hari:</span>
                            <span class="details-value">{{ $rental->total_days }} Hari</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Booking details table -->
        <table class="receipt-table">
            <thead>
                <tr>
                    <th>Deskripsi Kenderaan</th>
                    <th>No. Pendaftaran</th>
                    <th style="text-align: center;">Tempoh (Hari)</th>
                    <th style="text-align: right;">Kadar Harian</th>
                    <th style="text-align: right;">Jumlah Kasar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $rental->car ? $rental->car->name : 'Kenderaan Sewaan' }}</strong><br>
                        <span style="font-size: 11px; color: #64748B;">Sewa kereta NikaFleet</span>
                    </td>
                    <td>{{ $rental->car ? $rental->car->plate_number : '-' }}</td>
                    <td style="text-align: center;">{{ $rental->total_days }}</td>
                    <td style="text-align: right;">RM {{ number_format($rental->price_per_day, 2) }}</td>
                    <td style="text-align: right;">RM {{ number_format($rental->total_days * $rental->price_per_day, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Payment Status & Breakdown -->
        <div>
            <!-- Payment status box -->
            @if($rental->balance_due <= 0)
                <div class="payment-status-box">
                    <h4>✓ Pembayaran Penuh</h4>
                    <p>Status: LUNAS. Terima kasih! Tiada baki tertunggak untuk sewaan ini.</p>
                </div>
            @else
                <div class="payment-status-box unpaid">
                    <h4>⚠️ Pembayaran Separa</h4>
                    <p>Status: Deposit Saja. Sila jelaskan baki tertunggak sebanyak <strong>RM {{ number_format($rental->balance_due, 2) }}</strong> sebelum/semasa mengambil kenderaan.</p>
                </div>
            @endif

            <!-- Pricing Breakdown -->
            <div class="pricing-block">
                <table class="pricing-table">
                    <tr>
                        <td class="label">Subjumlah Kasar:</td>
                        <td class="value">RM {{ number_format($rental->total_days * $rental->price_per_day, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Deposit Dibayar:</td>
                        <td class="value" style="color: #059669;">- RM {{ number_format($rental->deposit_paid, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td class="label">Baki Perlu Dibayar:</td>
                        <td class="value">RM {{ number_format($rental->balance_due, 2) }}</td>
                    </tr>
                </table>
            </div>
            <div class="clear"></div>
        </div>

        <!-- Thank you slogan -->
        <div class="thank-you">
            Terima kasih atas kepercayaan anda kepada NikaFleet! 🚗
        </div>

        <!-- Footer -->
        <div class="footer">
            {{ \App\Models\Setting::get('address', 'Rawang, Selangor, Malaysia') }}<br>
            TikTok: {{ \App\Models\Setting::get('tiktok', 'https://www.tiktok.com/@nika.fleet') }} &bull; Hubungi Kami: {{ \App\Models\Setting::get('phone', '+60 11-6824 7599') }}<br>
            <em>Nak sewa? Nika kan ada!</em>
        </div>
    </div>
</body>
</html>
