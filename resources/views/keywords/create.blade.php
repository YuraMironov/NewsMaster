@extends('layout.layout')

@section('content')
    <h1>Add New Keyword</h1>
    <hr>
    <form action="{{url('keywords')}}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="keyword">Keyword</label>
            <input type="text" class="form-control" id="keyword"  name="keyword">
        </div>
        <div class="form-group">
            <label for="disable">Disable</label>
            <input type="checkbox" class="form-control" id="disable" name="disable">
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