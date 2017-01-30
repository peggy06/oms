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
                        <h1 class="page-header">Progress Report</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-bar-chart-o fa-fw"></i> Student Progress Report
                                 <span class="pull-right small" >
                                    <a href="javascript:ready()" id="printer" class="btn btn-success btn-sm"><i class="fa fa-print fa-fw"></i> Print</a>                            
                                </span>
                            </h4>
                           
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-hover">
                                                <thead class="text-center">
                                                    <td>Name</td>
                                                    <td>Company</td>
                                                    <td>Hours Rendered</td>
                                                </thead>
                                                <tbody>
                                                    @foreach($users as $user)
                                                    <tr>
                                                        <td>{{ $user->name }}</td>
                                                        <td>
                                                        @if(count($company->find($user->profile->company_id)))
                                                            {{ $company->find($user->profile->company_id)->name }}, {{$company->find($user->profile->company_id)->address}} 
                                                        @else
                                                            no company yet
                                                        @endif
                                                        </td>
                                                        <td>
                                                            @if($user->profile->number_of_hours_rendered < 60)
                                                                {{ $user->profile->number_of_hours_rendered }} seconds
                                                            @elseif($user->profile->number_of_hours_rendered  < 3600)
                                                                {{ number_format($user->profile->number_of_hours_rendered / 60, 0) }} minutes
                                                            @elseif($user->profile->number_of_hours_rendered > 3600)
                                                                {{ number_format($user->profile->number_of_hours_rendered / 60 / 60, 0) }} minutes
                                                            @endif
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
    <script>
        function ready(){
            document.getElementById('printer').setAttribute('style', 'display: none');
            window.print();

            document.getElementById('printer').setAttribute('style', 'margin-right: 80px; display: block');
        }
    </script>
@stop