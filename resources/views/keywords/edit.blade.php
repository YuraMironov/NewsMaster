@extends('layout.layout')

@section('content')
    <h1>Edit New Keyword</h1>
    <hr>
    <form action="{{url('keywords', [$keyword->id])}}" method="POST">
        <input type="hidden" name="_method" value="PUT">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="keyword">Keyword</label>
            <input type="text" class="form-control" id="keyword"  name="keyword" value="{{$keyword->keyword}}">
        </div>
        <div class="form-group">
            <label for="disable">Disable</label>
            <input type="checkbox" class="form-control" id="disable"  name="disable" @if ($keyword->disable) checked @endif>
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