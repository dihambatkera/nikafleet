<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class WhatsAppTemplateController extends Controller
{
    private const DEFAULT_TEMPLATE = "Salam NikaFleet,\n\nSaya ingin membuat tempahan sewa kereta. Berikut adalah maklumat saya:\n\nNama            : {customer_name}\nNo. Telefon     : {customer_phone}\n\nKenderaan       : {vehicle_name}\nHarga Sewa      : RM {price_per_day} / hari\n\nTarikh Ambil    : {pickup_date}\nMasa Ambil      : {pickup_time}\nTarikh Pulang   : {return_date}\nMasa Pulang     : {return_time}\nTempoh          : {duration}\nLokasi Ambil    : {location}\n\nAnggaran Harga  : RM {estimated_price}\n({duration} x RM {price_per_day}/hari)\n\nSila sahkan ketersediaan dan butiran selanjutnya. Terima kasih.";

    public function index()
    {
        $template = Setting::get('booking_whatsapp_template', self::DEFAULT_TEMPLATE);

        $variables = [
            '{customer_name}'  => 'Customer full name',
            '{customer_phone}' => 'Customer phone number',
            '{vehicle_name}'   => 'Vehicle name (e.g. Perodua Myvi)',
            '{price_per_day}'  => 'Price per day (number)',
            '{pickup_date}'    => 'Pickup date (formatted)',
            '{pickup_time}'    => 'Pickup time (formatted)',
            '{return_date}'    => 'Return date (formatted)',
            '{return_time}'    => 'Return time (formatted)',
            '{duration}'       => 'Duration (e.g. 3 days)',
            '{location}'       => 'Pickup location',
            '{estimated_price}' => 'Estimated total price',
        ];

        return view('admin.whatsapp.index', compact('template', 'variables'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'template' => 'required|string|max:5000',
        ]);

        Setting::set('booking_whatsapp_template', $request->template);

        return back()->with('success', 'WhatsApp template saved successfully.');
    }

    public function resetDefault(Request $request)
    {
        Setting::set('booking_whatsapp_template', self::DEFAULT_TEMPLATE);

        return back()->with('success', 'WhatsApp template reset to default.');
    }

    public static function getDefault(): string
    {
        return self::DEFAULT_TEMPLATE;
    }
}
