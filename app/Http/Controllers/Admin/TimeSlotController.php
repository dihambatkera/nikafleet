<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    public function index()
    {
        $slots = TimeSlot::orderBy('sort_order')->orderBy('time_value')->get();
        return view('admin.time-slots.index', compact('slots'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'      => 'required|string|max:50',
            'time_value' => 'required|string|regex:/^\d{2}:\d{2}$/|unique:time_slots,time_value',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        TimeSlot::create([
            'label'      => $validated['label'],
            'time_value' => $validated['time_value'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active'  => true,
        ]);

        return back()->with('success', "Time slot \"{$validated['label']}\" added.");
    }

    public function update(Request $request, $id)
    {
        $slot = TimeSlot::findOrFail($id);

        $validated = $request->validate([
            'label'      => 'required|string|max:50',
            'time_value' => 'required|string|regex:/^\d{2}:\d{2}$/|unique:time_slots,time_value,' . $slot->id,
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $slot->update([
            'label'      => $validated['label'],
            'time_value' => $validated['time_value'],
            'sort_order' => $validated['sort_order'] ?? $slot->sort_order,
        ]);

        return back()->with('success', "Time slot updated successfully.");
    }

    public function toggleStatus($id)
    {
        $slot = TimeSlot::findOrFail($id);
        $slot->is_active = !$slot->is_active;
        $slot->save();

        $label = $slot->is_active ? 'enabled' : 'disabled';
        return back()->with('success', "Time slot \"{$slot->label}\" has been {$label}.");
    }

    public function destroy($id)
    {
        $slot = TimeSlot::findOrFail($id);
        $slot->delete();

        return back()->with('success', "Time slot \"{$slot->label}\" deleted.");
    }
}
