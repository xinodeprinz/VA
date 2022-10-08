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
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Balance ({{ session('currency') === 'USD' ? '$' : session('currency') }})</th>
                                <th>Admin</th>
                                <th>Plan</th>
                                <th>Expires</th>
                                <th>Advert</th>
                                <th>Blocked</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $id => $user)
                                <tr>
                                    <td>{{ ++$id }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>+{{ $user->code . $user->phone_number }}</td>
                                    <td>{{ number_format($user->account_balance, 2, '.', ',') }}</td>
                                    <td>{{ $user->is_admin ? 'true' : 'false' }}</td>
                                    <td class="text-capitalize">{{ $user->plan()->first()->title ?? '-' }}</td>
                                    <td>{{ $user->expires_in }}</td>
                                    <td>{{ $user->is_advert ? 'true' : 'false' }}</td>
                                    <td>{{ $user->is_blocked ? 'true' : 'false' }}</td>
                                    <td>{{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <form action="{{ route('user.block', ['id' => $user->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                                    {{ $user->is_blocked ? 'Unblock' : 'Block' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('user.delete', ['id' => $user->id]) }}" method="POST"
                                                style="margin-left:0.3rem !important">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
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
