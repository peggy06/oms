@extends('templates.master')

@section('content')
    @include('backend.templates.nav')
    <br>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="well well-lg">
                    <div class="panel-heading">
                        <h4>Forgot Password</h4>
                    </div>
                    <div class="panel-body">
                        <h4>
                            Enter your email to recover your account
                        </h4>
                        @if(session()->has('noUser'))
                            <span class="text-danger small">{{ session()->get('noUser') }}</span> <br>
                        @endif
                        {{ Form::open(['method' => 'post', 'url' => route('recover')]) }}
                        <div class="form-group">
                            {{ Form::email('email', null, ['class' => 'form-control', 'required' => 'true', 'placeholder' => 'Enter email to recover']) }}
                        </div>
                        {{ Form::submit('Recover', ['class' => 'btn btn-success btn-md']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop