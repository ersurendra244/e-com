@extends('admin.layout', ['title' => $subcategory->name . ' ' . $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.subcategory') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h4 class="card-title">{{ $subcategory->name }} {{ $title }}</h4>
                    <form action="{{ route('admin.subcategory.items_store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="subcategory_id" value="{{ $subcategory->id }}">
                            @php
                                $selected = is_array($subcategory->item_type) ? $subcategory->item_type : [];
                            @endphp

                            @foreach ($item_types as $key => $item)
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="item_type[]" value="{{ $item->id }}"
                                                    {{ in_array($item->id, $selected ?? []) ? 'checked' : '' }}>
                                                {{ $item->name }}
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('child_scripts')
    <script>
        const loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        };
    </script>
@endpush
