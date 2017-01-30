<?php $__env->startSection('content'); ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php echo $__env->make('backend.admin.templates.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                                                <?php foreach($users->where(['deleted' => 0, 'confirmed' => 1])->get() as $user): ?>
                                                    <?php if($user->role == 4): ?>
                                                        <?php if($user->id != auth('admin')->user()->id): ?>
                                                            <a href="<?php echo e(route('adminChat', encrypt($user->id))); ?>">
                                                                <li class="text-right">
                                                                    <span class="pull-left">
                                                                    <?php echo e($user->name); ?>

                                                                    </span>
                                                                    <span >
                                                                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><b>@</b></a>
                                                                    </span>
                                                                </li>
                                                            </a>
                                                            <!-- Modal -->
                                                            <div id="myModal" class="modal fade" role="dialog">
                                                                <div class="modal-dialog modal-sm">

                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            <h4 class="modal-title">Compose Email</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <?php echo e(Form::open(['method' => 'post', 'url' => route('sendEmail')])); ?>

                                                                            <div class="form-group">
                                                                                <label for="">To:</label>
                                                                                <?php echo e(Form::text('to', $user->email, ['class' => 'form-control', 'readonly' => 'true'])); ?>

                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">From: </label>
                                                                                <?php echo e(Form::text('from', auth('admin')->user()->email, ['class' => 'form-control', 'readonly' => 'true'])); ?>

                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Subject: </label>
                                                                                <?php echo e(Form::text('subject', null, ['class' => 'form-control'])); ?>

                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Message:</label>
                                                                                <?php echo e(Form::textarea('message', null, ['rows' => '5', 'class' => 'form-control', 'required' => 'true'])); ?>

                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <?php echo e(Form::submit('Send', ['class' => 'btn btn-primary'])); ?>

                                                                            <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                                                                        </div>

                                                                        <?php echo e(Form::close()); ?>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>