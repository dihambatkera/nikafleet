<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Homepage — show hero + available cars + stats
     */
    public function home()
    {
        $availableCars = Car::available()
            ->where('status', '!=', 'hidden')
            ->with('images')
            ->latest()
            ->get();

        $stats = [
            'available_today' => Car::where('status', 'available')->count(),
            'total_fleet'     => Car::whereNotIn('status', ['hidden'])->withTrashed(false)->count(),
            'bookings_done'   => Rental::whereIn('status', ['completed', 'active', 'confirmed'])->count(),
        ];

        return view('user.home', compact('availableCars', 'stats'));
    }
}
