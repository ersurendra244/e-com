@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])
@section('content')
    @include('admin.common.message')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <a href="{{ route('admin.file_manager', $item->parent_id) }}" class="btn btn-sm btn-dark float-right"><i class="fa fa-arrow-circle-left"></i></a>
                    <a href="javascript:void(0)" onclick="saveContent();" class="btn btn-sm btn-primary float-right mr-2"><i class="fa fa-save"></i></a>
                    <lavel>{{ $item->name }}</lavel>
                </div>
                <div class="col-12">
                    <div id="editor" style="min-height: 90vh; border: 1px solid #ddd;"></div>
                    <textarea name="content" id="content" class="d-none">{{ $content }}</textarea>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('child_scripts')
    <script src="https://cdn.jsdelivr.net/npm/monaco-editor@0.34.1/min/vs/loader.js"></script>

    <script>
        require.config({
            paths: {
                'vs': 'https://cdn.jsdelivr.net/npm/monaco-editor@0.34.1/min/vs'
            }
        });

        let editorInstance = null;

        require(['vs/editor/editor.main'], function() {
            const content = document.getElementById('content').value;

            editorInstance = monaco.editor.create(document.getElementById('editor'), {
                value: content,
                language: getLanguage("{{ $extension ?? 'txt' }}"),
                theme: 'vs-light',
                automaticLayout: true,
                readOnly: false,
                scrollBeyondLastLine: false,
                minimap: {
                    enabled: false
                }
            });

            const lineHeight = editorInstance.getOption(monaco.editor.EditorOption.lineHeight);
            const lineCount = editorInstance.getModel().getLineCount();
            const height = lineHeight * lineCount + 20;
            document.getElementById('editor').style.height = `${height}px`;
            editorInstance.layout();
        });

        function getLanguage(extension) {
            switch (extension.toLowerCase()) {
                case 'php':
                    return 'php';
                case 'js':
                    return 'javascript';
                case 'html':
                    return 'html';
                case 'css':
                    return 'css';
                case 'json':
                    return 'json';
                case 'txt':
                    return 'plaintext';
                default:
                    return 'plaintext';
            }
        }

        // Save button click handler
        function saveContent() {
            const content = editorInstance.getValue();
            fetch("{{ route('admin.file_manager.file_save', $item->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    content: content
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    notifyMessage(data.message, 'success');
                } else {
                    notifyMessage(data.message, 'error');
                }
            })
            .catch(error => {
                alert('Error saving file.');
                notifyMessage(error, 'error');
            });
        }
    </script>
@endpush
