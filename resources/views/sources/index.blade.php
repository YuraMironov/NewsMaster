@extends('layout.layout')

@section('content')
    <a href="{{url('sources/create')}}">Add new source</a>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">id</th>
            <th scope="col">Source Name</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        @foreach($sources as $source)
            <tr>
                <td scope="row">{{$source->id}}</td>
                <td><a href="{{url('sources', [$source->id])}}">{{$source->name}}</a></td>
                <td><a href="{{url('sources', [$source->id, 'edit'])}}">Edit</a></td>
                <td>
                    <form action="{{url('sources', [$source->id])}}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-danger" value="Delete"/>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
