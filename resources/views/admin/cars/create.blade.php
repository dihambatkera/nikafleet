@extends('layouts.admin')

@section('title', 'Add New Vehicle')

@section('content')
<div class="max-w-6xl mx-auto space-y-4">
    <!-- Breadcrumbs/Heading -->
    <div class="flex items-center gap-2 text-sm text-gray-400">
        <a href="{{ route('admin.cars.index') }}" class="hover:text-gray-600 transition-colors">Manage Vehicles</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-800 font-semibold">Add New Vehicle</span>
    </div>

    <div>
        <h1 class="text-2xl font-bold text-gray-900 leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">Register New Vehicle</h1>
        <p class="text-xs text-gray-500 mt-1">Fill in all mandatory fields (*) to register a new rental vehicle.</p>
    </div>

    <!-- Livewire Form component -->
    <livewire:admin.car-form />
</div>
@endsection
