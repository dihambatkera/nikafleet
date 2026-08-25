@extends('layouts.admin')

@section('title', 'Create Booking')

@section('content')
<div class="p-6 md:p-8 max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="mb-7">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-700 mb-3 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Dashboard
        </a>
        <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Create Active Booking</h1>
        <p class="text-sm text-gray-500 mt-1">Create and confirm a booking directly from the admin panel.</p>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="flash-error mb-6">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul class="mt-1 list-disc ml-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.bookings.adminStore') }}" id="create-booking-form">
        @csrf

        <div class="admin-card">

            {{-- ── CUSTOMER DETAILS ────────────────────────────── --}}
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider" style="font-family: 'Plus Jakarta Sans', sans-serif;">Customer Details</h2>
            </div>
            <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Full Name <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="customer_name" id="customer_name"
                           value="{{ old('customer_name') }}"
                           placeholder="Customer's full name"
                           required
                           class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 transition-all focus:outline-none focus:ring-2"
                           style="border-color: #e5e7eb;"
                           onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    @error('customer_name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Phone Number <span class="text-red-400">*</span>
                    </label>
                    <input type="tel" name="customer_phone" id="customer_phone"
                           value="{{ old('customer_phone') }}"
                           placeholder="+60 11-XXXX XXXX"
                           required
                           class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 transition-all focus:outline-none"
                           style="border-color: #e5e7eb;"
                           onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    @error('customer_phone')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ── VEHICLE ─────────────────────────────────────── --}}
            <div class="px-6 py-4 border-t border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider" style="font-family: 'Plus Jakarta Sans', sans-serif;">Vehicle</h2>
            </div>
            <div class="px-6 py-5">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    Select Vehicle <span class="text-red-400">*</span>
                </label>
                <select name="car_id" id="car_id" required
                        class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 transition-all focus:outline-none bg-white"
                        style="border-color: #e5e7eb;"
                        onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    <option value="">— Select a vehicle —</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}"
                                data-price="{{ $car->price_per_day }}"
                                {{ old('car_id') == $car->id ? 'selected' : '' }}>
                            {{ $car->name ?? $car->brand . ' ' . $car->model }}
                            ({{ strtoupper($car->status) }}) — RM {{ number_format($car->price_per_day) }}/day
                        </option>
                    @endforeach
                </select>
                @error('car_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── RENTAL PERIOD ────────────────────────────────── --}}
            <div class="px-6 py-4 border-t border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider" style="font-family: 'Plus Jakarta Sans', sans-serif;">Rental Period</h2>
            </div>
            <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Pickup Date --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Pickup Date <span class="text-red-400">*</span>
                    </label>
                    <input type="date" name="start_date" id="start_date"
                           value="{{ old('start_date', date('Y-m-d')) }}"
                           min="{{ date('Y-m-d') }}"
                           required
                           class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 transition-all focus:outline-none"
                           style="border-color: #e5e7eb;"
                           onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    @error('start_date')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pickup Time --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Pickup Time <span class="text-red-400">*</span>
                    </label>
                    @if($timeSlots->isNotEmpty())
                        <select name="start_time" id="start_time" required
                                class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 transition-all focus:outline-none bg-white"
                                style="border-color: #e5e7eb;"
                                onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                            <option value="">— Select time —</option>
                            @foreach($timeSlots as $slot)
                                <option value="{{ $slot->time_value }}" {{ old('start_time') == $slot->time_value ? 'selected' : '' }}>
                                    {{ $slot->label }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <input type="time" name="start_time" id="start_time"
                               value="{{ old('start_time', '10:00') }}"
                               required
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 transition-all focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    @endif
                    @error('start_time')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Return Date --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Return Date <span class="text-red-400">*</span>
                    </label>
                    <input type="date" name="end_date" id="end_date"
                           value="{{ old('end_date', date('Y-m-d', strtotime('+1 day'))) }}"
                           min="{{ date('Y-m-d') }}"
                           required
                           class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 transition-all focus:outline-none"
                           style="border-color: #e5e7eb;"
                           onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    @error('end_date')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Return Time --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Return Time <span class="text-red-400">*</span>
                    </label>
                    @if($timeSlots->isNotEmpty())
                        <select name="end_time" id="end_time" required
                                class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 transition-all focus:outline-none bg-white"
                                style="border-color: #e5e7eb;"
                                onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                            <option value="">— Select time —</option>
                            @foreach($timeSlots as $slot)
                                <option value="{{ $slot->time_value }}" {{ old('end_time') == $slot->time_value ? 'selected' : '' }}>
                                    {{ $slot->label }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <input type="time" name="end_time" id="end_time"
                               value="{{ old('end_time', '10:00') }}"
                               required
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 transition-all focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    @endif
                    @error('end_time')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ── LOCATION ─────────────────────────────────────── --}}
            <div class="px-6 py-4 border-t border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pickup Location</h2>
            </div>
            <div class="px-6 py-5">
                @if($locations->isNotEmpty())
                    <select name="pickup_location" id="pickup_location" required
                            class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 transition-all focus:outline-none bg-white"
                            style="border-color: #e5e7eb;"
                            onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                        <option value="">— Select location —</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->name }}" {{ old('pickup_location') == $location->name ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <input type="text" name="pickup_location" id="pickup_location"
                           value="{{ old('pickup_location', 'Rawang, Selangor') }}"
                           placeholder="e.g. Rawang, Selangor"
                           required
                           class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 transition-all focus:outline-none"
                           style="border-color: #e5e7eb;"
                           onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                           onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                @endif
                @error('pickup_location')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── NOTES ──────────────────────────────────────── --}}
            <div class="px-6 py-4 border-t border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider" style="font-family: 'Plus Jakarta Sans', sans-serif;">Admin Notes</h2>
            </div>
            <div class="px-6 py-5">
                <textarea name="admin_notes" id="admin_notes" rows="3"
                          placeholder="Internal notes (not shown to customer)..."
                          class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 transition-all focus:outline-none resize-none"
                          style="border-color: #e5e7eb;"
                          onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                          onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">{{ old('admin_notes') }}</textarea>
            </div>

            {{-- ── PRICE PREVIEW ───────────────────────────────── --}}
            <div id="price-preview" class="hidden mx-6 mb-5 rounded-xl p-4 border" style="background: #fdf8ef; border-color: #e8d9b0;">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Estimated Duration</div>
                        <div class="text-lg font-bold text-gray-800 mt-0.5" id="preview-days">—</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Estimated Total</div>
                        <div class="text-xl font-bold mt-0.5" style="color:#bda04e" id="preview-total">—</div>
                    </div>
                </div>
            </div>

            {{-- ── SUBMIT ──────────────────────────────────────── --}}
            <div class="px-6 pb-6 flex gap-3">
                <button type="submit" id="submit-btn"
                        class="flex-1 py-3 text-sm font-bold text-white rounded-xl transition-all"
                        style="background: linear-gradient(135deg, #bda04e, #a08a3a);"
                        onmouseover="this.style.opacity='0.9'"
                        onmouseout="this.style.opacity='1'">
                    Create & Confirm Booking
                </button>
                <a href="{{ route('admin.dashboard') }}"
                   class="px-6 py-3 text-sm font-semibold text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors text-center">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    function calcPreview() {
        const startDate = document.getElementById('start_date').value;
        const endDate   = document.getElementById('end_date').value;
        const carSel    = document.getElementById('car_id');
        const preview   = document.getElementById('price-preview');

        if (!startDate || !endDate || !carSel.value) {
            preview.classList.add('hidden');
            return;
        }

        const d1 = new Date(startDate);
        const d2 = new Date(endDate);
        const days = Math.max(1, Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24)));

        const selectedOpt  = carSel.options[carSel.selectedIndex];
        const pricePerDay  = parseFloat(selectedOpt.getAttribute('data-price') || 0);
        const total        = days * pricePerDay;

        document.getElementById('preview-days').textContent  = days + (days === 1 ? ' day' : ' days');
        document.getElementById('preview-total').textContent = 'RM ' + total.toLocaleString('en-MY', { minimumFractionDigits: 0 });

        preview.classList.remove('hidden');
    }

    ['start_date','end_date','car_id'].forEach(id => {
        document.getElementById(id)?.addEventListener('change', calcPreview);
    });

    // Ensure end_date >= start_date
    document.getElementById('start_date')?.addEventListener('change', function() {
        const endInput = document.getElementById('end_date');
        if (endInput.value && endInput.value < this.value) {
            endInput.value = this.value;
        }
        endInput.min = this.value;
        calcPreview();
    });
</script>
@endsection
