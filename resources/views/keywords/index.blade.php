@extends('layout.layout')

@section('content')
    <h1> Keywords </h1>
    @foreach($alphabet as $a)
        <a href="{{url('keywords')}}?q={{$a}}">{{$a . ' '}}</a>
    @endforeach
    <br>
    <a href="{{url('keywords/create')}}">Add new keyword</a>
    <div style="max-width: 100%">
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        @foreach($keywords as $keyword)
            <a href="{{url('keywords', [$keyword->id])}}">{{$keyword->keyword}}</a>
        @endforeach
    </div>
@endsection
