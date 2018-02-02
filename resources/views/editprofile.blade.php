@extends('layouts.app')

@section('content')
    <form action="/profile" method="POST" enctype="multipart/form-data" class="form">
        <input type="hidden" name="_method" value="PATCH">
        {{ csrf_field() }}

        <label>Select an image:</label>
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
@endsection