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
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Amount ({{ session('currency') === 'USD' ? '$' : session('currency') }})</th>
                                <th>Method</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($user->deposits as $id => $d)
                                <tr>
                                    <td>{{ ++$id }}</td>
                                    <td>{{ $d->phone_number ?? '-' }}</td>
                                    <td>{{ $d->email ?? '-' }}</td>
                                    <td>{{ number_format($d->amount, 2, '.', ',') }}</td>
                                    <td>{{ $d->method }}</td>
                                    <td>{{ Carbon\Carbon::parse($d->created_at)->format('d/m/Y') }}</td>
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
