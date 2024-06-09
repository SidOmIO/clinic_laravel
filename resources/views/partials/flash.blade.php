@if (session('success'))
    <div class="alert alert-success fade show" role="alert">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger fade show" role="alert">
        {{ session('error') }}
    </div>
@endif
