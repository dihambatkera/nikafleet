<div class="space-y-6">
    <!-- Top actions & Search bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Search bar -->
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </span>
            <input type="text" 
                   wire:model.live.debounce.300ms="search" 
                   placeholder="Search by name, plate or brand..." 
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm shadow-sm" />
        </div>

        <!-- Add Button -->
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.cars.create') }}" 
               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-white rounded-xl font-semibold text-sm transition-all shadow-md hover:shadow-lg"
               style="background: linear-gradient(135deg, #bda04e, #a08a3a);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Vehicle
            </a>
        </div>
    </div>

    <!-- Filter tabs and Bulk Actions -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 border-b border-gray-200 pb-1">
        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-1">
            @foreach([
                'all' => 'All',
                'available' => 'Available',
                'rented' => 'Rented',
                'maintenance' => 'Maintenance',
                'hidden' => 'Hidden'
            ] as $key => $label)
                <button type="button"
                        wire:click="$set('statusFilter', '{{ $key }}')"
                        class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $statusFilter === $key ? 'bg-white text-blue-600 shadow-sm border border-gray-150' : 'text-gray-500 hover:text-gray-800' }}">
                    {{ $label }}
                    @php
                        $countQuery = App\Models\Car::query();
                        if ($key !== 'all') {
                            $countQuery->where('status', $key);
                        }
                        $count = $countQuery->count();
                    @endphp
                    <span class="ml-1.5 px-2 py-0.5 text-xs rounded-full {{ $statusFilter === $key ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-500' }}">
                        {{ $count }}
                    </span>
                </button>
            @endforeach
        </div>

        <!-- Bulk Actions -->
        @if(!empty($selectedCars))
            <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-50/50 rounded-xl border border-blue-100 animate-fadeIn">
                <span class="text-xs font-semibold text-blue-700 mr-2">{{ count($selectedCars) }} selected:</span>
                
                <button wire:click="bulkMarkAvailable" 
                        class="px-2.5 py-1.5 bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 rounded-lg text-xs font-medium transition-all">
                    Set Available
                </button>
                <button wire:click="bulkMarkHidden" 
                        class="px-2.5 py-1.5 bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 rounded-lg text-xs font-medium transition-all">
                    Set Hidden
                </button>
                <button wire:click="bulkDelete" 
                        onclick="confirm('Are you sure you want to soft-delete the selected vehicles?') || event.stopImmediatePropagation()"
                        class="px-2.5 py-1.5 bg-red-50 text-red-700 hover:bg-red-100 rounded-lg text-xs font-medium transition-all">
                    Delete
                </button>
            </div>
        @endif
    </div>

    <!-- Table -->
    <div class="admin-card">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/75 border-b border-gray-100">
                        <th class="p-4 w-10">
                            <input type="checkbox" 
                                   wire:model.live="selectAll" 
                                   class="rounded text-blue-600 focus:ring-blue-500 border-gray-300 w-4 h-4 cursor-pointer" />
                        </th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Vehicle Name</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Plate No.</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Rate/Day</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Location</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- Loading skeleton rows -->
                    <tr wire:loading.delay.class.remove="hidden" class="hidden">
                        <td colspan="9" class="p-0">
                            <div class="divide-y divide-gray-150">
                                @for($i = 0; $i < 5; $i++)
                                    <div class="p-4 flex items-center justify-between gap-4 animate-pulse">
                                        <div class="flex items-center gap-3">
                                            <div class="w-16 h-10 bg-gray-200 rounded-lg"></div>
                                            <div class="space-y-2">
                                                <div class="h-4 bg-gray-200 rounded w-32"></div>
                                                <div class="h-3 bg-gray-100 rounded w-24"></div>
                                            </div>
                                        </div>
                                        <div class="h-4 bg-gray-200 rounded w-20"></div>
                                        <div class="h-4 bg-gray-200 rounded w-16"></div>
                                        <div class="h-6 bg-gray-200 rounded w-24"></div>
                                    </div>
                                @endfor
                            </div>
                        </td>
                    </tr>

                    @forelse($cars as $car)
                        <tr wire:loading.remove class="hover:bg-gray-55/50 transition-colors group">
                            <td class="p-4">
                                <input type="checkbox" 
                                       wire:model.live="selectedCars" 
                                       value="{{ $car->id }}"
                                       class="rounded text-blue-600 focus:ring-blue-500 border-gray-300 w-4 h-4 cursor-pointer" />
                            </td>
                            <td class="p-4">
                                <div class="relative w-16 h-10 rounded-lg overflow-hidden border border-gray-200/60 bg-gray-50">
                                    <img src="{{ $car->primary_image_url }}" 
                                         alt="{{ $car->name }}" 
                                         loading="lazy"
                                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                                         class="w-full h-full object-cover" />
                                    <div class="absolute inset-0 items-center justify-center text-gray-300 bg-gray-50" style="display:none;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4" data-label="Vehicle Name">
                                <div class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $car->name }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $car->brand }} &middot; {{ $car->model }} ({{ $car->year }})
                                </div>
                            </td>
                            <td class="p-4 font-mono font-bold text-gray-800 text-sm tracking-wide" data-label="Plate No.">
                                {{ strtoupper($car->plate_number) }}
                            </td>
                            <td class="p-4" data-label="Category">
                                <span class="px-2 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-700 capitalize">
                                    {{ $car->type }}
                                </span>
                            </td>
                            <td class="p-4" data-label="Status">
                                <button type="button"
                                        wire:click="toggleStatus({{ $car->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold transition-all border shadow-sm cursor-pointer active:scale-95
                                            @if($car->status === 'available')
                                                bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100/70
                                            @elseif($car->status === 'rented')
                                                bg-blue-50 text-blue-700 border-blue-200 cursor-not-allowed
                                            @elseif($car->status === 'maintenance')
                                                bg-amber-50 text-amber-700 border-amber-200 hover:bg-amber-100/70
                                            @else
                                                bg-gray-100 text-gray-600 border-gray-300 hover:bg-gray-200
                                            @endif"
                                        @if($car->status === 'rented') disabled title="Vehicle is currently rented" @else title="Click to cycle status" @endif>
                                    <span class="w-1.5 h-1.5 rounded-full 
                                        @if($car->status === 'available') bg-emerald-500
                                        @elseif($car->status === 'rented') bg-blue-500
                                        @elseif($car->status === 'maintenance') bg-amber-500
                                        @else bg-gray-500 @endif"></span>
                                    <span class="capitalize">{{ $car->status }}</span>
                                </button>
                            </td>
                            <td class="p-4 font-semibold text-gray-900" data-label="Rate/Day">
                                RM {{ number_format($car->price_per_day, 2) }}
                            </td>
                            <td class="p-4 text-xs text-gray-500 max-w-[120px] truncate" title="{{ $car->location }}" data-label="Location">
                                {{ $car->location ?: '—' }}
                            </td>
                            <td class="p-4 text-right" data-label="Actions">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- View Detail -->
                                    <a href="{{ route('admin.cars.show', $car->id) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-all text-xs font-medium"
                                       title="View Details">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span class="hidden sm:inline">View</span>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.cars.edit', $car->id) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition-all text-xs font-medium"
                                       title="Edit Vehicle">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                        <span class="hidden sm:inline">Edit</span>
                                    </a>

                                    <!-- Upload Images -->
                                    <a href="{{ route('admin.cars.edit', $car->id) }}?tab=images" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-purple-50 text-purple-600 hover:bg-purple-100 rounded-lg transition-all text-xs font-medium"
                                       title="Upload Images">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="hidden sm:inline">Images</span>
                                    </a>

                                    <!-- Delete (Soft) -->
                                    <button type="button"
                                            wire:click="deleteCar({{ $car->id }})"
                                            onclick="confirm('Are you sure you want to delete this vehicle?') || event.stopImmediatePropagation()"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-all text-xs font-medium"
                                            title="Delete Vehicle">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span class="hidden sm:inline">Delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                No vehicles found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($cars->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $cars->links() }}
            </div>
        @endif
    </div>
</div>
