<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('backend.templates.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel well well-lg">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Set OJT Hours</h3>
                    </div>
                    <div class="panel-body">
                        <?php echo e(Form::open(['method' => 'post', 'url' => route('adminSetHours')])); ?>

                        <fieldset>
                            <?php /*hanldes auth->failed msg*/ ?>
                            <?php if(session()->has('failed')): ?>
                                <div class="text-danger text-center">
                                    <?php echo e(session()->get('failed')); ?>

                                </div>
                            <?php endif; ?>
                            <?php /*/handles auth->failed msg*/ ?>
                            <div class="form-group <?php echo e($errors->has('bsit') ? 'has-error' : ""); ?>">
                                <?php echo $errors->first('bit', '<span class="text-danger">:message</span>'); ?>

                                <?php echo e(Form::number('bsit',null, ['class' => 'form-control', 'placeholder' => 'OJT Hours for BSIT'])); ?>

                            </div>
                            <div class="form-group <?php echo e($errors->has('bit') ? 'has-error' : ""); ?>">
                                <?php echo $errors->first('bit', '<span class="text-danger">:message</span>'); ?>

                                <?php echo e(Form::number('bit',null, ['class' => 'form-control', 'placeholder' => 'OJT Hours for BIT'])); ?>

                            </div>
                            <div class="form-group">
                                <label for="academicYear">Academic Year:</label>
                                <select name="academicYear" id="academicYear" class="form-control">
                                    <option value="<?php echo e(Carbon\Carbon::now()->subYear(2)->format('Y')); ?>-<?php echo e(Carbon\Carbon::now()->subYear(1)->format('Y')); ?>"><?php echo e(Carbon\Carbon::now()->subYear(2)->format('Y')); ?>-<?php echo e(Carbon\Carbon::now()->subYear(1)->format('Y')); ?></option>
                                    <option value="<?php echo e(Carbon\Carbon::now()->subYear(1)->format('Y')); ?>-<?php echo e(Carbon\Carbon::now()->format('Y')); ?>"><?php echo e(Carbon\Carbon::now()->subYear(1)->format('Y')); ?>-<?php echo e(Carbon\Carbon::now()->format('Y')); ?></option>
                                    <option value="<?php echo e(Carbon\Carbon::now()->format('Y')); ?>-<?php echo e(Carbon\Carbon::now()->addYear(1)->format('Y')); ?>"><?php echo e(Carbon\Carbon::now()->format('Y')); ?>-<?php echo e(Carbon\Carbon::now()->addYear(1)->format('Y')); ?></option>
                                </select>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <?php echo e(Form::submit('Set',  ['class' => 'btn btn-lg btn-success pull-right'])); ?>

                        </fieldset>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>