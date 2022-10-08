@if (session('error'))
    <div style="position:fixed;bottom:4rem;right:1rem;z-index:1">
        <div class="alert alert-yoo alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if (session('success'))
    <div style="position:fixed;bottom:4rem;right:1rem;z-index:1">
        <div class="alert alert-yoo alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
