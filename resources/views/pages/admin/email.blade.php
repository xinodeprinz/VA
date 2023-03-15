@extends('layouts.account')

@section('content')
    <div style="margin-bottom:5rem">
        <div class="section-title">
            <h1>Email all users</h1>
        </div>

        <div class="mb-3">
            <select id="type" class="form-select">
                <option value="">Select Type...</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <input type="text" placeholder="Subject" id="subject" class="form-control">
        </div>
        <div class="mb-3">
            <textarea id="message" class="form-control" cols="30" rows="8" placeholder="Write message here"></textarea>
        </div>
        <button onclick="emailUsers(this)" class="btn btn-main">Email Now</button>
    </div>
@endsection
