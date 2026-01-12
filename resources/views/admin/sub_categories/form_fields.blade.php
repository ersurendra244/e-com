@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.subcategory') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <a href="{{ route('admin.subcategory.form_view', $subcategory->slug) }}"
                        class="btn btn-sm btn-warning float-right mr-2">View Form</a>
                    <h4 class="card-title mb-2">{{ $subcategory->slug }} - {{ $title }}</h4>
                    <p class=" text-muted"><i>Select Fields for Product Form</i></p>
                    <form action="{{ route('admin.subcategory.form_fields_save') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="data_table" class="table table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th>Fields</th>
                                                <th>Type</th>
                                                <th>Options</th>
                                                <th>Row. Cls.</th>
                                                <th>Field Cls.</th>
                                                <th>Required</th>
                                                <th>Order</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($form_fields as $key => $value)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="field_id[{{ $value->id }}]"
                                                                    value="{{ $value->id }}"
                                                                    {{ array_key_exists($value->id, $selected) ? 'checked' : '' }}>
                                                                {{ ucfirst($value->field_label) }}
                                                                <i class="input-helper"></i>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $value->field_type }}</td>
                                                    @php
                                                        $opts = json_decode($value->field_options, true);
                                                        if (!is_array($opts)) {
                                                            $opts = [];
                                                        }
                                                        $shown = array_slice($opts, 0, 3);
                                                    @endphp
                                                    <td title="{{ implode(', ', $opts) }}">
                                                        {{ implode(', ', $shown) }}
                                                        @if (count($opts) > 3)
                                                            ... <small class="text-muted">(+{{ count($opts) - 3 }}
                                                                more)</small>
                                                        @endif
                                                    </td>
                                                    <td style="width: 10%">
                                                        <input type="text" class="form-control p-2"
                                                            name="row_class[{{ $value->id }}]"
                                                            value="{{ $selected[$value->id]['row_class'] ?? '6' }}">
                                                    </td>
                                                    <td style="width: 10%">
                                                        <input type="text" class="form-control p-2"
                                                            name="field_class[{{ $value->id }}]"
                                                            value="{{ $selected[$value->id]['field_class'] ?? '' }}">
                                                    </td>
                                                    <td style="width: 5%">
                                                        <select style="padding: 0px 5px !important;"
                                                            class="form-control form-control-sm"
                                                            name="is_required[{{ $value->id }}]">
                                                            <option value="0"
                                                                {{ ($selected[$value->id]['is_required'] ?? 0) == 0 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="1"
                                                                {{ ($selected[$value->id]['is_required'] ?? 0) == 1 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>
                                                    <td style="width: 5%">
                                                        <input type="number" class="form-control p-2" id="order"
                                                            name="order[{{ $value->id }}]"
                                                            value="{{ $selected[$value->id]['order'] ?? '' }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <input type="hidden" name="subcategory_id" value="{{ $subcategory->id }}">
                            <input type="hidden" name="slug" value="{{ $subcategory->slug }}">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('child_scripts')
    <script>
        $.fn.dataTable.ext.order['dom-text-numeric'] = function(settings, col) {
            return this.api().column(col, {
                order: 'index'
            }).nodes().map(function(td, i) {
                let val = $('input', td).val();
                if (val === '' || val === null || val === undefined) {
                    return Number.POSITIVE_INFINITY;
                }
                return parseFloat(val);
            });
        };

        $(document).ready(function() {
            $('#data_table').DataTable({
                "ordering": true,
                "lengthMenu": [25, 50, 100],
                "pageLength": 25,
                "columnDefs": [{
                    "targets": 6,
                    "orderDataType": "dom-text-numeric"
                }],
                "order": [
                    [6, 'asc']
                ]
            });
        });
    </script>
@endpush
