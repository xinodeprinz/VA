@extends('layouts.account')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Referrals</h6>
                <p class="mb-3 mt-2">Refer people and get 10% of every deposit they do.</p>
                <p class="mb-0 mt-2 bg-primary text-white p-2 d-flex justify-content-between">
                    <span id="copy">{{ config('app.url') }}/register/{{ $user->username }}</span>
                    <span style="cursor: pointer" onclick="copy()">
                        <i class="far fa-copy"></i>
                    </span>
                </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($user->referrals as $id => $r)
                                <tr>
                                    <td>{{ ++$id }}</td>
                                    <td>{{ $r->username }}</td>
                                    <td>{{ $r->email }}</td>
                                    <td>+{{ $r->code . $r->phone_number }}</td>
                                    <td>{{ Carbon\Carbon::parse($r->created_at)->format('d/m/Y') }}</td>
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
