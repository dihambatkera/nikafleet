<div class="space-y-6" x-data="{ activeTab: @js($activeTab) }" x-init="$watch('$wire.activeTab', val => { if(val) { activeTab = val; switchVehicleTab(val); } })">
    <!-- Tabs Header -->
    <div class="flex items-center justify-between">
        <div class="flex border-b border-gray-200 w-full">
            <button type="button" 
                    id="tab-btn-general"
                    onclick="switchVehicleTab('general')"
                    @click="activeTab = 'general'; $wire.set('activeTab', 'general')"
                    wire:click="setTab('general')"
                    class="vehicle-tab-btn py-3 px-6 text-sm font-semibold border-b-2 transition-all flex items-center gap-2 cursor-pointer border-blue-600 text-blue-600 font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Vehicle Details
            </button>
            <button type="button" 
                    id="tab-btn-images"
                    onclick="switchVehicleTab('images')"
                    @click="activeTab = 'images'; $wire.set('activeTab', 'images')"
                    wire:click="setTab('images')"
                    class="vehicle-tab-btn py-3 px-6 text-sm font-semibold border-b-2 transition-all flex items-center gap-2 cursor-pointer border-transparent text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Vehicle Images ({{ count($imagesList) }})
            </button>
            <button type="button" 
                    id="tab-btn-blocks"
                    onclick="switchVehicleTab('blocks')"
                    @click="activeTab = 'blocks'; $wire.set('activeTab', 'blocks')"
                    wire:click="setTab('blocks')"
                    class="vehicle-tab-btn py-3 px-6 text-sm font-semibold border-b-2 transition-all flex items-center gap-2 cursor-pointer border-transparent text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Date Blocks ({{ count($blocksList) }})
            </button>
        </div>
    </div>

    <!-- Error/Success session alerts -->
    @if(session()->has('error'))
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-2 animate-fadeIn">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        <!-- ════════════════ TAB 1: GENERAL INFO ════════════════ -->
        <div id="tab-pane-general" class="vehicle-tab-pane space-y-6 animate-fadeIn" x-show="activeTab === 'general'">
            
            <!-- SECTION 1 — Identiti Kereta -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Section 1 &mdash; Vehicle Identity</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Display Name -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Display Name*</label>
                        <input type="text" wire:model="name" placeholder="e.g. Perodua Axia Sport Edition" 
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm @error('name') border-red-400 focus:ring-red-200 @enderror" />
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Plate Number -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Plate Number*</label>
                        <input type="text" wire:model="plate_number" placeholder="e.g. VGD 2341" 
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm uppercase @error('plate_number') border-red-400 focus:ring-red-200 @enderror" />
                        @error('plate_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Brand -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Brand*</label>
                        <input type="text" wire:model="brand" placeholder="e.g. Perodua" 
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm @error('brand') border-red-400 focus:ring-red-200 @enderror" />
                        @error('brand') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Model -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Model*</label>
                        <input type="text" wire:model="model" placeholder="e.g. Axia" 
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm @error('model') border-red-400 focus:ring-red-200 @enderror" />
                        @error('model') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Year -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Year*</label>
                        <input type="number" wire:model="year" placeholder="e.g. 2024" 
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm @error('year') border-red-400 focus:ring-red-200 @enderror" />
                        @error('year') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Color -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Vehicle Color*</label>
                        <div class="flex gap-2">
                            <input type="color" wire:model="color" class="w-10 h-9 p-0.5 border border-gray-200 rounded-lg cursor-pointer bg-white" />
                            <input type="text" wire:model="color" placeholder="#3B82F6" 
                                   class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" />
                        </div>
                        @error('color') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Type -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Vehicle Type*</label>
                        <select wire:model="type" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                            <option value="sedan">Sedan</option>
                            <option value="suv">SUV</option>
                            <option value="mpv">MPV</option>
                            <option value="pickup">Pickup</option>
                            <option value="van">Van</option>
                            <option value="hatchback">Hatchback</option>
                        </select>
                        @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Transmission -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Transmission*</label>
                        <select wire:model="transmission" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                            <option value="auto">Auto</option>
                            <option value="manual">Manual</option>
                        </select>
                        @error('transmission') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Seats -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Number of Seats*</label>
                        <input type="number" wire:model="seats" placeholder="5" 
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm @error('seats') border-red-400 focus:ring-red-200 @enderror" />
                        @error('seats') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Fuel Type -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Fuel Type*</label>
                        <select wire:model="fuel_type" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                            <option value="petrol">Petrol</option>
                            <option value="diesel">Diesel</option>
                            <option value="hybrid">Hybrid</option>
                            <option value="electric">Electric</option>
                        </select>
                        @error('fuel_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- SECTION 2 — Harga & Deposit -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Section 2 &mdash; Price & Deposit</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Price Per Day -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Daily Rate (RM)*</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs">RM</span>
                            <input type="number" step="0.01" wire:model="price_per_day" placeholder="120.00" 
                                   class="w-full pl-9 pr-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm @error('price_per_day') border-red-400 focus:ring-red-200 @enderror" />
                        </div>
                        @error('price_per_day') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Price Per Week -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Weekly Rate (RM) <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs">RM</span>
                            <input type="number" step="0.01" wire:model="price_per_week" placeholder="700.00" 
                                   class="w-full pl-9 pr-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" />
                        </div>
                        @error('price_per_week') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Deposit Amount -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Deposit Amount (RM)*</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs">RM</span>
                            <input type="number" step="0.01" wire:model="deposit_amount" placeholder="150.00" 
                                   class="w-full pl-9 pr-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm @error('deposit_amount') border-red-400 focus:ring-red-200 @enderror" />
                        </div>
                        @error('deposit_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Late Return Penalty -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Late Return Penalty/Hour (RM) <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs">RM</span>
                            <input type="number" step="0.01" wire:model="late_return_penalty" placeholder="10.00" 
                                   class="w-full pl-9 pr-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" />
                        </div>
                        @error('late_return_penalty') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- SECTION 3 — Status & Paparan -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Section 3 &mdash; Status & Display</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Status -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Status*</label>
                        <select wire:model="status" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                            <option value="available">Available</option>
                            <option value="rented">Rented</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="hidden">Hidden</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Custom Location -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Custom Location <span class="text-gray-400 font-normal">(Default if empty)</span></label>
                        <input type="text" wire:model="location" placeholder="e.g. Rawang, Selangor" 
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" />
                        @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Featured toggle -->
                    <div class="flex flex-col justify-center">
                        <span class="block text-xs font-semibold text-gray-600 mb-2">Featured on Homepage?</span>
                        <label class="relative inline-flex items-center cursor-pointer mt-1 select-none">
                            <input type="checkbox" wire:model="featured" class="sr-only peer" />
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Yes, mark as Featured</span>
                        </label>
                    </div>
                </div>

                <!-- Availability Note -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Availability Note <span class="text-gray-400 font-normal">(e.g. "Weekdays only", "Call first")</span></label>
                    <input type="text" wire:model="availability_note" placeholder="e.g. Available weekdays only" 
                           class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" />
                    @error('availability_note') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Description</label>
                    <textarea wire:model="description" rows="4" placeholder="Enter vehicle details, advantages, specs or rental terms..." 
                              class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm"></textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- SECTION 4 — Rekod Teknikal -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Section 4 &mdash; Technical Records</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Current Mileage -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Current Mileage (km)</label>
                        <input type="number" wire:model="mileage" placeholder="e.g. 35000" 
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" />
                        @error('mileage') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Last Service Date -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Last Service</label>
                        <input type="date" wire:model="last_service_date" 
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" />
                        @error('last_service_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Next Service Due -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Next Service Due</label>
                        <input type="date" wire:model="next_service_due" 
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" />
                        @error('next_service_due') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Insurance Expiry -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Insurance Expiry</label>
                        <input type="date" wire:model="insurance_expiry" 
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" />
                        @error('insurance_expiry') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Road Tax Expiry -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Road Tax Expiry</label>
                        <input type="date" wire:model="road_tax_expiry" 
                               class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm" />
                        @error('road_tax_expiry') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════════════ TAB 2: IMAGE UPLOADER ════════════════ -->
        <div id="tab-pane-images" class="vehicle-tab-pane space-y-6 animate-fadeIn hidden" style="display: none;" x-show="activeTab === 'images'">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-6">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Section 5 &mdash; Vehicle Images (Max 10)</h3>
                    </div>
                    <span class="text-xs text-gray-500">Uploaded images are automatically optimized and resized.</span>
                </div>

                <!-- Drag-and-drop file uploader area -->
                <div class="flex justify-center items-center w-full">
                    <label class="flex flex-col justify-center items-center w-full h-44 bg-gray-50 hover:bg-gray-100/70 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer transition-all hover:border-blue-500 group">
                        <div class="flex flex-col justify-center items-center pt-5 pb-6">
                            <!-- Cloud upload icon -->
                            <svg class="w-10 h-10 mb-3 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-bold text-blue-600">Click to upload</span> or drag files here</p>
                            <p class="text-xs text-gray-400">JPG, PNG, WEBP only (Max 10MB per file)</p>
                        </div>
                        <input type="file" wire:model="newImages" class="hidden" multiple accept="image/jpeg,image/png,image/webp,image/jpg" />
                    </label>
                </div>

                <!-- Livewire File Upload Loading Indicator -->
                <div wire:loading wire:target="newImages" class="w-full text-center py-3 text-sm text-blue-600 font-semibold bg-blue-50 rounded-xl">
                    <div class="inline-flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Uploading and preparing images, please wait...
                    </div>
                </div>

                @error('newImages.*')
                    <div class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Image List / Grid Preview -->
                @if(!empty($imagesList))
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Image Order (First or starred image is the Primary Image)</h4>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                            @foreach($imagesList as $index => $img)
                                <div class="relative group bg-gray-50 border border-gray-200 rounded-xl overflow-hidden shadow-sm flex flex-col justify-between" wire:key="img-card-{{ $img['id'] }}">
                                    
                                    <!-- Image Thumbnail -->
                                    <div class="relative h-28 w-full bg-gray-100">
                                        <img src="{{ $img['url'] }}" alt="Vehicle image" class="w-full h-full object-cover" />
                                        
                                        <!-- Primary Image Badge -->
                                        @if(!empty($img['is_primary']))
                                            <span class="absolute top-2 left-2 px-2 py-0.5 bg-yellow-400 text-yellow-950 font-bold text-[9px] uppercase tracking-wider rounded-md shadow flex items-center gap-1">
                                                <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                Primary
                                            </span>
                                        @endif

                                        <!-- Actions Overlay on Hover -->
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                            
                                            <!-- Star Icon (Set Primary) -->
                                            <button type="button" 
                                                    wire:click="setPrimaryImage('{{ $img['id'] }}')"
                                                    class="p-1.5 bg-white/95 hover:bg-white text-yellow-500 rounded-lg shadow transition-all hover:scale-110"
                                                    title="Set as Primary">
                                                <svg class="w-4 h-4 {{ !empty($img['is_primary']) ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.837-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            </button>

                                            <!-- Delete Button -->
                                            <button type="button" 
                                                    wire:click="deleteImage('{{ $img['id'] }}')"
                                                    class="p-1.5 bg-white/95 hover:bg-white text-red-600 rounded-lg shadow transition-all hover:scale-110"
                                                    title="Delete Image">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Reordering Controls -->
                                    <div class="flex items-center justify-between p-2 border-t border-gray-150 bg-white">
                                        <button type="button" 
                                                wire:click="moveImage({{ $index }}, -1)"
                                                class="p-1 text-gray-500 hover:text-blue-600 hover:bg-gray-100 rounded transition-all disabled:opacity-20"
                                                @if($index === 0) disabled @endif
                                                title="Move Left">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </button>
                                        <span class="text-[10px] font-semibold text-gray-400">#{{ $index + 1 }}</span>
                                        <button type="button" 
                                                wire:click="moveImage({{ $index }}, 1)"
                                                class="p-1 text-gray-500 hover:text-blue-600 hover:bg-gray-100 rounded transition-all disabled:opacity-20"
                                                @if($index === count($imagesList) - 1) disabled @endif
                                                title="Move Right">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-6 text-gray-400 border border-gray-200 border-dashed rounded-2xl bg-gray-50/50">
                        Please upload at least one image for this vehicle.
                    </div>
                @endif
            </div>
        </div>

        <!-- ════════════════ TAB 3: BLOCK AVAILABILITY ════════════════ -->
        <div id="tab-pane-blocks" class="vehicle-tab-pane space-y-6 animate-fadeIn hidden" style="display: none;" x-show="activeTab === 'blocks'">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-6">
                
                <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Section 6 &mdash; Block Availability (Optional)</h3>
                </div>

                <!-- Block Date Form -->
                <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Block From*</label>
                        <input type="date" wire:model="newBlockFrom" 
                               class="w-full px-3.5 py-2 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm @error('newBlockFrom') border-red-400 @enderror" />
                        @error('newBlockFrom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Block Until*</label>
                        <input type="date" wire:model="newBlockUntil" 
                               class="w-full px-3.5 py-2 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm @error('newBlockUntil') border-red-400 @enderror" />
                        @error('newBlockUntil') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2 flex items-end gap-3">
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Block Reason*</label>
                            <input type="text" wire:model="newBlockReason" placeholder="e.g. Major service, manual booking, etc." 
                                   class="w-full px-3.5 py-2 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm @error('newBlockReason') border-red-400 @enderror" />
                            @error('newBlockReason') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="button" 
                                wire:click="addBlock"
                                class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm transition-all shadow-md">
                            Add
                        </button>
                    </div>
                </div>

                <!-- Existing Blocks List -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Active Date Blocks</h4>
                    
                    <div class="overflow-hidden border border-gray-150 rounded-xl">
                        <table class="w-full text-left border-collapse bg-white">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-150">
                                    <th class="p-3 text-xs font-bold text-gray-500 uppercase">Start Date</th>
                                    <th class="p-3 text-xs font-bold text-gray-500 uppercase">End Date</th>
                                    <th class="p-3 text-xs font-bold text-gray-500 uppercase">Block Reason</th>
                                    <th class="p-3 text-xs font-bold text-gray-500 uppercase text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($blocksList as $block)
                                    <tr class="hover:bg-gray-50/50 transition-colors" wire:key="block-row-{{ $block['id'] }}">
                                        <td class="p-3 text-sm text-gray-800 font-semibold">
                                            {{ \Carbon\Carbon::parse($block['blocked_from'])->format('d/m/Y') }}
                                        </td>
                                        <td class="p-3 text-sm text-gray-800 font-semibold">
                                            {{ \Carbon\Carbon::parse($block['blocked_until'])->format('d/m/Y') }}
                                        </td>
                                        <td class="p-3 text-sm text-gray-600">
                                            {{ $block['reason'] }}
                                            @if(!empty($block['is_new']))
                                                <span class="ml-2 px-1.5 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-bold rounded">New</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-right">
                                            <button type="button" 
                                                    wire:click="deleteBlock('{{ $block['id'] }}')"
                                                    class="p-1 hover:bg-red-50 text-gray-400 hover:text-red-600 rounded transition-all"
                                                    title="Delete Block">
                                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-6 text-center text-gray-400 text-sm">
                                            No date blocks registered for this vehicle.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════════════ FORM ACTIONS ════════════════ -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-150">
            <!-- Left: Delete Button in Edit Mode -->
            @if($isEditMode)
                <button type="button" 
                        onclick="if(confirm('Are you sure you want to delete this vehicle?')) { document.getElementById('delete-car-form').submit(); }"
                        class="px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-xl font-semibold text-sm transition-all flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete Vehicle
                </button>
            @else
                <div></div>
            @endif

            <!-- Right Buttons: Cancel & Save -->
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.cars.index') }}" 
                   class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl font-semibold text-sm transition-all text-center">
                    Cancel
                </a>
                
                @if(!$isEditMode)
                    <button type="button" 
                            wire:click="save(false)"
                            class="px-5 py-2.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-xl font-semibold text-sm transition-all text-center">
                        Save & Add Another
                    </button>
                @endif

                <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm transition-all shadow-md shadow-blue-500/10 hover:shadow-lg hover:shadow-blue-500/20 text-center flex items-center justify-center gap-2">
                    <span wire:loading wire:target="save">
                        <svg class="animate-spin h-4.5 w-4.5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    Save & Return
                </button>
            </div>
        </div>
    </form>

    <!-- Invisible delete form for button in Edit Mode -->
    @if($isEditMode)
        <form id="delete-car-form" method="POST" action="{{ route('admin.cars.destroy', $car->id) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif

    <script>
    function switchVehicleTab(tabName) {
        // Hide all panes
        var panes = document.querySelectorAll('.vehicle-tab-pane');
        for (var i = 0; i < panes.length; i++) {
            panes[i].style.setProperty('display', 'none', 'important');
            panes[i].classList.add('hidden');
        }

        // Show target pane
        var targetPane = document.getElementById('tab-pane-' + tabName);
        if (targetPane) {
            targetPane.style.setProperty('display', 'block', 'important');
            targetPane.classList.remove('hidden');
        }

        // Update button active styles
        var btns = document.querySelectorAll('.vehicle-tab-btn');
        for (var j = 0; j < btns.length; j++) {
            btns[j].classList.remove('border-blue-600', 'text-blue-600', 'font-bold');
            btns[j].classList.add('border-transparent', 'text-gray-500');
        }

        var targetBtn = document.getElementById('tab-btn-' + tabName);
        if (targetBtn) {
            targetBtn.classList.remove('border-transparent', 'text-gray-500');
            targetBtn.classList.add('border-blue-600', 'text-blue-600', 'font-bold');
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            switchVehicleTab('{{ $activeTab ?? "general" }}');
        });
    } else {
        switchVehicleTab('{{ $activeTab ?? "general" }}');
    }

    document.addEventListener('livewire:navigated', function() {
        switchVehicleTab('{{ $activeTab ?? "general" }}');
    });
    </script>
</div>
