@if (session('success'))
    <div id="successMessage" class="alert alert-success alert-dismissible show" role="alert">
        {{ session('success') }}"
    </div>
@endif

@if (session('error'))
    <div id="errorMessage" class="alert alert-danger alert-dismissible show" role="alert">
        {{ session('error') }}"
    </div>
@endif
