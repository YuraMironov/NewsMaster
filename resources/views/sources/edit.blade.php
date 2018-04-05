@extends('layout.layout')

@section('content')
    <h1>Edit New Source</h1>
    <hr>
    <form action="{{url('sources', [$source->id])}}" method="POST">
        <input type="hidden" name="_method" value="PUT">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title">Source Name</label>
            <input type="text" class="form-control" id="sourceName"  name="name" value="{{$source->name}}">
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