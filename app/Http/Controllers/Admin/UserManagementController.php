<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'superadmin']))
            ->latest()
            ->get();

        $roles = Role::whereIn('name', ['admin', 'superadmin'])->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => ['required', Password::min(8)->mixedCase()->numbers()],
            'role'      => 'required|in:admin,superadmin',
        ]);

        $user = User::create([
            'name'               => $request->name,
            'email'              => $request->email,
            'password'           => Hash::make($request->password),
            'role'               => $request->role,
            'is_active'          => true,
            'email_verified_at'  => now(),
        ]);

        $user->assignRole($request->role);

        return back()->with('success', "Admin user \"{$user->name}\" created successfully.");
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Protect the last superadmin
        if ($user->isSuperAdmin() && $request->role !== 'superadmin') {
            $superAdminCount = User::whereHas('roles', fn($q) => $q->where('name', 'superadmin'))->count();
            if ($superAdminCount <= 1) {
                return back()->withErrors(['role' => 'Cannot downgrade the last superadmin account.']);
            }
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,superadmin',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        // Sync Spatie role
        $user->syncRoles([$request->role]);

        return back()->with('success', "User \"{$user->name}\" updated.");
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Cannot disable yourself
        if ($user->id === auth()->id()) {
            return back()->withErrors(['general' => 'You cannot disable your own account.']);
        }

        // Cannot disable the last active superadmin
        if ($user->isSuperAdmin()) {
            $activeSuperAdmins = User::whereHas('roles', fn($q) => $q->where('name', 'superadmin'))
                ->where('is_active', true)
                ->count();
            if ($activeSuperAdmins <= 1) {
                return back()->with('error', 'Cannot disable the last active superadmin.');
            }
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $label = $user->is_active ? 'enabled' : 'disabled';
        return back()->with('success', "User \"{$user->name}\" has been {$label}.");
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'new_password' => ['required', Password::min(8)->mixedCase()->numbers(), 'confirmed'],
        ]);

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', "Password for \"{$user->name}\" has been reset.");
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->isSuperAdmin()) {
            $superAdminCount = User::whereHas('roles', fn($q) => $q->where('name', 'superadmin'))->count();
            if ($superAdminCount <= 1) {
                return back()->with('error', 'Cannot delete the last superadmin account.');
            }
        }

        $user->delete();
        return back()->with('success', "User \"{$user->name}\" deleted.");
    }
}
