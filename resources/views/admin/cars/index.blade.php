@extends('layouts.admin')

@section('title', 'Manage Vehicles')

@section('content')
<div class="space-y-4">
    <!-- Breadcrumbs/Heading -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">Manage Vehicles</h1>
            <p class="text-xs text-gray-500 mt-1">Register, edit, filter and manage all NikaFleet rental vehicles.</p>
        </div>
    </div>

    <!-- Livewire component -->
    <livewire:admin.car-list />
</div>
@endsection
