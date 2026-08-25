<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.cars.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:50|unique:cars,plate_number',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'color' => 'required|string|max:50',
            'type' => 'required|in:sedan,suv,mpv,pickup,van,hatchback',
            'transmission' => 'required|in:auto,manual',
            'seats' => 'required|integer|min:1',
            'fuel_type' => 'required|in:petrol,diesel,hybrid,electric',
            'price_per_day' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance,hidden',
        ]);

        $car = Car::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $folder = "cars/{$car->id}";
                $path = $file->store($folder, 'public');
                $car->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.cars.index')->with('success', 'New vehicle registered successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $car = ($id instanceof Car) ? $id : Car::findOrFail($id);

        // Load relationships
        $rentals = $car->rentals()->orderBy('start_date', 'desc')->get();
        $expenses = $car->expenses()->orderBy('expense_date', 'desc')->get();

        // Calculate P&L
        $totalRevenue = $car->rentals()
            ->where('status', 'completed')
            ->sum('total_amount');

        $totalExpenses = $car->expenses()
            ->sum('amount');

        $netProfit = $totalRevenue - $totalExpenses;

        $today = Carbon::today();
        
        $techAlerts = [
            'next_service' => [
                'status' => 'ok',
                'message' => 'Next service date not set.',
            ],
            'insurance' => [
                'status' => 'ok',
                'message' => 'Insurance expiry date not set.',
            ],
            'road_tax' => [
                'status' => 'ok',
                'message' => 'Road tax expiry date not set.',
            ]
        ];

        if ($car->next_service_due) {
            $daysToService = $today->diffInDays($car->next_service_due, false);
            if ($daysToService < 0) {
                $techAlerts['next_service'] = [
                    'status' => 'danger',
                    'message' => 'Overdue for service (' . abs($daysToService) . ' days ago).',
                ];
            } elseif ($daysToService <= 14) {
                $techAlerts['next_service'] = [
                    'status' => 'warning',
                    'message' => 'Service due soon (in ' . $daysToService . ' days).',
                ];
            } else {
                $techAlerts['next_service'] = [
                    'status' => 'success',
                    'message' => 'Good. Next service in ' . $daysToService . ' days.',
                ];
            }
        }

        if ($car->insurance_expiry) {
            $daysToInsurance = $today->diffInDays($car->insurance_expiry, false);
            if ($daysToInsurance < 0) {
                $techAlerts['insurance'] = [
                    'status' => 'danger',
                    'message' => 'Insurance expired (' . abs($daysToInsurance) . ' days ago).',
                ];
            } elseif ($daysToInsurance <= 30) {
                $techAlerts['insurance'] = [
                    'status' => 'warning',
                    'message' => 'Insurance expiring soon (in ' . $daysToInsurance . ' days).',
                ];
            } else {
                $techAlerts['insurance'] = [
                    'status' => 'success',
                    'message' => 'Insurance valid for ' . $daysToInsurance . ' more days.',
                ];
            }
        }

        if ($car->road_tax_expiry) {
            $daysToRoadTax = $today->diffInDays($car->road_tax_expiry, false);
            if ($daysToRoadTax < 0) {
                $techAlerts['road_tax'] = [
                    'status' => 'danger',
                    'message' => 'Road tax expired (' . abs($daysToRoadTax) . ' days ago).',
                ];
            } elseif ($daysToRoadTax <= 30) {
                $techAlerts['road_tax'] = [
                    'status' => 'warning',
                    'message' => 'Road tax expiring soon (in ' . $daysToRoadTax . ' days).',
                ];
            } else {
                $techAlerts['road_tax'] = [
                    'status' => 'success',
                    'message' => 'Road tax valid for ' . $daysToRoadTax . ' more days.',
                ];
            }
        }

        return view('admin.cars.show', compact(
            'car',
            'rentals',
            'expenses',
            'totalRevenue',
            'totalExpenses',
            'netProfit',
            'techAlerts'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $car = ($id instanceof Car) ? $id : Car::findOrFail($id);
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $car = ($id instanceof Car) ? $id : Car::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:50|unique:cars,plate_number,' . $car->id,
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'color' => 'required|string|max:50',
            'type' => 'required|in:sedan,suv,mpv,pickup,van,hatchback',
            'transmission' => 'required|in:auto,manual',
            'seats' => 'required|integer|min:1',
            'fuel_type' => 'required|in:petrol,diesel,hybrid,electric',
            'price_per_day' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance,hidden',
        ]);

        $car->update($validated);

        return redirect()->route('admin.cars.index')->with('success', 'Vehicle details updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $car = ($id instanceof Car) ? $id : Car::findOrFail($id);
        $car->delete();
        return redirect()->route('admin.cars.index')->with('success', 'Vehicle deleted successfully.');
    }

    /**
     * Upload images for a car.
     */
    public function uploadImages(Request $request, $id)
    {
        $car = ($id instanceof Car) ? $id : Car::findOrFail($id);
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $startOrder = $car->images()->count() + 1;
        foreach ($request->file('images') as $index => $file) {
            $folder = "cars/{$car->id}";
            $path = $file->store($folder, 'public');
            $car->images()->create([
                'image_path' => $path,
                'is_primary' => $car->images()->count() === 0,
                'sort_order' => $startOrder + $index,
            ]);
        }

        return back()->with('success', 'Images uploaded successfully.');
    }

    /**
     * Delete image of a car.
     */
    public function deleteImage($id, $imgId)
    {
        $car = ($id instanceof Car) ? $id : Car::findOrFail($id);
        $image = $car->images()->findOrFail($imgId);

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}
