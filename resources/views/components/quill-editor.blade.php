@props(['id' => 'editor', 'name' => 'content', 'value' => ''])

<div>
    <input type="hidden" name="{{ $name }}" id="{{ $id }}_input" value="{{ $value }}">
    <div id="{{ $id }}" style="height: 400px;" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white">{!! $value !!}</div>
</div>

@once
@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar {
        background: white;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    .ql-container {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        font-size: 16px;
    }
    .dark .ql-toolbar {
        background: #1f2937;
        border-color: #374151;
    }
    .dark .ql-container {
        background: #1f2937;
        border-color: #374151;
        color: #f3f4f6;
    }
    .dark .ql-editor.ql-blank::before {
        color: #9ca3af;
    }
    .dark .ql-stroke {
        stroke: #9ca3af;
    }
    .dark .ql-fill {
        fill: #9ca3af;
    }
    .dark .ql-picker-label {
        color: #9ca3af;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quill_{{ $id }} = new Quill('#{{ $id }}', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    ['link', 'image'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                    ['clean']
                ]
            }
        });

        // Sincronizar con el input hidden
        quill_{{ $id }}.on('text-change', function() {
            document.getElementById('{{ $id }}_input').value = quill_{{ $id }}.root.innerHTML;
        });
    });
</script>
@endpush
@endonce