@extends('layouts.app')

@section('content')
    <category-items :items="{{ $items }}"></category-items>
@endsection