<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;

class UserCarController extends Controller
{

    /**
     * Car listing /cars
     */
    public function index(Request $request)
    {
        $query = Car::where('status', '!=', 'hidden')
            ->where('status', '!=', 'rented')
            ->with('images');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }
        if ($transmission = $request->input('transmission')) {
            $query->where('transmission', $transmission);
        }
        if ($seats = $request->input('seats')) {
            $query->where('seats', $seats);
        }
        if ($maxPrice = $request->input('max_price')) {
            $query->where('price_per_day', '<=', $maxPrice);
        }

        $cars = $query->latest()->get();

        $availableCount = $cars->where('status', 'available')->count();

        return view('user.cars', compact('cars', 'availableCount'));
    }

    /**
     * Car detail /cars/{id}
     */
    public function show(Car $car)
    {
        if ($car->status === 'hidden') {
            abort(404);
        }

        $car->load('images');

        return view('user.car-detail', compact('car'));
    }
}
