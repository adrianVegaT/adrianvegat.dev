<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-950 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mi Perfil</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Gestiona tu información personal y configuración de cuenta</p>
            </div>

            <div class="space-y-6">
                <!-- Profile Information -->
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Información del Perfil</h2>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Avatar -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Foto de Perfil
                            </label>
                            <div class="flex items-center gap-6">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full">
                                <div class="flex-1">
                                    <input 
                                        type="file" 
                                        name="avatar" 
                                        id="avatar"
                                        accept="image/*"
                                        class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('avatar') border-red-500 @enderror"
                                    >
                                    @error('avatar')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">JPG, PNG o WEBP. Máximo 2MB.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name', $user->name) }}"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('name') border-red-500 @enderror"
                                required
                            >
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('email') border-red-500 @enderror"
                                required
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            @if ($user->email_verified_at)
                                <p class="mt-1 text-sm text-green-600 dark:text-green-400">✓ Email verificado</p>
                            @else
                                <p class="mt-1 text-sm text-yellow-600 dark:text-yellow-400">⚠ Email sin verificar</p>
                            @endif
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Biografía
                            </label>
                            <textarea 
                                name="bio" 
                                id="bio" 
                                rows="4"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('bio') border-red-500 @enderror"
                                placeholder="Cuéntanos sobre ti..."
                            >{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Website -->
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sitio Web
                            </label>
                            <input 
                                type="url" 
                                name="website" 
                                id="website" 
                                value="{{ old('website', $user->website) }}"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('website') border-red-500 @enderror"
                                placeholder="https://ejemplo.com"
                            >
                            @error('website')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Social Links -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- GitHub -->
                            <div>
                                <label for="github_username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Usuario de GitHub
                                </label>
                                <div class="flex items-center">
                                    <span class="px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-r-0 border-gray-300 dark:border-gray-700 rounded-l-lg text-gray-600 dark:text-gray-400 text-sm">
                                        github.com/
                                    </span>
                                    <input 
                                        type="text" 
                                        name="github_username" 
                                        id="github_username" 
                                        value="{{ old('github_username', $user->github_username) }}"
                                        class="flex-1 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-r-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('github_username') border-red-500 @enderror"
                                        placeholder="usuario"
                                    >
                                </div>
                                @error('github_username')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Twitter -->
                            <div>
                                <label for="twitter_username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Usuario de Twitter/X
                                </label>
                                <div class="flex items-center">
                                    <span class="px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-r-0 border-gray-300 dark:border-gray-700 rounded-l-lg text-gray-600 dark:text-gray-400 text-sm">
                                        @
                                    </span>
                                    <input 
                                        type="text" 
                                        name="twitter_username" 
                                        id="twitter_username" 
                                        value="{{ old('twitter_username', $user->twitter_username) }}"
                                        class="flex-1 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-r-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('twitter_username') border-red-500 @enderror"
                                        placeholder="usuario"
                                    >
                                </div>
                                @error('twitter_username')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- LinkedIn -->
                        <div>
                            <label for="linkedin_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                URL de LinkedIn
                            </label>
                            <input 
                                type="url" 
                                name="linkedin_url" 
                                id="linkedin_url" 
                                value="{{ old('linkedin_url', $user->linkedin_url) }}"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('linkedin_url') border-red-500 @enderror"
                                placeholder="https://linkedin.com/in/usuario"
                            >
                            @error('linkedin_url')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            @if (session('status') === 'profile-updated')
                                <p class="text-sm text-green-600 dark:text-green-400">Perfil actualizado exitosamente.</p>
                            @endif
                            <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-lg transition-colors">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Update Password -->
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Actualizar Contraseña</h2>

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Contraseña Actual
                            </label>
                            <input 
                                type="password" 
                                name="current_password" 
                                id="current_password"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('current_password', 'updatePassword') border-red-500 @enderror"
                            >
                            @error('current_password', 'updatePassword')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nueva Contraseña
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('password', 'updatePassword') border-red-500 @enderror"
                            >
                            @error('password', 'updatePassword')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirmar Nueva Contraseña
                            </label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white"
                            >
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            @if (session('status') === 'password-updated')
                                <p class="text-sm text-green-600 dark:text-green-400">Contraseña actualizada exitosamente.</p>
                            @endif
                            <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-lg transition-colors">
                                Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Delete Account -->
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-red-200 dark:border-red-900 p-6">
                    <h2 class="text-xl font-semibold text-red-600 dark:text-red-400 mb-2">Eliminar Cuenta</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                        Una vez eliminada tu cuenta, todos tus datos serán borrados permanentemente. Esta acción no se puede deshacer.
                    </p>

                    <button 
                        type="button"
                        onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                        class="px-6 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 dark:hover:bg-red-500 rounded-lg transition-colors"
                    >
                        Eliminar Cuenta
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75" onclick="document.getElementById('deleteModal').classList.add('hidden')"></div>

            <div class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">¿Estás seguro?</h3>
                    </div>

                    <div class="px-6 py-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Esta acción no se puede deshacer. Todos tus proyectos, posts y comentarios serán eliminados permanentemente.
                        </p>

                        <div>
                            <label for="delete_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirma tu contraseña para continuar
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="delete_password"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-gray-900 dark:text-white @error('password', 'userDeletion') border-red-500 @enderror"
                                placeholder="Contraseña"
                            >
                            @error('password', 'userDeletion')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 flex justify-end gap-3">
                        <button 
                            type="button"
                            onclick="document.getElementById('deleteModal').classList.add('hidden')"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 dark:hover:bg-red-500 rounded-lg transition-colors"
                        >
                            Eliminar mi cuenta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>