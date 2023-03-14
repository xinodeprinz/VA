@extends('layouts.account')

@section('content')
    <div class="section-title">
        <h1>Email all users</h1>
    </div>

    <div class="mb-3">
        <input type="text" placeholder="Subject" id="subject" class="form-control" required>
    </div>
    <div class="mb-3">
        <textarea id="message" class="form-control" cols="30" rows="8" placeholder="Write message here" required></textarea>
    </div>
    <button onclick="emailUsers(this)" class="btn btn-main">Email Now</button>
@endsection
