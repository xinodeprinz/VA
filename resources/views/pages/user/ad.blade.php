@extends('layouts.account')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="mb-4">
            <div class="row">
                <div class="col-8 col-md-10 mt-2">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped" id="ad-progress" role="progressbar" style="width: 10%"
                            aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">10%</div>
                    </div>
                </div>
                <div class="col col-md-2">
                    <form action="{{ route('process-ad') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $ad->id }}">
                        <button type="submit" hidden id="claim-reward" class="btn btn-sm btn-primary shadow-sm">
                            Claim <span class="d-none d-sm-inline">Reward</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="h5 mb-4 font-weight-bold text-gray-800">
            {{ $ad->title }}
        </div>

        <div>{!! $ad->body !!}</div>

    </div>
    <!-- /.container-fluid -->

    <script src="/js/progress.js"></script>
@endsection
