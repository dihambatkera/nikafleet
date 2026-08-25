<div class="space-y-6" x-data="{ modalOpen: false, selectedEvent: {} }">
    <!-- Breadcrumbs/Heading -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">Kalendar Tempahan</h1>
            <p class="text-xs text-gray-500 mt-1">Lihat jadual tempahan kenderaan NikaFleet secara visual dan pantas.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Senarai Tempahan
            </a>
        </div>
    </div>

    <!-- Calendar Card -->
    <div class="admin-card p-6 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Scroll wrapper on mobile -->
        <div class="overflow-x-auto -mx-6 px-6 sm:mx-0 sm:px-0">
            <div class="min-w-[600px] sm:min-w-full">
                <!-- Calendar Element -->
                <div id="calendar" class="w-full" wire:ignore></div>
            </div>
        </div>
    </div>

    <!-- Beautiful Modal for Booking Details -->
    <div x-show="modalOpen" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        
        <div class="bg-white rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl border border-gray-100 transform transition-all"
             @click.away="modalOpen = false">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between"
                 :style="'background: linear-gradient(135deg, ' + selectedEvent.color + '22, ' + selectedEvent.color + '05)'">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider px-2 py-0.5 rounded"
                          :class="{
                              'bg-yellow-100 text-yellow-800': selectedEvent.status_badge === 'pending',
                              'bg-blue-100 text-blue-800': selectedEvent.status_badge === 'confirmed',
                              'bg-green-100 text-green-800': selectedEvent.status_badge === 'active',
                              'bg-gray-100 text-gray-800': selectedEvent.status_badge === 'completed',
                              'bg-red-100 text-red-800': selectedEvent.status_badge === 'cancelled' || selectedEvent.status_badge === 'refunded'
                          }"
                          x-text="selectedEvent.status">
                    </span>
                    <h3 class="text-lg font-bold text-gray-900 mt-1" x-text="selectedEvent.booking_code"></h3>
                </div>
                <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600 transition-colors p-1.5 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 space-y-4">
                <!-- Customer & Car Info Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase">Pelanggan</p>
                        <p class="text-sm font-bold text-gray-900 mt-0.5" x-text="selectedEvent.customer_name"></p>
                        <p class="text-xs text-gray-500" x-text="selectedEvent.customer_phone"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase">Kereta</p>
                        <p class="text-sm font-bold text-gray-900 mt-0.5" x-text="selectedEvent.car_name"></p>
                        <p class="text-xs text-gray-500" x-text="selectedEvent.plate_number"></p>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Dates Grid -->
                <div class="grid grid-cols-3 gap-2 text-center bg-gray-50 p-3 rounded-xl">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Tarikh Mula</p>
                        <p class="text-xs font-bold text-gray-800 mt-0.5" x-text="selectedEvent.start_date"></p>
                    </div>
                    <div class="flex items-center justify-center">
                        <span class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full font-bold" x-text="selectedEvent.total_days + ' Hari'"></span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Tarikh Tamat</p>
                        <p class="text-xs font-bold text-gray-800 mt-0.5" x-text="selectedEvent.end_date"></p>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Payment Summary -->
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Jumlah Kasar:</span>
                        <span class="font-semibold text-gray-900" x-text="'RM ' + selectedEvent.total_amount"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Deposit Dibayar:</span>
                        <span class="font-semibold text-green-600" x-text="'RM ' + selectedEvent.deposit_paid"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-bold">Baki Perlu Dibayar:</span>
                        <span class="font-bold text-red-600" x-text="'RM ' + selectedEvent.balance_due"></span>
                    </div>
                </div>
            </div>

            <!-- Modal Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-2">
                <button @click="modalOpen = false" class="px-4 py-2 border border-gray-200 bg-white text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-100 transition-colors">
                    Tutup
                </button>
                <a :href="selectedEvent.detail_url" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm inline-flex items-center gap-1.5">
                    Urus Tempahan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .fc {
            font-family: 'Inter', sans-serif;
        }
        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .fc .fc-button-primary {
            background-color: #ffffff;
            border-color: #e2e8f0;
            color: #475569;
            font-weight: 500;
            font-size: 0.875rem;
            border-radius: 10px;
            padding: 6px 12px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            text-transform: capitalize;
        }
        .fc .fc-button-primary:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #1e293b;
        }
        .fc .fc-button-primary:not(:disabled).fc-button-active, 
        .fc .fc-button-primary:not(:disabled):active {
            background-color: #3b82f6;
            border-color: #2563eb;
            color: #ffffff;
        }
        .fc .fc-button-primary:focus {
            box-shadow: 0 0 0 3px rgba(59,130,246,0.25) !important;
        }
        .fc-theme-standard td, .fc-theme-standard th {
            border-color: #f1f5f9;
        }
        .fc-theme-standard .fc-scrollgrid {
            border-color: #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }
        .fc .fc-col-header-cell-cushion {
            padding: 8px 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }
        .fc .fc-daygrid-day-number {
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            padding: 6px;
        }
        .fc .fc-daygrid-day.fc-day-today {
            background-color: #eff6ff !important;
        }
        .fc-event {
            border-radius: 6px;
            padding: 2px 4px;
            font-size: 0.75rem;
            font-weight: 500;
            border: none !important;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            transition: transform 0.1s;
        }
        .fc-event:hover {
            transform: scale(1.02);
            filter: brightness(0.95);
        }
    </style>
    @endpush

    @push('scripts')
    <!-- FullCalendar CDN -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var eventsData = {!! $eventsJson !!};

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'ms', // Malay locale support if available, or default
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulanan',
                    week: 'Mingguan'
                },
                events: eventsData,
                editable: false,
                selectable: false,
                allDaySlot: true,
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    
                    // Populate AlpineJS state variables
                    let alpineRoot = document.querySelector('[x-data]');
                    if (alpineRoot) {
                        let alpineData = Alpine.$data(alpineRoot);
                        alpineData.selectedEvent = info.event.extendedProps;
                        // Put the color into selectedEvent too
                        alpineData.selectedEvent.color = info.event.backgroundColor;
                        alpineData.modalOpen = true;
                    }
                }
            });
            calendar.render();
        });
    </script>
    @endpush
</div>
