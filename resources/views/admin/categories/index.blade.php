@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="card">
        <div class="card-body">
            @can('category create')
                <a href="{{ roleRoute('categories.create') }}" class="btn btn-sm btn-primary float-right">Add New</a>
            @endcan
            <h3 class="card-title">{{ $title }}</h3>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>image</th>
                                    <th>Name</th>
                                    <th>Parent Category</th>
                                    <th>Order By</th>
                                    <th>Is Home</th>
                                    <th>Status</th>
                                    @canany(['category edit', 'category delete'])
                                        <th>Action</th>
                                    @endcanany
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
                    "url": "{{ roleRoute('categories.list') }}",
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
                        "data": "name"
                    },
                    {
                        "data": "parent_id"
                    },
                    {
                        "data": "order"
                    },
                    {
                        "data": "is_home"
                    },
                    {
                        "data": "status"
                    },
                    @canany(['category edit', 'category delete'])
                        {
                            "data": "action",
                            "orderable": false,
                            "searchable": false
                        },
                    @endcanany
                ]

            });
        });

    </script>
@endpush
