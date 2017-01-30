@extends('templates.master')

@section('content')
    <div class="container">
        <p>
            {{ $msg }}
            <br>
            <br>
            From: {{ $nameFrom }} ({{ $emailFrom }})<br>
            <span class="small text-muted">Send using BulSU OMS - Mailing System</span><br>
            <span style="font-size: 10pt;color: #880000">Note: This is a system generated email, do not reply on this message.</span>
        </p>
    </div>
@stop