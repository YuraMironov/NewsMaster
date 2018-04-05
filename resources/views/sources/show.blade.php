@extends('layout.layout')

@section('content')
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">edit</th>
            <th scope="col">delete</th>
        </tr>
        </thead>
        <tbody>
        {{--@foreach($tasks as $task)--}}
            <tr>
                <th scope="row">{{$source->id}}</th>
                <td >{{$source->name}}</td>
                <td><a href="{{url('sources', [$source->id, 'edit'])}}">Edit</a></td>
                <td>
                    <form action="{{url('sources', [$source->id])}}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-danger" value="Delete"/>
                    </form>
                </td>
            </tr>
        {{--@endforeach--}}
        </tbody>
    </table>
@endsection