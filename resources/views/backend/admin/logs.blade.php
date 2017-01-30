@extends('templates.master')

@section('content')
    <div id="wrapper">

        <!-- Navigation -->
        @include('backend.admin.templates.nav')
                <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">e-Logbook</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>
                            <span class="fa fa-list-alt fa-fw"></span> Activity Logs | <span class="small">Showing all user's activities, including you.</span>
                            {{--@if(session()->has('deletedLogs'))--}}
                                {{--<i class="fa fa-trash fa-fw"></i> Deleted Logs |--}}
                                {{--<span class="small"><a href="{{ route('activeLogs') }}">Activity Log</a></span>--}}
                                {{--<div class="pull-right">--}}
                                    {{--<a href="{{ route('restoreLogs') }}"><span class="glyphicon glyphicon-trash"></span> Restore All</a>--}}
                                {{--</div>--}}
                            {{--@else--}}
                                {{--<i class="fa fa-list-alt fa-fw"></i> Activity Log |--}}
                                {{--<span class="small"><a href="{{ route('deletedLogs') }}">Deleted Log</a></span>--}}
                                {{--TODO: decide if this function will be added or it was too risky ?--}}
                                {{--<div class="pull-right">--}}
                                {{--<a href="{{ route('resetLogs') }}" class="text-danger"><span class="fa fa-minus-circle fa-fw"></span> Delete All</a>--}}
                                {{--</div>--}}
                            {{--@endif--}}
                            </h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <th>User</th>
                                        <th>Activity</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach( $logs->where('deleted', '0')->get() as $log)
                                            <tr class="odd gradeX">
{{--                                                <td>{{ $users->where('id', $log->user_id)->first()->name == auth('admin')->user()->name ? "You" : $users->where('id', $log->user_id)->first()->name }}</td>--}}
                                                <td>{{ $users->where('id', $log->user_id)->first()->name }}</td>
                                                <td>{{ $log->activity }}</td>
                                                <td>
                                                    @if($log->created_at->format('M. d, Y') == \Carbon\Carbon::yesterday()->format('M. d, Y'))
                                                        {{ 'Yesterday, ' }}
                                                    @elseif($log->created_at->format('M. d, Y') == \Carbon\Carbon::today()->format('M. d, Y'))
                                                        {{ 'Today, ' }}
                                                    @else
                                                        {{ $log->created_at->diffForHumans().', ' }}
                                                    @endif
                                                    {{ $log->created_at->format('M. d, Y') }}
                                                </td>
                                                <td class="center"><a href="" data-toggle="modal" data-target="#activityModal{{ $log->id }}">View Details</a></td>
                                            </tr>

                                            <div class='modal fade' id='activityModal{{ $log->id }}' role='dialog'>
                                                <div class='modal-dialog modal-sm'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                            <h4 class='modal-title'>Detailed View</h4>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <ul class="list-unstyled">
                                                                <li>{{$users->where('id', $log->user_id)->first()->name}}</li>
                                                                <li>{{ $log->activity }}</li>
                                                                <li>at {{$log->created_at->format('M. d, Y h:i:s A')}}, {{ $log->created_at->diffForHumans() }}</li>
                                                            </ul>
                                                        </div>
                                                        <div class='modal-footer'>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
@stop