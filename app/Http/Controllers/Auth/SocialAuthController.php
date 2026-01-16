<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class SocialAuthController extends Controller
{
    /**
     * Redirigir al proveedor de autenticación
     */
    public function redirect(string $provider)
    {
        try {
            $this->validateProvider($provider);
            
            \Log::info("Redirigiendo a {$provider} para autenticación");
            
            return Socialite::driver($provider)->redirect();
            
        } catch (Exception $e) {
            \Log::error("Error en redirect de {$provider}: " . $e->getMessage());
            
            return redirect()->route('login')
                ->with('error', 'Error al conectar con ' . ucfirst($provider) . '. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Manejar el callback del proveedor
     */
    public function callback(string $provider)
    {
        try {
            $this->validateProvider($provider);
            
            \Log::info("Callback recibido de {$provider}");
            \Log::info("Request params: ", request()->all());

            $socialUser = Socialite::driver($provider)->user();
            
            \Log::info("Usuario obtenido de {$provider}", [
                'id' => $socialUser->getId(),
                'email' => $socialUser->getEmail(),
                'name' => $socialUser->getName(),
            ]);

            // Buscar o crear usuario
            $user = $this->findOrCreateUser($socialUser, $provider);

            // Autenticar usuario
            Auth::login($user, true);

            \Log::info("Usuario autenticado correctamente: {$user->email}");

            // Redirigir según el rol del usuario
            if ($user->hasRole(['admin', 'author'])) {
                return redirect()->route('admin.dashboard')
                    ->with('success', '¡Bienvenido de nuevo, ' . $user->name . '!');
            }

            return redirect()->route('home')
                ->with('success', '¡Bienvenido, ' . $user->name . '!');

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            \Log::error("Invalid state exception en {$provider}: " . $e->getMessage());
            
            return redirect()->route('login')
                ->with('error', 'Sesión expirada. Por favor, intenta iniciar sesión nuevamente.');

        } catch (Exception $e) {
            \Log::error("Error en callback de {$provider}: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());
            
            return redirect()->route('login')
                ->with('error', 'Error al autenticar con ' . ucfirst($provider) . '. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Buscar o crear usuario basado en proveedor social
     */
    protected function findOrCreateUser($socialUser, string $provider): User
    {
        try {
            \Log::info("Buscando usuario con provider={$provider} y provider_id={$socialUser->getId()}");
            
            // Buscar usuario existente por provider
            $user = User::where('provider', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();

            if ($user) {
                \Log::info("Usuario encontrado por provider: {$user->email}");
                
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
                \Log::info("Usuario encontrado por email: {$user->email}, vinculando provider");
                
                // Vincular cuenta social a usuario existente
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]);

                return $user;
            }

            \Log::info("Creando nuevo usuario desde {$provider}");

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
            
            \Log::info("Nuevo usuario creado: {$newUser->email} con rol 'user'");

            // Extraer información adicional según el proveedor
            if ($provider === 'github' && isset($socialUser->user)) {
                $newUser->update([
                    'github_username' => $socialUser->getNickname(),
                    'bio' => $socialUser->user['bio'] ?? null,
                ]);
            }

            return $newUser;
            
        } catch (Exception $e) {
            \Log::error("Error al buscar/crear usuario: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Validar que el proveedor sea válido
     */
    protected function validateProvider(string $provider): void
    {
        if (!in_array($provider, ['google', 'github'])) {
            \Log::error("Provider inválido: {$provider}");
            abort(404, 'Proveedor de autenticación no soportado');
        }
    }
}