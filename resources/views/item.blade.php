@extends('layouts.app')

@section('content')
    <item :item="{{$item}}"></item>
    <stories :item="{{$item}}"></stories>
@endsection