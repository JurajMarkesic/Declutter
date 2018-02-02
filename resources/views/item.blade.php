@extends('layouts.app')

@section('content')
    <item :item="{{$item}}"></item>
    <create-story :item_id="{{ $item->id }}"></create-story>
    <stories :item="{{$item}}"></stories>
@endsection