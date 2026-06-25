@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])
@section('content')
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
            right: 65px;
            top: -1px;
            background-color: #ffffff;
            min-width: 100px;
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
        <div class="card-body">
            <a href="{{ roleRoute('subcategory') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
            <a href="{{ roleRoute('subcategory.form_view', $subcategory->slug) }}"
                class="btn btn-sm btn-warning float-right mr-2">View Form</a>
            @can('menu create')
                <a href="javascript:void(0)" onclick="addnew()" class="btn btn-sm btn-primary float-right mr-2">Add New</a>
            @endcan
            <h3 class="card-title">{{ $title }}</h3>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Options</th>
                                    <th>Required</th>
                                    <th>R. Cls.</th>
                                    <th>F. Cls.</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    @canany(['menu edit', 'menu delete'])
                                        <th style="width: 10%">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($form_fields as $key => $value)
                                    <tr>
                                        <td>{{ $value->field_label ?? 'N/A' }}</td>
                                        <td>{{ $value->field_name ?? 'N/A' }}</td>
                                        <td>{{ $value->field_type ?? 'N/A' }}</td>

                                        @php
                                            $opts = $value->field_options ?? [];
                                            $shown = array_slice($opts, 0, 3);
                                        @endphp

                                        <td title="{{ implode(', ', $opts) }}">
                                            {{ implode(', ', $shown) }}
                                            @if (count($opts) > 3)
                                                ... <small class="text-muted">(+{{ count($opts) - 3 }} more)</small>
                                            @endif
                                        </td>

                                        <td>{{ $value->is_required ? 'Yes' : 'No' }}</td>
                                        <td>{{ $value->row_class ?? '' }}</td>
                                        <td>{{ $value->field_class ?? '' }}</td>
                                        <td>{{ $value->order }}</td>

                                        <td>
                                            @if ($value->status == 1)
                                                <span class="text-success">Active</span>
                                            @else
                                                <span class="text-danger">Inactive</span>
                                            @endif
                                        </td>

                                        @canany(['menu edit', 'menu delete'])
                                            <td>
                                                <div class="p-2 bd-highlight">
                                                    <div class="dropdown">
                                                        <button class="dropbtn text-center">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-content">
                                                            @can('menu edit')
                                                                <a href="javascript:void(0)" onclick="addnew({{ $value->id }})"
                                                                    class="text-primary">
                                                                    Edit
                                                                </a>
                                                            @endcan

                                                            @can('menu delete')
                                                                <a href="javascript:void(0)"
                                                                    onclick="deleteData('{{ roleRoute('subcategory.form_fields_delete', $value->id) }}')"
                                                                    class="text-danger">
                                                                    Delete
                                                                </a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header py-3 bg-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Add New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="manageForm" action="{{ roleRoute('subcategory.form_fields_save') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="edit_id" name="edit_id" value="">
                            <input type="hidden" id="subcategory_id" name="subcategory_id"
                                value="{{ $subcategory->id ?? '' }}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="field_label">Field Label</label>
                                    <input type="text" class="form-control" id="field_label" name="field_label"
                                        placeholder="Enter field label" value="">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="field_name">Field Name</label>
                                    <input type="text" class="form-control" id="field_name" name="field_name"
                                        placeholder="Enter field name" value="">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="field_type">Field Type</label>
                                    <select class="form-control" name="field_type" id="field_type">
                                        <option value="">--select--</option>
                                        <option value="text">Text</option>
                                        <option value="textarea">Textarea</option>
                                        <option value="select">Select</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="radio">Radio</option>
                                        <option value="number">Number</option>
                                        <option value="date">Date</option>
                                        <option value="file">File</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6" id="options_box" style="display:none;">
                                <div class="form-group">
                                    <label class="form-label" for="field_options">Options (comma separated)</label>
                                    <input type="text" class="form-control" id="field_options" name="field_options"
                                        placeholder="Ex: Red, Blue, Green" value="">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="is_required">Is Required</label>
                                    <select name="is_required" class="form-control" id="is_required">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="row_class">Row Class</label>
                                    <input name="row_class" class="form-control" id="row_class" value="12">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="field_class">Field Class</label>
                                    <input name="field_class" class="form-control" id="field_class">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="order">Order No</label>
                                    <input type="number" class="form-control" id="order" name="order"
                                        value="0">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
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
            $('#data_table').DataTable();

            $(document).on('change', '#field_type', function() {
                if (['select', 'checkbox', 'radio'].includes($(this).val())) {
                    $('#options_box').show();
                } else {
                    $('#options_box').hide();
                }
            });
        });

        $('#field_options').on('input', function() {
            $(".error-message").remove();
        });
        $(document).on('blur', '#field_options', function() {
            $(".error-message").remove();
            const val = $(this).val().trim();
            if (val === '') return;
            const options = val.split(',').map(opt => opt.trim()).filter(Boolean);
            const invalidChars = options.some(opt => /[^a-zA-Z0-9\s\-\_\(\)]/.test(opt));
            const hasEmpty = options.some(opt => opt.length === 0);
            const duplicateCheck = new Set(options.map(o => o.toLowerCase())).size !== options.length;
            let errorMsg = '';
            if (hasEmpty) {
                errorMsg = 'Only comma separated values allowed.';
            } else if (invalidChars) {
                errorMsg = 'Special characters are not allowed.';
            } else if (duplicateCheck) {
                errorMsg = 'Duplicate option names not allowed.';
            }
            if (errorMsg) {
                $(this).focus();
                $(this).after('<span class="text-danger error-message">' + errorMsg + '</span>');
            } else {
                $(this).val(options.join(', '));
            }
        });



        $('#manageForm').submit(function(e) {
            e.preventDefault();
            $(".error-message").remove();
            var formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        location.reload();
                    } else if (response.status == "error") {
                        $.each(response.errors, function(key, value) {
                            $("#" + key).after('<span class="text-danger error-message">' +
                                value[0] + '</span>');
                        });
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        function addnew(id) {
            $(".error-message").remove();
            $('#manageForm')[0].reset();
            $('#exampleModalLabel').text('Add New');
            $('#edit_id').val('');

            if (id) {
                $.ajax({
                    url: "{{ roleRoute('sub_categories.form_fields_edit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            $('#exampleModalLabel').text('Edit Form Field');
                            let options = response.data.field_options;
                            try {
                                if (typeof options === 'string') {
                                    options = JSON.parse(options);
                                }
                            } catch (e) {
                                options = [];
                            }
                            $('#edit_id').val(response.data.id);
                            $('#field_label').val(response.data.field_label);
                            $('#field_name').val(response.data.field_name);
                            $('#field_type').val(response.data.field_type).trigger('change');
                            $('#field_options').val(options && options.length ? options.join(', ') : '');
                            $('#is_required').val(response.data.is_required);
                            $('#row_class').val(response.data.row_class);
                            $('#field_class').val(response.data.field_class);
                            $('#order').val(response.data.order);
                            $('#status').val(response.data.status);
                        }
                    }
                });
            } else {
                $('#field_type').val('').trigger('change');
            }
            $('#exampleModal').modal('show');
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
