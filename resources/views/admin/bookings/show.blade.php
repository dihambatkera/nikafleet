@extends('layouts.admin')

@section('title', 'Booking Details ' . $rental->booking_code)

@section('content')
<div class="space-y-6" x-data="{ 
    cancelModalOpen: false, 
    copySuccess: false,
    copyCode() {
        navigator.clipboard.writeText('{{ $rental->booking_code }}');
        this.copySuccess = true;
        setTimeout(() => this.copySuccess = false, 2000);
    }
}">
    <!-- Breadcrumbs/Heading -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <nav class="flex items-center gap-1.5 text-sm text-gray-500">
            <a href="{{ route('admin.bookings.index') }}" class="hover:text-gray-900 transition-colors">Bookings</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="font-semibold text-gray-800">{{ $rental->booking_code }}</span>
        </nav>
        
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors shadow-sm">
                Back to Bookings
            </a>
        </div>
    </div>

    <!-- Smart Conflict Detection Alert -->
    @if($conflict)
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-5 flex items-start gap-4 shadow-sm animate-pulse">
            <div class="text-2xl mt-0.5">⚠️</div>
            <div class="flex-1">
                <h3 class="font-bold text-[15px]" style="font-family: 'Plus Jakarta Sans', sans-serif;">This vehicle is already booked for these dates!</h3>
                <p class="text-xs text-red-700 mt-1 leading-relaxed">
                    Vehicle <strong>{{ $rental->car->name }}</strong> has a schedule conflict with the following confirmed/active booking:
                </p>
                <div class="mt-3 p-3 bg-red-100/50 rounded-xl inline-flex flex-col sm:flex-row sm:items-center gap-3">
                    <span class="text-xs font-bold text-red-900 bg-red-200 px-2 py-0.5 rounded">
                        Conflict Detected
                    </span>
                    <a href="{{ route('admin.bookings.show', $conflict->id) }}" class="text-xs font-bold text-red-900 underline hover:text-red-950">
                        {{ $conflict->booking_code }} ({{ $conflict->customer_name }})
                    </a>
                    <span class="text-xs text-red-800">
                        {{ $conflict->start_date->format('d/m/Y') }} → {{ $conflict->end_date->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
    @endif

    <!-- Two-column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- LEFT COLUMN — Booking Info (Col Span 2) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Booking code & Info card -->
            <div class="admin-card p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-gray-100 pb-5 gap-4">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Booking Code (Click to Copy)</p>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-2xl font-black text-gray-900 tracking-wider" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $rental->booking_code }}</span>
                            <button @click="copyCode()" 
                                    class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-lg transition-all"
                                    :class="copySuccess ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'">
                                <span x-text="copySuccess ? '✓ Copied' : 'Copy'"></span>
                            </button>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase text-left sm:text-right">Created At</p>
                        <p class="text-sm font-bold text-gray-700 mt-1">{{ $rental->created_at->format('d/m/Y h:i A') }}</p>
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="py-5 border-b border-gray-100 space-y-4">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Customer Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-400">Full Name</p>
                            <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $rental->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Phone Number (Tap-to-call)</p>
                            <p class="text-sm font-bold mt-0.5">
                                <a href="tel:{{ $rental->customer_phone }}" class="text-blue-600 hover:underline">
                                    {{ $rental->customer_phone }}
                                </a>
                            </p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-xs text-gray-400">Customer Notes</p>
                            <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100 mt-1 italic">
                                {{ $rental->customer_notes ?: 'No notes from customer.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Car & Rental Dates -->
                <div class="py-5 border-b border-gray-100 space-y-4">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Vehicle & Rental Period</h3>
                    <div class="flex flex-col sm:flex-row items-center gap-4 bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                        <div class="relative w-24 h-16 bg-slate-200 rounded-xl border border-gray-200 overflow-hidden animate-pulse-placeholder">
                            <img src="{{ $rental->car ? $rental->car->primary_image_url : asset('images/car-placeholder.png') }}"
                                 alt="{{ $rental->car ? $rental->car->name : 'Vehicle' }}"
                                 loading="lazy"
                                 onload="this.parentElement.classList.remove('animate-pulse-placeholder', 'bg-slate-200')"
                                 class="w-full h-full object-cover">
                        </div>
                        
                        <div class="flex-1 text-center sm:text-left">
                            @if($rental->car)
                                <a href="{{ route('admin.cars.show', $rental->car->id) }}" class="text-[15px] font-bold text-gray-900 hover:underline">
                                    {{ $rental->car->name }}
                                </a>
                                <div class="flex flex-wrap justify-center sm:justify-start gap-2 mt-1.5">
                                    <span class="text-xs font-bold text-gray-600 bg-white px-2 py-0.5 border border-gray-200 rounded">
                                        {{ $rental->car->plate_number }}
                                    </span>
                                    <span class="text-xs font-semibold text-gray-500 uppercase">
                                        {{ $rental->car->type }}
                                    </span>
                                </div>
                            @else
                                <p class="text-sm text-red-500 italic">This vehicle has been deleted from records.</p>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                        <div>
                            <p class="text-xs text-gray-400">Start Date</p>
                            <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $rental->start_date ? $rental->start_date->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">End Date</p>
                            <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $rental->end_date ? $rental->end_date->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Duration</p>
                            <p class="text-sm font-black text-blue-600 mt-0.5">{{ $rental->total_days }} {{ $rental->total_days === 1 ? 'Day' : 'Days' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pricing breakdown -->
                <div class="pt-5 space-y-4">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Payment Breakdown</h3>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">{{ $rental->total_days }} days × RM {{ number_format($rental->price_per_day, 2) }}</span>
                            <span class="font-semibold text-gray-900">RM {{ number_format($rental->total_days * $rental->price_per_day, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Deposit Paid</span>
                            <span class="font-semibold text-green-600">- RM {{ number_format($rental->deposit_paid, 2) }}</span>
                        </div>

                        <hr class="border-gray-200">

                        <div class="flex justify-between items-center pt-1">
                            <span class="text-sm font-bold text-gray-800">Balance Due</span>
                            <span class="text-lg font-black text-red-600">RM {{ number_format($rental->balance_due, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment proof image (if uploaded) -->
            @if($rental->payment_proof)
                <div class="admin-card p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Payment Proof</h3>
                    <div class="relative group overflow-hidden rounded-xl border border-gray-200">
                        <div class="relative w-full max-h-[400px] bg-slate-200 animate-pulse-placeholder overflow-hidden">
                            <img src="{{ asset('storage/' . $rental->payment_proof) }}" 
                                 alt="Payment Proof" 
                                 loading="lazy"
                                 onload="this.parentElement.classList.remove('animate-pulse-placeholder', 'bg-slate-200')"
                                 class="w-full h-full object-contain bg-gray-50">
                        </div>
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                            <a href="{{ asset('storage/' . $rental->payment_proof) }}" target="_blank"
                               class="px-4 py-2 bg-white text-gray-900 rounded-xl text-xs font-bold shadow-md hover:bg-gray-100 transition-colors">
                                View Original Image
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Admin Notes with dynamic save indicator -->
            <div class="admin-card p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <label for="admin_notes" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Admin Notes</label>
                    <span id="save-status" class="text-xs">
                        <span class="text-gray-400 font-medium">✓ Ready</span>
                    </span>
                </div>
                <textarea id="admin_notes" rows="4" 
                          placeholder="Enter administrative notes here. Auto-saved as you type..."
                          class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder-gray-400">{{ $rental->admin_notes }}</textarea>
            </div>
        </div>

        <!-- RIGHT COLUMN — Status & Actions -->
        <div class="space-y-6">
            
            <!-- Current Status Badge and Action Box -->
            <div class="admin-card p-6 bg-white rounded-2xl shadow-sm border border-gray-100 space-y-6">
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Current Status</p>
                    <div class="flex items-center gap-3 mt-1.5">
                        <span class="px-3.5 py-1.5 rounded-full text-sm font-black uppercase tracking-wider
                            @if($rental->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($rental->status === 'confirmed') bg-blue-100 text-blue-800
                            @elseif($rental->status === 'active') bg-green-100 text-green-800
                            @elseif($rental->status === 'completed') bg-gray-100 text-gray-800
                            @elseif($rental->status === 'cancelled') bg-red-100 text-red-800
                            @elseif($rental->status === 'refunded') bg-purple-100 text-purple-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $rental->status }}
                        </span>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Visual Stepper Timeline -->
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-4">Rental Timeline</p>
                    <div class="relative pl-6 space-y-6">
                        <!-- timeline line -->
                        <div class="absolute left-[7px] top-2 bottom-2 w-0.5 bg-gray-200"></div>

                        @php
                            $timeline = [
                                'pending' => ['label' => 'Pending Confirmation', 'time' => $rental->created_at],
                                'confirmed' => ['label' => 'Booking Confirmed', 'time' => $rental->confirmed_at],
                                'active' => ['label' => 'Rental Active', 'time' => $rental->started_at],
                                'completed' => ['label' => 'Rental Completed', 'time' => $rental->completed_at],
                            ];
                            $activePassed = true;
                        @endphp

                        @foreach($timeline as $key => $details)
                            @php
                                $isCurrent = $rental->status === $key;
                                $hasTime = !empty($details['time']);
                            @endphp
                            <div class="relative flex items-start gap-3">
                                <!-- Bullet -->
                                <div class="absolute left-[-23px] top-1 w-3.5 h-3.5 rounded-full border-2 bg-white transition-all
                                    {{ $hasTime ? 'border-green-500 bg-green-500 shadow-sm shadow-green-500/20' : 'border-gray-300' }}
                                    {{ $isCurrent ? 'ring-4 ring-blue-500/20 border-blue-500' : '' }}">
                                </div>
                                
                                <div>
                                    <p class="text-xs font-bold {{ $hasTime ? 'text-gray-900' : 'text-gray-400' }}">{{ $details['label'] }}</p>
                                    @if($hasTime)
                                        <p class="text-[10px] text-gray-500 mt-0.5">{{ $details['time']->format('d/m/Y h:i A') }}</p>
                                    @else
                                        <p class="text-[10px] text-gray-400 mt-0.5">Pending</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Actions Buttons -->
                <div class="space-y-3">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-2">Admin Actions</p>

                    <!-- ✅ Confirm Booking -->
                    @if($rental->status === 'pending')
                        <form method="POST" action="{{ route('admin.bookings.confirm', $rental->id) }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors shadow-sm flex items-center justify-center gap-1.5">
                                <span>✅</span> Confirm Booking
                            </button>
                        </form>
                    @endif

                    <!-- 🚗 Start Rental -->
                    @if($rental->status === 'confirmed')
                        <form method="POST" action="{{ route('admin.bookings.start', $rental->id) }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-green-600 text-white rounded-xl text-sm font-semibold hover:bg-green-700 transition-colors shadow-sm flex items-center justify-center gap-1.5">
                                <span>🚗</span> Start Rental
                            </button>
                        </form>
                    @endif

                    <!-- 🏁 Complete Rental -->
                    @if($rental->status === 'active')
                        <form method="POST" action="{{ route('admin.bookings.complete', $rental->id) }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm flex items-center justify-center gap-1.5">
                                <span>🏁</span> Complete Rental
                            </button>
                        </form>
                    @endif

                    <!-- ❌ Cancel Button -->
                    @if(in_array($rental->status, ['pending', 'confirmed', 'active']))
                        <button type="button" @click="cancelModalOpen = true"
                                class="w-full py-2.5 border border-red-200 text-red-600 rounded-xl text-sm font-semibold hover:bg-red-50 transition-all flex items-center justify-center gap-1.5">
                            <span>❌</span> Cancel Booking
                        </button>
                    @endif

                    <!-- 🖨️ Print Receipt PDF -->
                    @if(in_array($rental->status, ['confirmed', 'active', 'completed']))
                        <a href="{{ route('admin.bookings.receipt', $rental->id) }}" 
                           class="w-full py-2.5 bg-gray-900 text-white rounded-xl text-sm font-semibold hover:bg-gray-800 transition-colors shadow-sm flex items-center justify-center gap-1.5">
                            <span>🖨️</span> Print Receipt (PDF)
                        </a>
                    @endif

                    <!-- WhatsApp customer button: opens wa.me/60[phone]?text=... -->
                    @php
                        // clean phone number prefixing for Malaysia
                        $cleanPhone = preg_replace('/[^0-9]/', '', $rental->customer_phone);
                        if (str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '60' . substr($cleanPhone, 1);
                        } elseif (!str_starts_with($cleanPhone, '60')) {
                            $cleanPhone = '60' . $cleanPhone;
                        }
                        
                        $waText = rawurlencode("Salam " . $rental->customer_name . ",\n\nThis is from NikaFleet regarding your vehicle booking for " . ($rental->car ? $rental->car->name : '') . " (Booking Code: " . $rental->booking_code . ").\n\nCurrent Status: " . strtoupper($rental->status) . ".\n\nThank you!");
                    @endphp
                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank"
                       class="w-full py-2.5 bg-[#25D366] text-white rounded-xl text-sm font-semibold hover:bg-[#20ba59] transition-colors shadow-sm flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4 fill-current text-white" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.428 1.98 13.977 1.053 11.99 1.053c-5.437 0-9.861 4.371-9.865 9.8-.001 1.636.43 3.238 1.248 4.647L2.393 20.4l5.127-1.341c1.32.9 2.761 1.095 4.127 1.095z"/>
                        </svg>
                        Contact on WhatsApp
                    </a>
                </div>
            </div>
        </div>
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
                        <p class="text-xs text-gray-500 mt-0.5">Booking: <span class="font-bold text-gray-700">{{ $rental->booking_code }}</span></p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.bookings.cancel', $rental->id) }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="reason" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Cancellation Reason</label>
                        <textarea name="reason" id="reason" rows="3" required
                                  placeholder="Please enter the reason for cancellation..."
                                  class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder-gray-400"></textarea>
                    </div>

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
                            Back
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let debounceTimer;
        const notesTextarea = document.getElementById('admin_notes');
        const statusEl = document.getElementById('save-status');

        if (notesTextarea) {
            notesTextarea.addEventListener('input', function(e) {
                statusEl.innerHTML = '<span class="text-gray-400 font-semibold animate-pulse">Saving...</span>';
                
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetch('{{ route("admin.bookings.notes", $rental->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ admin_notes: e.target.value })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            statusEl.innerHTML = '<span class="text-green-500 font-medium">✓ Saved successfully</span>';
                        } else {
                            statusEl.innerHTML = '<span class="text-red-500 font-medium">✗ Failed to save</span>';
                        }
                    })
                    .catch(error => {
                        statusEl.innerHTML = '<span class="text-red-500 font-medium">✗ Network Error</span>';
                    });
                }, 1000);
            });
        }
    });
</script>
@endpush
@endsection
