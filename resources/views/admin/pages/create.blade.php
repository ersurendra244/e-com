@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.pages') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h4 class="card-title">{{ $title }}</h4>
                    <form action="{{ route('admin.pages.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="1">Active
                                        </option>
                                        <option value="0">Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea class="form-control summernote" id="description" name="description" placeholder="Enter description">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>
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
        $(document).ready(function() {
            $(".summernote").each(function() {
                // Destroy old instance if already initialized
                if ($(this).next().hasClass('note-editor')) {
                    $(this).summernote('destroy');
                }

                // Initialize Summernote
                $(this).summernote({
                    height: 300,
                    tabsize: 2,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['fontsize', 'color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });
        });
    </script>
@endpush
