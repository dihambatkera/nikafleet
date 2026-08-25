<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — NikaFleet Admin</title>
    <meta name="description" content="NikaFleet Admin Panel — Sistem Pengurusan Fleet Kereta">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- AlpineJS via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        :root {
            --sidebar-bg: #1E293B;
            --sidebar-active: #bda04e;
            --sidebar-hover: rgba(255,255,255,0.08);
            --content-bg: #F8F9FA;
        }
        body { background-color: var(--content-bg); font-family: 'Inter', sans-serif; }

        /* Sidebar */
        #admin-sidebar {
            background-color: var(--sidebar-bg);
            width: 260px;
        }
        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #94a3b8;
            transition: background 0.15s, color 0.15s;
            text-decoration: none;
            margin-bottom: 2px;
        }
        .sidebar-nav-link:hover {
            background: var(--sidebar-hover);
            color: #e2e8f0;
        }
        .sidebar-nav-link.active {
            background: var(--sidebar-active);
            color: #ffffff;
            font-weight: 600;
        }
        .sidebar-nav-link svg {
            flex-shrink: 0;
            width: 18px;
            height: 18px;
        }
        .sidebar-section-label {
            padding: 16px 14px 6px;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #475569;
        }

        /* Main content */
        #main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            background-color: var(--content-bg);
            transition: margin-left 0.3s;
        }
        @media (max-width: 1023px) {
            #main-wrapper { margin-left: 0; }
        }

        /* Topbar */
        #admin-topbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 30;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }

        /* Notification bell */
        .bell-btn {
            position: relative;
            padding: 8px;
            border-radius: 8px;
            color: #6b7280;
            transition: background 0.15s, color 0.15s;
            cursor: pointer;
            border: none;
            background: none;
        }
        .bell-btn:hover { background: #f3f4f6; color: #111827; }
        .bell-dot {
            position: absolute;
            top: 6px; right: 6px;
            width: 8px; height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
        }

        /* Card */
        .admin-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 1px 2px rgba(0,0,0,0.04);
            border: 1px solid #f1f5f9;
            overflow: hidden;
        }

        /* Flash message */
        .flash-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.875rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .flash-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.875rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Grey image skeleton pulse */
        @keyframes pulse-grey {
            0%, 100% { background-color: #f1f5f9; }
            50% { background-color: #cbd5e1; }
        }
        .animate-pulse-placeholder {
            animation: pulse-grey 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Form touch targets and full-width on mobile */
        @media (max-width: 640px) {
            form input, form select, form textarea, .form-input {
                width: 100% !important;
                min-height: 44px !important;
            }
            form button, form .btn-primary, form .btn-outline, form .btn-green {
                width: 100% !important;
                min-height: 44px !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
        }

        /* Modals full screen on mobile */
        @media (max-width: 639px) {
            .fixed.inset-0.z-50 > div, .fixed.inset-0.z-\[100\] > div, .fixed.inset-0.z-40 > div {
                max-width: 100% !important;
                width: 100% !important;
                height: 100% !important;
                min-height: 100vh !important;
                border-radius: 0px !important;
                margin: 0 !important;
            }
            .fixed.inset-0.z-50 > div > div {
                height: 100% !important;
                border-radius: 0px !important;
            }
        }

        /* Mobile bottom navigation spacing */
        @media (max-width: 1023px) {
            body {
                padding-bottom: 70px !important;
            }
        }

        /* Responsive tables to card-stack converter styling */
        @media (max-width: 767px) {
            .admin-card table:not(.fc-scrollgrid-sync-table):not(.fc-col-header-table):not(.fc-scrollgrid) {
                display: block !important;
                width: 100% !important;
            }
            .admin-card table:not(.fc-scrollgrid-sync-table):not(.fc-col-header-table):not(.fc-scrollgrid) thead {
                display: none !important;
            }
            .admin-card table:not(.fc-scrollgrid-sync-table):not(.fc-col-header-table):not(.fc-scrollgrid) tbody {
                display: block !important;
                width: 100% !important;
            }
            .admin-card table:not(.fc-scrollgrid-sync-table):not(.fc-col-header-table):not(.fc-scrollgrid) tr {
                display: flex !important;
                flex-direction: column !important;
                padding: 1rem !important;
                border-bottom: 8px solid #f1f5f9 !important;
                background: #ffffff !important;
                margin-bottom: 0.5rem !important;
                border-radius: 12px !important;
                box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
            }
            .admin-card table:not(.fc-scrollgrid-sync-table):not(.fc-col-header-table):not(.fc-scrollgrid) td {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 0.5rem 0 !important;
                border: none !important;
                width: 100% !important;
                text-align: right !important;
            }
            .admin-card table:not(.fc-scrollgrid-sync-table):not(.fc-col-header-table):not(.fc-scrollgrid) td::before {
                content: attr(data-label) !important;
                font-weight: 700 !important;
                text-transform: uppercase !important;
                font-size: 0.72rem !important;
                color: #64748b !important;
                margin-right: 1rem !important;
                text-align: left !important;
            }
            .admin-card table:not(.fc-scrollgrid-sync-table):not(.fc-col-header-table):not(.fc-scrollgrid) td[data-label=""]::before,
            .admin-card table:not(.fc-scrollgrid-sync-table):not(.fc-col-header-table):not(.fc-scrollgrid) td[data-label="Tindakan"]::before,
            .admin-card table:not(.fc-scrollgrid-sync-table):not(.fc-col-header-table):not(.fc-scrollgrid) td[data-label="TINDAKAN"]::before,
            .admin-card table:not(.fc-scrollgrid-sync-table):not(.fc-col-header-table):not(.fc-scrollgrid) td[data-label="Gambar Utama"]::before {
                display: none !important;
            }
            .admin-card table:not(.fc-scrollgrid-sync-table):not(.fc-col-header-table):not(.fc-scrollgrid) td[data-label=""] {
                justify-content: center !important;
            }
        }

        /* ── FLASH MESSAGES ──────────────────────────────── */
        .flash-success, .flash-error {
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            padding: 0.875rem 1rem;
            border-radius: 0.625rem;
            font-size: 0.8125rem;
            font-weight: 500;
        }
        .flash-success {
            background: rgba(16,185,129,0.08);
            border: 1px solid rgba(16,185,129,0.25);
            color: #065f46;
        }
        .flash-error {
            background: rgba(239,68,68,0.06);
            border: 1px solid rgba(239,68,68,0.2);
            color: #991b1b;
        }
    </style>

    @stack('styles')
</head>
<body class="h-full antialiased" x-data="{ sidebarOpen: false, sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" x-init="$watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val))">

<!-- ═══════════════════════════════════════════════════
     MOBILE OVERLAY
══════════════════════════════════════════════════════ -->
<div x-show="sidebarOpen"
     x-transition:enter="transition-opacity ease-linear duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-40 bg-black/50 lg:hidden"
     @click="sidebarOpen = false">
</div>

<!-- ═══════════════════════════════════════════════════
     SIDEBAR
══════════════════════════════════════════════════════ -->
<aside id="admin-sidebar"
       class="fixed inset-y-0 left-0 z-50 flex flex-col transform transition-all duration-300 ease-in-out lg:translate-x-0"
       :class="{
           'translate-x-0': sidebarOpen,
           '-translate-x-full lg:translate-x-0': !sidebarOpen,
           'lg:w-[70px]': sidebarCollapsed,
           'lg:w-[250px]': !sidebarCollapsed
       }"
       :style="sidebarCollapsed ? 'width: 70px' : ''">

    <!-- Logo -->
    <div class="flex items-center gap-3 px-5 py-5 flex-shrink-0" style="border-bottom: 1px solid rgba(255,255,255,0.07)">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background: linear-gradient(135deg, #bda04e, #a08a3a); box-shadow: 0 2px 8px rgba(189,160,78,0.4)">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.34.34M5 16H4M19 16h1M15 16H9m10 0l-2-6H9l-2 6"/>
            </svg>
        </div>
        <div x-show="!sidebarCollapsed" x-transition.opacity>
            <p class="text-sm font-bold text-white leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">NikaFleet</p>
            <p class="text-[10px]" style="color: #64748b">Admin Panel</p>
        </div>
        <!-- Desktop sidebar toggle -->
        <button @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('sidebarCollapsed', sidebarCollapsed)"
                class="hidden lg:flex ml-auto p-1.5 rounded-lg transition-colors hover:bg-white/10"
                style="color: #64748b"
                :title="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'">
            <svg class="w-4 h-4 transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-3 py-3">

        <p class="sidebar-section-label">Main</p>

        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>


        <p class="sidebar-section-label">Operations</p>

        <a href="{{ route('admin.bookings.index') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.bookings.index') || request()->routeIs('admin.bookings.show') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Active Bookings
        </a>

        <a href="{{ route('admin.bookings.create') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.bookings.create') ? 'active' : '' }}"
           style="padding-left: 38px; font-size: 0.8125rem;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Booking
        </a>

        <p class="sidebar-section-label">Fleet</p>

        <a href="{{ route('admin.cars.index') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.34.34M5 16H4M19 16h1M15 16H9m10 0l-2-6H9l-2 6"/>
            </svg>
            Manage Vehicles
        </a>

        <p class="sidebar-section-label">Configuration</p>

        <a href="{{ route('admin.locations.index') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Locations
        </a>

        <a href="{{ route('admin.time-slots.index') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.time-slots.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Time Slots
        </a>

        <a href="{{ route('admin.whatsapp.index') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.whatsapp.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            WhatsApp Template
        </a>

        @if(auth()->user() && auth()->user()->isSuperAdmin())
        <p class="sidebar-section-label">Admin</p>

        <a href="{{ route('admin.users.index') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            User Management
        </a>
        @endif

        <p class="sidebar-section-label">System</p>

        <a href="{{ route('admin.settings.index') }}"
           class="sidebar-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Settings
        </a>
    </nav>

    <!-- Admin info + Logout at bottom -->
    <div class="flex-shrink-0 px-3 py-3" style="border-top: 1px solid rgba(255,255,255,0.07)">
        <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl" style="background: rgba(255,255,255,0.04)">
            <img src="{{ auth()->user()->avatar_url }}"
                 alt="{{ auth()->user()->name }}"
                 class="w-8 h-8 rounded-full object-cover flex-shrink-0"
                 style="box-shadow: 0 0 0 2px rgba(59,130,246,0.5)">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate leading-tight">{{ auth()->user()->name }}</p>
                <p class="text-xs truncate" style="color: #64748b">Administrator</p>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                        class="p-1.5 rounded-lg transition-colors"
                        style="color: #64748b"
                        title="Log Out"
                        onmouseover="this.style.color='#ef4444';this.style.background='rgba(239,68,68,0.1)'"
                        onmouseout="this.style.color='#64748b';this.style.background='transparent'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- ═══════════════════════════════════════════════════
     MAIN WRAPPER
══════════════════════════════════════════════════════ -->
<div id="main-wrapper" :style="sidebarCollapsed ? 'margin-left: 70px' : ''" class="transition-all duration-300">

    <!-- ─── TOP BAR ─────────────────────────────────── -->
    <header id="admin-topbar">
        <!-- Left: hamburger (mobile) + breadcrumb -->
        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <button @click="sidebarCollapsed = !sidebarCollapsed"
                    class="hidden lg:flex p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors"
                    title="Toggle sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Breadcrumb -->
            <nav class="hidden sm:flex items-center gap-1.5 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-gray-600 transition-colors font-medium">NikaFleet</a>
                <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="font-semibold text-gray-800">@yield('title', 'Dashboard')</span>
            </nav>

            <!-- Mobile page title -->
            <span class="sm:hidden font-bold text-gray-800 text-base">@yield('title', 'Dashboard')</span>
        </div>

        <!-- Right: actions -->
        <div class="flex items-center gap-2">
            <!-- Notification Bell (future) -->
            <button class="bell-btn" title="Notifications" onclick="window.location.href='{{ route('admin.dashboard') }}'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @if(isset($badgeCount) && $badgeCount > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full flex items-center justify-center min-w-[15px] h-3.5 shadow-sm">
                        {{ $badgeCount }}
                    </span>
                @else
                    <span class="bell-dot"></span>
                @endif
            </button>

            <!-- View Site -->
            <a href="{{ route('home') }}" target="_blank"
               class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                View Site
            </a>

            <!-- Admin name badge -->
            <div class="hidden sm:flex items-center gap-2 pl-2 border-l border-gray-200 ml-1">
                <img src="{{ auth()->user()->avatar_url }}" alt=""
                     class="w-7 h-7 rounded-full object-cover">
                <span class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }}</span>
            </div>
        </div>
    </header>

    <!-- ─── PAGE CONTENT ──────────────────────────────── -->
    <main class="p-6">
        {{-- Flash messages --}}
        @if(session('success'))
            <div class="flash-success">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flash-error">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- ─── FOOTER ─────────────────────────────────── -->
    <footer class="px-6 py-4 text-center" style="border-top: 1px solid #f1f5f9;">
        <p class="text-xs text-gray-400">&copy; {{ date('Y') }} NikaFleet &mdash; <em>Your trusted car rental partner.</em></p>
    </footer>
</div>

@stack('scripts')

<!-- Mobile Bottom Navigation Bar (Dashboard | Kereta | Tempahan | Kewangan) -->
<div class="lg:hidden fixed bottom-0 left-0 right-0 bg-slate-900 border-t border-slate-800 z-[45] px-4 py-2.5 flex items-center justify-around text-slate-400">
    <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('admin.dashboard') ? 'text-yellow-400 font-semibold' : 'text-slate-400' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span class="text-[10px]">Dashboard</span>
    </a>
    <a href="{{ route('admin.cars.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('admin.cars.*') ? 'text-yellow-400 font-semibold' : 'text-slate-400' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.34.34M5 16H4M19 16h1M15 16H9m10 0l-2-6H9l-2 6"/>
        </svg>
        <span class="text-[10px]">Kereta</span>
    </a>
    <a href="{{ route('admin.bookings.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('admin.bookings.*') ? 'text-yellow-400 font-semibold' : 'text-slate-400' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span class="text-[10px]">Tempahan</span>
    </a>
    <a href="{{ route('admin.whatsapp.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('admin.whatsapp.*') ? 'text-yellow-400 font-semibold' : 'text-slate-400' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
        <span class="text-[10px]">WhatsApp</span>
    </a>
</div>

<!-- Toast Notification System -->
<div x-data="toastComponent()"
     @toast.window="add($event.detail)"
     class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 w-full max-w-sm pointer-events-none"
     x-cloak>
    <template x-for="toast in toasts" :key="toast.id">
        <div class="p-4 rounded-xl shadow-lg border text-white flex items-start gap-3 pointer-events-auto transition-all duration-300 transform translate-y-0"
             :class="{
                'bg-green-600 border-green-700': toast.type === 'success',
                'bg-red-600 border-red-700': toast.type === 'error',
                'bg-amber-500 border-amber-600': toast.type === 'warning',
                'bg-blue-600 border-blue-700': toast.type === 'info'
             }"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <!-- Icon -->
            <div class="flex-shrink-0 text-lg">
                <template x-if="toast.type === 'success'"><span>✅</span></template>
                <template x-if="toast.type === 'error'"><span>❌</span></template>
                <template x-if="toast.type === 'warning'"><span>⚠️</span></template>
                <template x-if="toast.type === 'info'"><span>ℹ️</span></template>
            </div>
            <!-- Body -->
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold" x-text="toast.message"></p>
            </div>
            <!-- Close button -->
            <button @click="remove(toast.id)" class="text-white hover:text-gray-200 p-0.5 rounded-lg hover:bg-white/10 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>

<script>
function toastComponent() {
    return {
        toasts: [],
        add(detail) {
            const id = Date.now() + Math.random().toString(36).substr(2, 9);
            const type = detail.type || 'info';
            const message = detail.message || '';
            const duration = type === 'success' ? 4000 : (type === 'error' ? 6000 : (type === 'warning' ? null : 4000));
            
            this.toasts.push({ id, type, message });
            
            if (duration) {
                setTimeout(() => {
                    this.remove(id);
                }, duration);
            }
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        },
        init() {
            @if(session('success'))
                this.add({ type: 'success', message: '{{ session('success') }}' });
            @endif
            @if(session('error'))
                this.add({ type: 'error', message: '{{ session('error') }}' });
            @endif
            @if(session('warning'))
                this.add({ type: 'warning', message: '{{ session('warning') }}' });
            @endif
            @if(session('info'))
                this.add({ type: 'info', message: '{{ session('info') }}' });
            @endif
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const setupTables = () => {
        document.querySelectorAll('table').forEach(table => {
            // Skip calendars and non-standard tables
            if (table.closest('.fc') || table.classList.contains('fc-scrollgrid') || table.classList.contains('fc-col-header') || table.classList.contains('fc-scrollgrid-sync-table')) return;
            const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText.trim());
            if (headers.length === 0) return;
            table.querySelectorAll('tbody tr').forEach(row => {
                row.querySelectorAll('td').forEach((td, index) => {
                    if (headers[index] && !td.getAttribute('data-label')) {
                        td.setAttribute('data-label', headers[index]);
                    }
                });
            });
        });
    };
    setupTables();
    
    // Livewire compatibility
    document.addEventListener('livewire:navigated', setupTables);
    document.addEventListener('livewire:updated', setupTables);
    window.addEventListener('livewire:load', setupTables);
});
</script>
@livewireScripts
@stack('scripts')
</body>
</html>
