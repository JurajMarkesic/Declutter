@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <info-container :user="{{ $user }}"></info-container>
        </div>

        <div class="col-md-7 offset-md-1">
            <timeline></timeline>
        </div>
    </div>
@endsection
