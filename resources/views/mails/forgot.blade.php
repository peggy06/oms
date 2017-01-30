@extends('templates.master')

@section('content')
    <div class="container">
        <p>
            Recover Account:
            <br>
            <a href="{{ route('userConfirmation', $code) }}">Please use this link to recover your account</a>
            <br>
        </p>
        Thanks,<br>
        OJT Monitoring BOTS
    </div>
@stop