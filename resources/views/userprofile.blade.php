@extends('layouts.app')

@section('content')
    @if( $isUser )
        <user-profile :user="{{$user}}"></user-profile>
    @else
        @if($isPublic)
            {{--<profile :user="{{$user}}"></profile>--}}
        @else
            <h3>This profile is private.</h3>
        @endif
    @endif

@endsection
