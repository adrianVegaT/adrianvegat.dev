<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    /**
     * Redirigir al proveedor de autenticación
     */
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);
        
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Manejar el callback del proveedor
     */
    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Error al autenticar con ' . ucfirst($provider));
        }

        // Buscar o crear usuario
        $user = $this->findOrCreateUser($socialUser, $provider);

        // Autenticar usuario
        Auth::login($user, true);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Buscar o crear usuario basado en proveedor social
     */
    protected function findOrCreateUser($socialUser, string $provider): User
    {
        // Buscar usuario existente por provider
        $user = User::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if ($user) {
            // Actualizar información del usuario
            $user->update([
                'avatar' => $socialUser->getAvatar(),
                'name' => $socialUser->getName() ?? $user->name,
            ]);
            
            return $user;
        }

        // Buscar usuario por email
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Vincular cuenta social a usuario existente
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);

            return $user;
        }

        // Crear nuevo usuario
        $newUser = User::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            'avatar' => $socialUser->getAvatar(),
            'password' => Hash::make(Str::random(24)), // Password aleatorio
            'email_verified_at' => now(), // Auto-verificar email de OAuth
        ]);

        // Asignar rol de usuario por defecto
        $newUser->assignRole('user');

        // Extraer información adicional según el proveedor
        if ($provider === 'github') {
            $newUser->update([
                'github_username' => $socialUser->getNickname(),
                'bio' => $socialUser->user['bio'] ?? null,
            ]);
        }

        return $newUser;
    }

    /**
     * Validar que el proveedor sea válido
     */
    protected function validateProvider(string $provider): void
    {
        if (!in_array($provider, ['google', 'github'])) {
            abort(404);
        }
    }
}