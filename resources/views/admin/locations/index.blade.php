@extends('layouts.admin')

@section('title', 'Locations')

@section('content')
<div class="p-6 md:p-8" x-data="locationsApp()">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-7">
        <div>
            <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pickup Locations</h1>
            <p class="text-sm text-gray-500 mt-1">Manage locations shown to customers in the booking form.</p>
        </div>
        <button @click="showCreate = true"
                class="inline-flex items-center gap-2 text-sm font-semibold text-white px-5 py-2.5 rounded-xl shadow transition-all"
                style="background: linear-gradient(135deg, #bda04e, #a08a3a);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Location
        </button>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="flash-success mb-5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flash-error mb-5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Create Modal --}}
    <div x-show="showCreate" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.4);" @click.self="showCreate = false">
        <div class="admin-card w-full max-w-md" @click.stop>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Add Location</h2>
                <button @click="showCreate = false" class="text-gray-400 hover:text-gray-600 transition-colors">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.locations.store') }}">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Location Name *</label>
                        <input type="text" name="name" placeholder="e.g. Rawang, Selangor" required
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Address (optional)</label>
                        <input type="text" name="address" placeholder="Full address or description"
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
                    <button type="submit" class="flex-1 py-2.5 text-sm font-bold text-white rounded-xl" style="background: #bda04e;">Save Location</button>
                    <button type="button" @click="showCreate = false" class="px-5 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div x-show="showEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.4);" @click.self="showEdit = false">
        <div class="admin-card w-full max-w-md" @click.stop>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Edit Location</h2>
                <button @click="showEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors">✕</button>
            </div>
            <form :action="'/admin/locations/' + editId + '?_method=PUT'" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Location Name *</label>
                        <input type="text" name="name" :value="editName" required
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Address</label>
                        <input type="text" name="address" :value="editAddress"
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

    {{-- Locations Table --}}
    <div class="admin-card">
        @if($locations->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-14 h-14 rounded-full flex items-center justify-center mb-4" style="background: rgba(189,160,78,0.1)">
                    <svg class="w-7 h-7" style="color:#bda04e" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-700">No Locations Yet</p>
                <p class="text-xs text-gray-400 mt-1 mb-5">Add pickup locations to show in the booking form.</p>
                <button @click="showCreate = true" class="text-sm font-semibold text-white px-5 py-2.5 rounded-xl" style="background: #bda04e;">
                    Add First Location
                </button>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Name</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Address</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Order</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($locations as $loc)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4" data-label="Name">
                                <div class="font-semibold text-gray-800">{{ $loc->name }}</div>
                            </td>
                            <td class="px-5 py-4 text-gray-500" data-label="Address">
                                {{ $loc->address ?? '—' }}
                            </td>
                            <td class="px-5 py-4 text-gray-500" data-label="Order">
                                {{ $loc->sort_order }}
                            </td>
                            <td class="px-5 py-4" data-label="Status">
                                @if($loc->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500 ring-1 ring-gray-200">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right" data-label="Actions">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Edit --}}
                                    <button @click="openEdit({{ $loc->id }}, '{{ addslashes($loc->name) }}', '{{ addslashes($loc->address ?? '') }}', {{ $loc->sort_order }})"
                                            class="text-xs font-medium text-gray-500 hover:text-gray-800 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                                        Edit
                                    </button>

                                    {{-- Toggle Status --}}
                                    <form method="POST" action="{{ route('admin.locations.toggle', $loc->id) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="text-xs font-medium px-3 py-1.5 rounded-lg transition-colors"
                                                style="{{ $loc->status === 'active' ? 'color:#ef4444;background:rgba(239,68,68,0.08)' : 'color:#10b981;background:rgba(16,185,129,0.08)' }}">
                                            {{ $loc->status === 'active' ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('admin.locations.destroy', $loc->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Delete this location?')"
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
function locationsApp() {
    return {
        showCreate: {{ $errors->has('name') ? 'true' : 'false' }},
        showEdit: false,
        editId: null,
        editName: '',
        editAddress: '',
        editSort: 0,

        openEdit(id, name, address, sort) {
            this.editId      = id;
            this.editName    = name;
            this.editAddress = address;
            this.editSort    = sort;
            this.showEdit    = true;
        }
    }
}
</script>
@endsection
