@extends('layout.layout')

@section('content')
    <h1>Create New</h1>
    <hr>
    <form action="{{url('articles', [$article->id])}}" method="POST">
        <input type="hidden" name="_method" value="PUT">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="articleTitle">Article Title</label>
            <input type="text" class="form-control" id="articleTitle" name="title" value="{{$article->title}}">
        </div>
        <div class="form-group">
            <label for="ArticleDescription">Article Description</label>
            <input type="text" width="150px" height="100px" class="form-control" id="ArticleDescription"
                   name="description"  value="{{$article->description}}">
        </div>
        <div class="form-group">
            <label for="articleUrl">Article Url</label>
            <input type="text" class="form-control" id="articleUrl" name="url"  value="{{$article->url}}">
        </div>
        <div class="form-group">
            <label for="articleImgUrl">Article image url</label>
            <input type="text" class="form-control" id="articleImgUrl" name="urltoimage"  value="{{$article->urltoimage}}">
        </div>
        <div class="form-group">
            <label for="articleAuthor">Article author</label>
            <input type="text" class="form-control" id="articleAuthor" name="author"  value="{{$article->author}}">
        </div>
        <div class="form-group">
            <label for="articleSource">Article source</label>
            <select id="articleSource" name="source_id">
                @foreach($sources as $source)
                    <option value="{{$source->id}}"
                    @if($source->id == $article->source_id)
                        selected
                    @endif
                    >{{$source->name}}</option>
                @endforeach
            </select>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection