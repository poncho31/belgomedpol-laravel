@extends('layouts.app')

@section('content')
    <table class="table">
        <tr>
            <td>Date</td>
            <td>Message</td>
        </tr>
        @foreach($logs as $log)
            <tr>
                <td>{{ $log->created_at }}</td>
                <td>{{ $log->message }}</td>
            </tr>
        @endforeach
    </table>
@endsection
