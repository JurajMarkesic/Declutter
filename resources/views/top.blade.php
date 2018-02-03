@extends('layouts.app')

@section('content')
    @foreach($itemsByCost as $itemCost)
        <h1>{{ $itemCost[0]->name }}</h1>
        <h4>Avg Cost: {{ $itemCost[1] }}</h4>
        <br><br>
    @endforeach
    <hr>
    <hr>
    @foreach($declutters as $itemDec)
        <h1>{{ $itemDec->name }}</h1>
        <h3>{{ $itemDec->declutters }}</h3>
        <br><br>
    @endforeach
@endsection