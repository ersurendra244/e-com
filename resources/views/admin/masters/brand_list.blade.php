@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])
@section('content')
    @include('admin.common.message')
    <div class="card">
        <div class="card-body">
            @can('brand create')
                <a href="javascript:void(0)" onclick="addnew()" class="btn btn-sm btn-primary float-right">Add New</a>
            @endcan
            <h3 class="card-title">{{ $title }}</h3>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 10%">Image</th>
                                    {{-- <th>Name</th> --}}
                                    <th>Brand Details</th>
                                    <th>Status</th>
                                    {{-- <th>Created At</th> --}}
                                    @canany(['brand edit','brand delete'])
                                        <th>Action</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <img class="img-sm rounded w-100 h-100" src="{{ asset('uploads/brands/' . $value->image) }}" alt=""/>
                                        </td>
                                        <td>
                                            <h5>{{ $value->name }}</h5>
                                            <p>{{ $value->description }}</p>
                                        </td>
                                        {{-- <td>{{ $value->name }}</td>
                                        <td>{{ $value->description }}</td> --}}
                                        <td>{{ $value->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        {{-- <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td> --}}
                                        @canany(['brand edit','brand delete'])
                                            <td>
                                                @can('brand edit')
                                                <a href="javascript:void(0)" onclick="addnew({{ $value->id }})"
                                                    class="btn btn-sm btn-info">Edit</a>
                                                @endcan
                                                @can('brand delete')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="deleteData({{ $value->id }})">Delete</button>
                                                @endcan
                                            </td>
                                        @endcan
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
                    <form id="addressForm" action="{{ route('admin.masters.brand_save') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="edit_id" name="edit_id" value="">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter name" value="">

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="form-label" for="image">Image</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="image" name="image"
                                                onchange="loadFile(event)" />
                                            </div>
                                        </div>
                                    </div>
                                    <img id="output" src="" style="width: 70px; height: 70px; border: 1px solid #ddd; border-radius: 5px;" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
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
        });

        const loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        };

        $('#addressForm').submit(function(e) {
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
            $('#addressForm')[0].reset();
            if (id) {
                $.ajax({
                    url: "{{ route('admin.masters.brand_edit') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            $('#exampleModalLabel').text('Edit Brand');
                            $('#edit_id').val(response.data.id);
                            $('#name').val(response.data.name);
                            $('#description').val(response.data.description);
                            $('#status').val(response.data.status);
                            $('#output').attr('src', '{{ asset('uploads/brands') }}/' + response.data.image);
                            $('#image').val('');
                        }
                    }
                });
            }
            $('#exampleModal').modal('show');
        }
    </script>
@endpush
