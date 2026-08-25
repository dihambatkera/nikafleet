@extends('layouts.admin')

@section('title', 'Tetapan Sistem')

@php
    $activeTab = request()->get('tab', 'maklumat-syarikat');
@endphp

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ activeTab: '{{ $activeTab }}' }">
    
    <!-- Toast Notifications -->
    @if(session('success'))
    <div x-data="{ show: true }" 
         x-init="setTimeout(() => show = false, 4500)" 
         x-show="show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-90"
         class="fixed bottom-5 right-5 z-50 bg-slate-900 border border-slate-800 text-white px-5 py-4 rounded-2xl shadow-2xl flex items-center gap-4 max-w-sm">
        <div class="w-8 h-8 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <div>
            <p class="font-bold text-[14px]" style="font-family: 'Plus Jakarta Sans', sans-serif;">Berjaya!</p>
            <p class="text-xs text-slate-400 mt-0.5">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" 
         x-init="setTimeout(() => show = false, 4500)" 
         x-show="show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-90"
         class="fixed bottom-5 right-5 z-50 bg-slate-900 border border-slate-800 text-white px-5 py-4 rounded-2xl shadow-2xl flex items-center gap-4 max-w-sm">
        <div class="w-8 h-8 rounded-full bg-rose-500/10 text-rose-500 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <p class="font-bold text-[14px]" style="font-family: 'Plus Jakarta Sans', sans-serif;">Ralat!</p>
            <p class="text-xs text-slate-400 mt-0.5">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">Tetapan Sistem</h1>
        <p class="text-slate-500 mt-1 text-sm">Uruskan maklumat syarikat, tetapan sewaan, had tempahan, akaun keselamatan pentadbir, dan pengurusan data.</p>
    </div>

    <!-- Layout Wrapper -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Navigation Tabs -->
        <div class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-3 shadow-sm space-y-1">
                
                <!-- Tab 1 -->
                <button @click="activeTab = 'maklumat-syarikat'" 
                        :class="activeTab === 'maklumat-syarikat' ? 'bg-indigo-50 border-indigo-200 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 border-transparent hover:text-slate-900'"
                        class="w-full text-left px-4 py-3 rounded-xl border flex items-center gap-3 transition duration-150 text-sm font-semibold">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Maklumat Syarikat</span>
                </button>

                <!-- Tab 2 -->
                <button @click="activeTab = 'tempahan'" 
                        :class="activeTab === 'tempahan' ? 'bg-indigo-50 border-indigo-200 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 border-transparent hover:text-slate-900'"
                        class="w-full text-left px-4 py-3 rounded-xl border flex items-center gap-3 transition duration-150 text-sm font-semibold">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Tetapan Tempahan</span>
                </button>

                <!-- Tab 3 -->
                <button @click="activeTab = 'kewangan'" 
                        :class="activeTab === 'kewangan' ? 'bg-indigo-50 border-indigo-200 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 border-transparent hover:text-slate-900'"
                        class="w-full text-left px-4 py-3 rounded-xl border flex items-center gap-3 transition duration-150 text-sm font-semibold">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Kewangan</span>
                </button>

                <!-- Tab 4 -->
                <button @click="activeTab = 'admin-pengguna'" 
                        :class="activeTab === 'admin-pengguna' ? 'bg-indigo-50 border-indigo-200 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 border-transparent hover:text-slate-900'"
                        class="w-full text-left px-4 py-3 rounded-xl border flex items-center gap-3 transition duration-150 text-sm font-semibold">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Pengguna Admin</span>
                </button>

                <!-- Tab 5 -->
                <button @click="activeTab = 'data-backup'" 
                        :class="activeTab === 'data-backup' ? 'bg-indigo-50 border-indigo-200 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 border-transparent hover:text-slate-900'"
                        class="w-full text-left px-4 py-3 rounded-xl border flex items-center gap-3 transition duration-150 text-sm font-semibold">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4"/>
                    </svg>
                    <span>Data & Backup</span>
                </button>

            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm">
            
            <!-- ═══════════════════════════════════════════════════
                 TAB 1: MAKLUMAT SYARIKAT
                 ═══════════════════════════════════════════════════ -->
            <div x-show="activeTab === 'maklumat-syarikat'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1">
                <form action="{{ route('admin.settings.company') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="border-b border-slate-100 pb-5 mb-6">
                        <h2 class="text-xl font-bold text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Maklumat Syarikat</h2>
                        <p class="text-slate-500 text-xs mt-1">Sediakan butiran profil perniagaan anda yang akan dipaparkan di portal awam dan resit pelanggan.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Company Logo -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Logo Syarikat</label>
                            <div class="flex items-center gap-6" x-data="{ logoPreview: '{{ file_exists(public_path('logo.jpeg')) ? asset('logo.jpeg') . '?v=' . time() : 'https://ui-avatars.com/api/?name=NikaFleet&background=4f46e5&color=fff' }}' }">
                                <div class="w-24 h-24 rounded-2xl overflow-hidden bg-slate-50 border border-slate-200 flex items-center justify-center flex-shrink-0">
                                    <img :src="logoPreview" class="w-full h-full object-contain" alt="Logo preview">
                                </div>
                                <div>
                                    <input type="file" name="logo" id="logo" class="hidden" accept="image/*"
                                           @change="const file = $event.target.files[0]; if (file) { logoPreview = URL.createObjectURL(file) }">
                                    <label for="logo" class="cursor-pointer inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        Muat Naik Logo
                                    </label>
                                    <p class="text-[11px] text-slate-400 mt-2">Format disokong: JPEG, JPG, PNG. Saiz maks: 2MB. Logo akan menggantikan fail di <code>public/logo.jpeg</code>.</p>
                                    @error('logo')
                                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Company Name -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Syarikat <span class="text-rose-500">*</span></label>
                            <input type="text" name="company_name" value="{{ old('company_name', setting('company_name', 'NikaFleet')) }}" 
                                   class="w-full px-4 py-3 rounded-xl border @error('company_name') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            @error('company_name')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tagline -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tagline Syarikat <span class="text-rose-500">*</span></label>
                            <input type="text" name="tagline" value="{{ old('tagline', setting('tagline', 'Nak sewa? Nika kan ada!')) }}" 
                                   class="w-full px-4 py-3 rounded-xl border @error('tagline') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            @error('tagline')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. Telefon Syarikat <span class="text-rose-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', setting('phone', '+60 11-6824 7599')) }}" 
                                   class="w-full px-4 py-3 rounded-xl border @error('phone') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            @error('phone')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- WhatsApp Number -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. WhatsApp <span class="text-rose-500">*</span></label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', setting('whatsapp', '+60116824 7599')) }}" 
                                   class="w-full px-4 py-3 rounded-xl border @error('whatsapp') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            @error('whatsapp')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location / Address -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Syarikat <span class="text-rose-500">*</span></label>
                            <textarea name="address" rows="3" 
                                      class="w-full px-4 py-3 rounded-xl border @error('address') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">{{ old('address', setting('address', 'Rawang, Selangor, Malaysia')) }}</textarea>
                            @error('address')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Social Media URLs -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pautan TikTok <span class="text-rose-500">*</span></label>
                            <input type="text" name="tiktok" value="{{ old('tiktok', setting('tiktok', 'https://www.tiktok.com/@nika.fleet')) }}" 
                                   class="w-full px-4 py-3 rounded-xl border @error('tiktok') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            @error('tiktok')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pautan Instagram (Pilihan)</label>
                            <input type="text" name="instagram" value="{{ old('instagram', setting('instagram', '')) }}" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pautan Facebook (Pilihan)</label>
                            <input type="text" name="facebook" value="{{ old('facebook', setting('facebook', '')) }}" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                        </div>

                        <!-- Google Maps Embed Link -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Google Maps Embed URL</label>
                            <input type="text" name="google_maps_embed" value="{{ old('google_maps_embed', setting('google_maps_embed', '')) }}" 
                                   placeholder="https://www.google.com/maps/embed?pb=..."
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            <p class="text-[10px] text-slate-400 mt-1">Masukkan pautan src daripada kod iframe Google Maps.</p>
                        </div>

                        <!-- About Us -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Penerangan Ringkas Mengenai Syarikat (About Us) <span class="text-rose-500">*</span></label>
                            <textarea name="about_us" rows="4" 
                                      class="w-full px-4 py-3 rounded-xl border @error('about_us') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">{{ old('about_us', setting('about_us', 'NikaFleet menyediakan perkhidmatan sewa kereta pandu sendiri di Rawang dan sekitar Selangor.')) }}</textarea>
                            @error('about_us')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl shadow-sm transition hover:scale-[1.01] active:scale-[0.99] text-sm">
                            Simpan Maklumat Syarikat
                        </button>
                    </div>
                </form>
            </div>

            <!-- ═══════════════════════════════════════════════════
                 TAB 2: TETAPAN TEMPAHAN
                 ═══════════════════════════════════════════════════ -->
            <div x-show="activeTab === 'tempahan'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1">
                <form action="{{ route('admin.settings.booking') }}" method="POST">
                    @csrf
                    <div class="border-b border-slate-100 pb-5 mb-6">
                        <h2 class="text-xl font-bold text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Tetapan Tempahan</h2>
                        <p class="text-slate-500 text-xs mt-1">Uruskan syarat tempahan kereta, tempoh had masa, deposit pendahuluan, dan mesej templat.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Minimum Booking Days -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Minimum Hari Sewaan <span class="text-rose-500">*</span></label>
                            <input type="number" name="booking_min_days" value="{{ old('booking_min_days', setting('booking_min_days', 1)) }}" min="1"
                                   class="w-full px-4 py-3 rounded-xl border @error('booking_min_days') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            @error('booking_min_days')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Maximum Advance Booking Days -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Maksimum Tempahan Awal (Hari) <span class="text-rose-500">*</span></label>
                            <input type="number" name="booking_max_advance_days" value="{{ old('booking_max_advance_days', setting('booking_max_advance_days', 90)) }}" min="1"
                                   class="w-full px-4 py-3 rounded-xl border @error('booking_max_advance_days') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            <p class="text-[10px] text-slate-400 mt-1">Pelanggan tidak boleh membuat tempahan melebihi had hari ini daripada tarikh hari ini.</p>
                            @error('booking_max_advance_days')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Require Deposit Upfront? -->
                        <div class="md:col-span-2">
                            <div class="flex items-center gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/60" x-data="{ requireDep: {{ setting('booking_require_deposit', '1') == '1' ? 'true' : 'false' }} }">
                                <input type="checkbox" name="booking_require_deposit" id="booking_require_deposit" value="1"
                                       x-model="requireDep"
                                       class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 transition">
                                <div>
                                    <label for="booking_require_deposit" class="block text-sm font-bold text-slate-800 cursor-pointer">Wajibkan Deposit Awal?</label>
                                    <p class="text-slate-500 text-xs">Jika aktif, pelanggan wajib membuat pembayaran deposit terlebih dahulu untuk mengesahkan tempahan.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Deposit Type & Value -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Pengiraan Deposit <span class="text-rose-500">*</span></label>
                            <select name="booking_deposit_type" 
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition bg-white">
                                <option value="percentage" {{ old('booking_deposit_type', setting('booking_deposit_type', 'percentage')) === 'percentage' ? 'selected' : '' }}>Peratusan (%)</option>
                                <option value="fixed" {{ old('booking_deposit_type', setting('booking_deposit_type', 'percentage')) === 'fixed' ? 'selected' : '' }}>Nilai Tetap (RM)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nilai / Kadar Deposit <span class="text-rose-500">*</span></label>
                            <input type="number" step="0.01" name="booking_deposit_value" value="{{ old('booking_deposit_value', setting('booking_deposit_value', 50)) }}" min="0"
                                   class="w-full px-4 py-3 rounded-xl border @error('booking_deposit_value') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            @error('booking_deposit_value')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Auto-cancel pending bookings after X hours -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Batal Auto Tempahan Menunggu (Jam) <span class="text-rose-500">*</span></label>
                            <input type="number" name="booking_auto_cancel_hours" value="{{ old('booking_auto_cancel_hours', setting('booking_auto_cancel_hours', 2)) }}" min="1"
                                   class="w-full px-4 py-3 rounded-xl border @error('booking_auto_cancel_hours') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            <p class="text-[10px] text-slate-400 mt-1">Tempahan bertaraf pending (Menunggu bayaran/pengesahan) akan dibatalkan secara automatik selepas tempoh jam ini.</p>
                            @error('booking_auto_cancel_hours')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <!-- Booking Confirmation Message -->
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mesej Pengesahan Tempahan <span class="text-rose-500">*</span></label>
                            <textarea name="booking_confirmation_message" rows="3" 
                                      class="w-full px-4 py-3 rounded-xl border @error('booking_confirmation_message') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">{{ old('booking_confirmation_message', setting('booking_confirmation_message', 'Terima kasih atas tempahan anda! Kami akan menghubungi anda sebentar lagi.')) }}</textarea>
                            <p class="text-[10px] text-slate-400 mt-1">Dipaparkan kepada pelanggan di laman web selepas berjaya menghantar tempahan.</p>
                            @error('booking_confirmation_message')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <!-- WhatsApp message template -->
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Templat Mesej WhatsApp untuk Tempahan Baru <span class="text-rose-500">*</span></label>
                            <textarea name="booking_whatsapp_template" rows="4" 
                                      class="w-full px-4 py-3 rounded-xl border @error('booking_whatsapp_template') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm font-mono transition">{{ old('booking_whatsapp_template', setting('booking_whatsapp_template', "Salam sejahtera {customer_name},\n\nTerima kasih kerana memilih NikaFleet!\nTempahan anda telah didaftarkan secara rawak dengan butiran berikut:\n\nKod Tempahan: {booking_code}\nKenderaan: {car_name}\nTarikh Sewa: {start_date} hingga {end_date}\n\nSila lakukan pembayaran deposit sebanyak {deposit_amount} ke akaun bank kami untuk mengesahkan sewaan. Terima kasih!")) }}</textarea>
                            <div class="bg-indigo-50/50 p-3 rounded-xl border border-indigo-100/60 mt-2">
                                <p class="text-[11px] text-indigo-900 font-semibold mb-1">Kod Pemboleh Ubah Dinamik Tersedia:</p>
                                <div class="flex flex-wrap gap-2 text-[10px] font-mono text-indigo-700">
                                    <span class="bg-white px-2 py-0.5 rounded border border-indigo-100">{customer_name}</span>
                                    <span class="bg-white px-2 py-0.5 rounded border border-indigo-100">{booking_code}</span>
                                    <span class="bg-white px-2 py-0.5 rounded border border-indigo-100">{car_name}</span>
                                    <span class="bg-white px-2 py-0.5 rounded border border-indigo-100">{start_date}</span>
                                    <span class="bg-white px-2 py-0.5 rounded border border-indigo-100">{end_date}</span>
                                    <span class="bg-white px-2 py-0.5 rounded border border-indigo-100">{deposit_amount}</span>
                                </div>
                            </div>
                            @error('booking_whatsapp_template')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl shadow-sm transition hover:scale-[1.01] active:scale-[0.99] text-sm">
                            Simpan Tetapan Tempahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- ═══════════════════════════════════════════════════
                 TAB 3: KEWANGAN
                 ═══════════════════════════════════════════════════ -->
            <div x-show="activeTab === 'kewangan'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1">
                <form action="{{ route('admin.settings.finance') }}" method="POST" x-data="{ taxApplicable: {{ setting('finance_tax_applicable', '0') == '1' ? 'true' : 'false' }} }">
                    @csrf
                    <div class="border-b border-slate-100 pb-5 mb-6">
                        <h2 class="text-xl font-bold text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Kewangan</h2>
                        <p class="text-slate-500 text-xs mt-1">Uruskan parameter kewangan, cukai SST/GST, denda lewat pemulangan, dan perbelanjaan overhead bulanan.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Currency Symbol -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Simbol Mata Wang <span class="text-rose-500">*</span></label>
                            <input type="text" name="currency" value="{{ old('currency', setting('currency', 'RM')) }}" 
                                   class="w-full px-4 py-3 rounded-xl border @error('currency') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            @error('currency')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Financial Year Month -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Bulan Mula Tahun Kewangan <span class="text-rose-500">*</span></label>
                            <select name="finance_fy_start_month" 
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition bg-white">
                                @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                    <option value="{{ $month }}" {{ old('finance_fy_start_month', setting('finance_fy_start_month', 'January')) === $month ? 'selected' : '' }}>{{ __($month) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Late Return Penalty per hour -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kadar Denda Lewat Pulang Per Jam (RM) <span class="text-rose-500">*</span></label>
                            <input type="number" step="0.01" name="finance_late_penalty_per_hour" value="{{ old('finance_late_penalty_per_hour', setting('finance_late_penalty_per_hour', 0)) }}" min="0"
                                   class="w-full px-4 py-3 rounded-xl border @error('finance_late_penalty_per_hour') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            @error('finance_late_penalty_per_hour')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Overhead monthly expenses -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Perbelanjaan Overhead Bulanan Tetap (RM) <span class="text-rose-500">*</span></label>
                            <input type="number" step="0.01" name="finance_overhead_expenses" value="{{ old('finance_overhead_expenses', setting('finance_overhead_expenses', 0)) }}" min="0"
                                   class="w-full px-4 py-3 rounded-xl border @error('finance_overhead_expenses') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            <p class="text-[10px] text-slate-400 mt-1">Sewa pejabat, utiliti asas, langganan sistem tetap bulanan untuk laporan Untung & Rugi bersih.</p>
                            @error('finance_overhead_expenses')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- GST/SST Toggle -->
                        <div class="md:col-span-2">
                            <div class="flex items-center gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/60">
                                <input type="checkbox" name="finance_tax_applicable" id="finance_tax_applicable" value="1"
                                       x-model="taxApplicable"
                                       class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 transition">
                                <div>
                                    <label for="finance_tax_applicable" class="block text-sm font-bold text-slate-800 cursor-pointer">Kenakan Cukai GST/SST?</label>
                                    <p class="text-slate-500 text-xs">Aktifkan pilihan ini untuk menambah kadar cukai SST/GST bagi setiap pembayaran pelanggan.</p>
                                </div>
                            </div>
                        </div>

                        <!-- GST/SST rate (shown only if toggle active) -->
                        <div class="md:col-span-2" x-show="taxApplicable" x-collapse x-cloak>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kadar Cukai SST/GST (%) <span class="text-rose-500">*</span></label>
                            <input type="number" step="0.01" name="finance_tax_rate" value="{{ old('finance_tax_rate', setting('finance_tax_rate', 6)) }}" min="0" max="100"
                                   class="w-full px-4 py-3 rounded-xl border @error('finance_tax_rate') border-rose-400 @else border-slate-200 @enderror focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            @error('finance_tax_rate')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl shadow-sm transition hover:scale-[1.01] active:scale-[0.99] text-sm">
                            Simpan Tetapan Kewangan
                        </button>
                    </div>
                </form>
            </div>

            <!-- ═══════════════════════════════════════════════════
                 TAB 4: PENGGUNA ADMIN
                 ═══════════════════════════════════════════════════ -->
            <div x-show="activeTab === 'admin-pengguna'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1">
                
                <!-- Admin User Table -->
                <div class="mb-10">
                    <div class="border-b border-slate-100 pb-4 mb-6 flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pengguna Admin</h2>
                            <p class="text-slate-500 text-xs mt-1">Senarai semua pengguna yang mempunyai akses portal pengurusan admin NikaFleet.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-2xl border border-slate-200/80 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50 font-semibold text-slate-700">
                                <tr>
                                    <th class="px-6 py-4 text-left tracking-wider">Nama Pentadbir</th>
                                    <th class="px-6 py-4 text-left tracking-wider">E-mel</th>
                                    <th class="px-6 py-4 text-left tracking-wider">Peranan</th>
                                    <th class="px-6 py-4 text-center tracking-wider">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-800 bg-white">
                                @foreach($admins as $admin)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 flex items-center gap-3">
                                        <img src="{{ $admin->avatar_url }}" alt="avatar" class="w-8 h-8 rounded-full object-cover">
                                        <span class="font-medium text-slate-900">{{ $admin->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $admin->email }}</td>
                                    <td class="px-6 py-4">
                                        @if($admin->isSuperAdmin())
                                            <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full">Super Admin</span>
                                        @else
                                            <span class="bg-slate-100 text-slate-700 border border-slate-200 text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full">Admin</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($currentUser->isSuperAdmin())
                                            @if($admin->id !== $currentUser->id && !$admin->isSuperAdmin())
                                                <form action="{{ route('admin.settings.admin.destroy', $admin->id) }}" method="POST" 
                                                      onsubmit="return confirm('Adakah anda pasti mahu memadam admin {{ $admin->name }}? Tindakan ini tidak boleh diundurkan.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold text-xs bg-rose-50 hover:bg-rose-100/80 px-3 py-1.5 rounded-lg transition border border-rose-200">
                                                        Padam
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-slate-400 text-xs font-semibold select-none italic">-</span>
                                            @endif
                                        @else
                                            <span class="text-slate-400 text-xs font-semibold select-none italic" title="Hanya super-admin sahaja">Tiada Hak</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-4 border-t border-slate-100">
                    
                    <!-- Add Admin (Visible to Super Admin only) -->
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftar Admin Baru</h3>
                        @if($currentUser->isSuperAdmin())
                            <p class="text-slate-500 text-xs mb-5">Hanya Super-Admin boleh mendaftar dan memberikan kelayakan akaun pentadbir baru.</p>
                            
                            <form action="{{ route('admin.settings.admin.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Penuh <span class="text-rose-500">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                                    @error('name')
                                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat E-mel <span class="text-rose-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                                    @error('email')
                                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Laluan <span class="text-rose-500">*</span></label>
                                    <input type="password" name="password" required
                                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                                    @error('password')
                                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Sahkan Kata Laluan <span class="text-rose-500">*</span></label>
                                    <input type="password" name="password_confirmation" required
                                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl transition shadow-sm hover:scale-[1.005] active:scale-[0.995] text-xs uppercase tracking-wider">
                                        Daftarkan Admin
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="bg-amber-50 border border-amber-200 p-5 rounded-2xl flex items-start gap-3">
                                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">Hak Akses Terhad</h4>
                                    <p class="text-slate-600 text-xs mt-1">Hanya pengguna bertaraf <strong>Super Admin</strong> sahaja dibenarkan mendaftarkan pengguna pentadbir baru atau memadam akaun sedia ada.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Change Own Password -->
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">Tukar Kata Laluan Anda</h3>
                        <p class="text-slate-500 text-xs mb-5">Tukar kata laluan keselamatan bagi akaun pentadbir aktif anda sekarang.</p>

                        <form action="{{ route('admin.settings.password') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Laluan Semasa <span class="text-rose-500">*</span></label>
                                <input type="password" name="current_password" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                                @error('current_password')
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Laluan Baru <span class="text-rose-500">*</span></label>
                                <input type="password" name="new_password" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                                @error('new_password')
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Sahkan Kata Laluan Baru <span class="text-rose-500">*</span></label>
                                <input type="password" name="new_password_confirmation" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-slate-800 text-sm transition">
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 rounded-xl transition shadow-sm hover:scale-[1.005] active:scale-[0.995] text-xs uppercase tracking-wider">
                                    Kemaskini Kata Laluan
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════
                 TAB 5: DATA & BACKUP
                 ═══════════════════════════════════════════════════ -->
            <div x-show="activeTab === 'data-backup'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1">
                <div class="border-b border-slate-100 pb-5 mb-6">
                    <h2 class="text-xl font-bold text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Data & Backup</h2>
                    <p class="text-slate-500 text-xs mt-1">Eksport laporan penting syarikat, sandarkan seluruh data pangkalan data SQL, atau tetapkan semula data kepada demo asal.</p>
                </div>

                <div class="space-y-6">
                    
                    <!-- Excel Export Card -->
                    <div class="p-6 rounded-2xl border border-slate-200/80 bg-white flex flex-col md:flex-row justify-between items-start md:items-center gap-6 shadow-sm hover:shadow-md transition duration-200">
                        <div class="max-w-xl">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Eksport Semua Data Perniagaan</h3>
                            </div>
                            <p class="text-slate-500 text-xs">Jana dan muat turun fail Excel multi-sheet lengkap mengandungi data kereta (fleet), rekod tempahan sewa, aliran pendapatan, dan kategori perbelanjaan.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.settings.export.excel') }}" class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-3 rounded-xl transition text-xs shadow-sm hover:scale-[1.01] active:scale-[0.99]">
                                Muat Turun fail Excel
                            </a>
                        </div>
                    </div>

                    <!-- Database Backup SQL -->
                    <div class="p-6 rounded-2xl border border-slate-200/80 bg-white flex flex-col md:flex-row justify-between items-start md:items-center gap-6 shadow-sm hover:shadow-md transition duration-200">
                        <div class="max-w-xl">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Sandarkan Database (Backup SQL)</h3>
                            </div>
                            <p class="text-slate-500 text-xs">Muat turun seluruh pangkalan data dalam satu fail skrip SQL (termasuk skema CREATE TABLE dan rekod data INSERT) untuk tujuan kecemasan atau migrasi pelayan.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.settings.export.backup') }}" class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-3 rounded-xl transition text-xs shadow-sm hover:scale-[1.01] active:scale-[0.99]">
                                Fail Sandaran SQL (.sql)
                            </a>
                        </div>
                    </div>

                    <!-- Reset Demo Data (App env = local only) -->
                    @if(config('app.env') === 'local')
                    <div class="p-6 rounded-2xl border border-rose-100 bg-rose-50/20 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 shadow-sm">
                        <div class="max-w-xl">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-rose-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Set Semula Data Demo (Tempatan Sahaja)</h3>
                            </div>
                            <p class="text-slate-600 text-xs">Memadam semua rekod tempahan baru, data kewangan, serta kereta anda saat ini, lalu menyemai semula pangkalan data menggunakan data seeder laluan. <strong>Tindakan ini memadam semua data kekal!</strong></p>
                        </div>
                        <div>
                            <form action="{{ route('admin.settings.reset') }}" method="POST" 
                                  onsubmit="return confirm('AMARAN: Anda pasti mahu memadam seluruh database dan menyemai semula data demo asal? Semua tempahan dan pengubahsuaian anda akan hilang kekal.')">
                                @csrf
                                <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-rose-600 hover:bg-rose-700 text-white font-semibold px-5 py-3 rounded-xl transition text-xs shadow-sm hover:scale-[1.01] active:scale-[0.99]">
                                    Set Semula Data
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

        </div>

    </div>

</div>
@endsection
