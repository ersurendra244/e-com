@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])
@section('content')
    <style>
        .table td img,
        .jsgrid .jsgrid-table td img {
            width: revert-layer;
            height: auto;
            border-radius: 0%;
        }
    </style>
    @include('admin.common.message')
    <div class="card">
        <div class="card-body">
            <a href="javascript:void(0)" onclick="exportData();" class="btn btn-sm btn-success float-right">Export</a>
            <h3 class="card-title">{{ $title }}</h3>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label" for="issue_number">Issue Number</label>
                        <input type="text" class="form-control filters" id="issue_number" name="issue_number"
                            placeholder="Enter issue number" value="">

                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label" for="status">Status</label>
                        <select class="form-control filters" id="status" name="status">
                            <option value="All">All</option>
                            <option value="Closed">Closed</option>
                            <option value="Re-Open">Re-Open</option>
                            <option value="Pending">Pending</option>
                            <option value="Assigned (Viewed)">Assigned (Viewed)</option>
                            <option value="Assigned (Not Viewed)">Assigned (Not Viewed)</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label" for="from_date">From Date</label>
                        <input type="text" class="form-control datepicker filters" id="from_date" name="from_date"
                            placeholder="Enter from date" value="">

                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label" for="to_date">To Date</label>
                        <input type="text" class="form-control datepicker filters" id="to_date" name="to_date"
                            placeholder="Enter to date" value="">

                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>Issue No</th>
                                    <th>Created At</th>
                                    <th>User Name</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th>Department</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Zone</th>
                                    <th>Ward</th>
                                    <th>Assigned To</th>
                                    <th>Mode</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Resolved At</th>
                                    <th>Agency</th>
                                    <th>Escalated</th>
                                    <th>Escalated At</th>
                                    <th>Escalated To</th>
                                    <th>Before Image</th>
                                    <th>After Image</th>
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
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script>
        if ($(".datepicker").length) {
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });
        }
        $('.filters').on('keyup change', function() {
            $('#data_table').DataTable().ajax.reload();
        });
        $(document).ready(function() {
            $('#data_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ roleRoute('issues.data') }}",
                    type: "GET",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.issue_number = $('#issue_number').val();
                        d.status = $('#status').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    },
                    dataSrc: function(json) {
                        if (json.success) {
                            notifyMessage(json.success, 'success');
                        }
                        return json.data;
                    },
                    error: function(xhr) {
                        let message = '';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            message = xhr.responseJSON.error;
                        }
                        notifyMessage(message, 'error');
                    }
                },
                columns: [{
                        data: 'issue_number'
                    },
                    {
                        data: 'created_at',
                        render: function(data) {
                            return data ? moment(data).format('DD-MM-YYYY HH:mm:ss') : '-';
                        }
                    },
                    {
                        data: 'user_name'
                    },
                    {
                        data: 'user_mobile_number'
                    },
                    {
                        data: 'status_name'
                    },
                    {
                        data: 'department_name'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'category_name'
                    },
                    {
                        data: 'zone_name'
                    },
                    {
                        data: 'ward_name'
                    },
                    {
                        data: 'assigned_user_name'
                    },
                    {
                        data: 'mode',
                        defaultContent: '-'
                    },
                    {
                        data: 'latitude'
                    },
                    {
                        data: 'longitude'
                    },
                    {
                        data: 'resolved_at',
                        render: function(data) {
                            return data ? moment(data).format('DD-MM-YYYY') : '-';
                        }
                    },
                    {
                        data: 'agency_name',
                        defaultContent: '-'
                    },
                    {
                        data: 'is_escalated',
                        defaultContent: 'No'
                    },
                    {
                        data: 'escalated_at',
                        render: function(data) {
                            return data ? moment(data).format('DD-MM-YYYY') : '-';
                        }
                    },
                    {
                        data: 'escalated_to',
                        defaultContent: '-'
                    },
                    {
                        data: 'before_image',
                        render: function(data) {
                            return `<a href="${data}" target="_blank">
                                <img src="${data}" width="60"/>
                            </a>`;
                        }
                    },
                    {
                        data: 'after_image',
                        render: function(data) {
                            return `<a href="${data}" target="_blank">
                                <img src="${data}" width="60"/>
                            </a>`;
                        }
                    }
                ]
            });
        });

        function exportData() {
            let issue_number = $('#issue_number').val();
            let status = $('#status').val();
            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();
            let url = "{{ roleRoute('issues.export') }}?issue_number=" + issue_number +
                    "&status=" + status +
                    "&from_date=" + from_date +
                    "&to_date=" + to_date;

            window.location.href = url;
        }
    </script>
@endpush
