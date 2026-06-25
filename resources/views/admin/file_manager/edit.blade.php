<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Melody Admin</title>
    <link rel="stylesheet" href="{{ asset('admin/vendors/iconfonts/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}" />
    <style>
        body,
        html {
            overflow: hidden !important;
            padding-right: 0 !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <a href="{{ roleRoute('file_manager', $item->parent_id) }}"
                            class="btn btn-sm btn-dark float-right"><i class="fa fa-arrow-circle-left"></i></a>
                        @if($mode == 'edit')
                        <a href="javascript:void(0)" onclick="saveContent();"
                            class="btn btn-sm btn-primary float-right mr-2"><i class="fa fa-save"></i></a>
                        @endif
                        <lavel>{{ $item->name }}</lavel>
                    </div>
                    <div class="col-12">
                        <div id="editor" style="min-height: 85vh; border: 1px solid #ddd;"></div>
                        <textarea name="content" id="content" class="d-none">{{ $content }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/vendor.bundle.addons.js') }}"></script>
    <script src="{{ asset('notify.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/monaco-editor@0.34.1/min/vs/loader.js"></script>

    <script>
        require.config({
            paths: {
                'vs': 'https://cdn.jsdelivr.net/npm/monaco-editor@0.34.1/min/vs'
            }
        });

        let editorInstance = null;
        const type = `{{ $mode }}` != 'edit' ? true : false;

        require(['vs/editor/editor.main'], function() {
            const content = document.getElementById('content').value;

            editorInstance = monaco.editor.create(document.getElementById('editor'), {
                value: content,
                language: getLanguage("{{ $extension ?? 'txt' }}"),
                theme: 'vs-light',
                automaticLayout: true,
                readOnly: type,
                scrollBeyondLastLine: true,
                minimap: {
                    enabled: false
                }
            });

            document.getElementById('editor').style.height = `90vh`;
            editorInstance.layout();

            // --- यहाँ नया कोड जोड़ें ---
            editorInstance.addAction({
                id: 'save-file', // इस एक्शन का एक यूनिक ID
                label: 'Save File', // कमांड पैलेट में दिखने वाला टेक्स्ट
                keybindings: [
                    monaco.KeyMod.CtrlCmd | monaco.KeyCode
                    .KeyS // Ctrl+S (Windows/Linux) या Cmd+S (macOS)
                ],
                precondition: null, // इस एक्शन को हमेशा सक्षम रखें
                contextMenuGroupId: 'navigation', // कमांड पैलेट में ग्रुपिंग (वैकल्पिक)
                contextMenuOrder: 1, // कमांड पैलेट में ऑर्डर (वैकल्पिक)
                run: function(editor) {
                    // जब Ctrl+S दबाया जाता है तो यह फ़ंक्शन चलेगा
                    if (!type) { // केवल तभी सेव करें जब editor readOnly ना हो
                        saveContent(); // आपकी मौजूदा saveContent फ़ंक्शन को कॉल करें
                        console.log('Ctrl+S pressed. Saving content...');
                    } else {
                        console.log('Editor is read-only. Cannot save.');
                    }
                    return null; // कोई परिणाम नहीं लौटाता है
                }
            });
            // --- नया कोड यहाँ समाप्त होता है ---

            editorInstance.addAction({
                id: 'format-document-context-menu',
                label: 'Format Document',
                keybindings: [
                    monaco.KeyMod.Shift | monaco.KeyMod.Alt | monaco.KeyCode.KeyF
                ],
                contextMenuGroupId: '1_modification',
                contextMenuOrder: 1.6,
                precondition: '!editorReadonly',
                run: async function(editor) {
                    if (!type) {
                        try {
                            const formatted = await editor.getAction('editor.action.formatDocument')
                                .run();
                            // Check if formatting actually occurred
                            if (formatted) {
                                console.log('Document formatted successfully via action.');
                                notifyMessage('Code formatted successfully!', 'success');
                            } else {
                                console.warn(
                                    'Format action ran, but no changes were made. (Perhaps already formatted or no formatter for this language/content).'
                                    );
                                notifyMessage(
                                    'Formatting action completed, but no changes. (Is content already formatted or language supported?)',
                                    'info');
                            }

                        } catch (e) {
                            console.error('Failed to format document:', e);
                            notifyMessage(
                                'Failed to format code. Ensure language formatter is available.',
                                'error');
                        }
                    } else {
                        console.log('Editor is read-only. Cannot format.');
                        notifyMessage('Cannot format code in read-only mode.', 'info');
                    }
                    return null;
                }
            });
            // --- Additional Debugging for Language Services ---
            // This will log available formatters for the current language
            setTimeout(() => { // Give Monaco a moment to register language services
                const providers = monaco.languages.getDocumentFormattingEditProviders(editorLanguage);
                console.log(`Formatting providers for "${editorLanguage}":`, providers.length > 0 ?
                    providers : 'None found');
                if (editorLanguage === 'html' && providers.length === 0) {
                    console.warn(
                        'CRITICAL: No HTML formatting provider found. This is unexpected for standard Monaco setup.'
                        );
                }
            }, 1000); // Wait 1 second to ensure services are registered

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

        // Save button click handler (यह फ़ंक्शन आपका मौजूदा सेव फ़ंक्शन है)
        function saveContent() {
            const content = editorInstance.getValue();
            fetch("{{ roleRoute('file_manager.file_save', $item->id) }}", {
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

    <script>
        function notifyMessage(message, type) {
            $.notify(message, {
                className: type,
                closeOnClick: true,
                globalPosition: 'top right'
            });
        }
    </script>
</body>

</html>
