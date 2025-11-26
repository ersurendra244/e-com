@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])
@section('content')
    <style>
        .breadcrumb-trail {
            font-size: 16px;
            font-family: cursive;
            font-weight: 500;
            color: #333;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 2px;
        }

        .breadcrumb-trail a {
            color: #495057;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .breadcrumb-trail a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .breadcrumb-trail span {
            color: #495057;
            margin: 0 0;
        }

        .veiw-area ul {
            list-style-type: none;
        }

        .veiw-area ul li a {
            margin: 5px 0;
            color: #495057 !important;
            text-decoration: none !important;
            transition: color 0.2s ease !important;
        }

        .veiw-area ul li a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
    <style>
        .dropdown {
            position: relative;
            /* display: inline-block; */
        }

        .dropbtn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #ffffff;
            min-width: 120px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 8px 12px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown.show .dropdown-content {
            display: block;
        }
    </style>
    <style>
        .swal-modal .form-group {
            margin-bottom: 1rem;
        }

        .swal-modal .form-label {
            display: block;
            margin-bottom: .5rem;
            font-weight: bold;
        }

        .swal-modal .form-control {
            display: block;
            width: 100%;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .swal-modal .file-input {
            width: 100%;
            box-sizing: border-box;
        }

        .swal-modal ul#swal-fileList-old {
            /* ID को सही किया */
            list-style: none;
            padding-left: 0;
            margin-top: 10px;
        }

        .swal-modal ul#swal-fileList-old li {
            /* ID को सही किया */
            background-color: #f8f9fa;
            border: 1px solid #e2e6ea;
            padding: 5px 10px;
            margin-bottom: 5px;
            border-radius: 4px;
        }

        /* एरर मैसेज के लिए स्टाइल */
        .swal-modal .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 5px;
            display: block;
        }
    </style>
    @include('admin.common.message')
    <div class="card">
        <div class="card-body">
            <div class="dropdown">
                <button class="dropbtn float-right"><i class="fas fa-ellipsis-v"></i></button>
                <div class="dropdown-content">
                    <a href="javascript:void(0)" onclick="addnew('folder')" class="text-primary">Create Folder</a>
                    <a href="javascript:void(0)" onclick="addnew('text')" class="text-primary">Create File</a>
                    <a href="javascript:void(0)" onclick="addnew('file')" class="text-primary">Upload Files</a>
                </div>
            </div>
            <div class="breadcrumb-trail">
                <a href="{{ route('admin.file_manager', null) }}">File Manager</a>
                @foreach ($breadcrumbs as $crumb)
                    <span>/</span>
                    <a href="{{ route('admin.file_manager', $crumb->id) }}">{{ $crumb->name }}</a>
                @endforeach
            </div>
            <div class="row mt-2" style="min-height: 56vh;">
                <div class="col-12 veiw-area">
                    <table class="table table-hover">
                        @foreach ($items as $item)
                            <tr>
                                <td width="80%">
                                    @if ($item->type === 'folder')
                                        {!! fileTypeIcon($item->name) !!} <a
                                            href="{{ route('admin.file_manager', $item->id) }}">{{ $item->name }}</a>
                                    @elseif(in_array(pathinfo($item->name, PATHINFO_EXTENSION), ['txt', 'html', 'php', 'js', 'css']))
                                        {!! fileTypeIcon($item->name) !!} <a href="{{ route('admin.file_manager.view', $item->id) }}"
                                            class="text-primary" target="_blank">{{ $item->name }}</a>
                                    @elseif(in_array(pathinfo($item->name, PATHINFO_EXTENSION), [
                                            'jpg',
                                            'jpeg',
                                            'png',
                                            'gif',
                                            'svg',
                                            'webp',
                                            'ico',
                                            'bmp',
                                            'tif',
                                            'tiff',
                                            'avif',
                                        ]))
                                        {!! fileTypeIcon($item->name) !!} <a href="{{ asset($item->path . $item->name) }}"
                                            class="text-primary" target="_blank">{{ $item->name }}</a>
                                    @else
                                        {!! fileTypeIcon($item->name) !!} <a href="{{ asset($item->path . $item->name) }}"
                                            class="text-primary" target="_blank">{{ $item->name }}</a>
                                    @endif
                                </td>

                                <td width="15%">
                                    {{ $item->total_size_formatted }}
                                </td>
                                <td width="5%">
                                    <div class="dropdown">
                                        <button class="dropbtn"><i class="fas fa-ellipsis-v"></i></button>
                                        <div class="dropdown-content">
                                            @if ($item->type === 'folder')
                                                <a href="{{ route('admin.file_manager', $item->id) }}"
                                                    class="text-primary">Open</a>
                                            @elseif(in_array(pathinfo($item->name, PATHINFO_EXTENSION), ['txt', 'html', 'php', 'js', 'css']))
                                                <a href="{{ route('admin.file_manager.edit', $item->id) }}"
                                                    class="text-primary" target="_blank">Edit</a>
                                            @elseif(in_array(pathinfo($item->name, PATHINFO_EXTENSION), [
                                                    'jpg',
                                                    'jpeg',
                                                    'png',
                                                    'gif',
                                                    'svg',
                                                    'webp',
                                                    'ico',
                                                    'bmp',
                                                    'tif',
                                                    'tiff',
                                                    'avif',
                                                ]))
                                                <a href="{{ asset($item->path . $item->name) }}" class="text-primary"
                                                    target="_blank">Open</a>
                                            @else
                                                <a href="{{ asset($item->path . $item->name) }}" class="text-primary"
                                                    target="_blank">Download</a>
                                            @endif
                                            {{-- Rename function changed to 'edit-item' type --}}
                                            <a href="javascript:void(0)"
                                                onclick="addnew('edit-item' , {{ $item->id }}, '{{ $item->name }}')"
                                                class="text-primary">Rename</a>
                                            <a href="javascript:void(0)"
                                                onclick="deleteData(`{{ route('admin.file_manager.delete', $item->id) }}`)"
                                                class="text-danger">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('child_scripts')
    <script>
        // notifyMessage function (as provided in previous answers)
        function notifyMessage(message, type) {
            console.log(`Notification (${type}): ${message}`);
            // Implement your actual notification system here, e.g., Toastr, custom div
            const notificationArea = document.createElement('div'); // Create a temporary div for demo
            notificationArea.id = 'temp-notification-area';
            notificationArea.style.position = 'fixed';
            notificationArea.style.top = '20px';
            notificationArea.style.right = '20px';
            notificationArea.style.padding = '10px 20px';
            notificationArea.style.backgroundColor = type === 'success' ? 'lightgreen' : (type === 'error' ? 'lightcoral' :
                'lightblue');
            notificationArea.style.color = 'white';
            notificationArea.style.borderRadius = '5px';
            notificationArea.style.zIndex = '9999';
            notificationArea.textContent = message;
            document.body.appendChild(notificationArea);
            setTimeout(() => {
                notificationArea.remove();
            }, 3000);
        }

        // The core addnew function updated for SweetAlert (old)
        function addnew(type, item_id = null, name = '') {
            let title = '';
            let formHtml = '';
            let showNameField = false;
            let showFileInput = false;

            if (type === 'folder') {
                title = 'Create New Folder';
                showNameField = true;
            } else if (type === 'text') {
                title = 'Create New File';
                showNameField = true;
            } else if (type === 'file') {
                title = 'Upload Files';
                showFileInput = true;
            } else if (type === 'edit-item') {
                title = 'Rename Item';
                showNameField = true;
            } else {
                title = 'Manage Item';
            }

            formHtml = `
                <div class="swal-form-container">
                    <input type="hidden" id="swal-parent_id-old" value="{{ $parent_id }}">
                    <input type="hidden" id="swal-item_id-old" value="${item_id || ''}">
                    <input type="hidden" id="swal-type-old" value="${type}">

                    ${showNameField ? `
                            <div class="form-group folder-field">
                                <label class="form-label" for="swal-name-old">Name</label>
                                <input type="text" class="form-control" id="swal-name-old" placeholder="Enter name" value="${name}">
                                <span id="name-error-old" class="error-message" style="display:none;"></span>
                            </div>` : ''}

                    ${showFileInput ? `
                            <div class="form-group file-field">
                                <p class="form-label mb-1">Upload Files</p>
                                <div class="input-group">
                                    <input type="file" class="form-control file-input" id="swal-file-input-old" name="files[]" multiple />
                                </div>
                                <ul id="swal-fileList-old" class="mt-2"></ul>
                                <span id="file-error-old" class="error-message" style="display:none;"></span>
                            </div>` : ''}
                </div>
            `;

            swal({
                title: title,
                content: {
                    element: "div",
                    attributes: {
                        innerHTML: formHtml
                    },
                },
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: null,
                        visible: true,
                        className: "btn btn-light",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Submit",
                        value: true,
                        visible: true,
                        className: "btn btn-primary swal-button--confirm",
                        closeModal: false,
                    }
                },
            }).then((value) => {
                if (value) {
                    const popup = document.querySelector('.swal-modal');
                    if (!popup) {
                        console.error("SweetAlert modal not found.");
                        return;
                    }

                    const currentType = popup.querySelector('#swal-type-old').value;
                    const nameInput = popup.querySelector('#swal-name-old');
                    const fileInput = popup.querySelector('#swal-file-input-old');

                    popup.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');

                    let validationErrors = {};

                    if (currentType === 'file') {
                        if (!fileInput || fileInput.files.length === 0) {
                            validationErrors.file = 'Please select a file to upload.';
                        }
                    } else { // folder, text, edit-item
                        if (!nameInput || nameInput.value.trim().length === 0) {
                            validationErrors.name = 'Name cannot be empty.';
                        }
                    }

                    if (Object.keys(validationErrors).length > 0) {
                        if (validationErrors.name) {
                            popup.querySelector('#name-error-old').textContent = validationErrors.name;
                            popup.querySelector('#name-error-old').style.display = 'block';
                        }
                        if (validationErrors.file) {
                            popup.querySelector('#file-error-old').textContent = validationErrors.file;
                            popup.querySelector('#file-error-old').style.display = 'block';
                        }
                        return;
                    }

                    const confirmButton = popup.querySelector('.swal-button--confirm');
                    if (confirmButton) {
                        confirmButton.textContent = 'Submitting...';
                        confirmButton.disabled = true;
                    }

                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('parent_id', popup.querySelector('#swal-parent_id-old').value);
                    formData.append('item_id', popup.querySelector('#swal-item_id-old').value);
                    formData.append('type', currentType);

                    if (showNameField) {
                        formData.append('name', nameInput ? nameInput.value : '');
                    }
                    if (showFileInput) {
                        Array.from(fileInput.files).forEach(file => {
                            formData.append('files[]', file);
                        });
                    }

                    let actionUrl;
                    if (currentType === 'edit-item') {
                        actionUrl = "{{ route('admin.file_manager.rename') }}";
                    } else {
                        actionUrl = "{{ route('admin.file_manager.create') }}";
                    }

                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            swal.close();
                            if (response.success) {
                                notifyMessage(response.message || 'Operation successful!', 'success');
                                location.reload();
                            } else {
                                notifyMessage(response.message || 'Operation failed!', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            swal.close();
                            let errorMessage = 'Something went wrong. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            notifyMessage(`Request failed: ${errorMessage}`, 'error');
                        }
                    });

                } else {
                    notifyMessage('Operation cancelled.', 'info');
                }
            });

            setTimeout(() => {
                const popup = document.querySelector('.swal-modal');
                if (!popup) return;

                const nameInput = popup.querySelector('#swal-name-old');
                const fileInput = popup.querySelector('#swal-file-input-old');

                if (nameInput) {
                    nameInput.addEventListener('input', () => toggleOldSwalSubmitButton(popup, type, showNameField,
                        showFileInput));
                }
                if (fileInput) {
                    fileInput.addEventListener('change', (event) => {
                        const fileListElement = popup.querySelector('#swal-fileList-old');
                        const files = event.target.files;
                        fileListElement.innerHTML = '';
                        Array.from(files).forEach((file, index) => {
                            const li = document.createElement('li');
                            li.textContent =
                                `${index + 1}. ${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
                            fileListElement.appendChild(li);
                        });
                        toggleOldSwalSubmitButton(popup, type, showNameField, showFileInput);
                    });
                }
                toggleOldSwalSubmitButton(popup, type, showNameField, showFileInput);
            }, 100);
        }

        function toggleOldSwalSubmitButton(popup, type, showNameField, showFileInput) {
            const confirmButton = popup.querySelector('.swal-button--confirm');
            if (!confirmButton) return;

            let isValid = false;
            const nameInput = popup.querySelector('#swal-name-old');
            const fileInput = popup.querySelector('#swal-file-input-old');

            if (type === 'file') {
                isValid = fileInput && fileInput.files.length > 0;
            } else {
                isValid = nameInput && nameInput.value.trim().length > 0;
            }

            confirmButton.disabled = !isValid;
        }

        // Dropdown toggle logic
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dropdown .dropbtn').forEach(button => {
                button.addEventListener('click', function(event) {
                    document.querySelectorAll('.dropdown.show').forEach(openDropdown => {
                        if (openDropdown !== this.closest('.dropdown')) {
                            openDropdown.classList.remove('show');
                        }
                    });

                    this.closest('.dropdown').classList.toggle('show');
                    event.stopPropagation(); // Prevent click from propagating to document
                });
            });

            window.addEventListener('click', function(event) {
                document.querySelectorAll('.dropdown.show').forEach(openDropdown => {
                    openDropdown.classList.remove('show');
                });
            });
        });
    </script>
@endpush
