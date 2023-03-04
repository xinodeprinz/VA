@if (session('error'))
    <div style="position:fixed;bottom:4rem;right:1rem;z-index:1">
        <div class="alert alert-yoo alert-danger text-center alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" id="close-alert" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if (session('success'))
    <div style="position:fixed;bottom:4rem;right:1rem;z-index:1">
        <div class="alert alert-yoo alert-success text-center alert-dismissible fade show mt-3" role="alert">
            <span>{{ session('success') }}</span>
            <button type="button" id="close-alert" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
        </div>
    </div>
@endif

@if (session('info'))
    <div style="position:fixed;bottom:4rem;right:1rem;z-index:1">
        <div class="alert alert-yoo alert-info text-center alert-dismissible fade show mt-3" role="alert">
            <span>{{ session('info') }}</span>
            <button type="button" id="close-alert" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
        </div>
    </div>
@endif
