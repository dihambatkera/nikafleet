@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 md:p-8">

    {{-- ── HEADER ────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Operations Dashboard
            </h1>
            <p class="text-sm text-gray-500 mt-1">{{ now()->format('l, d F Y') }}</p>
        </div>
        <a href="{{ route('admin.bookings.create') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-white px-5 py-2.5 rounded-xl shadow transition-all"
           style="background: linear-gradient(135deg, #bda04e, #a08a3a); box-shadow: 0 4px 12px rgba(189,160,78,0.35);"
           onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(189,160,78,0.45)';"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(189,160,78,0.35)';">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Booking
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flash-success mb-6">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flash-error mb-6">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── STAT CARDS ─────────────────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Total Cars --}}
        <div class="admin-card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Cars</span>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(189,160,78,0.12)">
                    <svg class="w-4 h-4" style="color:#bda04e" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.34.34M5 16H4M19 16h1M15 16H9m10 0l-2-6H9l-2 6"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $totalCars }}</div>
            <div class="text-xs text-gray-400 mt-1">Fleet registered</div>
        </div>

        {{-- Available --}}
        <div class="admin-card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Available</span>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(16,185,129,0.12)">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-emerald-600">{{ $availableCars }}</div>
            <div class="text-xs text-gray-400 mt-1">Ready to rent</div>
        </div>

        {{-- Active Bookings --}}
        <div class="admin-card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Active</span>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(59,130,246,0.12)">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-blue-600">{{ $activeBookings }}</div>
            <div class="text-xs text-gray-400 mt-1">Active & confirmed</div>
        </div>

        {{-- On Maintenance --}}
        <div class="admin-card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Maintenance</span>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(245,158,11,0.12)">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-amber-500">{{ $maintenanceCars }}</div>
            <div class="text-xs text-gray-400 mt-1">Under service</div>
        </div>
    </div>

    {{-- ── ACTIVE BOOKINGS TABLE ───────────────────────────── --}}
    <div class="admin-card mb-8">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <h2 class="text-base font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Active Bookings</h2>
                <p class="text-xs text-gray-400 mt-0.5">Pending, Confirmed and Active rentals</p>
            </div>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-700 transition-colors">
                View All →
            </a>
        </div>

        @if($activeRentals->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4" style="background: rgba(189,160,78,0.1)">
                    <svg class="w-8 h-8" style="color:#bda04e" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-700">No Active Bookings</p>
                <p class="text-xs text-gray-400 mt-1 mb-5">No rentals are currently active or confirmed.</p>
                <a href="{{ route('admin.bookings.create') }}"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-white px-5 py-2.5 rounded-xl"
                   style="background: #bda04e;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Active Booking
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Booking</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Customer</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Vehicle</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Period</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($activeRentals as $rental)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4" data-label="Booking">
                                <a href="{{ route('admin.bookings.show', $rental->id) }}"
                                   class="font-mono text-xs font-bold hover:underline"
                                   style="color:#bda04e">{{ $rental->booking_code }}</a>
                            </td>
                            <td class="px-5 py-4" data-label="Customer">
                                <div class="font-semibold text-gray-800 text-sm">{{ $rental->customer_name }}</div>
                                <div class="text-xs text-gray-400">{{ $rental->customer_phone }}</div>
                            </td>
                            <td class="px-5 py-4" data-label="Vehicle">
                                <div class="font-medium text-gray-700 text-sm">
                                    {{ $rental->car ? $rental->car->name : '—' }}
                                </div>
                            </td>
                            <td class="px-5 py-4" data-label="Period">
                                <div class="text-xs text-gray-600">
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}</span>
                                    <span class="text-gray-400 mx-1">→</span>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}</span>
                                </div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $rental->total_days }} day(s)</div>
                            </td>
                            <td class="px-5 py-4" data-label="Status">
                                @php
                                    $statusConfig = match($rental->status) {
                                        'active'    => ['bg-emerald-50 text-emerald-700 ring-emerald-200', 'Active'],
                                        'confirmed' => ['bg-blue-50 text-blue-700 ring-blue-200', 'Confirmed'],
                                        'pending'   => ['bg-amber-50 text-amber-700 ring-amber-200', 'Pending'],
                                        default     => ['bg-gray-50 text-gray-500 ring-gray-200', ucfirst($rental->status)],
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ring-1 {{ $statusConfig[0] }}">
                                    {{ $statusConfig[1] }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right" data-label="Actions">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.bookings.show', $rental->id) }}"
                                       class="text-xs font-medium text-gray-500 hover:text-gray-800 transition-colors px-3 py-1.5 rounded-lg hover:bg-gray-100">
                                        View
                                    </a>
                                    @if($rental->status === 'active')
                                    <form method="POST" action="{{ route('admin.bookings.endSession', $rental->id) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Mark this booking as completed and release the vehicle?')"
                                                class="text-xs font-semibold text-white px-3 py-1.5 rounded-lg transition-all"
                                                style="background: #059669;">
                                            End Session
                                        </button>
                                    </form>
                                    @elseif($rental->status === 'confirmed')
                                    <form method="POST" action="{{ route('admin.bookings.start', $rental->id) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="text-xs font-semibold text-white px-3 py-1.5 rounded-lg transition-all"
                                                style="background: #3b82f6;">
                                            Activate
                                        </button>
                                    </form>
                                    @elseif($rental->status === 'pending')
                                    <form method="POST" action="{{ route('admin.bookings.confirm', $rental->id) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="text-xs font-semibold text-white px-3 py-1.5 rounded-lg transition-all"
                                                style="background: #bda04e;">
                                            Confirm
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ── 7-DAY SCHEDULE STRIP ────────────────────────────── --}}
    <div class="admin-card mb-8">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">7-Day Schedule</h2>
        </div>
        <div class="grid grid-cols-7 divide-x divide-gray-100">
            @foreach($scheduleStrip as $day)
            <div class="p-3 text-center {{ $day['date']->isToday() ? 'bg-amber-50' : '' }}">
                <div class="text-xs font-semibold {{ $day['date']->isToday() ? 'text-amber-600' : 'text-gray-400' }}">
                    {{ $day['date']->format('D') }}
                </div>
                <div class="text-sm font-bold {{ $day['date']->isToday() ? 'text-amber-700' : 'text-gray-700' }} mt-0.5">
                    {{ $day['date']->format('d') }}
                </div>
                @if($day['bookings']->count() > 0)
                    <div class="mt-1 flex justify-center">
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full text-[10px] font-bold text-white"
                              style="background:#bda04e;">
                            {{ $day['bookings']->count() }}
                        </span>
                    </div>
                @else
                    <div class="mt-2 h-5 flex items-center justify-center">
                        <div class="w-1.5 h-1.5 rounded-full bg-gray-200"></div>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── RECENTLY COMPLETED/CANCELLED ───────────────────── --}}
    @if($recentBookings->isNotEmpty())
    <div class="admin-card">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Recent History</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-700 transition-colors">
                View All →
            </a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($recentBookings as $rental)
            <div class="flex items-center justify-between px-6 py-3.5 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-4">
                    <span class="font-mono text-xs font-bold" style="color:#bda04e">{{ $rental->booking_code }}</span>
                    <div>
                        <div class="text-sm font-semibold text-gray-800">{{ $rental->customer_name }}</div>
                        <div class="text-xs text-gray-400">{{ $rental->car ? $rental->car->name : '—' }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}</span>
                    @if($rental->status === 'completed')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-500">Done</span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-500">Cancelled</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
