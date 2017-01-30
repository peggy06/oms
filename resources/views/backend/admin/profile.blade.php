@extends('templates.master')

@section('content')
    @include('backend.admin.templates.nav')
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Profile</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-user fa-fw"></i> User Profile</h4>
                        </div>
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table ">
                                    <tbody>
                                    <tr>
                                        <td>Name:</td>
                                        <td class="text-right">{{ auth('admin')->user()->name }}</td>
                                        <td><a href=""><div class="small text-left"><span class="fa fa-pencil fa-fw"></span> Edit</div></a></td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td class="text-right">{{ auth('admin')->user()->email }}</td>
                                        <td><a href="{{ route('setEmail') }}"><span class="small"><span class="fa fa-edit fa-fw "></span> Edit</span></a></td>
                                    </tr>
                                    <tr>
                                        <td>Password:</td>
                                        <td class="text-right">******</td>
                                        <td><a href="{{ route('setPass') }}"><span class="small"><span class="fa fa-edit fa-fw "></span> Edit</span></a></td>
                                    </tr>
                                    </tbody>
                                </table>
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