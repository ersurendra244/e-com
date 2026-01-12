@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    <style>
        tbody td {
            /* padding: 5px 5px 5px 5px !important;
            margin: 0px 0px 0px 0px !important; */
            line-height: 1.5 !important;
        }

        .dropdown {
            position: relative;
            display: inline-block;
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
                                    <th>Products</th>
                                    <th>Categories</th>
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
                        "data": "title"
                    },
                    {
                        "data": "category"
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
