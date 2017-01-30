@extends('templates.master')

@section('content')

    <div id="wrapper">

        <!-- Navigation -->
        @include('frontend.users.advisers.templates.nav')
                <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">My Inbox</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-comment fa-fw"></i> Chat</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel panel-default  chat-panel">
                                        <div class="panel-heading">
                                            OJT Forms Upload
                                        </div>
                                        <div class="panel-body">
                                            {{ Form::open(['method' => 'post', 'url' => route('formUpload'), 'files' => true])  }}
                                        <div class="form-group{{ $errors->has('form') ? 'has-error' : "" }}">
                                            {!! $errors->first('form', '<span class="text-danger">:message</span>') !!}
                                             {{ Form::file('form', null, ['class' => 'form-control']) }}
                                        </div>
                                        <br>
                                        {{ Form::submit('Upload File', ['class' => 'btn btn-primary btn-md'])}}
                                    {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel panel-default chat-panel">
                                        <div class="panel-heading">
                                            Uploaded Forms
                                        </div>
                                        <div class="panel-body">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead class="text-center">
                                                    <td>Filename</td>
                                                    <td>Action</td>
                                                </thead>
                                                <tbody>
                                                    @foreach($forms as $form)
                                                    <tr>
                                                        <td width="50%">{{ $form->name }}</td>
                                                        <td class="text-right">
                                                            <a href="{{ $form->path }}" download>Dowload</a> | 
                                                            <a href="{{ route('formRemove', $form->id) }}"> Remove</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop