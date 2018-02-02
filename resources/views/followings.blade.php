@extends('layouts.app')

@section('content')
    <followings :followings="{{ $followings }}"></followings>
@endsection