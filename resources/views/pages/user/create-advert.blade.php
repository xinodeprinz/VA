@extends('layouts.account')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <form class="user" method="POST" action="{{ route('create-advert') }}">
            @csrf
            <div class="form-group">
                <input type="text" value="{{ old('title') }}" name="title"
                    class="form-control form-control-user @error('title')
                    is-invalid
                @enderror"
                    placeholder="Ad Title">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <textarea id="editor" name="body" value="{{ old('body') }}"
                    class="form-control form-control-user @error('body')
                is-invalid
            @enderror"
                    placeholder="Build your ad here!!"></textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col col-md-4 offset-md-4">
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Create Ad
                    </button>
                </div>
            </div>
        </form>

    </div>
    <!-- /.container-fluid -->
@endsection
