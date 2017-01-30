@extends('templates.master')

@section('content')
@include('frontend.users.advisers.templates.nav')
        <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Student Profile</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-user fa-fw"></i> {{ $user->firstname }}'s Profile</h4>
                </div>
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="panel chat-panel panel-default">
                                    <div class="panel-heading">
                                        Personal Information
                                    </div>
                                    <div class="panel-body">
                                        <span class="lead">
                                        {{ $user->lastname }}, {{ $user->firstname }}
                                    </span><br>
                                        <fa class="fa fa-phone fa-fw"></fa> 0{{ $user->profile->contact }}<br>
                                        @ {{ $user->email }}<br>
                                        <fa class="fa fa-university fa-fw"></fa> {{ $course->find($user->profile->course)->code }} {{ $section->find($user->profile->section)->section  }}
                                        <br>
                                        <span class="fa fa-clock-o fa-fw"></span>Total Hours Required:
                                        @if($course->find($user->profile->course)->id == 1)
                                            {{ $hours->find(1)->bsit }} hrs
                                        @else
                                            {{ $hours->find(1)->bit }} hrs
                                        @endif
                                        <br>
                                        &nbsp;<span class="gyphicon glyphicon-hourglass"></span> Number of Rendered Hours:
                                        @if($user->profile->number_of_hours_rendered < 60)
                                            {{ number_format($user->profile->number_of_hours_rendered, 2)  }} secs
                                        @elseif($user->profile->number_of_hours_rendered < 3600)
                                            {{ number_format($user->profile->number_of_hours_rendered /60 , 2)}} mins
                                        @elseif($user->profile->number_of_hours_rendered > 3600)
                                            {{ number_format($user->profile->number_of_hours_rendered / 60 / 60  , 2)}} hrs
                                        @endif
                                        <br>
                                        <span class="fa fa-briefcase fa-fw"></span> {{ $company->find($user->profile->company_id)->name }}
                                        <br>
                                        <span class="fa fa-map-marker fa-fw"></span> {{ $company->find($user->profile->company_id)->address }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel chat-panel panel-default">
                                    <div class="panel-heading">
                                        DTR
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <td>Date</td>
                                                <td>Time-in</td>
                                                <td>Time-out</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($dtr->count() != 0)
                                                @foreach($dtr as $time_record)
                                                    <tr>
                                                        <td>{{ $time_record->date }}</td>
                                                        <td>{{ $time_record->created_at->format('h:i:s a') }}</td>
                                                        <td>{{ $time_record->updated_at->format('h:i:s a') }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel chat-panel panel-default">
                                    <div class="panel-heading">
                                        {{ $user->firstname }}'s Documents
                                    </div>
                                    <div class="panel-body">
                                        <ul class="list-unstyled chat">
                                            <li><a href="{{ route('adviserShowWaiverLetter', $user->id) }}">Waiver</a></li>
                                            <li><a href="{{ route('adviserShowPersonalLetter', $user->id) }}">Personal Information</a></li>
                                            <li><a href="{{ route('adviserShowEvaluationLetter', $user->id) }}">OJT Evaluation</a></li>
                                            <li>SWASS
                                                <ul class="list-unstyled" style="text-indent: 20px;">
                                                    @for($ctr = 1; $ctr <= $week_no; $ctr++)
                                                        <li><a href="{{ route('adviserShowSwassLetter', [$ctr, $user->id]) }}">week no. {{ $ctr }}</a></li>
                                                    @endfor
                                                </ul>
                                            </li>
                                        </ul>
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <td>filename</td>
                                                <td>Action</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($forms->count())
                                                @foreach($forms as $form)
                                                    <tr>
                                                        <td width="50%">{{ $form->name }}</td>
                                                        <td class="text-right">
                                                            <a href="{{ $form->path }}" download>Dowload</a>
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
                    </div>
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