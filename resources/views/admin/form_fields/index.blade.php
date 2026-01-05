@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])
@section('content')
    @include('admin.common.message')
    <div class="card">
        <div class="card-body">
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
                                    <th style="width: 10px">#</th>
                                    <th>Label</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Options</th>
                                    <th>Required</th>
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
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->field_label ?? 'N/A' }}</td>
                                        <td>{{ $value->field_name ?? 'N/A' }}</td>
                                        <td>{{ $value->field_type ?? 'N/A' }}</td>
                                        @php
                                            $opts = json_decode($value->field_options, true);
                                            if (!is_array($opts)) {
                                                $opts = [];
                                            }
                                            $shown = array_slice($opts, 0, 3);
                                        @endphp

                                        <td title="{{ implode(', ', $opts) }}">
                                            {{ implode(', ', $shown) }}
                                            @if (count($opts) > 3)
                                                ... <small class="text-muted">(+{{ count($opts) - 3 }} more)</small>
                                            @endif
                                        </td>
                                        <td>{{ $value->is_required == 1 ? 'Yes' : 'No' }}</td>
                                        <td>{{ $value->order }}</td>
                                        @php
                                            $status =
                                                $value->status == 1
                                                    ? '<label class="badge badge-outline-success badge-pill py-1">Active</label>'
                                                    : '<label class="badge badge-outline-danger badge-pill py-1">Inactive</label>';
                                        @endphp

                                        <td>{!! $status !!}</td>
                                        @canany(['menu edit', 'menu delete'])
                                            <td>
                                                @can('menu edit')
                                                    <button onclick="addnew({{ $value->id }})"
                                                        class="btn btn-outline-secondary btn-rounded btn-icon"><i class="fas fa-pencil-alt text-info"></i></button>
                                                @endcan
                                                @can('menu delete')
                                                    <button class="btn btn-outline-secondary btn-rounded btn-icon"
                                                        onclick="deleteData('{{ route('admin.form_fields.delete', $value->id) }}')"><i class="fas fa-trash text-danger"></i></button>
                                                @endcan
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
                    <form id="manageForm" action="{{ route('admin.form_fields.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="edit_id" name="edit_id" value="">
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
                    url: "{{ route('admin.form_fields.edit') }}",
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
    </script>
@endpush
