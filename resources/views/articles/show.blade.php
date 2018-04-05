@extends('layout.layout')

@section('content')
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <table class="table">
        <thead class="thead-dark">
        <tr>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Published</th>
            <th scope="col">Author</th>
            <th scope="col">Source</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
            <th scope="col">Keywords</th>
        </tr>
        </thead>
        <tbody style="vertical-align: top">
            <tr>
                <td scope="row">{{$article->title}}</td>
                <td scope="row"><div style="width: 300px; height: inherit; overflow: hidden"><p>{{$article->description}}</p></div></td>
                <td scope="row">{{ $article->publishedat }}</td>
                <td scope="row">{{$article->author}}</td>
                <td scope="row">{{$article->source->name}}</td>
                <td><a href="{{url('articles', [$article->id, 'edit'])}}">Edit</a></td>
                <td>
                    <form action="{{url('articles', [$article->id])}}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-danger" value="Delete"/>
                    </form>
                </td>
                <td>
                @foreach($article->keywords as $keyword)
                    <a href="{{url('keywords', [$keyword->id])}}">{{$keyword->keyword}}</a>
                    </br>
                @endforeach
                </td>

            </tr>
        </tbody>
    </table>
@endsection