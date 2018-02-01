@extends('layouts.app')

@section('content')
    <search-results :results="{{ $result  }}"></search-results>
@endsection