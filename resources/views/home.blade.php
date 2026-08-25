<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NikaFleet - Clean, safe, and affordable vehicle rentals. Simple booking process via WhatsApp.">
    <title>NikaFleet — Premium Car Rental Services</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@300;400;500;600;700&family=Inter+Tight:wght@500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#bda04e',
                        'gold-dark': '#a08a3a',
                        'gold-light': '#e8d9b0',
                        'gold-wash': '#fdf8ef',
                        charcoal: '#4b4b4b',
                        'charcoal-light': '#6b6b6b',
                        'charcoal-muted': '#9b9b9b',
                        'charcoal-wash': '#f7f7f5',
                        hairline: '#e8e4dc',
                    },
                    fontFamily: {
                        display: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        tight: ['"Inter Tight"', 'Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        :root {
            --text-xs: 0.6875rem;
            --text-sm: 0.8125rem;
            --text-base: 1rem;
            --text-md: 1.125rem;
            --text-lg: 1.375rem;
            --text-xl: 1.75rem;
            --text-2xl: 2.5rem;
            --text-3xl: 3.5rem;
            --text-hero: clamp(4rem, 8vw, 7rem);

            --color-white: #ffffff;
            --color-gold: #bda04e;
            --color-gold-dark: #a08a3a;
            --color-gold-muted: #e8d9b0;
            --color-gold-wash: #fdf8ef;
            --color-charcoal: #4b4b4b;
            --color-charcoal-light: #6b6b6b;
            --color-charcoal-muted: #9b9b9b;
            --color-charcoal-wash: #f7f7f5;
            --color-hairline: #e8e4dc;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--color-charcoal);
            background: var(--color-white);
            margin: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Eyebrow label */
        .eyebrow {
            font-family: 'Inter Tight', 'Inter', system-ui, sans-serif;
            font-weight: 600;
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--color-gold);
            margin-bottom: 0.75rem;
            display: block;
        }

        /* Primary button */
        .btn-primary {
            background: var(--color-gold);
            color: var(--color-white);
            font-family: 'Inter Tight', 'Inter', system-ui, sans-serif;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 14px 32px;
            border-radius: 2px;
            border: none;
            cursor: pointer;
            transition: background 200ms ease, transform 150ms ease;
            display: inline-block;
            text-decoration: none;
            text-align: center;
            line-height: 1;
        }
        .btn-primary:hover { background: var(--color-gold-dark); transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary:focus-visible { outline: 2px solid var(--color-gold); outline-offset: 3px; }

        /* Ghost / Secondary button */
        .btn-ghost {
            background: transparent;
            color: var(--color-charcoal);
            border: 1.5px solid var(--color-charcoal);
            font-family: 'Inter Tight', 'Inter', system-ui, sans-serif;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 13px 32px;
            border-radius: 2px;
            cursor: pointer;
            transition: all 200ms ease;
            display: inline-block;
            text-decoration: none;
            text-align: center;
            line-height: 1;
        }
        .btn-ghost:hover { border-color: var(--color-gold); color: var(--color-gold); }

        /* Gold outline button */
        .btn-gold-outline {
            background: transparent;
            color: var(--color-gold);
            border: 1.5px solid var(--color-gold);
            font-family: 'Inter Tight', 'Inter', system-ui, sans-serif;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 13px 32px;
            border-radius: 2px;
            cursor: pointer;
            transition: all 200ms ease;
            display: inline-block;
            text-decoration: none;
            text-align: center;
            line-height: 1;
        }
        .btn-gold-outline:hover { background: var(--color-gold); color: var(--color-white); }

        /* Card base */
        .nf-card {
            background: var(--color-white);
            border: 1px solid var(--color-hairline);
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(75,75,75,0.06);
            transition: all 280ms ease;
            overflow: hidden;
        }
        .nf-card:hover {
            box-shadow: 0 8px 28px rgba(75,75,75,0.12);
            transform: translateY(-3px);
        }

        /* Gold accent rule */
        .gold-rule {
            height: 2px;
            background: var(--color-gold);
            width: 48px;
            margin-bottom: 1rem;
        }

        /* Section container */
        .section-container {
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 2rem;
            padding-right: 2rem;
        }

        /* Section padding */
        .section-pad {
            padding-top: 6rem;
            padding-bottom: 6rem;
        }

        /* Hero text size */
        .hero-headline {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-size: clamp(4rem, 8vw, 7rem);
            line-height: 0.95;
            color: var(--color-charcoal);
            font-weight: 500;
            letter-spacing: -0.02em;
        }

        /* Hamburger lines */
        .hamburger-line {
            display: block;
            width: 20px;
            height: 1.5px;
            background: var(--color-charcoal);
            transition: all 200ms ease;
        }

        /* Modal scrollbar */
        .modal-body::-webkit-scrollbar { width: 4px; }
        .modal-body::-webkit-scrollbar-track { background: transparent; }
        .modal-body::-webkit-scrollbar-thumb { background: var(--color-gold-muted); border-radius: 2px; }

        /* Timeline connector */
        .timeline-connector {
            border-top: 2px dotted var(--color-gold-muted);
            flex: 1;
            margin-top: 24px;
        }

        /* Car card image hover */
        .car-card-img-wrap img {
            transition: transform 400ms ease;
        }
        .nf-card:hover .car-card-img-wrap img {
            transform: scale(1.03);
        }

        /* Fade in animation */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeInUp 0.7s ease forwards;
        }

        /* Input focus ring */
        .nf-input:focus {
            border-color: var(--color-gold) !important;
            outline: none;
            box-shadow: 0 0 0 3px rgba(189,160,78,0.12);
        }

        .nf-input.error {
            border-color: #c0392b !important;
        }

        /* ─── MOBILE RESPONSIVENESS ─── */

        /* Prevent horizontal scroll globally */
        html, body {
          overflow-x: hidden;
          -webkit-overflow-scrolling: touch;
        }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }

        /* Images never overflow */
        img, svg { max-width: 100%; }

        /* ─── NAVBAR MOBILE ─── */
        @media (max-width: 767px) {
          .navbar-desktop-links { display: none !important; }
          .navbar-desktop-phone { display: none !important; }
          .navbar-hamburger { display: flex !important; }
          .navbar-rent-btn  { display: none !important; }
        }
        @media (min-width: 768px) {
          .navbar-hamburger { display: none !important; }
        }

        /* ─── HERO TWO-COLUMN SPLIT — MOBILE ─── */

        /* Default (desktop): two equal columns, full viewport height */
        .hero-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          min-height: calc(100vh - 72px);
        }

        /* Mobile: single column, text top, car bottom */
        @media (max-width: 767px) {
          .hero-grid {
            grid-template-columns: 1fr !important;
            min-height: unset !important;
          }

          .hero-left {
            order: 1;
            padding: 3rem 1.5rem 2rem !important;
            text-align: center !important;
            align-items: center !important;
          }

          .hero-left .hero-body {
            margin-left: auto !important;
            margin-right: auto !important;
          }

          .hero-left .hero-buttons {
            justify-content: center !important;
          }

          .hero-left .hero-trust-bar {
            justify-content: center !important;
            flex-wrap: wrap !important;
            gap: 0.75rem !important;
          }

          .hero-trust-divider {
            display: none !important;
          }

          .hero-right {
            order: 2;
            border-left: none !important;
            border-top: 1px solid #f0ebe0 !important;
            min-height: 320px !important;
            padding: 2rem 1rem !important;
          }

          .hero-title {
            font-size: clamp(2.5rem, 9vw, 3.75rem) !important;
          }

          .blueprint-wrap {
            min-height: 300px !important;
          }

          .blueprint-wrap > svg {
            max-width: 100% !important;
          }
        }

        /* Tablet */
        @media (min-width: 768px) and (max-width: 1199px) {
          .hero-left {
            padding: 4rem 2.5rem 4rem 3rem !important;
          }

          .hero-title {
            font-size: clamp(2.75rem, 4.5vw, 4rem) !important;
          }
        }

        /* Ensure the right column fills its grid cell vertically */
        .hero-right {
          height: 100%;
        }

        /* Blueprint wrap fills the right column */
        .blueprint-wrap {
          width: 100%;
          height: 100%;
          min-height: 400px;
        }

        /* ─── STATS BAR MOBILE ─── */
        @media (max-width: 767px) {
          .stats-grid {
            grid-template-columns: 1fr 1fr !important;
            gap: 0 !important;
          }
          .stats-divider-v { display: none !important; }
          .stat-item {
            padding: 1.25rem !important;
            border-bottom: 1px solid #e8d9b0 !important;
          }
          .stat-item:nth-child(odd) {
            border-right: 1px solid #e8d9b0 !important;
          }
        }

        /* ─── FLEET SECTION MOBILE ─── */
        @media (max-width: 1023px) {
          .fleet-grid {
            grid-template-columns: repeat(2, 1fr) !important;
          }
        }
        @media (max-width: 639px) {
          .fleet-grid {
            grid-template-columns: 1fr !important;
          }
          .fleet-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 0.5rem !important;
          }
        }

        /* ─── HOW TO RENT MOBILE ─── */
        @media (max-width: 767px) {
          .steps-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
          }
          .steps-connector { display: none !important; }
          .step-item { text-align: left !important; }
        }

        /* ─── TIKTOK SECTION MOBILE ─── */
        @media (max-width: 767px) {
          .tiktok-grid {
            grid-template-columns: 1fr !important;
          }
        }

        /* ─── WHY SECTION MOBILE ─── */
        @media (max-width: 1023px) {
          .why-grid {
            grid-template-columns: repeat(2, 1fr) !important;
          }
        }
        @media (max-width: 639px) {
          .why-grid {
            grid-template-columns: 1fr !important;
          }
        }

        /* ─── CTA BAND MOBILE ─── */
        @media (max-width: 767px) {
          .cta-band-inner {
            flex-direction: column !important;
            text-align: center !important;
            gap: 2rem !important;
          }
          .cta-band-buttons {
            align-items: center !important;
          }
          .cta-band-heading {
            font-size: clamp(1.75rem, 6vw, 2.25rem) !important;
          }
        }

        /* ─── FOOTER MOBILE ─── */
        @media (max-width: 1023px) {
          .footer-top-grid {
            grid-template-columns: 1fr 1fr !important;
            gap: 2rem !important;
          }
        }
        @media (max-width: 639px) {
          .footer-top-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
          }
          .footer-bottom-inner {
            flex-direction: column !important;
            text-align: center !important;
            gap: 0.5rem !important;
          }
        }

        /* ─── BOOKING MODAL (CENTERED) ─── */
        .booking-modal-overlay {
          position: fixed;
          inset: 0;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          width: 100vw;
          height: 100vh;
          background: rgba(15, 23, 42, 0.7);
          backdrop-filter: blur(6px);
          -webkit-backdrop-filter: blur(6px);
          z-index: 9999;
          display: flex;
          align-items: center;
          justify-content: center;
          padding: 1.5rem;
          overflow-y: auto;
          box-sizing: border-box;
        }
        .booking-modal-panel {
          margin: auto;
          width: 100%;
          max-width: 540px;
          background: #ffffff;
          border-radius: 6px;
          box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.45);
          position: relative;
          max-height: 90vh;
          overflow-y: auto;
          box-sizing: border-box;
        }
        @media (max-width: 639px) {
          .booking-modal-panel {
            border-radius: 12px 12px 0 0;
            max-height: 92vh;
            height: auto;
            max-width: 100%;
            margin-bottom: 0;
          }
          .booking-modal-overlay {
            padding: 0;
            align-items: flex-end;
          }
          /* Date/time grid stacks to 1 column on small phones */
          .datetime-grid {
            grid-template-columns: 1fr;
          }
        }

        /* ─── GENERAL SECTION PADDING MOBILE ─── */
        @media (max-width: 767px) {
          .section-pad {
            padding-top: 3.5rem !important;
            padding-bottom: 3.5rem !important;
          }
          .section-container {
            padding-left: 1.25rem !important;
            padding-right: 1.25rem !important;
          }
        }

        /* ─── TAP TARGETS — min 44px for all interactive elements ─── */
        @media (max-width: 767px) {
          button, a, input[type="submit"], input[type="button"] {
            min-height: 44px;
          }
        }

    </style>
</head>

<body x-data="{
    mobileNav: false,
    bookingModal: false,
    selectedCar: null,
    bookingForm: {
        name: '',
        phone: '',
        startDate: '',
        startTime: '',
        endDate: '',
        endTime: '',
        location: WA_LOCATIONS.length > 0 ? WA_LOCATIONS[0] : '',
        notes: ''
    },
    get totalDays() {
        if (!this.bookingForm.startDate || !this.bookingForm.endDate) return 0;
        const d1 = new Date(this.bookingForm.startDate);
        const d2 = new Date(this.bookingForm.endDate);
        const diff = (d2 - d1) / (1000 * 60 * 60 * 24);
        return diff > 0 ? Math.ceil(diff) : 0;
    },
    get totalPrice() {
        if (!this.selectedCar) return 0;
        return this.totalDays * this.selectedCar.price;
    },
    openBooking(car) {
        this.selectedCar = car;
        this.bookingForm = {
            name: '',
            phone: '',
            startDate: '',
            startTime: WA_TIMESLOTS.length > 0 ? WA_TIMESLOTS[0].value : '',
            endDate: '',
            endTime: WA_TIMESLOTS.length > 0 ? WA_TIMESLOTS[0].value : '',
            location: WA_LOCATIONS.length > 0 ? WA_LOCATIONS[0] : '',
            notes: ''
        };
        this.bookingModal = true;
        document.body.style.overflow = 'hidden';
    },
    closeBooking() {
        this.bookingModal = false;
        document.body.style.overflow = '';
    },
    formatDate(dateStr) {
        if (!dateStr) return '';
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const d = new Date(dateStr);
        return d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
    },
    formatTime(timeStr) {
        if (!timeStr) return 'Not specified';
        // Try to match a label from WA_TIMESLOTS first
        const slot = WA_TIMESLOTS.find(s => s.value === timeStr);
        if (slot) return slot.label;
        const [h, m] = timeStr.split(':');
        const hour = parseInt(h);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        return (hour % 12 || 12) + ':' + m + ' ' + ampm;
    },
    sendWhatsApp() {
        const f = this.bookingForm;
        if (!f.name || !f.phone || !f.startDate || !f.startTime || !f.endDate || !f.endTime) {
            alert('Please fill in all required fields before submitting.');
            return;
        }
        const msg = this.buildMessage();
        window.open('https://wa.me/601168247599?text=' + encodeURIComponent(msg), '_blank');
        this.closeBooking();
    },
    buildMessage() {
        const f = this.bookingForm;
        const car = this.selectedCar;
        const days = this.totalDays;
        const estimatedPrice = (days * car.price).toLocaleString('en-MY', {minimumFractionDigits: 0, maximumFractionDigits: 0});
        const durationStr = days + (days === 1 ? ' day' : ' days');

        let msg = WA_TEMPLATE;
        msg = msg.replaceAll('{customer_name}',   f.name);
        msg = msg.replaceAll('{customer_phone}',  f.phone);
        msg = msg.replaceAll('{vehicle_name}',    car.name);
        msg = msg.replaceAll('{price_per_day}',   car.price.toString());
        msg = msg.replaceAll('{pickup_date}',     this.formatDate(f.startDate));
        msg = msg.replaceAll('{pickup_time}',     this.formatTime(f.startTime));
        msg = msg.replaceAll('{return_date}',     this.formatDate(f.endDate));
        msg = msg.replaceAll('{return_time}',     this.formatTime(f.endTime));
        msg = msg.replaceAll('{duration}',        durationStr);
        msg = msg.replaceAll('{location}',        f.location);
        msg = msg.replaceAll('{estimated_price}', estimatedPrice);
        if (f.notes) msg += '\nAdditional Notes: ' + f.notes;
        return msg;
    }
}" @keydown.escape.window="closeBooking()">

    {{-- Fleet data for Alpine --}}
    <script>
        const FLEET_DATA     = @json($sampleCars);
        const WA_TEMPLATE    = @json($whatsappTemplate);
        const WA_LOCATIONS   = @json($locations->pluck('name'));
        const WA_TIMESLOTS   = @json($timeSlots->map(fn($s) => ['label' => $s->label, 'value' => $s->time_value]));
    </script>

    {{-- ============================================================ --}}
    {{-- NAVBAR --}}
    {{-- ============================================================ --}}
    <nav class="sticky top-0 z-[100] bg-white border-b border-hairline" style="backdrop-filter: blur(12px); background: rgba(255,255,255,0.97);">
        <div class="section-container">
            <div class="flex items-center justify-between" style="height: 72px;">
                {{-- Left: Wordmark only (logo removed) --}}
                <a href="/" style="text-decoration: none; display: flex; align-items: center;">
                    <span style="
                        font-family: 'Inter Tight', Inter, system-ui, sans-serif;
                        font-weight: 700;
                        font-size: 1.0625rem;
                        letter-spacing: 0.2em;
                        text-transform: uppercase;
                        color: #4b4b4b;
                        line-height: 1;
                    ">NIKAFLEET</span>
                </a>

                {{-- Center: Nav links (desktop) --}}
                <div class="navbar-desktop-links hidden md:flex items-center gap-8">
                    <a href="#fleet" class="font-sans text-charcoal-light hover:text-gold transition-colors duration-200 no-underline" style="font-size: 13px; font-weight: 500;">Our Fleet</a>
                    <a href="#cara-sewa" class="font-sans text-charcoal-light hover:text-gold transition-colors duration-200 no-underline" style="font-size: 13px; font-weight: 500;">How to Rent</a>
                    <a href="#hubungi" class="font-sans text-charcoal-light hover:text-gold transition-colors duration-200 no-underline" style="font-size: 13px; font-weight: 500;">Contact Us</a>
                </div>

                {{-- Right: CTA + Phone (desktop) --}}
                <div class="hidden md:flex items-center gap-5">
                    <span class="navbar-desktop-phone font-tight text-charcoal-muted" style="font-size: 12px;">+60 11-6824 7599</span>
                    <a href="https://wa.me/601168247599?text=Hi%20NikaFleet!%20I%20would%20like%20to%20enquire%20about%20car%20rental." target="_blank" rel="noopener" class="navbar-rent-btn btn-primary" style="padding: 10px 24px; font-size: 12px;">Rent Now</a>
                </div>

                {{-- Mobile: Hamburger --}}
                <button @click="mobileNav = !mobileNav" class="navbar-hamburger md:hidden flex flex-col justify-center items-center bg-transparent border-none cursor-pointer p-2" style="gap: 5px;" aria-label="Menu">
                    <span class="hamburger-line" :class="mobileNav && 'translate-y-[6.5px] rotate-45'" style="transition: all 300ms ease;"></span>
                    <span class="hamburger-line" :class="mobileNav && 'opacity-0'" style="transition: all 200ms ease;"></span>
                    <span class="hamburger-line" :class="mobileNav && '-translate-y-[6.5px] -rotate-45'" style="transition: all 300ms ease;"></span>
                </button>
            </div>
        </div>

        {{-- Mobile Drawer --}}
        <div x-show="mobileNav" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden bg-white border-b border-hairline" x-cloak>
            <div class="section-container py-4 flex flex-col gap-3">
                <a href="#fleet" @click="mobileNav = false" class="font-sans text-charcoal-light py-2 no-underline" style="font-size: 14px; font-weight: 500;">Our Fleet</a>
                <a href="#cara-sewa" @click="mobileNav = false" class="font-sans text-charcoal-light py-2 no-underline" style="font-size: 14px; font-weight: 500;">How to Rent</a>
                <a href="#hubungi" @click="mobileNav = false" class="font-sans text-charcoal-light py-2 no-underline" style="font-size: 14px; font-weight: 500;">Contact Us</a>
                <div class="pt-2 border-t border-hairline">
                    <a href="https://wa.me/601168247599?text=Hi%20NikaFleet!%20I%20would%20like%20to%20enquire%20about%20car%20rental." target="_blank" rel="noopener" class="btn-primary block w-full text-center" style="padding: 14px 24px;">Rent Now</a>
                </div>
            </div>
        </div>

        {{-- Mobile Overlay --}}
        <div x-show="mobileNav" @click="mobileNav = false" class="md:hidden fixed inset-0 z-[-1]" style="background: rgba(0,0,0,0.4);" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak></div>
    </nav>

    {{-- ============================================================ --}}
    {{-- HERO SECTION --}}
    {{-- ============================================================ --}}

    <!-- ═══ HERO SECTION ═══ -->
    <section style="
      background-color: #ffffff;
      position: relative;
      overflow: hidden;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    ">

      <!-- Gold horizontal rule — decorative line across full width at 68% height -->
      <div style="
        position: absolute;
        top: 68%;
        left: 0;
        right: 0;
        height: 1px;
        background-color: #e8d9b0;
        pointer-events: none;
        z-index: 0;
      "></div>

      <!-- Two-column grid — fills remaining viewport height after navbar (72px) -->
      <div style="
        display: grid;
        grid-template-columns: 1fr 1fr;
        flex: 1;
        min-height: calc(100vh - 72px);
        position: relative;
        z-index: 1;
        max-width: 100%;
      " class="hero-grid">

        <!-- ═══ LEFT COLUMN ═══ -->
        <div style="
          display: flex;
          flex-direction: column;
          justify-content: center;
          padding: 5rem 4rem 5rem 6rem;
          position: relative;
        " class="hero-left">

          <!-- HEADLINE -->
          <h1 style="
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-weight: 500;
            font-size: clamp(3rem, 5.5vw, 5.5rem);
            line-height: 1.0;
            color: #4b4b4b;
            letter-spacing: -0.02em;
            margin: 0 0 1.75rem 0;
            padding: 0;
          " class="hero-title">
            Comfortable<br>
            Cars,<br>
            <em style="color: #bda04e; font-style: italic;">Worry-Free</em><br>
            Journeys.
          </h1>

          <p style="
            font-family: Inter, system-ui, sans-serif;
            font-weight: 300;
            font-size: 1.0625rem;
            color: #6b6b6b;
            line-height: 1.75;
            margin: 0 0 2.5rem 0;
            max-width: 380px;
          " class="hero-body">
            Looking to rent a car? NikaFleet offers a well-maintained
            fleet of clean, safe, and affordable vehicles. Simple process,
            fast response.
          </p>

          <!-- Buttons -->
          <div style="
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 3.5rem;
          " class="hero-buttons">
            <a href="#fleet" style="
              display: inline-flex;
              align-items: center;
              justify-content: center;
              background-color: #bda04e;
              color: #ffffff;
              font-family: 'Inter Tight', Inter, sans-serif;
              font-weight: 600;
              font-size: 0.8125rem;
              letter-spacing: 0.1em;
              text-transform: uppercase;
              text-decoration: none;
              padding: 14px 32px;
              border-radius: 2px;
              border: none;
              cursor: pointer;
              transition: background-color 200ms ease, transform 150ms ease;
              white-space: nowrap;
            "
            onmouseover="this.style.backgroundColor='#a08a3a'; this.style.transform='translateY(-1px)'"
            onmouseout="this.style.backgroundColor='#bda04e'; this.style.transform='translateY(0)'"
            >Rent a Car Now</a>

            <a href="#fleet" style="
              display: inline-flex;
              align-items: center;
              justify-content: center;
              background-color: transparent;
              color: #4b4b4b;
              font-family: 'Inter Tight', Inter, sans-serif;
              font-weight: 600;
              font-size: 0.8125rem;
              letter-spacing: 0.1em;
              text-transform: uppercase;
              text-decoration: none;
              padding: 13px 32px;
              border-radius: 2px;
              border: 1.5px solid #4b4b4b;
              cursor: pointer;
              transition: border-color 200ms ease, color 200ms ease;
              white-space: nowrap;
            "
            onmouseover="this.style.borderColor='#bda04e'; this.style.color='#bda04e'"
            onmouseout="this.style.borderColor='#4b4b4b'; this.style.color='#4b4b4b'"
            >View Our Fleet</a>
          </div>

          <!-- Trust bar -->
          <div style="
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 0;
            padding-top: 1.75rem;
            border-top: 1px solid #e8e4dc;
          " class="hero-trust-bar">

            <span style="
              font-family: 'Inter Tight', Inter, sans-serif;
              font-weight: 500;
              font-size: 0.6875rem;
              letter-spacing: 0.14em;
              text-transform: uppercase;
              color: #9b9b9b;
              padding-right: 1.25rem;
            ">Est. Nov 2025</span>

            <span class="hero-trust-divider" style="
              display: inline-block;
              width: 1px;
              height: 12px;
              background-color: #d0ccc4;
              margin-right: 1.25rem;
              flex-shrink: 0;
            "></span>

            <span style="
              font-family: 'Inter Tight', Inter, sans-serif;
              font-weight: 500;
              font-size: 0.6875rem;
              letter-spacing: 0.14em;
              text-transform: uppercase;
              color: #9b9b9b;
              padding-right: 1.25rem;
            ">Self-Drive Rental</span>

            <span class="hero-trust-divider" style="
              display: inline-block;
              width: 1px;
              height: 12px;
              background-color: #d0ccc4;
              margin-right: 1.25rem;
              flex-shrink: 0;
            "></span>

            <span style="
              font-family: 'Inter Tight', Inter, sans-serif;
              font-weight: 500;
              font-size: 0.6875rem;
              letter-spacing: 0.14em;
              text-transform: uppercase;
              color: #9b9b9b;
            ">@nika.fleet</span>

          </div>

        </div>
        <!-- end hero-left -->

        <!-- ═══ RIGHT COLUMN ═══ -->
        <div style="
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          position: relative;
          background-color: #ffffff;
          border-left: 1px solid #ffffff;
          overflow: hidden;
          min-height: 400px;
        " class="hero-right">

          <!-- Blueprint car container -->
          <div class="blueprint-wrap" style="
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            box-sizing: border-box;
          ">

            <!-- Faint transparent logo watermark — behind the car -->
            <div style="
              position: absolute;
              inset: 0;
              display: flex;
              align-items: center;
              justify-content: center;
              pointer-events: none;
              z-index: 0;
            ">
              <img
                src="{{ asset('assets/images/logo-official-transparent.png') }}"
                alt=""
                aria-hidden="true"
                style="
                  width: 65%;
                  max-width: 320px;
                  height: auto;
                  opacity: 0.07;
                  object-fit: contain;
                  display: block;
                "
                onerror="this.style.display='none'"
              >
            </div>


            <!-- THE CAR SVG — centered and large -->
            <svg
              viewBox="50 95 490 165"
              xmlns="http://www.w3.org/2000/svg"
              style="
                position: relative;
                z-index: 1;
                width: 100%;
                max-width: 620px;
                height: auto;
                display: block;
                overflow: visible;
              "
              role="img"
              aria-label="NikaFleet blueprint car illustration">

              <defs>

                <!-- Headlight glow filter -->
                <filter id="nf-glow" x="-80%" y="-80%" width="260%" height="260%">
                  <feGaussianBlur in="SourceGraphic" stdDeviation="5" result="blur"/>
                  <feMerge>
                    <feMergeNode in="blur"/>
                    <feMergeNode in="SourceGraphic"/>
                  </feMerge>
                </filter>

                <!-- Soft shadow under car -->
                <filter id="nf-shadow" x="-10%" y="-10%" width="120%" height="200%">
                  <feGaussianBlur in="SourceGraphic" stdDeviation="6" result="blur"/>
                  <feColorMatrix in="blur" type="matrix"
                    values="0 0 0 0 0.741
                            0 0 0 0 0.627
                            0 0 0 0 0.306
                            0 0 0 0.25 0"/>
                </filter>

              </defs>

              <style>
                /* ── FLOAT ANIMATION ── */
                @keyframes nf-float {
                  0%   { transform: translateY(0px);  }
                  50%  { transform: translateY(-9px); }
                  100% { transform: translateY(0px);  }
                }

                /* ── WHEEL SPIN ── */
                @keyframes nf-spin-f {
                  from { transform: rotate(0deg);   }
                  to   { transform: rotate(360deg); }
                }
                @keyframes nf-spin-r {
                  from { transform: rotate(0deg);   }
                  to   { transform: rotate(360deg); }
                }

                /* ── DRAW-IN (construction lines) ── */
                @keyframes nf-draw {
                  0%   { stroke-dashoffset: 800; opacity: 0; }
                  20%  { opacity: 1; }
                  100% { stroke-dashoffset: 0;   opacity: 1; }
                }

                /* ── HEADLIGHT PULSE ── */
                @keyframes nf-pulse {
                  0%, 100% { opacity: 0.3; }
                  50%       { opacity: 0.9; }
                }

                /* ── FADE IN ── */
                @keyframes nf-fadein {
                  from { opacity: 0; transform: translateY(14px); }
                  to   { opacity: 1; transform: translateY(0);    }
                }

                /* Car group floats */
                .nf-car-group {
                  animation: nf-float 4s ease-in-out infinite;
                  transform-origin: center bottom;
                }

                /* Front wheel spins around its own center */
                .nf-wheel-front {
                  animation: nf-spin-f 8s linear infinite;
                  transform-origin: 155px 216px;
                }

                /* Rear wheel spins around its own center */
                .nf-wheel-rear {
                  animation: nf-spin-r 8s linear infinite;
                  transform-origin: 420px 216px;
                }

                /* Construction lines draw themselves in */
                .nf-cl {
                  stroke: #bda04e;
                  stroke-width: 0.6;
                  fill: none;
                  opacity: 0;
                  stroke-dasharray: 800;
                  stroke-dashoffset: 800;
                  animation: nf-draw 2s ease forwards;
                }

                /* Headlight glows */
                .nf-headglow {
                  animation: nf-pulse 2.4s ease-in-out infinite;
                }

                /* Whole car fades in then floats */
                .nf-car-group {
                  opacity: 0;
                  animation:
                    nf-fadein 0.8s ease 0.1s forwards,
                    nf-float  4s  ease-in-out 1s infinite;
                }

                /* Label text */
                .nf-label {
                  font-family: 'Inter Tight', 'Inter', monospace;
                  font-size: 7px;
                  fill: #bda04e;
                  opacity: 0.6;
                  letter-spacing: 1.5px;
                  text-transform: uppercase;
                }
              </style>

              <!-- ══ GROUND SHADOW ══ -->
              <ellipse cx="290" cy="230" rx="205" ry="8"
                       fill="#bda04e" opacity="0.06"/>

              <!-- ══ CONSTRUCTION LINES (draw in on load) ══ -->

              <!-- Horizontal centerline of car body -->
              <line class="nf-cl" x1="55" y1="148" x2="525" y2="148"
                    style="stroke-dasharray: 14 6; animation-delay: 0.3s;"/>

              <!-- Wheel center axis — front -->
              <line class="nf-cl" x1="88" y1="216" x2="222" y2="216"
                    style="animation-delay: 0.5s;"/>
              <!-- Wheel center axis — rear -->
              <line class="nf-cl" x1="354" y1="216" x2="488" y2="216"
                    style="animation-delay: 0.6s;"/>

              <!-- Wheel center verticals — front -->
              <line class="nf-cl" x1="155" y1="168" x2="155" y2="264"
                    style="animation-delay: 0.7s;"/>
              <!-- Wheel center verticals — rear -->
              <line class="nf-cl" x1="420" y1="168" x2="420" y2="264"
                    style="animation-delay: 0.8s;"/>

              <!-- Wheelbase dimension line -->
              <line class="nf-cl" x1="155" y1="268" x2="420" y2="268"
                    style="animation-delay: 1.0s; stroke-dasharray: 800;"/>

              <!-- Wheelbase tick marks -->
              <line class="nf-cl" x1="155" y1="264" x2="155" y2="274"
                    style="animation-delay: 1.1s; stroke-dasharray: 800;"/>
              <line class="nf-cl" x1="420" y1="264" x2="420" y2="274"
                    style="animation-delay: 1.1s; stroke-dasharray: 800;"/>

              <!-- Overall length dimension line -->
              <line class="nf-cl" x1="80" y1="246" x2="500" y2="246"
                    style="animation-delay: 1.2s; stroke-dasharray: 800;"/>
              <line class="nf-cl" x1="80"  y1="242" x2="80"  y2="252"
                    style="animation-delay: 1.2s; stroke-dasharray: 800;"/>
              <line class="nf-cl" x1="500" y1="242" x2="500" y2="252"
                    style="animation-delay: 1.2s; stroke-dasharray: 800;"/>

              <!-- Dimension labels -->
              <text class="nf-label" x="280" y="260" text-anchor="middle"
                    style="opacity:0; animation: nf-draw 0.8s ease 1.4s forwards;">
                WHEELBASE
              </text>


              <!-- Height reference line — top of roof -->
              <line class="nf-cl" x1="50" y1="110" x2="80" y2="110"
                    style="animation-delay: 0.9s; stroke-dasharray: 800;"/>
              <line class="nf-cl" x1="50" y1="204" x2="80" y2="204"
                    style="animation-delay: 0.9s; stroke-dasharray: 800;"/>
              <line class="nf-cl" x1="55" y1="110" x2="55" y2="204"
                    style="animation-delay: 1.0s; stroke-dasharray: 800;"/>
              <text class="nf-label" x="46" y="160" text-anchor="middle"
                    transform="rotate(-90, 46, 160)"
                    style="font-size:6px; opacity:0; animation: nf-draw 0.8s ease 1.5s forwards;">
                HEIGHT
              </text>

              <!-- ══ CAR BODY (floats + fades in) ══ -->
              <g class="nf-car-group">

                <!-- ── BODY SILHOUETTE ── -->
                <path d="
                  M 80  204
                  L 80  185
                  Q 80  180  84  178
                  L 100 174
                  L 100 168
                  L 152 168
                  L 186 128
                  Q 194 116  208 114
                  L 375 112
                  Q 390 112  400 122
                  L 430 168
                  L 490 168
                  Q 496 170  498 176
                  L 500 184
                  L 500 204
                  Z
                "
                fill="rgba(189,160,78,0.04)"
                stroke="#bda04e"
                stroke-width="1.75"
                stroke-linejoin="round"
                stroke-linecap="round"/>

                <!-- ── CABIN / GREENHOUSE ── -->
                <path d="
                  M 186 128
                  Q 194 116  208 114
                  L 375 112
                  Q 390 112  400 122
                  L 430 168
                  L 152 168
                  Z
                "
                fill="rgba(189,160,78,0.06)"
                stroke="#bda04e"
                stroke-width="1.4"
                stroke-linejoin="round"/>

                <!-- ── WINDSCREEN (front) ── -->
                <path d="
                  M 186 165
                  L 214 128
                  Q 221 118  234 116
                  L 315 115
                  L 315 165
                  Z
                "
                fill="rgba(189,160,78,0.08)"
                stroke="#bda04e"
                stroke-width="1.1"/>

                <!-- ── REAR SCREEN ── -->
                <path d="
                  M 315 115
                  L 372 113
                  Q 387 113  398 124
                  L 428 165
                  L 315 165
                  Z
                "
                fill="rgba(189,160,78,0.065)"
                stroke="#bda04e"
                stroke-width="1.1"/>

                <!-- ── A-PILLAR ── -->
                <line x1="214" y1="128" x2="186" y2="165"
                      stroke="#bda04e" stroke-width="1.4"/>

                <!-- ── B-PILLAR ── -->
                <line x1="315" y1="113" x2="315" y2="168"
                      stroke="#bda04e" stroke-width="1.6"/>

                <!-- ── C-PILLAR ── -->
                <line x1="398" y1="124" x2="428" y2="165"
                      stroke="#bda04e" stroke-width="1.4"/>

                <!-- ── ROOFLINE INNER TRIM LINE ── -->
                <line x1="208" y1="116" x2="375" y2="114"
                      stroke="#bda04e" stroke-width="0.6"
                      stroke-dasharray="5 3" opacity="0.5"/>

                <!-- ── DOOR LINES ── -->
                <!-- Front door -->
                <rect x="190" y="168" width="124" height="32" rx="0"
                      fill="none" stroke="#bda04e" stroke-width="0.8" opacity="0.55"/>
                <!-- Rear door -->
                <rect x="316" y="168" width="112" height="32" rx="0"
                      fill="none" stroke="#bda04e" stroke-width="0.8" opacity="0.55"/>

                <!-- ── DOOR HANDLES ── -->
                <!-- Front -->
                <rect x="248" y="182" width="20" height="4" rx="2"
                      fill="none" stroke="#bda04e" stroke-width="1" opacity="0.7"/>
                <!-- Rear -->
                <rect x="370" y="182" width="20" height="4" rx="2"
                      fill="none" stroke="#bda04e" stroke-width="1" opacity="0.7"/>

                <!-- ── HOOD LINE ── -->
                <path d="M 100 168 Q 136 155  152 168"
                      fill="none" stroke="#bda04e" stroke-width="1"
                      stroke-linecap="round" opacity="0.7"/>

                <!-- ── TRUNK LINE ── -->
                <path d="M 430 168 Q 466 155  490 168"
                      fill="none" stroke="#bda04e" stroke-width="1"
                      stroke-linecap="round" opacity="0.7"/>

                <!-- ── HEADLIGHT CLUSTER (FRONT) ── -->
                <g class="nf-headglow" filter="url(#nf-glow)">
                  <!-- Main housing -->
                  <path d="
                    M 80 185
                    Q 80 180 84 178
                    L 100 174
                    L 100 168
                    L 88  168
                    Q 80  168 80 176
                    Z
                  "
                  fill="rgba(189,160,78,0.18)"
                  stroke="#bda04e" stroke-width="1.5"/>
                  <!-- DRL strip -->
                  <line x1="82" y1="190" x2="98" y2="188"
                        stroke="#bda04e" stroke-width="2" stroke-linecap="round"/>
                  <!-- Upper beam -->
                  <line x1="82" y1="180" x2="98" y2="178"
                        stroke="#bda04e" stroke-width="0.8" opacity="0.8"/>
                  <line x1="82" y1="184" x2="98" y2="183"
                        stroke="#bda04e" stroke-width="0.6" opacity="0.5"/>
                </g>

                <!-- ── TAILLIGHT CLUSTER (REAR) ── -->
                <g opacity="0.8">
                  <path d="
                    M 500 184
                    L 500 168
                    L 488 168
                    L 488 184
                    Q 494 186 500 184
                    Z
                  "
                  fill="rgba(189,160,78,0.12)"
                  stroke="#bda04e" stroke-width="1.5"/>
                  <!-- Taillight bar -->
                  <line x1="490" y1="190" x2="498" y2="188"
                        stroke="#bda04e" stroke-width="2" stroke-linecap="round"/>
                  <line x1="490" y1="178" x2="498" y2="177"
                        stroke="#bda04e" stroke-width="0.8" opacity="0.6"/>
                </g>

                <!-- ── FRONT BUMPER DETAIL ── -->
                <path d="M 80 204 Q 78 210 82 213 L 100 213 L 100 204 Z"
                      fill="rgba(189,160,78,0.06)"
                      stroke="#bda04e" stroke-width="1.1"/>
                <!-- Grille suggestion -->
                <line x1="84" y1="208" x2="98" y2="208"
                      stroke="#bda04e" stroke-width="0.8" opacity="0.5"/>
                <line x1="84" y1="211" x2="98" y2="211"
                      stroke="#bda04e" stroke-width="0.8" opacity="0.5"/>

                <!-- ── REAR BUMPER DETAIL ── -->
                <path d="M 500 204 Q 502 210 498 213 L 478 213 L 478 204 Z"
                      fill="rgba(189,160,78,0.06)"
                      stroke="#bda04e" stroke-width="1.1"/>
                <!-- Exhaust -->
                <rect x="482" y="208" width="14" height="5" rx="2.5"
                      fill="none" stroke="#bda04e" stroke-width="0.8" opacity="0.6"/>

                <!-- ── SIDE SKIRT / SILL ── -->
                <rect x="100" y="200" width="378" height="5" rx="1"
                      fill="rgba(189,160,78,0.1)"
                      stroke="#bda04e" stroke-width="0.75"/>

                <!-- ── FRONT WHEEL ARCH ── -->
                <path d="M 88 204 Q 92 164 155 164 Q 218 164 222 204"
                      fill="rgba(253,252,250,0.95)"
                      stroke="#bda04e" stroke-width="2"/>

                <!-- ── REAR WHEEL ARCH ── -->
                <path d="M 356 204 Q 360 164 420 164 Q 484 164 488 204"
                      fill="rgba(253,252,250,0.95)"
                      stroke="#bda04e" stroke-width="2"/>

                <!-- ══ FRONT WHEEL (rotates around 155, 216) ══ -->
                <g class="nf-wheel-front">
                  <!-- Outer tyre -->
                  <circle cx="155" cy="216" r="40"
                          fill="rgba(189,160,78,0.04)"
                          stroke="#bda04e" stroke-width="2.2"/>
                  <!-- Inner tyre wall -->
                  <circle cx="155" cy="216" r="33"
                          fill="none"
                          stroke="#bda04e" stroke-width="0.7"
                          stroke-dasharray="4 4" opacity="0.45"/>
                  <!-- Rim outer ring -->
                  <circle cx="155" cy="216" r="26"
                          fill="rgba(189,160,78,0.07)"
                          stroke="#bda04e" stroke-width="1.6"/>
                  <!-- Hub cap ring -->
                  <circle cx="155" cy="216" r="8"
                          fill="rgba(189,160,78,0.15)"
                          stroke="#bda04e" stroke-width="1.4"/>
                  <!-- Hub center -->
                  <circle cx="155" cy="216" r="3.5"
                          fill="#bda04e" opacity="0.4"/>
                  <!-- Spoke 1 — 12 o'clock -->
                  <line x1="155" y1="208" x2="155" y2="190"
                        stroke="#bda04e" stroke-width="1.4"/>
                  <!-- Spoke 2 — 6 o'clock -->
                  <line x1="155" y1="224" x2="155" y2="242"
                        stroke="#bda04e" stroke-width="1.4"/>
                  <!-- Spoke 3 — 9 o'clock -->
                  <line x1="147" y1="216" x2="129" y2="216"
                        stroke="#bda04e" stroke-width="1.4"/>
                  <!-- Spoke 4 — 3 o'clock -->
                  <line x1="163" y1="216" x2="181" y2="216"
                        stroke="#bda04e" stroke-width="1.4"/>
                  <!-- Spoke 5 — ~1 o'clock -->
                  <line x1="160" y1="211" x2="171" y2="200"
                        stroke="#bda04e" stroke-width="1.4"/>
                  <!-- Spoke 6 — ~7 o'clock -->
                  <line x1="150" y1="221" x2="139" y2="232"
                        stroke="#bda04e" stroke-width="1.4"/>
                </g>

                <!-- ══ REAR WHEEL (rotates around 420, 216) ══ -->
                <g class="nf-wheel-rear">
                  <!-- Outer tyre -->
                  <circle cx="420" cy="216" r="40"
                          fill="rgba(189,160,78,0.04)"
                          stroke="#bda04e" stroke-width="2.2"/>
                  <!-- Inner tyre wall -->
                  <circle cx="420" cy="216" r="33"
                          fill="none"
                          stroke="#bda04e" stroke-width="0.7"
                          stroke-dasharray="4 4" opacity="0.45"/>
                  <!-- Rim outer ring -->
                  <circle cx="420" cy="216" r="26"
                          fill="rgba(189,160,78,0.07)"
                          stroke="#bda04e" stroke-width="1.6"/>
                  <!-- Hub cap ring -->
                  <circle cx="420" cy="216" r="8"
                          fill="rgba(189,160,78,0.15)"
                          stroke="#bda04e" stroke-width="1.4"/>
                  <!-- Hub center -->
                  <circle cx="420" cy="216" r="3.5"
                          fill="#bda04e" opacity="0.4"/>
                  <!-- Spoke 1 — 12 o'clock -->
                  <line x1="420" y1="208" x2="420" y2="190"
                        stroke="#bda04e" stroke-width="1.4"/>
                  <!-- Spoke 2 — 6 o'clock -->
                  <line x1="420" y1="224" x2="420" y2="242"
                        stroke="#bda04e" stroke-width="1.4"/>
                  <!-- Spoke 3 — 9 o'clock -->
                  <line x1="412" y1="216" x2="394" y2="216"
                        stroke="#bda04e" stroke-width="1.4"/>
                  <!-- Spoke 4 — 3 o'clock -->
                  <line x1="428" y1="216" x2="446" y2="216"
                        stroke="#bda04e" stroke-width="1.4"/>
                  <!-- Spoke 5 — ~1 o'clock -->
                  <line x1="425" y1="211" x2="436" y2="200"
                        stroke="#bda04e" stroke-width="1.4"/>
                  <!-- Spoke 6 — ~7 o'clock -->
                  <line x1="415" y1="221" x2="404" y2="232"
                        stroke="#bda04e" stroke-width="1.4"/>
                </g>

              </g><!-- end .nf-car-group -->

            </svg>
            <!-- end car SVG -->

          </div>
          <!-- end blueprint-wrap -->

        </div>
        <!-- end hero-right -->

      </div>
      <!-- end hero-grid -->

    </section>
    <!-- ═══ END HERO SECTION ═══ -->

    {{-- ============================================================ --}}
    {{-- STATS BAR --}}
    {{-- ============================================================ --}}
    <section class="bg-gold-wash border-t border-b border-gold-light" style="padding: 1.75rem 0;">
        <div class="section-container">
            <div class="stats-grid grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-0">
                {{-- Stat 1 --}}
                <div class="stat-item text-center md:border-r border-gold-light">
                    <div class="font-tight font-bold text-charcoal" style="font-size: 28px;">{{ $availableCars }}</div>
                    <div class="font-sans text-charcoal-muted mt-1" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.08em;">Cars Available</div>
                </div>
                {{-- Stat 2 --}}
                <div class="stat-item text-center md:border-r border-gold-light">
                    <div class="font-tight font-bold text-charcoal" style="font-size: 28px;">{{ $totalFleet }}</div>
                    <div class="font-sans text-charcoal-muted mt-1" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.08em;">Fleet Size</div>
                </div>
                {{-- Stat 3 --}}
                <div class="stat-item text-center md:border-r border-gold-light">
                    <div class="font-tight font-bold text-charcoal" style="font-size: 28px;">{{ $completedOrders }}</div>
                    <div class="font-sans text-charcoal-muted mt-1" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.08em;">Completed Rentals</div>
                </div>
                {{-- Stat 4 --}}
                <div class="stat-item text-center">
                    <div class="font-tight font-bold text-charcoal" style="font-size: 28px;">24/7</div>
                    <div class="font-sans text-charcoal-muted mt-1" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.08em;">Available 24/7</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FLEET SECTION --}}
    {{-- ============================================================ --}}
    <section id="fleet" class="bg-white section-pad">
        <div class="section-container">
            {{-- Header --}}
            <div class="text-center mb-12">
                <span class="eyebrow">Our Fleet</span>
                <div class="gold-rule mx-auto" style="margin-bottom: 1.25rem;"></div>
                <h2 class="font-display text-charcoal" style="font-size: var(--text-2xl); font-weight: 500; line-height: 1.2; margin: 0;">Available Vehicles</h2>
                <p class="font-sans text-charcoal-light mx-auto mt-4" style="font-size: 17px; max-width: 560px; line-height: 1.7;">
                    Every vehicle in the NikaFleet fleet is carefully maintained and ready for you. Filter by type, transmission, or capacity to find your ideal rental.
                </p>
            </div>

            {{-- Car Grid --}}
            <div class="fleet-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($sampleCars as $car)
                <div class="nf-card">
                    {{-- Car Image --}}
                    <div class="car-card-img-wrap overflow-hidden" style="aspect-ratio: 16/9;">
                        <img src="{{ $car['image'] }}"
                             alt="{{ $car['name'] }}"
                             class="w-full h-full object-cover"
                             loading="lazy"
                             onerror="this.src='https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=800&q=80&auto=format&fit=crop'">
                    </div>

                    {{-- Card Body --}}
                    <div style="padding: 1.25rem 1.5rem 1.5rem;">
                        {{-- Name --}}
                        <h3 class="font-tight text-charcoal" style="font-size: 15px; font-weight: 600; margin: 0;">{{ $car['name'] }}</h3>
                        {{-- Type tag --}}
                        <span class="font-tight text-gold mt-1 inline-block" style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.1em;">{{ strtoupper($car['type']) }} &mdash; {{ strtoupper($car['transmission']) }}</span>

                        {{-- Specs Row --}}
                        <div class="flex gap-4 mt-3 pt-3 border-t border-hairline">
                            <div>
                                <div class="font-sans text-charcoal-muted" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em;">Seats</div>
                                <div class="font-sans text-charcoal-light" style="font-size: 12px;">{{ $car['seats'] }}</div>
                            </div>
                            <div>
                                <div class="font-sans text-charcoal-muted" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em;">Fuel</div>
                                <div class="font-sans text-charcoal-light" style="font-size: 12px;">{{ $car['fuel'] }}</div>
                            </div>
                            <div>
                                <div class="font-sans text-charcoal-muted" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em;">Year</div>
                                <div class="font-sans text-charcoal-light" style="font-size: 12px;">{{ $car['year'] }}</div>
                            </div>
                        </div>

                        {{-- Price + CTA --}}
                        <div class="flex items-end justify-between mt-4">
                            <div>
                                <div class="font-tight text-charcoal-muted" style="font-size: 10px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.1em;">Rental Rate</div>
                                <div class="font-tight text-charcoal" style="font-size: 22px; font-weight: 700;">
                                    RM {{ $car['price'] }} <span class="font-sans text-charcoal-muted" style="font-size: 12px; font-weight: 400;">/ day</span>
                                </div>
                            </div>
                            <button @click="openBooking({{ json_encode($car) }})" class="btn-primary" style="padding: 9px 20px; font-size: 12px;">Book</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Bottom text --}}
            <div class="text-center mt-10">
                <p class="font-sans text-charcoal-muted italic" style="font-size: 14px;">
                    All vehicles can be booked directly via WhatsApp. No online payment required.
                </p>
                <a href="#fleet" class="btn-gold-outline mt-6 inline-block">View All Vehicles</a>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- HOW TO BOOK SECTION --}}
    {{-- ============================================================ --}}
    <section id="cara-sewa" class="bg-charcoal-wash section-pad">
        <div class="section-container">
            {{-- Header --}}
            <div class="text-center mb-16">
                <span class="eyebrow">Simple Process</span>
                <div class="gold-rule mx-auto" style="margin-bottom: 1.25rem;"></div>
                <h2 class="font-display text-charcoal" style="font-size: var(--text-2xl); font-weight: 500; line-height: 1.2; margin: 0;">How to Rent</h2>
            </div>

            {{-- Timeline --}}
            <div class="steps-grid flex flex-col md:flex-row items-start md:items-start gap-6 md:gap-0">
                {{-- Step 1 --}}
                <div class="step-item flex-1 flex flex-col items-center text-center px-2">
                    <div class="flex items-center justify-center rounded-full bg-white border-gold" style="width: 48px; height: 48px; border: 1.5px solid #bda04e;">
                        <span class="font-tight font-semibold text-gold" style="font-size: 16px;">1</span>
                    </div>
                    <h3 class="font-tight text-charcoal mt-4" style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0;">Choose Your Car</h3>
                    <p class="font-sans text-charcoal-light mt-2" style="font-size: 13px; line-height: 1.7; max-width: 220px;">
                        Browse our fleet and select the vehicle that fits your needs and budget.
                    </p>
                </div>
                <div class="steps-connector timeline-connector hidden md:block"></div>

                {{-- Step 2 --}}
                <div class="step-item flex-1 flex flex-col items-center text-center px-2">
                    <div class="flex items-center justify-center rounded-full bg-white border-gold" style="width: 48px; height: 48px; border: 1.5px solid #bda04e;">
                        <span class="font-tight font-semibold text-gold" style="font-size: 16px;">2</span>
                    </div>
                    <h3 class="font-tight text-charcoal mt-4" style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0;">Fill in Details</h3>
                    <p class="font-sans text-charcoal-light mt-2" style="font-size: 13px; line-height: 1.7; max-width: 220px;">
                        Enter your name, phone number, rental dates, pickup and return times, and location.
                    </p>
                </div>
                <div class="steps-connector timeline-connector hidden md:block"></div>

                {{-- Step 3 --}}
                <div class="step-item flex-1 flex flex-col items-center text-center px-2">
                    <div class="flex items-center justify-center rounded-full bg-white border-gold" style="width: 48px; height: 48px; border: 1.5px solid #bda04e;">
                        <span class="font-tight font-semibold text-gold" style="font-size: 16px;">3</span>
                    </div>
                    <h3 class="font-tight text-charcoal mt-4" style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0;">Send to WhatsApp</h3>
                    <p class="font-sans text-charcoal-light mt-2" style="font-size: 13px; line-height: 1.7; max-width: 220px;">
                        The system generates a complete booking message and opens it directly in WhatsApp.
                    </p>
                </div>
                <div class="steps-connector timeline-connector hidden md:block"></div>

                {{-- Step 4 --}}
                <div class="step-item flex-1 flex flex-col items-center text-center px-2">
                    <div class="flex items-center justify-center rounded-full bg-white border-gold" style="width: 48px; height: 48px; border: 1.5px solid #bda04e;">
                        <span class="font-tight font-semibold text-gold" style="font-size: 16px;">4</span>
                    </div>
                    <h3 class="font-tight text-charcoal mt-4" style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0;">Confirm Booking</h3>
                    <p class="font-sans text-charcoal-light mt-2" style="font-size: 13px; line-height: 1.7; max-width: 220px;">
                        We will review and confirm your booking via WhatsApp shortly after.
                    </p>
                </div>
            </div>

            {{-- CTA --}}
            <div class="text-center mt-12">
                <a href="https://wa.me/601168247599?text=Hi%20NikaFleet!%20I%20would%20like%20to%20rent%20a%20car." target="_blank" rel="noopener" class="btn-primary" style="padding: 16px 40px;">Book a Car Now</a>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- TIKTOK SECTION --}}
    {{-- ============================================================ --}}
    <section class="bg-white section-pad">
        <div class="section-container">
            {{-- Header --}}
            <div class="text-center mb-12">
                <span class="eyebrow">Social Media</span>
                <div class="gold-rule mx-auto" style="margin-bottom: 1.25rem;"></div>
                <h2 class="font-display text-charcoal" style="font-size: var(--text-2xl); font-weight: 500; line-height: 1.2; margin: 0;">Follow Us on TikTok</h2>
                <p class="font-sans text-charcoal-light mx-auto mt-4" style="font-size: 16px; max-width: 480px; line-height: 1.7;">
                    Watch our latest fleet videos, car tips, and exclusive offers on NikaFleet TikTok.
                </p>
            </div>

            {{-- Two column --}}
            <div class="tiktok-grid grid md:grid-cols-2 gap-8 items-start">
                {{-- Left: Profile card --}}
                <div class="bg-gold-wash border border-gold-light rounded" style="padding: 2rem;">
                    <img src="{{ asset('assets/images/logo-official.jpeg') }}" alt="NikaFleet" style="height: 56px; border-radius: 4px; margin-bottom: 1rem;">
                    <div class="font-tight font-bold text-charcoal" style="font-size: 18px;">@nika.fleet</div>
                    <span class="font-tight text-gold inline-block mt-1" style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.1em;">TikTok</span>
                    <div class="border-t border-gold-light my-4"></div>
                    <p class="font-sans text-charcoal-light" style="font-size: 14px; line-height: 1.65; margin: 0;">
                        Latest fleet updates, car walkthroughs, and behind-the-scenes from NikaFleet.
                    </p>
                    <a href="https://www.tiktok.com/@nika.fleet" target="_blank" rel="noopener" class="btn-gold-outline w-full text-center mt-6 block">Follow on TikTok</a>
                </div>

                {{-- Right: TikTok embed --}}
                <div>
                    {{-- Primary: TikTok embed --}}
                    <div style="max-width: 480px; margin: 0 auto;" id="tiktok-embed-wrap">
                        <div style="display:flex; justify-content:center;">
                            <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@nika.fleet" data-unique-id="nika.fleet" data-embed-type="creator" style="max-width: 780px; min-width: 288px; border-radius: 4px; overflow: hidden;">
                                <section>
                                    <a target="_blank" href="https://www.tiktok.com/@nika.fleet">@nika.fleet</a>
                                </section>
                            </blockquote>
                            <script async src="https://www.tiktok.com/embed.js"></script>
                        </div>
                    </div>

                    {{-- Fallback card --}}
                    <noscript>
                        <div class="rounded text-center" style="background: #4b4b4b; padding: 2.5rem;">
                            <div class="font-tight text-gold" style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em;">Watch on TikTok</div>
                            <div class="font-tight text-white mt-2" style="font-size: 24px; font-weight: 700;">@nika.fleet</div>
                            <p class="mt-2" style="font-size: 13px; color: rgba(255,255,255,0.7);">Tap to see our latest fleet videos.</p>
                            <a href="https://www.tiktok.com/@nika.fleet" target="_blank" rel="noopener" class="btn-primary mt-6 inline-block">Open TikTok</a>
                        </div>
                    </noscript>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- WHY NIKAFLEET SECTION --}}
    {{-- ============================================================ --}}
    <section class="bg-charcoal-wash section-pad">
        <div class="section-container">
            {{-- Header --}}
            <div class="text-center mb-12">
                <span class="eyebrow">Why Choose Us</span>
                <div class="gold-rule mx-auto" style="margin-bottom: 1.25rem;"></div>
                <h2 class="font-display text-charcoal" style="font-size: var(--text-2xl); font-weight: 500; line-height: 1.2; margin: 0;">Why NikaFleet?</h2>
            </div>

            {{-- Cards --}}
            <div class="why-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Card 1 --}}
                <div class="bg-white border border-hairline rounded transition-all duration-[250ms] hover:border-gold hover:shadow-[0_6px_20px_rgba(189,160,78,0.1)]" style="padding: 1.75rem;">
                    <div style="width: 24px; height: 3px; background: #bda04e; margin-bottom: 1.25rem;"></div>
                    <h3 class="font-tight text-charcoal" style="font-size: 15px; font-weight: 600; margin: 0 0 0.5rem;">Simple Process</h3>
                    <p class="font-sans text-charcoal-light" style="font-size: 14px; line-height: 1.7; margin: 0;">
                        Book directly via WhatsApp &mdash; no accounts, no complicated forms.
                    </p>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white border border-hairline rounded transition-all duration-[250ms] hover:border-gold hover:shadow-[0_6px_20px_rgba(189,160,78,0.1)]" style="padding: 1.75rem;">
                    <div style="width: 24px; height: 3px; background: #bda04e; margin-bottom: 1.25rem;"></div>
                    <h3 class="font-tight text-charcoal" style="font-size: 15px; font-weight: 600; margin: 0 0 0.5rem;">Clean & Safe Vehicles</h3>
                    <p class="font-sans text-charcoal-light" style="font-size: 14px; line-height: 1.7; margin: 0;">
                        Every car is serviced and cleaned before each rental.
                    </p>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white border border-hairline rounded transition-all duration-[250ms] hover:border-gold hover:shadow-[0_6px_20px_rgba(189,160,78,0.1)]" style="padding: 1.75rem;">
                    <div style="width: 24px; height: 3px; background: #bda04e; margin-bottom: 1.25rem;"></div>
                    <h3 class="font-tight text-charcoal" style="font-size: 15px; font-weight: 600; margin: 0 0 0.5rem;">Fast Response</h3>
                    <p class="font-sans text-charcoal-light" style="font-size: 14px; line-height: 1.7; margin: 0;">
                        We reply to enquiries and confirm bookings quickly.
                    </p>
                </div>

                {{-- Card 4 --}}
                <div class="bg-white border border-hairline rounded transition-all duration-[250ms] hover:border-gold hover:shadow-[0_6px_20px_rgba(189,160,78,0.1)]" style="padding: 1.75rem;">
                    <div style="width: 24px; height: 3px; background: #bda04e; margin-bottom: 1.25rem;"></div>
                    <h3 class="font-tight text-charcoal" style="font-size: 15px; font-weight: 600; margin: 0 0 0.5rem;">Transparent Pricing</h3>
                    <p class="font-sans text-charcoal-light" style="font-size: 14px; line-height: 1.7; margin: 0;">
                        No hidden fees. The price you see is the price you pay.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CONTACT / CTA BAND --}}
    {{-- ============================================================ --}}
    <section id="hubungi" class="bg-charcoal" style="padding: 5rem 0;">
        <div class="section-container">
            <div class="cta-band-inner grid md:grid-cols-2 gap-12 items-center">
                {{-- Left --}}
                <div>
                    <span class="font-tight text-gold" style="font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.1em;">Get in Touch</span>
                    <h2 class="cta-band-heading font-display text-white mt-2" style="font-size: 36px; font-weight: 500; line-height: 1.2; margin-bottom: 0;">Ready to Hit the Road?</h2>
                    <p class="mt-4" style="font-family: 'Inter', sans-serif; font-weight: 300; font-size: 15px; color: rgba(255,255,255,0.7); line-height: 1.7;">
                        Contact us via WhatsApp or phone. We are here to help you find the right vehicle.
                    </p>
                </div>

                {{-- Right --}}
                <div class="cta-band-buttons flex flex-col gap-4 md:items-end items-start">
                    <a href="https://wa.me/601168247599?text=Hi%20NikaFleet!%20I%20would%20like%20to%20enquire%20about%20car%20rental." target="_blank" rel="noopener" class="btn-primary" style="padding: 16px 40px;">Chat on WhatsApp</a>
                    <a href="tel:+601168247599" class="inline-block no-underline font-tight font-semibold text-center transition-all duration-200" style="font-size: 13px; letter-spacing: 0.08em; text-transform: uppercase; padding: 13px 32px; border-radius: 2px; border: 1.5px solid rgba(255,255,255,0.4); color: rgba(255,255,255,0.8);" onmouseover="this.style.borderColor='#bda04e'; this.style.color='#bda04e';" onmouseout="this.style.borderColor='rgba(255,255,255,0.4)'; this.style.color='rgba(255,255,255,0.8)';">+60 11-6824 7599</a>
                    <span class="font-tight" style="font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.5);">Fast Response Guaranteed</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FOOTER --}}
    {{-- ============================================================ --}}
    <footer class="bg-charcoal" style="border-top: 2px solid #bda04e;">
        {{-- Top section --}}
        <div class="section-container" style="padding: 3.5rem 0 2.5rem;">
            <div class="footer-top-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">
                {{-- Column 1: Brand --}}
                <div>
                    <img src="{{ asset('assets/images/logo-official-transparent.png') }}" alt="NikaFleet" style="height: 44px; filter: brightness(10);">
                    <div class="font-tight text-white mt-3" style="font-size: 13px; font-weight: 700; letter-spacing: 0.18em;">NIKAFLEET</div>
                    <div class="font-display italic mt-1" style="font-size: 16px; color: rgba(255,255,255,0.6);">Need a car? Nika's got you.</div>
                    <a href="https://www.tiktok.com/@nika.fleet" target="_blank" rel="noopener" class="font-tight text-gold no-underline inline-block mt-5 hover:opacity-80 transition-opacity" style="font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.1em;">@nika.fleet</a>
                </div>

                {{-- Column 2: Navigation --}}
                <div>
                    <div style="font-family: 'Inter Tight', sans-serif; font-size: 10px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.18em; color: rgba(255,255,255,0.4); margin-bottom: 1rem;">Navigation</div>
                    <div class="flex flex-col gap-2">
                        <a href="#fleet" class="font-sans no-underline transition-colors duration-200 hover:text-gold" style="font-size: 13px; color: rgba(255,255,255,0.65);">Our Fleet</a>
                        <a href="#cara-sewa" class="font-sans no-underline transition-colors duration-200 hover:text-gold" style="font-size: 13px; color: rgba(255,255,255,0.65);">How to Rent</a>
                        <a href="#hubungi" class="font-sans no-underline transition-colors duration-200 hover:text-gold" style="font-size: 13px; color: rgba(255,255,255,0.65);">Contact Us</a>
                    </div>
                </div>

                {{-- Column 3: Vehicle Types --}}
                <div>
                    <div style="font-family: 'Inter Tight', sans-serif; font-size: 10px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.18em; color: rgba(255,255,255,0.4); margin-bottom: 1rem;">Vehicle Types</div>
                    <div class="flex flex-col gap-2">
                        <a href="{{ url('/cars?type=sedan') }}" class="font-sans no-underline transition-colors duration-200 hover:text-gold" style="font-size: 13px; color: rgba(255,255,255,0.65);">Sedan</a>
                        <a href="{{ url('/cars?type=suv') }}" class="font-sans no-underline transition-colors duration-200 hover:text-gold" style="font-size: 13px; color: rgba(255,255,255,0.65);">SUV</a>
                        <a href="{{ url('/cars?type=mpv') }}" class="font-sans no-underline transition-colors duration-200 hover:text-gold" style="font-size: 13px; color: rgba(255,255,255,0.65);">MPV</a>
                        <a href="{{ url('/cars?type=van') }}" class="font-sans no-underline transition-colors duration-200 hover:text-gold" style="font-size: 13px; color: rgba(255,255,255,0.65);">Van</a>
                        <a href="{{ url('/cars?transmission=auto') }}" class="font-sans no-underline transition-colors duration-200 hover:text-gold" style="font-size: 13px; color: rgba(255,255,255,0.65);">Automatic</a>
                        <a href="{{ url('/cars?transmission=manual') }}" class="font-sans no-underline transition-colors duration-200 hover:text-gold" style="font-size: 13px; color: rgba(255,255,255,0.65);">Manual</a>
                    </div>
                </div>

                {{-- Column 4: Contact Us --}}
                <div>
                    <div style="font-family: 'Inter Tight', sans-serif; font-size: 10px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.18em; color: rgba(255,255,255,0.4); margin-bottom: 1rem;">Contact Us</div>
                    <div class="flex flex-col gap-4">
                        <div>
                            <div class="font-tight text-gold" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Phone</div>
                            <a href="tel:+601168247599" class="font-tight text-white no-underline" style="font-size: 14px; font-weight: 500;">+60 11-6824 7599</a>
                        </div>
                        <div>
                            <div class="font-tight text-gold" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">WhatsApp</div>
                            <a href="https://wa.me/601168247599" target="_blank" rel="noopener" class="font-sans no-underline transition-colors duration-200 hover:text-gold" style="font-size: 13px; color: rgba(255,255,255,0.65);">Chat Now</a>
                        </div>
                        <div>
                            <div class="font-tight text-gold" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">TikTok</div>
                            <a href="https://www.tiktok.com/@nika.fleet" target="_blank" rel="noopener" class="font-sans text-gold no-underline" style="font-size: 13px;">@nika.fleet</a>
                        </div>
                        <div>
                            <div class="font-tight text-gold" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Location</div>
                            <span class="font-sans" style="font-size: 13px; color: rgba(255,255,255,0.65);">Rawang, Selangor</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="section-container">
            <div class="footer-bottom-inner flex flex-col sm:flex-row items-center justify-between py-5" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <span class="font-sans" style="font-size: 12px; color: rgba(255,255,255,0.4);">Copyright 2025 NikaFleet. All Rights Reserved.</span>
                <span class="font-tight text-gold mt-2 sm:mt-0" style="font-size: 11px; font-weight: 500; letter-spacing: 0.18em; text-transform: uppercase;">EST. NOV 2025</span>
            </div>
        </div>
    </footer>

    {{-- ============================================================ --}}
    {{-- BOOKING MODAL — Complete replacement --}}
    {{-- ============================================================ --}}
    <div
      x-show="bookingModal"
      x-cloak
      class="booking-modal-overlay"
      @click.self="closeBooking()"
      @keydown.escape.window="closeBooking()"
    >
      <div
        class="booking-modal-panel"
        @click.stop
      >

        <!-- Modal Header -->
        <div style="
          background: #4b4b4b;
          padding: 1.5rem 2rem;
          display: flex;
          align-items: flex-start;
          justify-content: space-between;
        ">
          <div>
            <div style="
              font-family: 'Inter Tight', Inter, sans-serif;
              font-weight: 600;
              font-size: 0.6875rem;
              letter-spacing: 0.16em;
              text-transform: uppercase;
              color: #bda04e;
              margin-bottom: 0.375rem;
            ">Booking Form</div>
            <div style="
              font-family: 'Inter Tight', Inter, sans-serif;
              font-weight: 700;
              font-size: 1rem;
              color: #ffffff;
            " x-text="selectedCar ? selectedCar.name : ''"></div>
            <div style="
              font-family: Inter, sans-serif;
              font-size: 0.8125rem;
              color: rgba(255,255,255,0.55);
              margin-top: 2px;
            " x-text="selectedCar ? 'RM ' + selectedCar.price + ' / day' : ''"></div>
          </div>
          <button
            @click="closeBooking()"
            style="
              background: none;
              border: none;
              cursor: pointer;
              color: rgba(255,255,255,0.45);
              font-size: 1.25rem;
              line-height: 1;
              padding: 2px;
              transition: color 200ms;
              margin-top: 2px;
              flex-shrink: 0;
            "
            aria-label="Close booking modal"
            onmouseover="this.style.color='rgba(255,255,255,0.85)'"
            onmouseout="this.style.color='rgba(255,255,255,0.45)'"
          >&times;</button>
        </div>

        <!-- Modal Body -->
        <div style="padding: 1.75rem 2rem;">

          <!-- Full Name -->
          <div style="margin-bottom: 1.125rem;">
            <label style="
              display: block;
              font-family: 'Inter Tight', Inter, sans-serif;
              font-weight: 500;
              font-size: 0.6875rem;
              letter-spacing: 0.12em;
              text-transform: uppercase;
              color: #6b6b6b;
              margin-bottom: 6px;
            ">Full Name <span style="color:#bda04e;">*</span></label>
            <input
              type="text"
              x-model="bookingForm.name"
              placeholder="Your name as in your ID"
              required
              style="
                width: 100%;
                box-sizing: border-box;
                padding: 11px 14px;
                border: 1px solid #e8e4dc;
                border-radius: 3px;
                font-family: Inter, sans-serif;
                font-size: 0.875rem;
                color: #4b4b4b;
                background: #ffffff;
                outline: none;
                transition: border-color 200ms, box-shadow 200ms;
              "
              onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
              onblur="this.style.borderColor='#e8e4dc'; this.style.boxShadow='none'"
            >
          </div>

          <!-- Phone Number -->
          <div style="margin-bottom: 1.125rem;">
            <label style="
              display: block;
              font-family: 'Inter Tight', Inter, sans-serif;
              font-weight: 500;
              font-size: 0.6875rem;
              letter-spacing: 0.12em;
              text-transform: uppercase;
              color: #6b6b6b;
              margin-bottom: 6px;
            ">Phone Number <span style="color:#bda04e;">*</span></label>
            <input
              type="tel"
              x-model="bookingForm.phone"
              placeholder="+60 11-XXXX XXXX"
              required
              style="
                width: 100%;
                box-sizing: border-box;
                padding: 11px 14px;
                border: 1px solid #e8e4dc;
                border-radius: 3px;
                font-family: Inter, sans-serif;
                font-size: 0.875rem;
                color: #4b4b4b;
                background: #ffffff;
                outline: none;
                transition: border-color 200ms, box-shadow 200ms;
              "
              onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
              onblur="this.style.borderColor='#e8e4dc'; this.style.boxShadow='none'"
            >
          </div>

          <!-- Date + Time grid — 2 columns -->
          <div class="datetime-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.125rem;">

            <!-- Pickup Date -->
            <div>
              <label style="
                display: block;
                font-family: 'Inter Tight', Inter, sans-serif;
                font-weight: 500;
                font-size: 0.6875rem;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: #6b6b6b;
                margin-bottom: 6px;
              ">Pickup Date <span style="color:#bda04e;">*</span></label>
              <input
                type="date"
                x-model="bookingForm.startDate"
                :min="new Date().toISOString().split('T')[0]"
                required
                style="
                  width: 100%;
                  box-sizing: border-box;
                  padding: 11px 14px;
                  border: 1px solid #e8e4dc;
                  border-radius: 3px;
                  font-family: Inter, sans-serif;
                  font-size: 0.875rem;
                  color: #4b4b4b;
                  background: #ffffff;
                  outline: none;
                  transition: border-color 200ms, box-shadow 200ms;
                "
                onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                onblur="this.style.borderColor='#e8e4dc'; this.style.boxShadow='none'"
              >
            </div>

            <!-- Pickup Time -->
            <div>
              <label style="
                display: block;
                font-family: 'Inter Tight', Inter, sans-serif;
                font-weight: 500;
                font-size: 0.6875rem;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: #6b6b6b;
                margin-bottom: 6px;
              ">Pickup Time <span style="color:#bda04e;">*</span></label>
              @if($timeSlots->isNotEmpty())
              <select
                x-model="bookingForm.startTime"
                required
                style="
                  width: 100%;
                  box-sizing: border-box;
                  padding: 11px 14px;
                  border: 1px solid #e8e4dc;
                  border-radius: 3px;
                  font-family: Inter, sans-serif;
                  font-size: 0.875rem;
                  color: #4b4b4b;
                  background: #ffffff;
                  outline: none;
                  transition: border-color 200ms, box-shadow 200ms;
                "
                onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                onblur="this.style.borderColor='#e8e4dc'; this.style.boxShadow='none'"
              >
                @foreach($timeSlots as $slot)
                <option value="{{ $slot->time_value }}">{{ $slot->label }}</option>
                @endforeach
              </select>
              @else
              <input
                type="time"
                x-model="bookingForm.startTime"
                required
                style="
                  width: 100%;
                  box-sizing: border-box;
                  padding: 11px 14px;
                  border: 1px solid #e8e4dc;
                  border-radius: 3px;
                  font-family: Inter, sans-serif;
                  font-size: 0.875rem;
                  color: #4b4b4b;
                  background: #ffffff;
                  outline: none;
                  transition: border-color 200ms, box-shadow 200ms;
                "
                onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                onblur="this.style.borderColor='#e8e4dc'; this.style.boxShadow='none'"
              >
              @endif
            </div>

            <!-- Return Date -->
            <div>
              <label style="
                display: block;
                font-family: 'Inter Tight', Inter, sans-serif;
                font-weight: 500;
                font-size: 0.6875rem;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: #6b6b6b;
                margin-bottom: 6px;
              ">Return Date <span style="color:#bda04e;">*</span></label>
              <input
                type="date"
                x-model="bookingForm.endDate"
                :min="bookingForm.startDate || new Date().toISOString().split('T')[0]"
                required
                style="
                  width: 100%;
                  box-sizing: border-box;
                  padding: 11px 14px;
                  border: 1px solid #e8e4dc;
                  border-radius: 3px;
                  font-family: Inter, sans-serif;
                  font-size: 0.875rem;
                  color: #4b4b4b;
                  background: #ffffff;
                  outline: none;
                  transition: border-color 200ms, box-shadow 200ms;
                "
                onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                onblur="this.style.borderColor='#e8e4dc'; this.style.boxShadow='none'"
              >
            </div>

            <!-- Return Time -->
            <div>
              <label style="
                display: block;
                font-family: 'Inter Tight', Inter, sans-serif;
                font-weight: 500;
                font-size: 0.6875rem;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: #6b6b6b;
                margin-bottom: 6px;
              ">Return Time <span style="color:#bda04e;">*</span></label>
              @if($timeSlots->isNotEmpty())
              <select
                x-model="bookingForm.endTime"
                required
                style="
                  width: 100%;
                  box-sizing: border-box;
                  padding: 11px 14px;
                  border: 1px solid #e8e4dc;
                  border-radius: 3px;
                  font-family: Inter, sans-serif;
                  font-size: 0.875rem;
                  color: #4b4b4b;
                  background: #ffffff;
                  outline: none;
                  transition: border-color 200ms, box-shadow 200ms;
                "
                onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                onblur="this.style.borderColor='#e8e4dc'; this.style.boxShadow='none'"
              >
                @foreach($timeSlots as $slot)
                <option value="{{ $slot->time_value }}">{{ $slot->label }}</option>
                @endforeach
              </select>
              @else
              <input
                type="time"
                x-model="bookingForm.endTime"
                required
                style="
                  width: 100%;
                  box-sizing: border-box;
                  padding: 11px 14px;
                  border: 1px solid #e8e4dc;
                  border-radius: 3px;
                  font-family: Inter, sans-serif;
                  font-size: 0.875rem;
                  color: #4b4b4b;
                  background: #ffffff;
                  outline: none;
                  transition: border-color 200ms, box-shadow 200ms;
                "
                onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                onblur="this.style.borderColor='#e8e4dc'; this.style.boxShadow='none'"
              >
              @endif
            </div>

          </div><!-- end date/time grid -->

          <!-- Pickup Location -->
          <div style="margin-bottom: 1.125rem;">
            <label style="
              display: block;
              font-family: 'Inter Tight', Inter, sans-serif;
              font-weight: 500;
              font-size: 0.6875rem;
              letter-spacing: 0.12em;
              text-transform: uppercase;
              color: #6b6b6b;
              margin-bottom: 6px;
            ">Pickup Location</label>
            @if($locations->isNotEmpty())
            <select
              x-model="bookingForm.location"
              style="
                width: 100%;
                box-sizing: border-box;
                padding: 11px 14px;
                border: 1px solid #e8e4dc;
                border-radius: 3px;
                font-family: Inter, sans-serif;
                font-size: 0.875rem;
                color: #4b4b4b;
                background: #ffffff;
                outline: none;
                transition: border-color 200ms, box-shadow 200ms;
              "
              onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
              onblur="this.style.borderColor='#e8e4dc'; this.style.boxShadow='none'"
            >
              @foreach($locations as $loc)
              <option value="{{ $loc->name }}">{{ $loc->name }}</option>
              @endforeach
            </select>
            @else
            <input
              type="text"
              x-model="bookingForm.location"
              placeholder="Enter pickup location"
              style="
                width: 100%;
                box-sizing: border-box;
                padding: 11px 14px;
                border: 1px solid #e8e4dc;
                border-radius: 3px;
                font-family: Inter, sans-serif;
                font-size: 0.875rem;
                color: #4b4b4b;
                background: #ffffff;
                outline: none;
                transition: border-color 200ms, box-shadow 200ms;
              "
              onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
              onblur="this.style.borderColor='#e8e4dc'; this.style.boxShadow='none'"
            >
            @endif
          </div>

          <!-- Additional Notes -->
          <div style="margin-bottom: 1.25rem;">
            <label style="
              display: block;
              font-family: 'Inter Tight', Inter, sans-serif;
              font-weight: 500;
              font-size: 0.6875rem;
              letter-spacing: 0.12em;
              text-transform: uppercase;
              color: #6b6b6b;
              margin-bottom: 6px;
            ">Additional Notes</label>
            <textarea
              x-model="bookingForm.notes"
              rows="3"
              placeholder="Any special requests or questions..."
              style="
                width: 100%;
                box-sizing: border-box;
                padding: 11px 14px;
                border: 1px solid #e8e4dc;
                border-radius: 3px;
                font-family: Inter, sans-serif;
                font-size: 0.875rem;
                color: #4b4b4b;
                background: #ffffff;
                outline: none;
                resize: vertical;
                transition: border-color 200ms, box-shadow 200ms;
              "
              onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
              onblur="this.style.borderColor='#e8e4dc'; this.style.boxShadow='none'"
            ></textarea>
          </div>

          <!-- Price preview -->
          <div
            x-show="totalDays > 0"
            style="
              background: #fdf8ef;
              border: 1px solid #e8d9b0;
              border-radius: 3px;
              padding: 1rem 1.25rem;
              margin-bottom: 1.25rem;
              display: flex;
              justify-content: space-between;
              align-items: center;
              flex-wrap: wrap;
              gap: 0.5rem;
            "
          >
            <div>
              <span style="font-family:'Inter Tight',Inter,sans-serif; font-size:0.75rem; color:#9b9b9b; text-transform:uppercase; letter-spacing:0.1em;">Duration</span>
              <div style="font-family:'Inter Tight',Inter,sans-serif; font-weight:700; font-size:1.0625rem; color:#4b4b4b; margin-top:2px;">
                <span x-text="totalDays"></span> day<span x-show="totalDays !== 1">s</span>
              </div>
            </div>
            <div style="text-align:right;">
              <span style="font-family:'Inter Tight',Inter,sans-serif; font-size:0.75rem; color:#9b9b9b; text-transform:uppercase; letter-spacing:0.1em;">Estimated Total</span>
              <div style="font-family:'Inter Tight',Inter,sans-serif; font-weight:700; font-size:1.25rem; color:#bda04e; margin-top:2px;">
                RM <span x-text="totalPrice.toLocaleString('en-MY', {minimumFractionDigits:0,maximumFractionDigits:0})"></span>
              </div>
            </div>
          </div>

          <!-- Note -->
          <p style="
            font-family: Inter, sans-serif;
            font-size: 0.75rem;
            color: #9b9b9b;
            line-height: 1.6;
            margin: 0 0 1.25rem;
            font-style: italic;
          ">
            Final price subject to admin confirmation. No payment is collected online.
          </p>

          <!-- Modal footer -->
          <div style="
            padding-top: 1.125rem;
            border-top: 1px solid #e8e4dc;
          ">
            <p style="
              font-family: Inter, sans-serif;
              font-size: 0.75rem;
              color: #9b9b9b;
              margin: 0 0 1rem;
            ">
              Clicking the button below will open WhatsApp with your booking details pre-filled.
            </p>
            <button
              @click="sendWhatsApp()"
              style="
                width: 100%;
                background: #bda04e;
                color: #ffffff;
                font-family: 'Inter Tight', Inter, sans-serif;
                font-weight: 600;
                font-size: 0.8125rem;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                padding: 15px 24px;
                border: none;
                border-radius: 2px;
                cursor: pointer;
                transition: background 200ms ease;
              "
              onmouseover="this.style.background='#a08a3a'"
              onmouseout="this.style.background='#bda04e'"
            >
              Send Booking Request via WhatsApp
            </button>
          </div>

        </div><!-- end modal body -->
      </div><!-- end modal panel -->
    </div><!-- end modal overlay -->

    {{-- ============================================================ --}}
    {{-- FLOATING LIVE VEHICLE AVAILABILITY PILL (Image 2 style) --}}
    {{-- ============================================================ --}}
    <a href="#fleet" id="floating-availability-pill" class="group" style="
        position: fixed;
        bottom: 28px;
        right: 28px;
        z-index: 90;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 12px 26px;
        background: linear-gradient(135deg, #0d1726 0%, #080f1d 50%, #030712 100%);
        border: 2px solid #22c55e;
        border-radius: 9999px;
        box-shadow: 0 10px 25px -4px rgba(0, 0, 0, 0.7), 0 0 16px rgba(34, 197, 94, 0.35), 0 0 0 1px rgba(34, 197, 94, 0.2);
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    " onmouseover="this.style.transform='translateY(-3px) scale(1.02)'; this.style.borderColor='#4ade80'; this.style.boxShadow='0 14px 32px -3px rgba(0, 0, 0, 0.8), 0 0 24px rgba(34, 197, 94, 0.6), 0 0 0 1px #4ade80';" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.borderColor='#22c55e'; this.style.boxShadow='0 10px 25px -4px rgba(0, 0, 0, 0.7), 0 0 16px rgba(34, 197, 94, 0.35), 0 0 0 1px rgba(34, 197, 94, 0.2)';">
        {{-- Pulsing dot in Green --}}
        <span style="position: relative; display: inline-flex; width: 12px; height: 12px; flex-shrink: 0;">
            <span style="
                position: absolute;
                inset: -2px;
                border-radius: 50%;
                background: #22c55e;
                animation: pill-ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
                opacity: 0.8;
            "></span>
            <span style="
                position: relative;
                display: inline-block;
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background: #22c55e;
                box-shadow: 0 0 10px #22c55e, 0 0 4px #22c55e;
            "></span>
        </span>

        {{-- Text in English, fits site theme --}}
        <span style="
            font-family: 'Inter Tight', 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            white-space: nowrap;
            text-shadow: 0 1px 3px rgba(0,0,0,0.5);
        ">
            {{ $availableCars }} {{ $availableCars == 1 ? 'UNIT' : 'UNITS' }} AVAILABLE. FAST BOOKING HERE
        </span>
    </a>

    <style>
        @keyframes pill-ping {
            75%, 100% {
                transform: scale(2.4);
                opacity: 0;
            }
        }
        @media (max-width: 640px) {
            #floating-availability-pill {
                right: 14px !important;
                bottom: 18px !important;
                padding: 10px 18px !important;
                gap: 9px !important;
            }
            #floating-availability-pill span {
                font-size: 11px !important;
                letter-spacing: 0.05em !important;
            }
        }
    </style>

</body>
</html>
