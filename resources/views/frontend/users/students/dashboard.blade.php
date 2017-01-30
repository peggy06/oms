@extends('templates.master')

@section('content')

    <div id="wrapper">
        <!-- Navigation -->
        @include('frontend.users.students.templates.nav')
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            @if($users->find(auth()->user()->id)->profile->company_id == 0)
                                Company
                            @else
                                Profile
                            @endif
                        </div>
                        <div class="panel-body">
                            @if($users->find(auth()->user()->id)->profile->company_id == 0)
                                <div class="row">
                                    <div class="col-md-6">
                                        @include('frontend.users.students.templates.map')
                                        <br>
                                        <div class="clearfix text-center">
                                            <span class="lead"> OR </span><br>
                                            <span class="small text-muted text-center">
                                                INPUT IT MANUALLY
                                            </span>
                                        </div>
                                        <br>
                                        {{ Form::open(['method' => 'post', 'url' => route('studentAddCompany')]) }}
                                            <div class="form-group {{ $errors->has('company_name') ? 'has-error' : "" }}">
                                                {!! $errors->first('company_name', '<span class="text-danger">:message</span>') !!}
                                                {{ Form::text('company_name', null, ['id' => 'company_name', 'class' => 'form-control', 'placeholder' => 'Company Name']) }}
                                            </div>
                                            <div class="form-group {{ $errors->has('company_address') ? 'has-error' : "" }}">
                                                {!! $errors->first('company_address', '<span class="text-danger">:message</span>') !!}
                                                {{ Form::textarea('company_address', null, ['id' => 'company_address', 'class' => 'form-control', 'placeholder' => 'Company Exact Address', 'rows' => 3, 'style' => 'resize: none']) }}
                                            </div>
                                            {{ Form::hidden('company_lat', null, ['id' => 'company_lat']) }}
                                            {{ Form::hidden('company_lng', null, ['id' => 'company_lng']) }}
                                            {{ Form::submit('Add as Company Choice', ['class' => 'btn btn-primary btn-sm    ', 'id' => 'addCompany']) }}
                                        {{ Form::close() }}
                                        <br>
                                    </div>
                                    <div class="col-md-6">
                                            <div class="chat-panel panel panel-default">
                                                <div class="panel-heading">Company Choice</div>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-bordered table-hover ">
                                                        <thead>
                                                        <tr class="small">
                                                            <td>Company</td>
                                                            <td>Action</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="small">
                                                            @if($choices->count() != 0)
                                                                @foreach($choices as $choice)
                                                                    <tr>
                                                                        <td width="50%">
                                                                            {{ $choice->name }}, <br>
                                                                            {{ $choice->address }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <a href="{{ route('studentSetCompany', $choice->id) }}" class="btn btn-social-icon btn-success"><span class="fa fa-map-marker fa-fw" style="font-size: 12pt"></span></a>
                                                                            <a href="{{ route('showRecommendation', $choice->id) }}" class="btn btn-primary btn-social-icon"><span class="fa fa-file-text fa-fw"></span></a>
                                                                            <a href="{{ route('studentRemoveCompany', $choice->id) }}" class="btn btn-danger btn-social-icon"><span class="fa fa-remove fa-fw"></span></a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @else
                                @if($users->find(auth()->user()->id)->profile->technology_area != "" and $users->find(auth()->user()->id)->profile->company_supervisor != "" and $users->find(auth()->user()->id)->profile->company_contact != "")
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <span class="fa fa-user fa-fw"></span> Personal Information

                                                </div>
                                                <div class="panel-body">
                                                    <ul class="list-unstyled">
                                                        <li>
                                                        <span class="lead">
                                                            {{ auth()->user()->name }}
                                                        </span><br>
                                                        <span class="small text-muted">
                                                            <span class="fa fa-phone fa fw"></span>&nbsp; 0{{ $users->find(auth()->user()->id)->profile->contact }}
                                                        </span><br>
                                                        <span class="small text-muted">
                                                            @&nbsp; {{ auth()->user()->email }}
                                                        </span><br>
                                                        <span class="small text-muted">
                                                            <span class="fa fa-institution fa-fw"></span>&nbsp; {{ $course->code }}
                                                        </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="panel panel-danger">
                                                <div class="panel-heading">
                                                    <span class="fa fa-building fa-fw"></span> Company Information
                                                </div>
                                                <div class="panel-body" style="overflow-y: scroll">
                                                    <ul class="list-unstyled">
                                                        <li>
                                                        <span class="lead">
                                                            {{ $company->find($users->find(auth()->user()->id)->profile->company_id)->name }}
                                                        </span><br>
                                                        <span class="small text-muted">
                                                            <span class="fa fa-phone fa fw"></span>&nbsp; 0
                                                        </span><br>
                                                        <span class="small text-muted">
                                                            <span class="fa fa-map-marker fa-fw"></span>&nbsp; {{ $company->find($users->find(auth()->user()->id)->profile->company_id)->address }}
                                                        </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="panel panel-success">
                                                <div class="panel-heading">
                                                    <span class="fa fa-bar-chart fa-fw"></span> Progress
                                                </div>
                                                <div class="panel-body">
                                                <span class="lead">
                                                    {{ number_format($progress, 2) }}%
                                                </span><br>
                                                    <br>
                                                <span class="small">
                                                    Total Hour(s) Rendered: 
                                                    @if(auth()->user()->profile->number_of_hours_rendered < 60)
                                                        {{ number_format(auth()->user()->profile->number_of_hours_rendered, 2)  }} secs
                                                    @elseif(auth()->user()->profile->number_of_hours_rendered < 3600)
                                                        {{ number_format(auth()->user()->profile->number_of_hours_rendered /60 , 2)}} mins
                                                    @elseif(auth()->user()->profile->number_of_hours_rendered > 3600)
                                                        {{ number_format(auth()->user()->profile->number_of_hours_rendered / 60 / 60  , 2)}} hrs
                                                    @endif
                                                     <br>
                                                    No. of Training Hours Required: 
                                                    @if($course->find(auth()->user()->profile->course)->id == 1)
                                                        {{ $hours->find(1)->bsit }} hrs
                                                    @else
                                                        {{ $hours->find(1)->bit }} hrs
                                                    @endif
                                                </span><br>&nbsp;
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="chat-panel panel panel-default" style="">
                                                <div class="panel-heading">
                                                    <span class="fa fa-clock-o fa-fw"></span> DTR <span class="small text-muted">(Daily Time Record)</span>
                                                </div>
                                                <div class="panel-body">

                                                    {{--TODO: remove style diplay: none--}}
                                                    <div id="loadingCoordinates" class="panel-body text-center" style="position: absolute;top: 0; left: 0;width: 100%;height: 100%; background-color: #e2e2e2;z-index: 1;opacity: 0.8">
                                                        <br><span class="lead">
                                                        Please wait for a while ... <br>
                                                        <span class="small text-muted">We're fetching your coordinates</span>
                                                    </span>
                                                    </div>
                                                    <div class="well well-md">
                                                        @if(session()->has('failed'))
                                                            <div class="text-danger">
                                                                {{ session()->get('failed') }}
                                                            </div>
                                                        @endif
                                                        {{ Form::open(['method' => 'post', 'url' => route('timeIn')]) }}
                                                        {{ Form::hidden('myLat', null, ['id' => 'myLat'] ) }}
                                                        {{ Form::hidden('myLng', null, ['id' => 'myLng'] ) }}
                                                        <span class="text-danger" id="coordinatesAlert">
                                                        @if(session()->has('far'))
                                                                {{ session()->get('far') }}
                                                        @endif
                                                    </span><br>
                                                        <div class="btn-group">
                                                            @if($today_record->count() != 0)
                                                                <button type="submit" class="btn {{ $today_record->first()->status == 1 ? 'btn-default disabled' : 'btn-success' }}" id="btnTimeIn" {{ $today_record->first()->status == 1 ? 'disabled' : '' }}> <span class="fa fa-clock-o fa-fw"></span> Time-in</button>
                                                                <a data-toggle="modal" data-target="#timeOutModal" class="btn {{ $today_record->first()->status == 1 ? 'btn-danger' : 'disabled btn-default' }}"> <span class="fa fa-sign-out fa-fw"></span>Time out</a>
                                                            @else
                                                                <button type="submit" class="btn btn-success" id="btnTimeIn"> <span class="fa fa-clock-o fa-fw"></span> Time-in</button>
                                                                <a data-toggle="modal" data-target="#timeOutModal" class="btn disabled btn-default"> <span class="fa fa-sign-out fa-fw"></span>Time out</a>
                                                            @endif
                                                        </div>

                                                        <div class="pull-right">
                                                            <a class="btn btn-warning btn-md" href="{{ route('changeCompany') }}">Change Company</a>
                                                        </div>
                                                        {{ Form::close() }}


                                                    </div>
                                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                        <thead>
                                                        <tr>
                                                            <td>Date</td>
                                                            <td>Time-in</td>
                                                            <td>Time-out</td>
                                                            <td>Company</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if($dtr->count() != 0)
                                                            @foreach($dtr as $time_record)
                                                                <tr>
                                                                    <td>{{ $time_record->date }}</td>
                                                                    <td>{{ $time_record->created_at->format('h:i:s a') }}</td>
                                                                    <td>{{ $time_record->updated_at->format('h:i:s a') == $time_record->created_at->format('h:i:s a') ? '-:-:- -' : $time_record->updated_at->format('h:i:s a') }}</td>
                                                                    <td>{{ $time_record->company }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </div>

                        <div class='modal fade' id='timeOutModal' role='dialog'>
                            <div class='modal-dialog modal-sm'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        <h4 class='modal-title'>Time-out</h4>
                                    </div>
                                    <div class='modal-body'>
                                        <div class="article">

                                            <span class="fa fa-exclamation-triangle fa-3x pull-left text-danger"></span>
                                            @if(Carbon\Carbon::now()->format('H:i:s') < auth()->user()->profile->sched_off)
                                                <span class="text-danger small">This will be register as UNDERTIME</span><br>
                                            @endif
                                            Are you sure you want to Time out ?
                                            <br>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <div class="pull-right">
                                            @if(Carbon\Carbon::now()->format('H:i:s') < auth()->user()->profile->sched_off)
                                                <a data-toggle="modal" data-target="#reasonModal" data-dismiss='modal' class="btn btn-danger btn-md"> Yes</a>
                                            @else
                                                <a href="{{ route('timeOUt') }}" class="btn btn-danger btn-md"> Yes</a>
                                            @endif
                                            <button type='button' class='btn btn-primary' data-dismiss='modal'> No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='modal fade' id='reasonModal' role='dialog'>
                            <div class='modal-dialog modal-sm'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        <h4 class='modal-title'>
                                            @if($today_record->count() != 0 and $today_record->first()->created_at->diffInHours(Carbon\Carbon::now()) < 9)
                                                UNDERTIME
                                            @endif
                                        </h4>
                                    </div>
                                    <div class='modal-body'>
                                        Tell your reason: <br>
                                        {{ Form::open(['method' => 'post', 'url' => route('timeOut', $users->find(auth()->user()->under_to)->profile->contact)]) }}
                                        <div class="form-group">
                                            {{ Form::textarea('reason', null, ['class' => 'form-control', 'required' => 'true']) }}
                                        </div>
                                        {{ Form::submit('Submit', ['class' => 'btn btn-success'] ) }}
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>


                        <script type="text/javascript">
                            window.onload = function () {
                                navigator.geolocation.getCurrentPosition(c);
                                return false;
                            }

                            var c = function (pos) {
                                var myLat = pos.coords.latitude;
                                var myLng = pos.coords.longitude;

                                document.getElementById('myLat').value=myLat;
                                document.getElementById('myLng').value=myLng;
                                var deg2rad = Math.PI/180;
                                var latFrom = myLat * deg2rad;
                                var lngFrom = myLng * deg2rad;
                                   // var latFrom = 0.25814353388146; //tentative , to test time-in
                                   // var lngFrom = 2.1131014365963;
                                var latTo = {{ deg2rad($company->find($users->find(auth()->user()->id)->profile->company_id)->latitude) }};
                                var lngTo = {{ deg2rad($company->find($users->find(auth()->user()->id)->profile->company_id)->longitude) }};
                               // var latTo = myLat * deg2rad;
                               // var lngTo = myLng * deg2rad;
                                var earthRadius = 6371000;

                                var latDelta = latTo - latFrom;
                                var lngDelta = lngTo - lngFrom;
                                var angle = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(latDelta / 2), 2) + Math.cos(latFrom) * Math.cos(latTo) * Math.pow(Math.sin(lngDelta / 2), 2)));
                                var distance = angle * earthRadius;

                                if(distance > 50){
                                    document.getElementById('btnTimeIn').setAttribute('disabled', 'true');
                                    document.getElementById('coordinatesAlert').innerHTML="Too far from the company";
                                }

                                if(document.getElementById('myLat').value != 0){
                                    document.getElementById('loadingCoordinates').setAttribute('style', 'display: none');
                                }

                            }
                        </script>

                                @else
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-3">
                                            <div class="well well-lg">
                                                {{ Form::open(['method' => 'post', 'url' => route('studentSetCompanyProfile')]) }}
                                                    {!! $errors->first('tech_area', '<span class="text-danger">:message</span><br>') !!}
                                                    <div class="form-group input-group {{ $errors->has('tech_area') ? 'has-error' : "" }}">

                                                        {{ Form::input('text', 'tech_area', null, ['class' => 'form-control', 'placeholder' => 'Technology Area']) }}
                                                    </div>
                                                    {!! $errors->first('comp_sup', '<span class="text-danger">:message</span><br>') !!}
                                                    <div class="form-group input-group {{ $errors->has('comp_sup') ? 'has-error' : "" }}">

                                                        {{ Form::input('text', 'comp_sup', null, ['class' => 'form-control', 'patter' => '[A-Za-z]', 'placeholder' => 'Supervisor']) }}
                                                    </div>
                                                    {!! $errors->first('comp_contact', '<span class="text-danger">:message</span><br>') !!}
                                                    <div class="form-group input-group {{ $errors->has('comp_contact') ? 'has-error' : "" }}">
                                                        <span class="input-group-addon">+63</span>
                                                        {{ Form::number('comp_contact', null, ['class' => 'form-control', 'placeholder' => 'Contact Number']) }}
                                                    </div>
                                                    Schedule:
                                                    {!! $errors->first('comp_contact', '<span class="text-danger">:message</span><br>') !!}
                                                    <div class="form-group {{ $errors->has('comp_contact') ? 'has-error' : "" }}">
                                                        <label for="sched_on" class="control-label col-sm-5">Time-in:</label>
                                                        <div class="col-sm-7">
                                                            {{ Form::time('sched_on', null, ['class' => 'form-control', 'placeholder' => 'hh:mm aa']) }}
                                                        </div>
                                                    </div>
                                                <br>
                                                    {!! $errors->first('comp_contact', '<span class="text-danger">:message</span><br>') !!}
                                                    <div class="form-group {{ $errors->has('comp_contact') ? 'has-error' : "" }}" style="margin-top: 5px;">
                                                        <label for="sched_off" class="control-label col-sm-5">Time-out:</label>
                                                        <div class="col-sm-7">
                                                            {{ Form::time('sched_off', null, ['class' => 'form-control', 'placeholder' => 'hh:mm aa']) }} &nbsp;
                                                        </div>
                                                    </div>
                                                    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                                {{ Form::close() }}

                                            </div>
                                        </div>
                                    </div>
                                @endif
                        @endif
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

@stop