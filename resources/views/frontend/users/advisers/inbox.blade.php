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
                                <div class="col-lg-6 col-lg-offset-3">
                                    <div class="chat-panel panel panel-default" id="chat">
                                        <div class="panel-heading">
                                            <i class="fa fa-comments-o fa-fw"></i>
                                            Messages
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <ul class="chat">
                                                @foreach($users->where(['deleted' => 0, 'confirmed' => 1])->get() as $user)
                                                    @if($user->id == 1 or $user->under_to == auth()->user()->id)
                                                        @if($user->id != auth()->user()->id)
                                                                <a href="{{ route('adviserChat', encrypt($user->id))}}">
                                                                    <li class="text-right">
                                                                        <span class="pull-left">
                                                                        {{ $user->name }} <span class="badge">{{$messages->where(['receiver' => auth()->user()->id, 'sender' => $user->id, 'seen' => 0])->count() != 0 ? $messages->where(['receiver' => auth()->user()->id, 'sender' => $user->id, 'seen' => 0])->count() : '' }}</span>
                                                                        </span>
                                                                    <span >
                                                                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal{{ $user->id }}"><b>@ Email me</b></a>
                                                                    </span>
                                                                    </li>
                                                                </a>
                                                            <!-- Modal -->
                                                            <div id="myModal{{ $user->id }}" class="modal fade" role="dialog">
                                                                <div class="modal-dialog modal-sm">

                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            <h4 class="modal-title">Compose Email</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {{ Form::open(['method' => 'post', 'url' => route('sendEmail')]) }}
                                                                            <div class="form-group">
                                                                                <label for="">To:</label>
                                                                                {{ Form::text('to', $user->email, ['class' => 'form-control', 'readonly' => 'true']) }}
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">From: </label>
                                                                                {{ Form::text('from', auth()->user()->email, ['class' => 'form-control', 'readonly' => 'true']) }}
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Subject: </label>
                                                                                {{ Form::text('subject', null, ['class' => 'form-control']) }}
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Message:</label>
                                                                                {{ Form::textarea('message', null, ['rows' => '5', 'class' => 'form-control', 'required' => 'true']) }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            {{ Form::submit('Send', ['class' => 'btn btn-primary']) }}
                                                                            <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                                                                        </div>

                                                                        {{ Form::close() }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach

                                            </ul>
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel .chat-panel -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session()->has('cantSendEmail'))
        {!! session()->get('cantSendEmail') !!}
    @endif
@stop