@extends('layouts.app')

@section('content')

    <h3 class="font-weight-bold">Profile:</h3>

    <form action="/profile" method="POST" enctype="multipart/form-data" class="form mt-4">
        <input type="hidden" name="_method" value="PATCH">
        {{ csrf_field() }}

        <label class="lead">Select an image:</label>
        <input type="file" name="image" class="form-control">

        <br>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    @if(session('status'))
        <br>
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        <br>
    @endif
    <br>

    <edit-profile :user="{{ $user }}"></edit-profile>

    <a href="/changePassword">
        <button class="btn btn-primary mt-5">Change Password</button>
    </a>

@endsection