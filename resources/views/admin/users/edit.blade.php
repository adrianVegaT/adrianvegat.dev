<x-admin-layout>
    <x-slot name="title">Editar Usuario</x-slot>

    <div class="max-w-4xl">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Dashboard</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('admin.users.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Usuarios</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 dark:text-white">Editar</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Editar Usuario</h1>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Información Básica</h2>

                <div class="space-y-4">
                    <!-- Avatar Preview -->
                    <div class="flex items-center gap-4">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Avatar actual</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">El avatar se genera automáticamente desde el nombre</p>
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
                    </div>

                    <!-- Password -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nueva Contraseña
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('password') border-red-500 @enderror"
                            >
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Dejar en blanco para no cambiar</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirmar Contraseña
                            </label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white"
                            >
                        </div>
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Rol <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="role" 
                            id="role"
                            class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('role') border-red-500 @enderror"
                            required
                        >
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role', $user->roles->first()?->name) === $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            <strong>Admin:</strong> Acceso completo al sistema.
                            <strong>Author:</strong> Puede crear y gestionar contenido.
                            <strong>User:</strong> Solo puede comentar.
                        </p>
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Biografía
                        </label>
                        <textarea 
                            name="bio" 
                            id="bio" 
                            rows="3"
                            class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white @error('bio') border-red-500 @enderror"
                            placeholder="Breve descripción del usuario"
                        >{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Enlaces Sociales</h2>

                <div class="space-y-4">
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

                    <!-- GitHub -->
                    <div>
                        <label for="github_username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Usuario de GitHub
                        </label>
                        <div class="flex items-center">
                            <span class="px-4 py-2 bg-gray-100 dark:bg-gray-800 border border-r-0 border-gray-300 dark:border-gray-700 rounded-l-lg text-gray-600 dark:text-gray-400">
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
                            <span class="px-4 py-2 bg-gray-100 dark:bg-gray-800 border border-r-0 border-gray-300 dark:border-gray-700 rounded-l-lg text-gray-600 dark:text-gray-400">
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
                </div>
            </div>

            <!-- User Stats -->
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Estadísticas</h2>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->projects->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Proyectos</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->posts->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Posts</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->comments->count() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Comentarios</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->created_at->diffForHumans() }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Miembro desde</p>
                    </div>
                </div>
            </div>

             <!-- Actions -->
            <div class="flex items-center justify-between">
                @if($user->id !== auth()->id())
                    <button 
                        type="button"
                        onclick="if(confirm('¿Estás seguro de eliminar este usuario?')) document.getElementById('deleteForm').submit()"
                        class="px-6 py-2 text-sm font-medium text-red-600 dark:text-red-400 bg-white dark:bg-gray-900 border border-red-300 dark:border-red-800 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                    >
                        Eliminar Usuario
                    </button>
                @else
                    <div></div>
                @endif

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-lg transition-colors">
                        Actualizar Usuario
                    </button>
                </div>
            </div>
        </form>

        <!-- Delete Form (fuera del form principal) -->
        @if($user->id !== auth()->id())
            <form id="deleteForm" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>
</x-admin-layout>