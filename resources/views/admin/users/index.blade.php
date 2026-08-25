@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="p-6 md:p-8" x-data="usersApp()">

    <div class="flex items-center justify-between mb-7">
        <div>
            <h1 class="text-2xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">User Management</h1>
            <p class="text-sm text-gray-500 mt-1">Manage admin and superadmin accounts. Superadmin access only.</p>
        </div>
        <button @click="showCreate = true"
                class="inline-flex items-center gap-2 text-sm font-semibold text-white px-5 py-2.5 rounded-xl"
                style="background: linear-gradient(135deg, #bda04e, #a08a3a);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Admin User
        </button>
    </div>

    @if(session('success'))
        <div class="flash-success mb-5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flash-error mb-5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="flash-error mb-5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <div>
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        </div>
    @endif

    {{-- Create Modal --}}
    <div x-show="showCreate" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.4);" @click.self="showCreate = false">
        <div class="admin-card w-full max-w-md" @click.stop>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Create Admin User</h2>
                <button @click="showCreate = false" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Full Name *</label>
                        <input type="text" name="name" required placeholder="Admin name"
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email *</label>
                        <input type="email" name="email" required placeholder="admin@nikafleet.com"
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Password *</label>
                        <input type="password" name="password" required placeholder="Minimum 8 characters"
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Role *</label>
                        <select name="role" required
                                class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none bg-white"
                                style="border-color: #e5e7eb;"
                                onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                            <option value="admin">Admin</option>
                            <option value="superadmin">Superadmin</option>
                        </select>
                    </div>
                </div>
                <div class="px-6 pb-5 flex gap-3">
                    <button type="submit" class="flex-1 py-2.5 text-sm font-bold text-white rounded-xl" style="background: #bda04e;">Create User</button>
                    <button type="button" @click="showCreate = false" class="px-5 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Reset Password Modal --}}
    <div x-show="showReset" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.4);" @click.self="showReset = false">
        <div class="admin-card w-full max-w-sm" @click.stop>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">Reset Password</h2>
                <button @click="showReset = false" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form :action="'/admin/users/' + resetId + '/reset-password'" method="POST">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <p class="text-xs text-gray-500">Setting new password for: <strong x-text="resetName" class="text-gray-800"></strong></p>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">New Password *</label>
                        <input type="password" name="new_password" required placeholder="Minimum 8 characters"
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Confirm Password *</label>
                        <input type="password" name="new_password_confirmation" required placeholder="Repeat password"
                               class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-800 focus:outline-none"
                               style="border-color: #e5e7eb;"
                               onfocus="this.style.borderColor='#bda04e'; this.style.boxShadow='0 0 0 3px rgba(189,160,78,0.12)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    </div>
                </div>
                <div class="px-6 pb-5 flex gap-3">
                    <button type="submit" class="flex-1 py-2.5 text-sm font-bold text-white rounded-xl" style="background: #ef4444;">Reset Password</button>
                    <button type="button" @click="showReset = false" class="px-5 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="admin-card">
        @if($users->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <p class="text-sm font-semibold text-gray-700">No Admin Users</p>
                <p class="text-xs text-gray-400 mt-1 mb-5">Add the first admin or superadmin account.</p>
                <button @click="showCreate = true" class="text-sm font-semibold text-white px-5 py-2.5 rounded-xl" style="background: #bda04e;">Add First Admin</button>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">User</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Role</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Joined</th>
                            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors {{ $user->id === auth()->id() ? 'ring-1 ring-amber-200 bg-amber-50/30' : '' }}">
                            <td class="px-5 py-4" data-label="User">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar_url }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0" alt="{{ $user->name }}">
                                    <div>
                                        <div class="font-semibold text-gray-800">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="text-xs text-amber-600 font-medium">(you)</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4" data-label="Role">
                                @if($user->hasRole('superadmin'))
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold ring-1" style="background:rgba(189,160,78,0.12); color:#bda04e; ring-color:rgba(189,160,78,0.3);">Superadmin</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 ring-1 ring-blue-200">Admin</span>
                                @endif
                            </td>
                            <td class="px-5 py-4" data-label="Status">
                                @if($user->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-500 ring-1 ring-red-200">Disabled</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-xs text-gray-400" data-label="Joined">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4 text-right" data-label="Actions">
                                <div class="flex items-center justify-end gap-2 flex-wrap">
                                    {{-- Toggle status --}}
                                    @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle', $user->id) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="text-xs font-medium px-3 py-1.5 rounded-lg transition-colors"
                                                style="{{ $user->is_active ? 'color:#ef4444;background:rgba(239,68,68,0.08)' : 'color:#10b981;background:rgba(16,185,129,0.08)' }}">
                                            {{ $user->is_active ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>
                                    @endif

                                    {{-- Reset Password --}}
                                    <button @click="openReset({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                            class="text-xs font-medium text-gray-500 hover:text-gray-800 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                                        Reset PW
                                    </button>

                                    {{-- Delete --}}
                                    @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Permanently delete this admin user?')"
                                                class="text-xs font-medium text-red-400 hover:text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>
function usersApp() {
    return {
        showCreate: {{ $errors->any() ? 'true' : 'false' }},
        showReset: false,
        resetId: null,
        resetName: '',
        openReset(id, name) {
            this.resetId   = id;
            this.resetName = name;
            this.showReset = true;
        }
    }
}
</script>
@endsection
