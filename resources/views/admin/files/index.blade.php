@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="card">
        <div class="card-body">
            @can('user create')
                <a href="{{ route('admin.files.create') }}" class="btn btn-sm btn-primary float-right">Create File</a>
            @endcan
            <h3 class="card-title">{{ $title }}</h3>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>File</th>
                                    <th>File Name</th>
                                    <th>Remarks</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th style="width: 30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="farword-modal" tabindex="-1" role="dialog" aria-labelledby="fsmodalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title mb-2" id="fsmodalLabel">Modal title</h5>
                    <form id="farword-form" action="{{ route('admin.files.share') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="role_id">Role</label>
                                    <select onchange="getUser(this.value)" name="role_id" class="form-control"
                                        id="role_id">
                                        <option value="">Choose a role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('role_id'))
                                        <span class="text-danger">{{ $errors->first('role_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="user_id">User</label>
                                    <select name="user_id" class="form-control" id="user_id">
                                        <option value="">--select--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="remark">Remark</label>
                                    <textarea class="form-control" id="remark" name="remark" placeholder="Enter remark">{{ old('remark') }}</textarea>
                                    @if ($errors->has('remark'))
                                        <span class="text-danger">{{ $errors->first('remark') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" name="file_id" id="file_id" value="">
                                <input type="hidden" name="action_type" id="action_type" value="">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('child_scripts')
    <script>
        $(document).ready(function() {
            $('#data_table').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 10,
                "lengthMenu": [
                    [10, 25, 50],
                    [10, 25, 50]
                ],
                "ajax": {
                    "url": "{{ route('admin.files.list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "uploadfile"
                    },
                    {
                        "data": "filename"
                    },
                    {
                        "data": "remark"
                    },
                    {
                        "data": "created_by"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "action",
                        "orderable": false,
                        "searchable": false
                    }
                ]

            });
        });

        function deleteData(id) {
            if (confirm("Are you sure you want to delete this file?")) {
                $.ajax({
                    url: "{{ route('admin.files.delete') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(response) {
                        alert('Something went wrong. Please try again.');
                    }
                });
            }
        }

        function fileShare(id, action_type) {
            $("#file_id").val(id);
            $("#action_type").val(action_type);
            if (action_type == 'forwarded') {
                $("#fsmodalLabel").text("Share File");
            } else {
                $("#fsmodalLabel").text("Return File");
            }
            $("#farword-modal").modal('show');

        }
        $("#farword-form").submit(function(e) {
            e.preventDefault();

            var form = $(this);
            // form.find(".error").remove();

            var formData = new FormData(this); // Correct FormData usage

            $.ajax({
                url: form.attr("action"),
                type: "POST",
                data: formData,
                processData: false, // Required for FormData
                contentType: false, // Required for FormData
                dataType: "json",
                success: function(response) {
                    if (response.status === "error") {
                        $.each(response.errors, function(field, error) {
                            var fieldElement = form.find("[name='" + field + "']");
                            fieldElement.closest(".form-group").append(
                                '<span class="text-danger">' + error + '</span>'
                            );
                        });
                    } else if (response.status === "success") {
                        $("#farword-modal").modal('hide');
                        location.reload();
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Debugging
                }
            });
        });

        // $("#loginForm").on("focus", "[name]", function() {
        //     $(this).closest(".form-group,").find(".text-danger").remove();
        // });
    </script>
@endpush
