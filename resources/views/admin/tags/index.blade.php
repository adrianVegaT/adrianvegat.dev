<x-admin-layout>
    <x-slot name="title">Tags</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Tags</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Gestiona los tags del blog</p>
            </div>
            <button onclick="openModal()" class="inline-flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Tag
            </button>
        </div>

        <!-- Tags Grid -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex flex-wrap gap-3">
                @forelse($tags as $tag)
                    <div class="group relative inline-flex items-center px-4 py-2 rounded-lg border-2 transition-all hover:scale-105" style="border-color: {{ $tag->color }}; background-color: {{ $tag->color }}10;">
                        <span class="text-sm font-medium" style="color: {{ $tag->color }}">
                            #{{ $tag->name }}
                        </span>
                        <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">
                            ({{ $tag->posts_count }})
                        </span>
                        
                        <!-- Actions -->
                        <div class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity flex gap-1">
                            <button 
                                onclick='editTag(@json($tag))'
                                class="w-6 h-6 flex items-center justify-center bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 shadow-sm"
                                title="Editar"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este tag?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-6 h-6 flex items-center justify-center bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 shadow-sm" title="Eliminar">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="w-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay tags</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comienza creando un nuevo tag.</p>
                        <div class="mt-6">
                            <button onclick="openModal()" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 dark:hover:bg-primary-500 text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Nuevo Tag
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if($tags->hasPages())
            <div class="mt-6">
                {{ $tags->links() }}
            </div>
        @endif

        <!-- Modal -->
        <div id="tagModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75" onclick="closeModal()"></div>

                <div class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form action="{{ route('admin.tags.store') }}" method="POST" id="tagForm">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modalTitle">Nuevo Tag</h3>
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
                                    placeholder="Laravel"
                                    required
                                    oninput="updatePreview()"
                                >
                            </div>

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
                                    oninput="updatePreview()"
                                >
                            </div>

                            <!-- Preview -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Vista Previa
                                </label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <div class="inline-flex items-center px-4 py-2 rounded-lg border-2" id="tagPreview" style="border-color: #3B82F6; background-color: #3B82F610;">
                                        <span class="text-sm font-medium" id="tagPreviewText" style="color: #3B82F6">
                                            #Laravel
                                        </span>
                                    </div>
                                </div>
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
            document.getElementById('tagModal').classList.remove('hidden');
            document.getElementById('tagForm').action = "{{ route('admin.tags.store') }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('modalTitle').textContent = 'Nuevo Tag';
            document.getElementById('submitButton').textContent = 'Crear';
            
            // Reset form
            document.getElementById('tagForm').reset();
            document.getElementById('color').value = '#3B82F6';
            updatePreview();
        }

        function closeModal() {
            document.getElementById('tagModal').classList.add('hidden');
        }

        function editTag(tag) {
            document.getElementById('tagModal').classList.remove('hidden');
            document.getElementById('tagForm').action = `/admin/tags/${tag.id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('modalTitle').textContent = 'Editar Tag';
            document.getElementById('submitButton').textContent = 'Actualizar';
            
            // Fill form
            document.getElementById('name').value = tag.name;
            document.getElementById('color').value = tag.color;
            updatePreview();
        }

        function updatePreview() {
            const name = document.getElementById('name').value || 'Laravel';
            const color = document.getElementById('color').value;
            const preview = document.getElementById('tagPreview');
            const text = document.getElementById('tagPreviewText');
            
            preview.style.borderColor = color;
            preview.style.backgroundColor = color + '10';
            text.style.color = color;
            text.textContent = '#' + name;
        }
    </script>
</x-admin-layout>