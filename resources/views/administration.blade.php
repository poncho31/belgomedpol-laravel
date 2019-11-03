@extends('layouts.app')

@section('content')
    <table>
        @foreach ($csv as $line)
        <tr>
            <td>{{ $line['date'] }}</td>
            <td>{{ $line['log'] }}</td>
        </tr>
        @endforeach
    </table>
@endsection
