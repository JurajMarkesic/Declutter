@extends('layouts.app')

@section('content')
    <form action="/items" method="POST" enctype="multipart/form-data" class="form">
        {{ csrf_field() }}

        <label>Name:</label>
        <input type="text" name="name" class="form-control"><br>

        <label>Select an image:</label>
        <input type="file" name="image" class="form-control"><br>

        <select name="category" class="form-control">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <br><br>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
