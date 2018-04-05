@extends('layout.layout')

@section('content')
    <h1>{{$keyword->keyword}}</h1>
        <table>
            <thead>
                <th>Date</th>
                <th>Use change</th>
            </thead>
            <tbody>
                <?php $old_count = 0 ?>
                @foreach($result as $date => $count)
                    <tr>
                        <td>== {{$date}} ==</td>
                        <td>
                           {{ $count - $old_count  }}
                            <?php $old_count = $count; ?>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@endsection