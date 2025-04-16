@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])
@section('content')
    @include('admin.common.message')
    <div class="card">
        <div class="card-body">
            <a href="javascript:void(0)" onclick="addnew()" class="btn btn-sm btn-primary float-right">Add New</a>
            <h3 class="card-title">{{ $title }}</h3>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Street</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>Postal Code</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addresses as $key => $address)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $address->street }}</td>
                                        <td>{{ $address->city }}</td>
                                        <td>{{ $address->state }}</td>
                                        <td>{{ $address->country }}</td>
                                        <td>{{ $address->postal_code }}</td>
                                        <td>{{ $address->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="addnew({{ $address->id }})"
                                                class="btn btn-sm btn-info">Edit</a>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteData({{ $address->id }})">Delete</button>
                                        </td>
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
                    <h5 class="modal-title text-white" id="exampleModalLabel">Add New Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addressForm" action="{{ route('user.store_address') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="edit_id" name="edit_id" value="">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="street">Street</label>
                                    <input type="text" class="form-control" id="street" name="street"
                                        placeholder="Enter street" value="">

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        placeholder="Enter city" value="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="state">State</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        placeholder="Enter state" value="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="country">Country</label>
                                    <input type="text" class="form-control" id="country" name="country"
                                        placeholder="Enter country" value="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="postal_code">Postal Code</label>
                                    <input type="number" class="form-control" id="postal_code" name="postal_code"
                                        placeholder="Enter postal code" value="">
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
                    url: "{{ route('user.edit_address') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            // console.log(response.data.street);
                            $('#exampleModalLabel').text('Edit Address');
                            $('#edit_id').val(response.data.id);
                            $('#street').val(response.data.street);
                            $('#city').val(response.data.city);
                            $('#state').val(response.data.state);
                            $('#country').val(response.data.country);
                            $('#postal_code').val(response.data.postal_code);
                            // $('#exampleModal').modal('show');
                        }
                    }
                });
            }
            $('#exampleModal').modal('show');
        }
    </script>
@endpush
