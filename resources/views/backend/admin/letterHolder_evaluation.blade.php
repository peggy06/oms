@extends('templates.map')


<div id="wrapper">
    <!-- Navigation -->
    @include('backend.admin.templates.nav')
            <!-- Page Content -->
    <div id="page-wrapper">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">My Document</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ route('adminStudentProfile', $id) }}" class="btn btn-info btn-circle"><span class="fa fa-arrow-left fa-fw"></span></a>  OJT Evaluation
                    </div>
                    <div class="panel-body">
                        <iframe src="{{ route('adminShowEvaluation', $id) }}" frameborder="0" width="100%" height="1008"></iframe>
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

