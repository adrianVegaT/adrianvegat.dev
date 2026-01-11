<x-admin-layout>
    <x-slot name="title">Categorías</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Categorías</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Gestiona las categorías del blog</p>
            </div>
            <button onclick="openModal()" class="inline-flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva Categoría
            </button>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories as $category)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $category->color }}20;">
                                @if($category->icon)
                                    <span class="text-lg">{{ $category->icon }}</span>
                                @else
                                    <svg class="w-6 h-6" style="color: {{ $category->color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $category->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $category->slug }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-400' : 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-400' }}">
                            {{ $category->is_active ? 'Activa' : 'Inactiva' }}
                        </span>
                    </div>

                    @if($category->description)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $category->description }}</p>
                    @endif

                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-800">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $category->projects_count + $category->posts_count }} elementos
                        </span>
                        <div class="flex items-center gap-2">
                            <button 
                                onclick='editCategory(@json($category))'
                                class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay categorías</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comienza creando una nueva categoría.</p>
                    <div class="mt-6">
                        <button onclick="openModal()" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nueva Categoría
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Modal -->
        <div id="categoryModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75" onclick="closeModal()"></div>

                <div class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form action="{{ route('admin.categories.store') }}" method="POST" id="categoryForm">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modalTitle">Nueva Categoría</h3>
                        </div>

                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name"
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white"
                                    required
                                >
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Descripción
                                </label>
                                <textarea 
                                    name="description" 
                                    id="description"
                                    rows="3"
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white"
                                ></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Color <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="color" 
                                        name="color" 
                                        id="color"
                                        value="#3B82F6"
                                        class="w-full h-10 px-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        required
                                    >
                                </div>

                                <div>
                                    <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Icono (Emoji)
                                    </label>
                                    <input 
                                        type="text" 
                                        name="icon" 
                                        id="icon"
                                        class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-gray-900 dark:text-white"
                                        placeholder="💻"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="is_active" 
                                        id="is_active"
                                        value="1"
                                        checked
                                        class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                                    >
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Categoría activa</span>
                                </label>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 flex justify-end gap-3">
                            <button 
                                type="button"
                                onclick="closeModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                            >
                                Cancelar
                            </button>
                            <button 
                                type="submit"
                                id="submitButton"
                                class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 rounded-lg transition-colors"
                            >
                                Crear
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
            document.getElementById('categoryForm').action = "{{ route('admin.categories.store') }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('modalTitle').textContent = 'Nueva Categoría';
            document.getElementById('submitButton').textContent = 'Crear';
            
            // Reset form
            document.getElementById('categoryForm').reset();
            document.getElementById('color').value = '#3B82F6';
            document.getElementById('is_active').checked = true;
        }

        function closeModal() {
            document.getElementById('categoryModal').classList.add('hidden');
        }

        function editCategory(category) {
            document.getElementById('categoryModal').classList.remove('hidden');
            document.getElementById('categoryForm').action = `/admin/categories/${category.id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('modalTitle').textContent = 'Editar Categoría';
            document.getElementById('submitButton').textContent = 'Actualizar';
            
            // Fill form
            document.getElementById('name').value = category.name;
            document.getElementById('description').value = category.description || '';
            document.getElementById('color').value = category.color;
            document.getElementById('icon').value = category.icon || '';
            document.getElementById('is_active').checked = category.is_active;
        }
    </script>
</x-admin-layout>