@extends('layouts.web')

@section('content')
    @include('components.jumbo', ['title' => __('main.Start earning')])

    <div class="my-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Attribute</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody class="text-capitalize">
                                <tr>
                                    <td>{{ __('main.Amount') }}</td>
                                    <td id="amount">-</td>
                                </tr>
                                <tr>
                                    <td>{{ __('main.videos per day') }}</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>{{ __('main.video cost') }}</td>
                                    <td id="video-cost">-</td>
                                </tr>
                                <tr>
                                    <td>{{ __('main.duration') }}</td>
                                    <td id="duration">-</td>
                                </tr>
                                <tr>
                                    <td>{{ __('main.total earn') }}</td>
                                    <td id="total-earn">-</td>
                                </tr>
                                <tr>
                                    <td>{{ __('main.withdrawal') }}</td>
                                    <td>automatic</td>
                                </tr>
                                <tr>
                                    <td>{{ __('main.Min withdrawal') }}</td>
                                    <td id="min-with">-</td>
                                </tr>
                                <tr>
                                    <td>{{ __('main.widthdrawal charge') }}</td>
                                    <td>{{ env('WITHDRAWAL_CHARGES_PERCENTAGE') }}%</td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-main text-white">
                                <tr class="text-capitalize">
                                    <td>{{ __('main.Amount Range') }}</td>
                                    <td>250 FCFA - 1,000,000 FCFA</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="shadow bg-white p-3">
                        <form action="{{ route('investment-plan') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="number" value="{{ old('amount') }}"
                                    onkeyup="details(this, '{{ csrf_token() }}')" placeholder="Amount" name="amount"
                                    class="form-control @error('amount')
                                        is-invalid
                                    @enderror">
                                <div class="input-group-text">FCFA</div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-main text-capitalize">
                                {{ __('main.invest now') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
