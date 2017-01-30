@extends('templates.master')

@section('content')

    <div id="wrapper">

        <!-- Navigation -->
        @include('backend.admin.templates.nav')
                <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Users</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-user fa-fw"></i> Student List</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach( $users->where(['role' => 5, 'confirmed' => 1])->get() as $user )
                                        <tr class="odd gradeX">
                                            <td>{{ $user->name }}</td>
                                            <td class="center"><a href="{{ route('adminStudentProfile', $user->id) }}" class="btn btn-sm btn-success {{ $users->find($user->id)->profile->company_id != 0 ? '' : 'disabled' }}">View Profile</a></td>
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
@stop