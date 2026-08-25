@extends('layouts.admin')

@section('title', 'Vehicle Details — ' . $car->name)

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Breadcrumbs & Actions Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <a href="{{ route('admin.cars.index') }}" class="hover:text-gray-600 transition-colors">Manage Vehicles</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-800 font-semibold">{{ $car->name }}</span>
            </div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-gray-900 leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $car->name }}</h1>
                <!-- Status Badge -->
                <span class="px-3 py-1 rounded-full text-xs font-semibold border shadow-sm capitalize
                    @if($car->status === 'available') bg-emerald-50 text-emerald-700 border-emerald-200
                    @elseif($car->status === 'rented') bg-blue-50 text-blue-700 border-blue-200
                    @elseif($car->status === 'maintenance') bg-amber-50 text-amber-700 border-amber-200
                    @else bg-gray-100 text-gray-600 border-gray-300 @endif">
                    {{ $car->status }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.cars.index') }}" 
               class="px-4 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl font-semibold text-xs transition-all shadow-sm">
                Back to Fleet
            </a>
            <a href="{{ route('admin.cars.edit', $car->id) }}" 
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-xs transition-all shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Edit Vehicle
            </a>
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- LEFT COLUMN (2/3 width) - Image Gallery, Rentals, Expenses -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- SECTION 5 — Image Gallery (Alpine.js integration) -->
            <div x-data="{ activeImage: '{{ $car->primary_image_url }}' }" class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Image Gallery</h3>
                
                <!-- Main Preview -->
                <div class="h-96 w-full rounded-xl overflow-hidden bg-gray-50 border border-gray-150 relative">
                    <img :src="activeImage" alt="{{ $car->name }}" class="w-full h-full object-cover" />
                </div>
                
                <!-- Thumbnails Slider -->
                @if($car->images->count() > 0)
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        @foreach($car->images as $img)
                            <button type="button" 
                                    @click="activeImage = '{{ asset('storage/' . $img->image_path) }}'" 
                                    class="w-24 h-16 rounded-lg overflow-hidden border-2 transition-all focus:outline-none flex-shrink-0"
                                    :class="activeImage === '{{ asset('storage/' . $img->image_path) }}' ? 'border-blue-500 ring-2 ring-blue-100' : 'border-gray-200 hover:border-gray-300'">
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Thumbnail" class="w-full h-full object-cover" />
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-gray-400 text-sm border border-dashed rounded-xl bg-gray-50">
                        No images uploaded for this vehicle.
                    </div>
                @endif
            </div>

            <!-- Rental History Table -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Rental History</h3>
                    <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded-md font-semibold">{{ $rentals->count() }} Bookings</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/75 border-b border-gray-100">
                                <th class="p-3 text-xs font-bold text-gray-500 uppercase">Booking Code</th>
                                <th class="p-3 text-xs font-bold text-gray-500 uppercase">Customer</th>
                                <th class="p-3 text-xs font-bold text-gray-500 uppercase">Rental Dates</th>
                                <th class="p-3 text-xs font-bold text-gray-500 uppercase">Days</th>
                                <th class="p-3 text-xs font-bold text-gray-500 uppercase">Status</th>
                                <th class="p-3 text-xs font-bold text-gray-500 uppercase text-right">Total (RM)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($rentals as $rental)
                                <tr class="hover:bg-gray-50/50 transition-colors text-sm">
                                    <td class="p-3 font-mono font-bold text-gray-800">
                                        <a href="{{ route('admin.bookings.show', $rental->id) }}" class="text-blue-600 hover:underline">
                                            {{ $rental->booking_code }}
                                        </a>
                                    </td>
                                    <td class="p-3">
                                        <div class="font-semibold text-gray-900">{{ $rental->customer_name }}</div>
                                        <div class="text-xs text-gray-400">{{ $rental->customer_phone }}</div>
                                    </td>
                                    <td class="p-3 text-gray-700">
                                        {{ $rental->start_date ? $rental->start_date->format('d/m/Y') : '-' }} - {{ $rental->end_date ? $rental->end_date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="p-3 text-gray-600">{{ $rental->total_days }} {{ $rental->total_days === 1 ? 'day' : 'days' }}</td>
                                    <td class="p-3">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold capitalize
                                            bg-{{ $rental->status_badge_color }}-50 text-{{ $rental->status_badge_color }}-700 border border-{{ $rental->status_badge_color }}-200">
                                            {{ $rental->status }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-right font-bold text-gray-900">
                                        RM {{ number_format($rental->total_amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400 text-sm">
                                        No booking history found for this vehicle.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Expense History Table -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Expense History</h3>
                    <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded-md font-semibold">{{ $expenses->count() }} Expenses</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/75 border-b border-gray-100">
                                <th class="p-3 text-xs font-bold text-gray-500 uppercase">Date</th>
                                <th class="p-3 text-xs font-bold text-gray-500 uppercase">Category</th>
                                <th class="p-3 text-xs font-bold text-gray-500 uppercase">Description</th>
                                <th class="p-3 text-xs font-bold text-gray-500 uppercase text-right">Amount (RM)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($expenses as $expense)
                                <tr class="hover:bg-gray-50/50 transition-colors text-sm">
                                    <td class="p-3 text-gray-600">
                                        {{ $expense->expense_date ? $expense->expense_date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-800 text-xs font-semibold capitalize">
                                            {{ $expense->category }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-gray-700 max-w-[200px] truncate" title="{{ $expense->description }}">
                                        {{ $expense->description }}
                                    </td>
                                    <td class="p-3 text-right font-bold text-gray-900">
                                        RM {{ number_format($expense->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-gray-400 text-sm">
                                        No expenses recorded for this vehicle.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN (1/3 width) - P&L Financials, Technical Alerts, Specs -->
        <div class="space-y-6">
            
            <!-- Profit/Loss Financial Card -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Financial Performance / P&L</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Total Revenue (Completed)</span>
                        <span class="font-bold text-gray-950">RM {{ number_format($totalRevenue, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Total Expenses</span>
                        <span class="font-bold text-red-600">RM {{ number_format($totalExpenses, 2) }}</span>
                    </div>
                    <hr class="border-gray-100">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-gray-700">Net Profit</span>
                        <span class="text-lg font-extrabold {{ $netProfit >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                            RM {{ number_format($netProfit, 2) }}
                        </span>
                    </div>
                </div>

                <!-- Custom Net Profit Banner -->
                <div class="p-4 rounded-xl text-center space-y-1 shadow-inner
                    @if($netProfit >= 0) bg-emerald-50 text-emerald-800 border border-emerald-100
                    @else bg-red-50 text-red-800 border border-red-100 @endif">
                    <p class="text-xs font-semibold">Performance Summary</p>
                    <p class="text-sm font-extrabold leading-snug">
                        This vehicle generated RM {{ number_format(abs($netProfit), 2) }} {{ $netProfit >= 0 ? 'net profit' : 'net loss' }}
                    </p>
                </div>
            </div>

            <!-- Technical Status Alert Panel -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Technical Status & Alerts</h3>

                <div class="space-y-4">
                    <!-- Mileage Info -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Current Mileage</p>
                            <p class="text-sm font-bold text-gray-800">{{ number_format($car->mileage) }} km</p>
                        </div>
                    </div>

                    <!-- Next Service Alert -->
                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 
                            @if($techAlerts['next_service']['status'] === 'danger') bg-red-50 text-red-600
                            @elseif($techAlerts['next_service']['status'] === 'warning') bg-amber-50 text-amber-600
                            @else bg-emerald-50 text-emerald-600 @endif">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-semibold">Last & Next Service</p>
                            <p class="text-xs text-gray-600 mt-0.5">
                                Last: {{ $car->last_service_date ? $car->last_service_date->format('d/m/Y') : 'No record' }}
                            </p>
                            <p class="text-xs font-bold leading-normal mt-0.5
                                @if($techAlerts['next_service']['status'] === 'danger') text-red-600
                                @elseif($techAlerts['next_service']['status'] === 'warning') text-amber-600
                                @else text-emerald-600 @endif">
                                {{ $techAlerts['next_service']['message'] }}
                            </p>
                        </div>
                    </div>

                    <!-- Insurance Expiry Alert -->
                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 
                            @if($techAlerts['insurance']['status'] === 'danger') bg-red-50 text-red-600
                            @elseif($techAlerts['insurance']['status'] === 'warning') bg-amber-50 text-amber-600
                            @else bg-emerald-50 text-emerald-600 @endif">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-semibold">Insurance Expiry Date</p>
                            <p class="text-xs text-gray-600 mt-0.5">
                                Expiry: {{ $car->insurance_expiry ? $car->insurance_expiry->format('d/m/Y') : 'No record' }}
                            </p>
                            <p class="text-xs font-bold leading-normal mt-0.5
                                @if($techAlerts['insurance']['status'] === 'danger') text-red-600
                                @elseif($techAlerts['insurance']['status'] === 'warning') text-amber-600
                                @else text-emerald-600 @endif">
                                {{ $techAlerts['insurance']['message'] }}
                            </p>
                        </div>
                    </div>

                    <!-- Road Tax Expiry Alert -->
                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 
                            @if($techAlerts['road_tax']['status'] === 'danger') bg-red-50 text-red-600
                            @elseif($techAlerts['road_tax']['status'] === 'warning') bg-amber-50 text-amber-600
                            @else bg-emerald-50 text-emerald-600 @endif">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-semibold">Road Tax Expiry Date</p>
                            <p class="text-xs text-gray-600 mt-0.5">
                                Expiry: {{ $car->road_tax_expiry ? $car->road_tax_expiry->format('d/m/Y') : 'No record' }}
                            </p>
                            <p class="text-xs font-bold leading-normal mt-0.5
                                @if($techAlerts['road_tax']['status'] === 'danger') text-red-600
                                @elseif($techAlerts['road_tax']['status'] === 'warning') text-amber-600
                                @else text-emerald-600 @endif">
                                {{ $techAlerts['road_tax']['message'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specifications Card -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Vehicle Specifications</h3>
                
                <div class="grid grid-cols-2 gap-y-3.5 gap-x-2 text-sm text-gray-700">
                    <div>
                        <span class="block text-[11px] text-gray-400 font-medium">Plate Number</span>
                        <span class="font-bold font-mono tracking-wide text-gray-900">{{ strtoupper($car->plate_number) }}</span>
                    </div>
                    <div>
                        <span class="block text-[11px] text-gray-400 font-medium">Type</span>
                        <span class="font-semibold capitalize text-gray-900">{{ $car->type }}</span>
                    </div>
                    <div>
                        <span class="block text-[11px] text-gray-400 font-medium">Transmission</span>
                        <span class="font-semibold capitalize text-gray-900">{{ $car->transmission }}</span>
                    </div>
                    <div>
                        <span class="block text-[11px] text-gray-400 font-medium">Seats</span>
                        <span class="font-semibold text-gray-900">{{ $car->seats }} seater</span>
                    </div>
                    <div>
                        <span class="block text-[11px] text-gray-400 font-medium">Fuel Type</span>
                        <span class="font-semibold capitalize text-gray-900">{{ $car->fuel_type }}</span>
                    </div>
                    <div>
                        <span class="block text-[11px] text-gray-400 font-medium">Location</span>
                        <span class="font-semibold text-gray-900 truncate block max-w-[120px]" title="{{ $car->location }}">{{ $car->location }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="block text-[11px] text-gray-400 font-medium">Availability Note</span>
                        <span class="font-semibold text-gray-800 text-xs">{{ $car->availability_note ?? 'No special notes' }}</span>
                    </div>
                    @if($car->price_per_week)
                        <div class="col-span-2">
                            <span class="block text-[11px] text-gray-400 font-medium">Weekly Rate</span>
                            <span class="font-semibold text-gray-800">RM {{ number_format($car->price_per_week, 2) }} / week</span>
                        </div>
                    @endif
                    @if($car->late_return_penalty)
                        <div class="col-span-2">
                            <span class="block text-[11px] text-gray-400 font-medium">Late Return Penalty</span>
                            <span class="font-semibold text-gray-800">RM {{ number_format($car->late_return_penalty, 2) }} / hour</span>
                        </div>
                    @endif
                </div>

                @if($car->description)
                    <div class="pt-3 border-t border-gray-100">
                        <span class="block text-[11px] text-gray-400 font-medium mb-1">Description</span>
                        <p class="text-xs text-gray-600 leading-relaxed whitespace-pre-line">{{ $car->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
