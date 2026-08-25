<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kesilapan Teknikal (500) — NikaFleet</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a; /* Slate 900 */
        }
        .font-display {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center space-y-6">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center shadow-lg shadow-teal-500/20">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.34.34M5 16H4M19 16h1M15 16H9m10 0l-2-6H9l-2 6"/>
                </svg>
            </div>
        </div>

        <!-- 500 Status Code Graphic -->
        <div class="relative">
            <h1 class="font-display text-9xl font-black text-slate-800 tracking-widest select-none">500</h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-3xl">🛠️</span>
            </div>
        </div>

        <!-- Text Content -->
        <div class="space-y-3">
            <h2 class="font-display text-2xl font-extrabold text-white">Ralat Sistem Server</h2>
            <p class="text-slate-400 text-sm leading-relaxed">Maaf, berlaku kesilapan teknikal. Sila hubungi kami di +60 11-6824 7599</p>
        </div>

        <!-- Action Button -->
        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="/" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition-all shadow-md active:scale-95 border border-slate-700">
                Kembali Utama
            </a>
            <a href="https://wa.me/601168247599?text=Salam%20NikaFleet%21%20Saya%20mengalami%20ralat%20teknikal%20sistem%20500." target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-teal-600 hover:bg-teal-500 text-white font-bold rounded-xl transition-all shadow-lg shadow-teal-500/20 active:scale-95">
                📲 Hubungi WhatsApp
            </a>
        </div>
    </div>
</body>
</html>
