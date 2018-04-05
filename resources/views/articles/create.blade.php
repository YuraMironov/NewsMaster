@extends('layout.layout')

@section('content')
    <h1>Add New Article</h1>
    <hr>
    <form action="{{url('articles')}}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="articleTitle">Article Title</label>
            <input type="text" class="form-control" id="articleTitle" name="title">
        </div>
        <div class="form-group">
            <label for="ArticleDescription">Article Description</label>
            <input type="text" width="150px" height="100px" class="form-control" id="ArticleDescription"
                   name="description">
        </div>
        <div class="form-group">
            <label for="articleUrl">Article Url</label>
            <input type="text" class="form-control" id="articleUrl" name="url">
        </div>
        <div class="form-group">
            <label for="articleImgUrl">Article image url</label>
            <input type="text" class="form-control" id="articleImgUrl" name="urltoimage">
        </div>
        <div class="form-group">
            <label for="articleAuthor">Article author</label>
            <input type="text" class="form-control" id="articleAuthor" name="author">
        </div>
        <div class="form-group">
            <label for="articleSource">Article source</label>
            <select id="articleSource" name="source_id">
                @foreach($sources as $source)
                    <option value="{{$source->id}}">{{$source->name}}</option>
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