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

    @include('admin.common.message')
    <div class="card">
        <div class="card">
            <div class="card-body">
                <div class="dropdown">
                    <button class="dropbtn float-right"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-content">
                        <a href="javascript:void(0)" onclick="addnew('folder')" class="text-primary">New Folder</a>
                        <a href="javascript:void(0)" onclick="addnew('file')" class="text-primary">New File</a>
                        <a href="javascript:void(0)" onclick="addnew('image')" class="text-primary">Upload Image</a>
                        <a href="javascript:void(0)" onclick="addnew('text')" class="text-primary">Text Document</a>
                    </div>
                </div>
                <div class="breadcrumb-trail">
                    <a href="{{ route('admin.file_manager', null) }}">File Manager</a>
                    @foreach ($breadcrumbs as $crumb)
                        <span>/</span>
                        <a href="{{ route('admin.file_manager', $crumb->id) }}">{{ $crumb->name }}</a>
                    @endforeach
                </div>
                <div class="row mt-2">
                    <div class="col-12 veiw-area">
                        <table class="table table-hover">
                            @foreach ($items as $item)
                                <tr>
                                    <td width="80%">
                                        @if ($item->type === 'folder')
                                            📁 <a href="{{ route('admin.file_manager', $item->id) }}">{{ $item->name }}</a>
                                        @elseif($item->type === 'image')
                                            🖼️ <a href="{{ asset($item->path . $item->name) }}" target="_blank">{{ $item->name }}</a>
                                        @else
                                            📄 <a href="{{ asset($item->path . $item->name) }}" target="_blank">{{ $item->name }}</a>
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
                                                    <a href="{{ route('admin.file_manager', $item->id) }}" class="text-primary">Open</a>
                                                @elseif($item->type === 'image')
                                                    <a href="{{ asset($item->path . $item->name) }}" target="_blank" class="text-primary">View</a>
                                                @else
                                                    <a href="{{ asset($item->path . $item->name) }}" target="_blank" class="text-primary">Download</a>
                                                @endif
                                                <a href="javascript:void(0)" onclick="addnew('folder' , {{ $item->id }}, '{{ $item->name }}')" class="text-primary">Rename</a>
                                                <a href="javascript:void(0)" onclick="addnew('file')" class="text-danger">Delete</a>
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
    </div>

    {{-- Modal for adding new folder or file --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="manage-form-label"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header py-3 bg-primary">
                    <h5 class="modal-title text-white" id="manage-form-label">Add New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="manage-form" action="{{ route('admin.file_manager.create') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                            <input type="hidden" name="item_id" id="item_id" value="">
                            <input type="hidden" name="type" id="type" value="">
                            <div class="col-md-12 folder">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter name" value="">

                                </div>
                            </div>
                            <div class="col-md-12 image">
                                <p class="form-label mb-1">Upload Images</p>
                                <div class="form-group mb-0">
                                    <div class="input-group">
                                        <input type="file" class="form-control image-input" name="images[]" multiple
                                            accept="image/*" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 my-2 image">
                                <div class="preview-container d-flex flex-wrap gap-2 mt-2">

                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary submit">Submit</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('child_scripts')
    <script>
        $(document).ready(function() {
            toggleSubmitButton(); // Initial check

            // On input in #name field
            $(document).on('input', '#name', function() {
                toggleSubmitButton();
            });

            // On file input change
            $(document).on('change', '.image-input', function(event) {
                const input = event.target;
                const files = input.files;
                const $container = $(input).closest('.row').find('.preview-container');
                $container.empty();
                Array.from(files).forEach(file => {
                    $container.css({
                        border: '1px solid #e0e0ef',
                        borderRadius: '2px',
                    });
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    $(img).css({
                        width: '75px',
                        height: '75px',
                        border: '1px solid #ddd',
                        borderRadius: '5px',
                        margin: '5px',
                    });
                    img.onload = () => URL.revokeObjectURL(img.src);
                    $container.append(img);
                });
                toggleSubmitButton();
            });

        });

        function addnew(type, item_id = null, name = '') {
            $(".error-message").remove();
            $('#manage-form')[0].reset();
            $('#type').val(type);
            $('#item_id').val(item_id);
            $('#name').val(name);
            $('.image-input').val('');
            $('.preview-container').empty();
            $('.preview-container').css({
                border: 'none',
                borderRadius: '0',
            });

            if (type === 'folder' || type === 'file' || type === 'text') {
                $('.image').hide();
                $('.folder').show();
            } else if (type === 'image' || item_id === null) {
                $('.folder').hide();
                $('.image').show();
            }

            $('#manage-form-label').text('Add New ' + type.charAt(0).toUpperCase() + type.slice(1));
            $('#exampleModal').modal('show');
            $('#manage-form').find('.submit').prop('disabled', true);
        }

        function toggleSubmitButton() {
            const currentType = $('#type').val();
            let isValid = false;

            if (currentType === 'image') {
                // Only image is required
                const fileInput = $('.image:visible').find('.image-input')[0];
                const imageSelected = fileInput && fileInput.files.length > 0;
                isValid = imageSelected;
            } else {
                // For folder, file, or text — only name required
                const nameFilled = $('#name').val().trim().length > 0;
                isValid = nameFilled;
            }

            $('#manage-form').find('.submit').prop('disabled', !isValid);
        }
        // $('#manage-form').submit(function(e) {
        //     console.log("Submitting form with type =", $('#type').val());
        // });
    </script>
    <script>
        document.addEventListener('click', function(e) {
            const dropdown = e.target.closest('.dropdown');

            // Close all other dropdowns
            document.querySelectorAll('.dropdown').forEach(el => {
                if (el !== dropdown) el.classList.remove('show');
            });

            if (e.target.matches('.dropbtn') || e.target.closest('.dropbtn')) {
                if (dropdown) dropdown.classList.toggle('show');
            } else {
                // Click outside dropdown closes all
                document.querySelectorAll('.dropdown').forEach(el => el.classList.remove('show'));
            }
        });
    </script>
@endpush
