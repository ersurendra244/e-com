@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])
@section('content')
    @include('admin.common.message')
    <style>
        .ratings {
            display: flex;
        }

        .fa-star {
            font-size: 24px;
            color: lightgray;
            font-size: small;
        }

        .fa-star.gold {
            color: gold;
        }
    </style>
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.products') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
            <h3 class="card-title">{{ $title }}</h3>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Product</th>
                                    <th>User</th>
                                    <th style="width: 35%">Reviews</th>
                                    <th>Created At</th>
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
                    "url": "{{ route('admin.products.reviews_list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.pid = '{{ $pid }}';
                    }
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "product"
                    },
                    {
                        "data": "user"
                    },
                    {
                        "data": "reviews"
                    },
                    {
                        "data": "created_at",
                        "orderable": false,
                        "searchable": false
                    }
                ]
            });
        });
    </script>
@endpush
