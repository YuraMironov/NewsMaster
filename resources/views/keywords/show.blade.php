@extends('layout.layout')

@section('content')
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <h1>Keyword info</h1>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Keyword</th>
            <th scope="col">Disable</th>
            <th scope="col">Use count</th>
            <th scope="col">Articles count</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
            <th scope="col">Articles</th>
        </tr>
        </thead>
        <tbody style="vertical-align: top;">
            <tr>
                <td >{{$keyword->keyword}}</td>
                <td><input type="checkbox" disabled @if($keyword->disable) checked @endif></td>
                <td >{{$keyword->counter}}</td>
                <td >{{count($keyword->articles)}}</td>
                <td><a href="{{url('keywords', [$keyword->id, 'edit'])}}">Edit</a></td>

                <td>
                    <form action="{{url('keywords', [$keyword->id])}}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-danger" value="Delete"/>
                    </form>
                </td>
                <td style="text-align: left">
                    @foreach($keyword->articles as $article)
                        <a href="{{url('articles', [$article->id])}}">{{$article->title}}</a>
                        </br>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
@endsection