@extends('layouts.admin')

@section('title', 'WhatsApp Template')

@section('content')
<div class="p-6 md:p-8">

    <div class="mb-7">
        <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">WhatsApp Booking Template</h1>
        <p class="text-sm text-gray-500 mt-1">Customise the message sent to NikaFleet when a customer clicks "Book" on the landing page.</p>
    </div>

    @if(session('success'))
        <div class="flash-success mb-5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="waTemplate()">

        {{-- LEFT: Editor --}}
        <div class="lg:col-span-2">
            <div class="admin-card">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Template Editor</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Use the variables listed on the right — they will be replaced with actual booking data.</p>
                </div>
                <form method="POST" action="{{ route('admin.whatsapp.update') }}">
                    @csrf
                    <div class="px-6 py-5">
                        <textarea name="template"
                                  id="wa-template"
                                  rows="20"
                                  x-model="template"
                                  @input="updatePreview()"
                                  class="w-full px-4 py-3 border rounded-xl text-sm font-mono text-gray-800 focus:outline-none resize-none"
                                  style="border-color: #e5e7eb; line-height: 1.7;"
                                  onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                                  onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">{{ $template }}</textarea>
                    </div>
                    <div class="px-6 pb-5 flex gap-3">
                        <button type="submit"
                                class="flex-1 py-2.5 text-sm font-bold text-white rounded-xl transition-all"
                                style="background: linear-gradient(135deg, #bda04e, #a08a3a);">
                            Save Template
                        </button>
                        <button type="button"
                                onclick="if(confirm('Reset to default template?')) document.getElementById('reset-form').submit()"
                                class="px-5 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                            Reset Default
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- RIGHT: Variables + Preview --}}
        <div class="space-y-5">

            {{-- Variables --}}
            <div class="admin-card">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-bold text-gray-900 text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">Available Variables</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Click to copy to clipboard</p>
                </div>
                <div class="px-5 py-4 space-y-2">
                    @foreach($variables as $var => $description)
                    <div class="flex items-start justify-between gap-2 group">
                        <button type="button"
                                onclick="copyToClipboard('{{ $var }}')"
                                class="font-mono text-xs px-2 py-1 rounded-lg transition-all hover:ring-1 flex-shrink-0"
                                style="background: rgba(189,160,78,0.1); color:#bda04e;"
                                onmouseover="this.style.ringColor='#bda04e'"
                                title="Click to copy">
                            {{ $var }}
                        </button>
                        <span class="text-xs text-gray-400 mt-1">{{ $description }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Preview --}}
            <div class="admin-card">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-bold text-gray-900 text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">Preview</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Sample substitution</p>
                </div>
                <div class="px-5 py-4">
                    <pre id="wa-preview"
                         class="text-xs text-gray-600 whitespace-pre-wrap font-mono leading-relaxed"
                         style="max-height: 360px; overflow-y: auto;"></pre>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden reset form --}}
<form id="reset-form" method="POST" action="{{ route('admin.whatsapp.update') }}">
    @csrf
    <input type="hidden" name="template" value="{{ \App\Http\Controllers\Admin\WhatsAppTemplateController::getDefault() }}">
</form>

<script>
function waTemplate() {
    return {
        template: document.getElementById('wa-template')?.value || '',
        init() {
            this.updatePreview();
        },
        updatePreview() {
            const sampleData = {
                '{customer_name}':   'Ahmad Razif',
                '{customer_phone}':  '+60 11-1234 5678',
                '{vehicle_name}':    'Perodua Myvi 1.5 AV',
                '{price_per_day}':   '95',
                '{pickup_date}':     '28 Aug 2026',
                '{pickup_time}':     '10:00 AM',
                '{return_date}':     '30 Aug 2026',
                '{return_time}':     '10:00 AM',
                '{duration}':        '2 days',
                '{location}':        'Rawang, Selangor',
                '{estimated_price}': '190',
            };

            let preview = this.template;
            for (const [key, val] of Object.entries(sampleData)) {
                preview = preview.replaceAll(key, val);
            }

            const previewEl = document.getElementById('wa-preview');
            if (previewEl) previewEl.textContent = preview;
        }
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Temporary feedback
        const btn = event.target;
        const original = btn.textContent;
        btn.textContent = '✓ copied';
        btn.style.background = 'rgba(16,185,129,0.1)';
        btn.style.color = '#059669';
        setTimeout(() => {
            btn.textContent = original;
            btn.style.background = 'rgba(189,160,78,0.1)';
            btn.style.color = '#bda04e';
        }, 1500);
    });
}
</script>
@endsection
