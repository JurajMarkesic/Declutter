@extends('layouts.app')

@section('content')
    <top-declutter :items="{{ $declutters }}"></top-declutter>
    <hr>
    <br>
    <hr>
    <top-cost :items="{{ json_encode($itemsByCost) }}"></top-cost>

@endsection