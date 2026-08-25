@extends('layouts.user')

@section('title', 'Hubungi Kami — NikaFleet')
@section('meta_description', 'Hubungi NikaFleet untuk pertanyaan sewa kereta. WhatsApp: +60 11-6824 7599. Lokasi: Rawang, Selangor.')

@section('content')

<div class="py-14 lg:py-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <!-- Page Header (DM Serif Display) -->
        <div class="flex flex-col items-center text-center mb-16">
            <h1 class="font-display text-4xl sm:text-5xl text-[#0D1117] font-normal">
                Hubungi Kami 💬
            </h1>
            <div class="divider-accent mt-4"></div>
            <p class="text-[#6B7280] text-sm sm:text-base mt-4 max-w-lg">
                Ada sebarang pertanyaan atau ingin menyewa bagi jangka masa panjang? Kami sedia melayani anda.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- ═══ LEFT: Contact Info + Map (5/12 cols) ═══ -->
            <div class="lg:col-span-5 space-y-6">

                <!-- Contact Channels Card -->
                <div class="card-light p-6 sm:p-8 space-y-4">
                    <h2 class="font-sans font-bold text-[#0D1117] text-sm uppercase tracking-wider mb-6">Saluran Hubungan</h2>

                    <!-- Phone (Uses Mono) -->
                    <a href="tel:+601168247599"
                       class="flex items-center gap-4 p-4 bg-[#F4F6F9] rounded-sm border border-[#E2E7EE] hover:border-[#2A5FD4] transition-colors group">
                        <div class="w-12 h-12 bg-[#2A5FD4] rounded-sm flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform shadow-sm">
                            <span class="text-[#FFFFFF] text-xl">📲</span>
                        </div>
                        <div>
                            <p class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold">Talian Telefon</p>
                            <p class="font-mono-data text-sm font-bold text-[#2A5FD4]">+60 11-6824 7599</p>
                        </div>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/601168247599?text=Salam%20NikaFleet%21%20Saya%20berminat%20sewa%20kereta.%20Boleh%20saya%20tanya%20detail%3F"
                       target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-4 p-4 bg-[#F4F6F9] rounded-sm border border-[#E2E7EE] hover:border-[#16A34A] transition-colors group">
                        <div class="w-12 h-12 bg-[#16A34A] rounded-sm flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform shadow-sm">
                            <span class="text-[#FFFFFF] text-xl">💬</span>
                        </div>
                        <div>
                            <p class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold">Sembang WhatsApp</p>
                            <p class="font-sans text-sm font-bold text-[#16A34A] uppercase tracking-wide">Mula Sembang Pantas</p>
                        </div>
                    </a>

                    <!-- TikTok -->
                    <a href="https://www.tiktok.com/@nika.fleet"
                       target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-4 p-4 bg-[#0F1117] rounded-sm border border-[#2E3A4E] hover:border-[#C5A94B] transition-colors group">
                        <div class="w-12 h-12 bg-[#252D3D] rounded-sm flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                            <span class="text-[#FFFFFF] text-xl">🎵</span>
                        </div>
                        <div>
                            <p class="text-[10px] text-[#A8B3C4] uppercase tracking-wider font-semibold">Saluran TikTok</p>
                            <p class="font-sans text-sm font-bold text-[#C5A94B]">@nika.fleet</p>
                        </div>
                    </a>

                    <!-- Location info -->
                    <div class="flex items-center gap-4 p-4 bg-[#F4F6F9] rounded-sm border border-[#E2E7EE]">
                        <div class="w-12 h-12 bg-[#D97706] rounded-sm flex items-center justify-center flex-shrink-0 shadow-sm">
                            <span class="text-[#FFFFFF] text-xl">📍</span>
                        </div>
                        <div>
                            <p class="text-[10px] text-[#6B7280] uppercase tracking-wider font-semibold">Kawasan Operasi</p>
                            <p class="font-sans text-sm font-bold text-[#374151] uppercase tracking-wide">Rawang, Selangor</p>
                        </div>
                    </div>
                </div>

                <!-- Google Maps Card -->
                <div class="card-light overflow-hidden">
                    <div class="p-4 border-b border-[#E2E7EE] bg-[#F4F6F9]">
                        <h3 class="font-sans font-bold text-xs text-[#0D1117] uppercase tracking-wider">Peta Lokasi Rawang</h3>
                    </div>
                    <div class="h-56">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63756.52745700261!2d101.54929545!3d3.31792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4d30b44c5151%3A0x8f2a5a3c7a2df3e0!2sRawang%2C%20Selangor!5e0!3m2!1sen!2smy!4v1717500000000!5m2!1sen!2smy"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

            </div>

            <!-- ═══ RIGHT: Contact Form (7/12 cols) ═══ -->
            <div class="lg:col-span-7">
                <div class="card-light p-6 sm:p-8 space-y-6">
                    <div>
                        <h2 class="font-sans font-bold text-lg text-[#0D1117] uppercase tracking-wide">Hantar Mesej</h2>
                        <p class="text-[#6B7280] text-xs mt-1">Kami akan maklum balas carian atau pertanyaan anda dalam masa singkat.</p>
                    </div>

                    @if(session('success'))
                        <div class="bg-[#DCFCE7] border border-[#BBF7D0] text-[#15803D] rounded-sm p-4 text-xs font-semibold uppercase tracking-wider flex items-center gap-2">
                            <span>✅</span>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-[#FEE2E2] border border-[#FECACA] rounded-sm p-4">
                            <ul class="text-red-700 text-xs space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="form-label-public" for="name">Nama Penuh *</label>
                                <input id="name" name="name" type="text" required
                                       value="{{ old('name') }}"
                                       placeholder="Masukkan nama penuh anda..."
                                       class="form-input-public">
                            </div>
                            <div class="space-y-1.5">
                                <label class="form-label-public" for="phone">No. Telefon WhatsApp *</label>
                                <input id="phone" name="phone" type="tel" required
                                       value="{{ old('phone') }}"
                                       placeholder="Contoh: 011-XXXX XXXX"
                                       class="form-input-public">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="form-label-public" for="message">Mesej Anda *</label>
                            <textarea id="message" name="message" rows="6" required
                                      placeholder="Tulis mesej atau pertanyaan anda di sini..."
                                      class="form-input-public resize-none">{{ old('message') }}</textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-2">
                            <button type="submit" class="btn-primary flex-1 text-xs py-4">
                                Hantar Mesej
                            </button>
                            <a href="https://wa.me/601168247599?text=Salam%20NikaFleet%21%20Saya%20berminat%20sewa%20kereta.%20Boleh%20saya%20tanya%20detail%3F"
                               target="_blank" rel="noopener noreferrer"
                               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#16A34A] hover:bg-[#14532D] text-[#FFFFFF] font-bold text-xs uppercase tracking-wider px-8 py-4 rounded-sm transition-all duration-200">
                                WhatsApp Terus
                            </a>
                        </div>

                        <p class="text-[10px] text-[#6B7280] text-center font-sans">
                            * Anda juga boleh terus menghubungi talian hotline kami di <a href="tel:+601168247599" class="text-[#2A5FD4] font-bold font-mono-data">+60 11-6824 7599</a>
                        </p>
                    </form>
                </div>
            </div>

        </div><!-- end grid -->
    </div>
</div>

@endsection
