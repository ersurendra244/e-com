@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="card">
        <div class="card-body">
            @can('permission create')
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-primary float-right">Add New</a>
            @endcan
            <h3 class="card-title">{{ $title }}</h3>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Menu</th>
                                    <th>Created At</th>
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
                "order": [[0, "desc"]],
                "ajax": {
                    "url": "{{ route('admin.permissions.list') }}",
                    "type": "POST",
                    "data": function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "menu"},
                    {"data": "created_at"},
                    {"data": "action", "orderable": false, "searchable": false}
                ]
            });
        });

    </script>
@endpush
