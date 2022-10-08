@extends('layouts.account')

@section('content')
    <div class="container-fluid">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Become an advertiser with {{ config('app.name') }}</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                Dropdown menus can be placed in the card header in order to extend the functionality
                of a basic card. In this dropdown card example, the Font Awesome vertical ellipsis
                icon in the card header can be clicked on in order to toggle a dropdown menu.

                <div class="text-right mt-2">
                    <form action="{{ route('adverts') }}" method="POST">
                        @csrf
                        <button type="submit" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            {{ $user->is_advert || $user->is_admin ? 'Create an Ad' : 'Subscribe Now' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
