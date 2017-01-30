@extends('templates.master')

@section('content')
    <div id="wrapper">

        <!-- Navigation -->
        @include('frontend.users.students.templates.nav')
                <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">OJT Forms</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            My Documents
                        </div>
                        <div class="panel body">
                            <br>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-3">
                                    <div class="well well-lg">
                                        <ul class="list-unstyled chat">
                                            @if(auth()->user()->accepted == 0)
                                                <li>
                                                   <span class="text-muted">Unavailable until accepted by your adviser</span>
                                                </li>
                                            @else
                                                <li><a href="{{ route('showWaiverLetter') }}">Waiver</a></li>
                                                <li><a href="{{ route('showPersonalLetter') }}">Personal Information</a></li>
                                                <li><a href="{{ route('showEvaluationLetter') }}">OJT Evaluation</a></li>
                                                <li>SWASS
                                                    <ul class="list-unstyled" style="text-indent: 20px;">
                                                        @for($ctr = 1; $ctr <= $week_no; $ctr++)
                                                            <li><a href="{{ route('showSwassLetter', $ctr) }}">week no. {{ $ctr }}</a></li>
                                                        @endfor
                                                    </ul>
                                                </li>
                                            @endif
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
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
@stop