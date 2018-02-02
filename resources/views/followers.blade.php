@extends('layouts.app')

@section('content')
    <followers :followers="{{ $followers }}"></followers>
@endsection