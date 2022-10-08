@extends('layouts.account')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Withdrawal History</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Amount ({{ session('currency') === 'FCFA' ? session('currency') : '$' }})</th>
                                <th>Method</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($user->withdrawals as $id => $w)
                                <tr>
                                    <td>{{ ++$id }}</td>
                                    <td>{{ $w->phone_number ?? '-' }}</td>
                                    <td>{{ $w->email ?? '-' }}</td>
                                    <td>{{ number_format($w->amount, 2, '.', ',') }}</td>
                                    <td>{{ $w->method }}</td>
                                    <td>{{ Carbon\Carbon::parse($w->created_at)->format('d/m/Y') }}</td>
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
