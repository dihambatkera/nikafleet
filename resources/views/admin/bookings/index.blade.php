@extends('layouts.admin')

@section('title', 'Bookings')

@section('content')
<div class="space-y-6" x-data="{ 
    cancelModalOpen: false, 
    cancelActionUrl: '', 
    bookingCode: '', 
    openCancelModal(actionUrl, code) {
        this.cancelActionUrl = actionUrl;
        this.bookingCode = code;
        this.cancelModalOpen = true;
    }
}">
    <!-- Heading/Breadcrumb Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">Booking Management</h1>
            <p class="text-xs text-gray-500 mt-1">Manage vehicle bookings, confirm status, print receipts, and check rental conflicts.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.bookings.calendar') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Schedule Calendar
            </a>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="border-b border-gray-200">
        <nav class="flex space-x-6 -mb-px">
            @php
                $tabs = [
                    'semua' => 'All',
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'active' => 'Active',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled'
                ];
            @endphp
            @foreach($tabs as $tabKey => $tabLabel)
                <a href="{{ request()->fullUrlWithQuery(['status' => $tabKey, 'page' => null]) }}"
                   class="pb-4 px-1 border-b-2 font-medium text-sm transition-all duration-150 {{ $status === $tabKey ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    {{ $tabLabel }}
                    <span class="ml-1 bg-gray-100 text-gray-600 text-[11px] px-2 py-0.5 rounded-full font-bold">
                        @if($tabKey === 'semua')
                            {{ \App\Models\Rental::count() }}
                        @elseif($tabKey === 'cancelled')
                            {{ \App\Models\Rental::whereIn('status', ['cancelled', 'refunded'])->count() }}
                        @else
                            {{ \App\Models\Rental::where('status', $tabKey)->count() }}
                        @endif
                    </span>
                </a>
            @endforeach
        </nav>
    </div>

    <!-- Filter Bar -->
    <div class="admin-card p-5 bg-white rounded-2xl shadow-sm border border-gray-100">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Hidden inputs to retain current status and sorting values -->
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="hidden" name="sort" value="{{ $sort }}">
            <input type="hidden" name="direction" value="{{ $direction }}">

            <!-- Search by Name/Code/Phone -->
            <div>
                <label for="search" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Search Customer / Code</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder-gray-400"
                           placeholder="Name, code, or phone...">
                </div>
            </div>

            <!-- Car Filter -->
            <div>
                <label for="car_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 font-medium">Filter Vehicle</label>
                <select name="car_id" id="car_id" 
                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    <option value="">All Vehicles</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                            {{ $car->name }} ({{ $car->plate_number }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date Range Picker -->
            <div>
                <label for="date_range" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Booking Date Range</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <input type="text" name="date_range" id="date_range" value="{{ request('date_range') }}"
                           class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder-gray-400"
                           placeholder="Select date range...">
                </div>
            </div>

            <!-- Action buttons inside filter bar -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2 bg-gray-900 text-white rounded-xl text-sm font-semibold hover:bg-gray-800 transition-colors shadow-sm flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'car_id', 'date_range']))
                    <a href="{{ route('admin.bookings.index', ['status' => $status]) }}" class="py-2 px-3 bg-gray-100 text-gray-600 rounded-xl text-sm font-semibold hover:bg-gray-200 transition-colors" title="Reset">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Booking Table -->
    <div class="admin-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-left">
                <thead class="bg-gray-50/70 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <tr>
                        <!-- Sortable Columns Helper -->
                        @php
                            function sortLink($column, $label, $currentSort, $currentDirection) {
                                $direction = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';
                                $icon = '';
                                if ($currentSort === $column) {
                                    $icon = $currentDirection === 'asc' ? ' 🔼' : ' 🔽';
                                }
                                $url = request()->fullUrlWithQuery(['sort' => $column, 'direction' => $direction]);
                                return "<a href=\"{$url}\" class=\"hover:text-gray-900 inline-flex items-center\">{$label}{$icon}</a>";
                            }
                        @endphp
                        <th class="px-6 py-4">{!! sortLink('booking_code', 'Booking Code', $sort, $direction) !!}</th>
                        <th class="px-6 py-4">{!! sortLink('customer', 'Customer', $sort, $direction) !!}</th>
                        <th class="px-6 py-4">Vehicle</th>
                        <th class="px-6 py-4">{!! sortLink('mula', 'Start', $sort, $direction) !!}</th>
                        <th class="px-6 py-4">{!! sortLink('tamat', 'End', $sort, $direction) !!}</th>
                        <th class="px-6 py-4">{!! sortLink('hari', 'Days', $sort, $direction) !!}</th>
                        <th class="px-6 py-4">{!! sortLink('jumlah', 'Total (RM)', $sort, $direction) !!}</th>
                        <th class="px-6 py-4">{!! sortLink('status', 'Status', $sort, $direction) !!}</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <!-- Booking Code -->
                            <td class="px-6 py-4 font-bold text-gray-900">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="hover:text-blue-600 underline">
                                    {{ $booking->booking_code }}
                                </a>
                            </td>
                            <!-- Customer Info -->
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-800">{{ $booking->customer_name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $booking->customer_phone }}</p>
                            </td>
                            <!-- Car info -->
                            <td class="px-6 py-4">
                                @if($booking->car)
                                    <p class="font-medium text-gray-800">{{ $booking->car->name }}</p>
                                    <p class="text-[11px] font-bold text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded inline-block mt-0.5">{{ $booking->car->plate_number }}</p>
                                @else
                                    <span class="text-red-500 italic text-xs">Vehicle Deleted</span>
                                @endif
                            </td>
                            <!-- Start Date -->
                            <td class="px-6 py-4 font-medium text-gray-600">
                                {{ $booking->start_date ? $booking->start_date->format('d/m/Y') : '-' }}
                            </td>
                            <!-- End Date -->
                            <td class="px-6 py-4 font-medium text-gray-600">
                                {{ $booking->end_date ? $booking->end_date->format('d/m/Y') : '-' }}
                            </td>
                            <!-- Total Days -->
                            <td class="px-6 py-4 text-center font-bold text-gray-700">
                                {{ $booking->total_days }}
                            </td>
                            <!-- Total Amount -->
                            <td class="px-6 py-4 font-bold text-gray-900">
                                RM {{ number_format($booking->total_amount, 2) }}
                            </td>
                            <!-- Status Badges -->
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                    @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($booking->status === 'active') bg-green-100 text-green-800
                                    @elseif($booking->status === 'completed') bg-gray-100 text-gray-800
                                    @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                    @elseif($booking->status === 'refunded') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <!-- Row Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <!-- View detail -->
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="p-1 text-gray-400 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors" title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    <!-- Confirm booking -->
                                    @if($booking->status === 'pending')
                                        <form method="POST" action="{{ route('admin.bookings.confirm', $booking->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="p-1 text-blue-500 hover:text-blue-700 rounded-lg hover:bg-blue-50 transition-colors" title="Confirm Booking">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Mark Active (Start Sewa) -->
                                    @if($booking->status === 'confirmed')
                                        <form method="POST" action="{{ route('admin.bookings.start', $booking->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="p-1 text-green-500 hover:text-green-700 rounded-lg hover:bg-green-50 transition-colors" title="Start Rental">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Complete Booking -->
                                    @if($booking->status === 'active')
                                        <form method="POST" action="{{ route('admin.bookings.complete', $booking->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="p-1 text-indigo-500 hover:text-indigo-700 rounded-lg hover:bg-indigo-50 transition-colors" title="Complete Rental">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Cancel Modal Trigger -->
                                    @if(in_array($booking->status, ['pending', 'confirmed', 'active']))
                                        <button type="button" 
                                                @click="openCancelModal('{{ route('admin.bookings.cancel', $booking->id) }}', '{{ $booking->booking_code }}')"
                                                class="p-1 text-red-500 hover:text-red-700 rounded-lg hover:bg-red-50 transition-colors" 
                                                title="Cancel Booking">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    @endif

                                    <!-- Print Receipt -->
                                    @if(in_array($booking->status, ['confirmed', 'active', 'completed']))
                                        <a href="{{ route('admin.bookings.receipt', $booking->id) }}" class="p-1 text-orange-500 hover:text-orange-700 rounded-lg hover:bg-orange-50 transition-colors" title="Print Receipt">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="font-medium text-gray-500">No bookings found.</p>
                                <p class="text-xs text-gray-400 mt-1">Try changing your search filters or status tab.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

    <!-- Cancellation Confirmation Modal -->
    <div x-show="cancelModalOpen" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        
        <div class="bg-white rounded-2xl max-w-md w-full overflow-hidden shadow-2xl border border-gray-100 transform transition-all"
             @click.away="cancelModalOpen = false">
            
            <div class="p-6">
                <div class="flex items-center gap-3 text-red-600 mb-4">
                    <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center flex-shrink-0 text-xl font-bold">⚠️</div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 leading-tight">Cancel Booking</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Booking: <span class="font-bold text-gray-700" x-text="bookingCode"></span></p>
                    </div>
                </div>

                <form method="POST" :action="cancelActionUrl" class="space-y-4">
                    @csrf
                    
                    <!-- Reason textarea -->
                    <div>
                        <label for="reason" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Cancellation Reason</label>
                        <textarea name="reason" id="reason" rows="3" required
                                  placeholder="Please enter the cancellation reason..."
                                  class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder-gray-400"></textarea>
                    </div>

                    <!-- Mark Refund Checkbox -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="mark_refund" id="mark_refund" value="1"
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500/20 w-4 h-4">
                        <label for="mark_refund" class="text-xs font-medium text-gray-600 select-none">
                            Mark deposit as refunded
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" @click="cancelModalOpen = false" 
                                class="px-4 py-2 border border-gray-200 bg-white text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-100 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-xl text-sm font-medium hover:bg-red-700 transition-colors shadow-sm">
                            Yes, Cancel Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Styling for Flatpickr range input inside filters */
    .flatpickr-calendar {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: 1px solid #f1f5f9;
        font-family: 'Inter', sans-serif;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#date_range", {
            mode: "range",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            conjunction: " to "
        });
    });
</script>
@endpush
@endsection
