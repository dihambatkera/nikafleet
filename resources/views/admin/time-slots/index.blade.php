@extends('layouts.admin')

@section('title', 'Time Slots')

@section('content')
<div class="p-6 md:p-8" x-data="timeSlotsApp()">

    <div class="flex items-center justify-between mb-7">
        <div>
            <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Time Slots</h1>
            <p class="text-sm text-gray-500 mt-1">Manage pickup & return times shown in the booking form.</p>
        </div>
        <button @click="showCreate = true"
                class="inline-flex items-center gap-2 text-sm font-semibold text-white px-5 py-2.5 rounded-xl"
                style="background: linear-gradient(135deg, #bda04e, #a08a3a);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Time Slot
        </button>
    </div>

    @if(session('success'))
        <div class="flash-success mb-5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Create Modal --}}
    <div x-show="showCreate" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.4);" @click.self="showCreate = false">
        <div class="admin-card w-full max-w-sm" @click.stop>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Add Time Slot</h2>
                <button @click="showCreate = false" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.time-slots.store') }}">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Display Label *</label>
                        <input type="text" name="label" placeholder="e.g. 08:00 AM" required
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">24h Value (HH:MM) *</label>
                        <input type="time" name="time_value" required
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Sort Order</label>
                        <input type="number" name="sort_order" value="0" min="0"
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                </div>
                <div class="px-6 pb-5 flex gap-3">
                    <button type="submit" class="flex-1 py-2.5 text-sm font-bold text-white rounded-xl" style="background: #bda04e;">Save</button>
                    <button type="button" @click="showCreate = false" class="px-5 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div x-show="showEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.4);" @click.self="showEdit = false">
        <div class="admin-card w-full max-w-sm" @click.stop>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Edit Time Slot</h2>
                <button @click="showEdit = false" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form :action="'/admin/time-slots/' + editId + '?_method=PUT'" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Display Label *</label>
                        <input type="text" name="label" :value="editLabel" required
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">24h Value (HH:MM) *</label>
                        <input type="time" name="time_value" :value="editValue" required
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Sort Order</label>
                        <input type="number" name="sort_order" :value="editSort" min="0"
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                </div>
                <div class="px-6 pb-5 flex gap-3">
                    <button type="submit" class="flex-1 py-2.5 text-sm font-bold text-white rounded-xl" style="background: #bda04e;">Update</button>
                    <button type="button" @click="showEdit = false" class="px-5 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="admin-card">
        @if($slots->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-14 h-14 rounded-full flex items-center justify-center mb-4" style="background: rgba(189,160,78,0.1)">
                    <svg class="w-7 h-7" style="color:#bda04e" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-700">No Time Slots</p>
                <p class="text-xs text-gray-400 mt-1 mb-5">Add time slots for customers to select during booking.</p>
                <button @click="showCreate = true" class="text-sm font-semibold text-white px-5 py-2.5 rounded-xl" style="background: #bda04e;">Add First Slot</button>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Label</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">24h Value</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Order</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($slots as $slot)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4" data-label="Label">
                                <div class="font-semibold text-gray-800">{{ $slot->label }}</div>
                            </td>
                            <td class="px-5 py-4 font-mono text-gray-500" data-label="Value">{{ $slot->time_value }}</td>
                            <td class="px-5 py-4 text-gray-500" data-label="Order">{{ $slot->sort_order }}</td>
                            <td class="px-5 py-4" data-label="Status">
                                @if($slot->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500 ring-1 ring-gray-200">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right" data-label="Actions">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="openEdit({{ $slot->id }}, '{{ addslashes($slot->label) }}', '{{ $slot->time_value }}', {{ $slot->sort_order }})"
                                            class="text-xs font-medium text-gray-500 hover:text-gray-800 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.time-slots.toggle', $slot->id) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="text-xs font-medium px-3 py-1.5 rounded-lg transition-colors"
                                                style="{{ $slot->is_active ? 'color:#ef4444;background:rgba(239,68,68,0.08)' : 'color:#10b981;background:rgba(16,185,129,0.08)' }}">
                                            {{ $slot->is_active ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.time-slots.destroy', $slot->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this time slot?')"
                                                class="text-xs font-medium text-red-400 hover:text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>
function timeSlotsApp() {
    return {
        showCreate: false,
        showEdit: false,
        editId: null,
        editLabel: '',
        editValue: '',
        editSort: 0,
        openEdit(id, label, value, sort) {
            this.editId    = id;
            this.editLabel = label;
            this.editValue = value;
            this.editSort  = sort;
            this.showEdit  = true;
        }
    }
}
</script>
@endsection
