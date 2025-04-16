@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.products') }}" class="btn btn-sm btn-dark float-right ml-2">Go Back</a>
            @can('product create')
            <a href="{{ route('admin.products.variants_manage', ['product_id' => $productData->id]) }}" class="btn btn-sm btn-primary float-right">Add New</a>
            @endcan
            <h3 class="card-title">{{ $title }} [{{ $productData->pid }}]</h3>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Image</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productData->variants as $key => $variant)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @php $image = $variant->images[0] ?? ''; @endphp
                                            <img class="img-sm rounded" src="{{ asset('uploads/products/' . $image) }}" alt=""/>
                                        </td>
                                        <td>{{ ucfirst($variant->color) }}</td>
                                        <td>{{ $variant->size }}</td>
                                        <td>{{ $variant->price }}</td>
                                        <td>{{ $variant->stock }}</td>
                                        <td>{{ $variant->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <a href="{{ route('admin.products.variants_manage', ['product_id' => $productData->id, 'id' => $variant->id]) }}"
                                               class="btn btn-sm btn-info">Edit</a>
                                            <button class="btn btn-sm btn-danger" onclick="deleteData({{ $variant->id }})">Delete</button>
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
@endsection

@push('child_scripts')
    <script>

        $(document).ready(function() {
            $('#data_table').DataTable();
        })
        function deleteData(id) {
            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    url: "{{ route('admin.products.delete') }}",
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
    </script>
@endpush
