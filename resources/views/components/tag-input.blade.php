@props(['name' => 'tags', 'value' => '', 'existingTags' => []])

<div x-data="tagInput({{ json_encode($existingTags) }}, '{{ $value }}')" class="relative">
    <div class="w-full min-h-[42px] px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus-within:ring-2 focus-within:ring-primary-500 focus-within:border-transparent">
        <!-- Selected Tags -->
        <div class="flex flex-wrap gap-2 mb-2" x-show="selectedTags.length > 0">
            <template x-for="(tag, index) in selectedTags" :key="index">
                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium border-2 transition-all hover:scale-105"
                    :style="`border-color: ${tag.color}; background-color: ${tag.color}10; color: ${tag.color}`">
                    <span x-text="'#' + tag.name"></span>
                    <button type="button" @click="removeTag(index)" class="ml-2 hover:opacity-70">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </span>
            </template>
        </div>

        <!-- Input -->
        <input 
            type="text"
            x-model="inputValue"
            @keydown.enter.prevent="addTag"
            @keydown.comma.prevent="addTag"
            @input="filterTags"
            @focus="showSuggestions = true"
            @blur="hideSuggestionsDelayed"
            placeholder="Escribe y presiona Enter o coma..."
            class="w-full bg-transparent border-0 focus:ring-0 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-sm p-0"
        >

        <!-- Hidden Input -->
        <input type="hidden" :name="name" :value="getTagsString()">
    </div>

    <!-- Suggestions Dropdown -->
    <div x-show="showSuggestions && filteredTags.length > 0" 
         x-transition
         class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg max-h-60 overflow-auto">
        <template x-for="tag in filteredTags" :key="tag.id">
            <button 
                type="button"
                @mousedown.prevent="selectSuggestion(tag)"
                class="w-full flex items-center px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
            >
                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium"
                    :style="`background-color: ${tag.color}20; color: ${tag.color}`">
                    <span x-text="'#' + tag.name"></span>
                </span>
                <span class="ml-2 text-xs text-gray-500 dark:text-gray-400" x-text="`(${tag.posts_count || 0} posts)`"></span>
            </button>
        </template>
    </div>

    <!-- Help Text -->
    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
        Escribe un tag y presiona <kbd class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">Enter</kbd> o <kbd class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">,</kbd> para agregarlo. Click en sugerencias para seleccionar.
    </p>
</div>

@once
@push('scripts')
<script>
function tagInput(existingTags, initialValue) {
    return {
        name: '{{ $name }}',
        existingTags: existingTags,
        selectedTags: [],
        inputValue: '',
        showSuggestions: false,
        filteredTags: [],
        hideTimeout: null,
        
        init() {
            // Parse initial value
            if (initialValue) {
                const tags = initialValue.split(',').map(t => t.trim()).filter(t => t);
                tags.forEach(tagName => {
                    const existing = this.existingTags.find(t => t.name.toLowerCase() === tagName.toLowerCase());
                    if (existing) {
                        this.selectedTags.push(existing);
                    } else {
                        // Crear tag temporal con color aleatorio
                        this.selectedTags.push({
                            name: tagName,
                            color: this.getRandomColor()
                        });
                    }
                });
            }
            this.filterTags();
        },
        
        filterTags() {
            if (this.inputValue.length === 0) {
                this.filteredTags = this.existingTags.filter(tag => 
                    !this.selectedTags.find(st => st.name === tag.name)
                );
            } else {
                this.filteredTags = this.existingTags.filter(tag => 
                    tag.name.toLowerCase().includes(this.inputValue.toLowerCase()) &&
                    !this.selectedTags.find(st => st.name === tag.name)
                );
            }
        },
        
        addTag() {
            const tagName = this.inputValue.trim();
            if (!tagName) return;
            
            // Check if already selected
            if (this.selectedTags.find(t => t.name.toLowerCase() === tagName.toLowerCase())) {
                this.inputValue = '';
                return;
            }
            
            // Check if exists in database
            const existing = this.existingTags.find(t => t.name.toLowerCase() === tagName.toLowerCase());
            
            if (existing) {
                this.selectedTags.push(existing);
            } else {
                // New tag
                this.selectedTags.push({
                    name: tagName,
                    color: this.getRandomColor()
                });
            }
            
            this.inputValue = '';
            this.showSuggestions = false;
            this.filterTags();
        },
        
        selectSuggestion(tag) {
            // Cancelar cualquier timeout pendiente
            if (this.hideTimeout) {
                clearTimeout(this.hideTimeout);
            }
            
            this.selectedTags.push(tag);
            this.inputValue = '';
            this.showSuggestions = false;
            this.filterTags();
        },
        
        hideSuggestionsDelayed() {
            // Dar tiempo para que el click en la sugerencia se procese
            this.hideTimeout = setTimeout(() => {
                this.showSuggestions = false;
            }, 200);
        },
        
        removeTag(index) {
            this.selectedTags.splice(index, 1);
            this.filterTags();
        },
        
        getTagsString() {
            return this.selectedTags.map(t => t.name).join(', ');
        },
        
        getRandomColor() {
            const colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'];
            return colors[Math.floor(Math.random() * colors.length)];
        }
    }
}
</script>
@endpush
@endonce