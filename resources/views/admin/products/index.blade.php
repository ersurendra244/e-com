@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="card">
        <div class="card-body">
            @can('product create')
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary float-right">Add New</a>
            @endcan
            <h3 class="card-title">{{ $title }}</h3>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Image</th>
                                    <th>PId</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Variants</th>
                                    <th>Status</th>
                                    <th>Collections</th>
                                    <th>Action</th>
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
                    "url": "{{ route('admin.products.list') }}",
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
                        "data": "image"
                    },
                    {
                        "data": "pid"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "category"
                    },
                    {
                        "data": "price"
                    },
                    {
                        "data": "variants"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "collections"
                    },
                    {
                        "data": "action",
                        "orderable": false,
                        "searchable": false
                    }
                ]

            });
        });

    </script>
@endpush
