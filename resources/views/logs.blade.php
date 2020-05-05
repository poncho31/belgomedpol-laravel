@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="pull-left" style="width:45%;">
        <label for="">Erreurs : </label>
        <table class="table">
            <tr>
                <td>Date</td>
                <td>Message</td>
            </tr>
            @foreach($errorLogs as $log)
                <tr>
                    <td>{{ $log->created_at }}</td>
                    <td>{{ $log->message }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    
    <div class="pull-left" style="width:45%;">
        <label for="">Run : </label>
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
    </div>
</div>
@endsection
