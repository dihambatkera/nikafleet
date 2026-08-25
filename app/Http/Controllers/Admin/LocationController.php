<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.locations.index', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255|unique:locations,name',
            'address'    => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Location::create([
            'name'       => $validated['name'],
            'address'    => $validated['address'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'status'     => 'active',
        ]);

        return back()->with('success', "Location \"{$validated['name']}\" added successfully.");
    }

    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'required|string|max:255|unique:locations,name,' . $location->id,
            'address'    => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $location->update([
            'name'       => $validated['name'],
            'address'    => $validated['address'] ?? null,
            'sort_order' => $validated['sort_order'] ?? $location->sort_order,
        ]);

        return back()->with('success', "Location updated successfully.");
    }

    public function toggleStatus($id)
    {
        $location = Location::findOrFail($id);
        $location->status = $location->status === 'active' ? 'inactive' : 'active';
        $location->save();

        $label = $location->status === 'active' ? 'enabled' : 'disabled';
        return back()->with('success', "Location \"{$location->name}\" has been {$label}.");
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return back()->with('success', "Location \"{$location->name}\" has been deleted.");
    }
}
