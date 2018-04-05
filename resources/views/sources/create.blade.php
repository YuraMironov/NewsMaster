@extends('layout.layout')

@section('content')
    <h1>Add New Task</h1>
    <hr>
    <form action="{{url('sources')}}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title">Task Name</label>
            <input type="text" class="form-control" id="sourceName"  name="name">
        </div>
        {{--<div class="form-group">--}}
            {{--<label for="description">Task Description</label>--}}
            {{--<input type="text" class="form-control" id="taskDescription" name="description">--}}
        {{--</div>--}}
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