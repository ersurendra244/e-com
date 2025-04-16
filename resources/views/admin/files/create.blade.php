@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.files') }}" class="btn btn-sm btn-dark float-right">Go Back</a>
                    <h4 class="card-title">{{ $title }}</h4>
                    <form action="{{ route('admin.files.save') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="filename">Name</label>
                                    <input type="text" class="form-control" id="filename" name="filename"
                                        placeholder="Enter file name" value="{{ old('filename') }}">
                                    @if ($errors->has('filename'))
                                        <span class="text-danger">{{ $errors->first('filename') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="role_id">Role</label>
                                    <select onchange="getUser(this.value)" name="role_id" class="form-control" id="role_id">
                                        <option value="">Choose a role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('role_id'))
                                        <span class="text-danger">{{ $errors->first('role_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="user_id">User</label>
                                    <select name="user_id" class="form-control" id="user_id">
                                        <option value="">--select--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-row">
                                    <img id="output" src="" style="width: 70px; height: 70px; border: 1px solid #ddd; border-radius: 5px;" />
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="form-label" for="uploadfile">Image</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="uploadfile" name="uploadfile"
                                                    onchange="loadFile(event)" />
                                            </div>
                                            @if ($errors->has('uploadfile'))
                                                <span class="text-danger">{{ $errors->first('uploadfile') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="remark">Remark</label>
                                    <textarea class="form-control" id="remark" name="remark"
                                        placeholder="Enter remark">{{ old('remark') }}</textarea>
                                    @if ($errors->has('remark'))
                                        <span class="text-danger">{{ $errors->first('remark') }}</span>
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
        const loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        };

    </script>
@endpush
