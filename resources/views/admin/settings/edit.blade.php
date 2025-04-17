@extends('admin.layout', ['title' => $title ?? '', 'subtitle' => $subtitle ?? ''])

@section('content')
    @include('admin.common.message')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{-- <a href="{{ route('admin.categories') }}" class="btn btn-sm btn-dark float-right">Go Back</a> --}}
                    <h4 class="card-title">{{ $title }}</h4>
                    <form action="{{ route('admin.settings.update', $edit_data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Enter title" value="{{ $edit_data->title ?? '' }}">
                                    @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="description">Description</label>
                                    <input type="text" class="form-control" id="description" name="description"
                                        placeholder="Enter description" value="{{ $edit_data->description ?? '' }}">
                                    @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter email" value="{{ $edit_data->email ?? '' }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="number" class="form-control" id="phone" name="phone"
                                        placeholder="Enter phone" value="{{ $edit_data->phone ?? '' }}">
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Enter address" value="{{ $edit_data->address ?? '' }}">
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="post_code">Post Code</label>
                                    <input type="text" class="form-control" id="post_code" name="post_code"
                                        placeholder="Enter post_code" value="{{ $edit_data->post_code ?? '' }}">
                                    @if ($errors->has('post_code'))
                                        <span class="text-danger">{{ $errors->first('post_code') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="map_iframe">Map Iframe</label>
                                    <textarea class="form-control" id="map_iframe" name="map_iframe"
                                        placeholder="Enter map_iframe">{{ $edit_data->map_iframe ?? old('map_iframe') }}</textarea>
                                    @if ($errors->has('map_iframe'))
                                        <span class="text-danger">{{ $errors->first('map_iframe') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-row">
                                    <img id="output1" src="{{ asset('uploads/settings/' . $edit_data->header_logo) }}" style="width: 70px; height: 70px; border: 1px solid #ddd; border-radius: 5px;" />
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="form-label" for="header_logo">Header Logo</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="header_logo" name="header_logo"
                                                    onchange="loadFile(event, 'output1')" />
                                            </div>
                                            @if ($errors->has('header_logo'))
                                                <span class="text-danger">{{ $errors->first('header_logo') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-row">
                                    <img id="output2" src="{{ asset('uploads/settings/' . $edit_data->footer_logo) }}" style="width: 70px; height: 70px; border: 1px solid #ddd; border-radius: 5px;" />
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="form-label" for="footer_logo">Footer Logo</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="footer_logo" name="footer_logo"
                                                    onchange="loadFile(event, 'output2')" />
                                            </div>
                                            @if ($errors->has('footer_logo'))
                                                <span class="text-danger">{{ $errors->first('footer_logo') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="facebook_url">Facebook Url</label>
                                    <input type="text" class="form-control" id="facebook_url" name="facebook_url"
                                        placeholder="Enter facebook_url" value="{{ $edit_data->facebook_url ?? '' }}">
                                    @if ($errors->has('facebook_url'))
                                        <span class="text-danger">{{ $errors->first('facebook_url') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="twitter_url">Twitter Url</label>
                                    <input type="text" class="form-control" id="twitter_url" name="twitter_url"
                                        placeholder="Enter twitter_url" value="{{ $edit_data->twitter_url ?? '' }}">
                                    @if ($errors->has('twitter_url'))
                                        <span class="text-danger">{{ $errors->first('twitter_url') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="linkedin_url">Linkedin Url</label>
                                    <input type="text" class="form-control" id="linkedin_url" name="linkedin_url"
                                        placeholder="Enter linkedin_url" value="{{ $edit_data->linkedin_url ?? '' }}">
                                    @if ($errors->has('linkedin_url'))
                                        <span class="text-danger">{{ $errors->first('linkedin_url') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="instagram_url">Instagram Url</label>
                                    <input type="text" class="form-control" id="instagram_url" name="instagram_url"
                                        placeholder="Enter instagram_url" value="{{ $edit_data->instagram_url ?? '' }}">
                                    @if ($errors->has('instagram_url'))
                                        <span class="text-danger">{{ $errors->first('instagram_url') }}</span>
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
        const loadFile = function(event, id) {
            var output = document.getElementById(id);
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        };
    </script>
@endpush
