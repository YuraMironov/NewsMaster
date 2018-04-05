@extends('layout.layout')

@section('content')
        <table>
            <thead>
                <th>Date</th>
                <th>Info</th>
            </thead>
            <tbody>
                @foreach($result as $date => $words)
                    <tr>
                        <td>== {{$date}} ==</td>
                        <td>
                            @foreach($words as $word)
                                <a href="{{url('keywords', [$word->id])}}">{{$word->keyword}}</a> {{' ' . $word->articles_count}}
                                </br>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@endsection