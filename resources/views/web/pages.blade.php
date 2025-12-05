@extends('web.layout', ['title' => $title ?? ''])

@section('content')
    <!-- Breadcrumb Start -->
    {{-- <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <span class="breadcrumb-item active">Contact</span>
                </nav>
            </div>
        </div>
    </div> --}}
    <!-- Breadcrumb End -->

    <!-- Contact Start -->
    <div class="container-fluid">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">{{ $title ?? ''}}</span></h2>
        <div class="row px-xl-5">
            <div class="col-lg-12 mb-5">
                {!! $page_data->description ?? '' !!}
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection

@push('child_scripts')

@endpush
