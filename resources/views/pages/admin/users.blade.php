@extends('layouts.account')

@section('content')
    <div style="margin-bottom:6rem">
        <div class="section-title">
            <h1>registered users</h1>
        </div>

        <p>Number of users: {{ $total }}</p>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Balance</th>
                        <th>Plan</th>
                        <th>Expires</th>
                        <th>Blocked</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $id => $u)
                        <tr>
                            <td>{{ ++$id }}</td>
                            <td>{{ $u->username }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->phone_number }}</td>
                            <td>{{ number_format($u->balance, 0) }}</td>
                            <td class="text-capitalize">{{ $u->plan ? $u->plan->title : '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($u->expires_on)->format('M d, Y') }}</td>
                            <td>{{ $u->is_blocked ? 'True' : 'False' }}</td>
                            <td>{{ Carbon\Carbon::parse($u->created_at)->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex">
                                    <form action="{{ route('user.block', ['id' => $u->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="d-sm-inline-block btn btn-sm btn-main shadow-sm">
                                            {{ $u->is_blocked ? 'Unblock' : 'Block' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('user.delete', ['id' => $u->id]) }}" method="POST"
                                        style="margin-left:0.3rem !important">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="d-sm-inline-block btn btn-sm btn-danger shadow-sm">
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
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
