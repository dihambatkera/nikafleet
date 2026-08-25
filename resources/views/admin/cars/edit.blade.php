@extends('layouts.admin')

@section('title', 'Edit Vehicle — ' . $car->name)

@section('content')
<div class="max-w-6xl mx-auto space-y-4">
    <!-- Breadcrumbs/Heading -->
    <div class="flex items-center gap-2 text-sm text-gray-400">
        <a href="{{ route('admin.cars.index') }}" class="hover:text-gray-600 transition-colors">Manage Vehicles</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-800 font-semibold">Edit Vehicle</span>
    </div>

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">Edit Vehicle &mdash; {{ $car->name }}</h1>
            <p class="text-xs text-gray-500 mt-1">Update vehicle details, images, or set rental availability blocks.</p>
        </div>
        <a href="{{ route('admin.cars.show', $car->id) }}" 
           class="inline-flex items-center gap-1.5 px-3 py-2 border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-xl font-semibold text-xs transition-all shadow-sm">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            View Details
        </a>
    </div>

    <!-- Livewire Form component -->
    <livewire:admin.car-form :car="$car" />
</div>
@endsection
