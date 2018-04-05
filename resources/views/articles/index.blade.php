@extends('layout.layout')

@section('content')
    <h1>Articles</h1>
    <form method="get">
        <input type="text" name="q" alt="Search news" placeholder="query input">
        <button type="submit">Go!</button>
    </form>
    <a href="{{url('articles/create')}}">Add new articles</a>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Source</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        @foreach($articles as $article)
            <tr>
                <td scope="row" style="text-align: left;"><a href="{{url('articles', [$article->id])}}">{{$article->title}}</a></td>
                <td scope="row">{{\App\Source::find($article->source_id)->name}}</td>
                <td scope="row">{{$article->publihedat}}</td>
                <td><a href="{{url('articles', [$article->id, 'edit'])}}">Edit</a></td>
                <td>
                    <form action="{{url('articles', [$article->id])}}" method="POST">
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
