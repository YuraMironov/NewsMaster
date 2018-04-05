@extends('layout.layout')

@section('content')
    @foreach ($popular as $keyword)
        <a href="{{url('keywords/popular/report', [$keyword->id])}}">{{$keyword->keyword . ' (' . $keyword->counter .')' }}</a>
        </br>
    @endforeach

@endsection