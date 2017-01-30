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
                        <h1 class="page-header">Dashboard</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    {{--students-panel--}}
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ $users->count() }}</div>
                                        <div>My Student(s)</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('myStudents') }}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{--signature-panel--}}
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-pencil fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        @if(auth()->user()->accepted == 1)
                                            <h3><a href="" data-toggle="modal" data-target="#digitalID" style="color: #fff !important;">Show ID</a></h3>

                                        @else
                                            <h3>Not Available</h3>
                                        @endif
                                        <div>My ID</div>
                                    </div>
                                </div>
                            </div>
                                <div class="panel-footer text-danger">
                                    @if(auth()->user()->accepted == 1)
                                        <span class="pull-left">Serve as your Digital ID</span>
                                        <div class="clearfix"></div>
                                    @else
                                        <span class="pull-left">Until admin accept your request.</span>
                                        <div class="clearfix"></div>
                                    @endif

                                </div>
                        </div>
                    </div>
                    {{--users-panel--}}
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ auth()->user()->logs()->where('deleted', 0)->count() }}</div>
                                        <div>My Activity</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('adviserActivityLogs') }}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="chat-panel panel panel-default" id="chat">
                            <div class="panel-heading">
                                <i class="fa fa-users fa-fw"></i>
                                My Students
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <ul class="chat">
                                    @if($users->count() != 0)
                                        @foreach($users as $user)
                                                <li>
                                                    {{ $user->name }}
                                                </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel .chat-panel -->
                    </div>

                    <div class="col-lg-4">
                        <div class="chat-panel panel panel-default" id="chat">
                            <div class="panel-heading">
                                <i class="fa fa-suitcase fa-fw"></i>
                                On Duty
                                <span class="pull-right">
                                    {{ $onDuty->count() }}/{{ $users->count() }}
                                </span>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <ul class="chat">
                                    @if($users->count() != 0)
                                        @foreach($users as $user)
                                            <li>
                                                {{ $user->name }}
                                                    @if($user->onDuty == 1)
                                                    <span class="pull-right text-success">
                                                        <span class="fa fa-toggle-on fa-fw"></span> On Duty
                                                    </span>
                                                    @else
                                                    <span class="pull-right text-muted">
                                                        <span class="fa fa-toggle-off fa-fw"></span> Off Duty
                                                    </span>
                                                    @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="panel chat-panel panel-default">
                            <div class="panel-heading">
                                <span class="fa fa-comments-o"></span> Messages
                            </div>
                            <div class="panel-body">
                                <ul class="chat">
                                @if($my_messages->count())
                                    @foreach($my_messages as $message)
                                    <a href="{{ route('adviserChat', encrypt($message->sender))}}" style="text-decoration: none;">
                                        <li style="padding: 5px;">
                                            <div class="">
                                                <span class="text-primary"><b>{{ $users->find($message->sender)->name }}</b></span><br>
                                                <span>{{ $message->message }}</span><br>
                                                <span class="small text-muted">{{ $message->created_at->format('M d') }} at {{ $message->created_at->format('h:i a') }} </span>
                                            </div>
                                        </li>
                                    </a>
                                    @endforeach()
                                @else
                                    <li>No new message</li>
                                @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <div class='modal fade' id='digitalID' role='dialog'>
        <div class='modal-dialog modal-sm'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    <h4 class='modal-title'>Digital ID</h4>
                </div>
                <div class='modal-body text-center'>
                    <span class="lead">{{ $signature->where(['deleted' => '0', 'user_id' => auth()->user()->id])->first()->signature }}</span>
                </div>
                <div class='modal-footer'>
                    <span class="small text-muted">&copy; BulSU OJT Monitoring System</span>
                </div>
            </div>
        </div>
    </div>
@stop