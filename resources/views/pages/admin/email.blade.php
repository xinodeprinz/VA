@extends('layouts.account')

@section('content')
    <div style="margin-bottom:5rem">
        <div class="section-title">
            <h1>Email all users</h1>
        </div>

        <div class="mb-3">
            <select id="type" class="form-select">
                <option value="">Select Type...</option>
                @foreach ($types as $key => $value)
                    <option value="{{ $key }}">{{ $key . ' - ' . $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <input type="number" placeholder="Skip" id="skip" class="form-control">
            </div>
            <div class="col-6">
                <input type="number" placeholder="Take" id="take" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <input type="text" placeholder="Subject" id="subject" class="form-control">
        </div>
        <div class="mb-3">
            <textarea class="form-control" id="editor"></textarea>
        </div>
        <button onclick="emailUsers(this)" class="btn btn-main">Email Now</button>
    </div>
@endsection
