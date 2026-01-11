<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $users = $query->latest()->paginate(20);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|exists:roles,name',
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url',
            'github_username' => 'nullable|string|max:255',
            'twitter_username' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url',
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'bio' => $validated['bio'] ?? null,
                'website' => $validated['website'] ?? null,
                'github_username' => $validated['github_username'] ?? null,
                'twitter_username' => $validated['twitter_username'] ?? null,
                'linkedin_url' => $validated['linkedin_url'] ?? null,
                'email_verified_at' => now(), // Auto-verificar usuarios creados por admin
            ]);

            $user->assignRole($validated['role']);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|exists:roles,name',
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url',
            'github_username' => 'nullable|string|max:255',
            'twitter_username' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url',
        ]);

        try {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'bio' => $validated['bio'] ?? null,
                'website' => $validated['website'] ?? null,
                'github_username' => $validated['github_username'] ?? null,
                'twitter_username' => $validated['twitter_username'] ?? null,
                'linkedin_url' => $validated['linkedin_url'] ?? null,
            ]);

            if (!empty($validated['password'])) {
                $user->update(['password' => Hash::make($validated['password'])]);
            }

            // Actualizar rol
            $user->syncRoles([$validated['role']]);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Usuario actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        // No permitir que el admin se elimine a sí mismo
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        try {
            $user->delete();

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Usuario eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }
}