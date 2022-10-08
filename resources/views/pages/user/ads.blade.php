@extends('layouts.account')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Deposit History</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($ads as $id => $ad)
                                <tr>
                                    <td>{{ ++$id }}</td>
                                    <td>{{ $ad->title }}</td>
                                    <td>
                                        <form action="{{ route('ads') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $ad->id }}">
                                            <button type="submit"
                                                class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                                View
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
