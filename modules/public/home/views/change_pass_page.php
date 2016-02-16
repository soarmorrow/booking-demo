<style type="text/css">
    .login-box-body{
        background-color: #fff;
        border-radius: 5px;
        text-align: center;
        border-color: #fff;
        padding: 20px;
    }
    #da-login-form input {
        border-radius: 5px;
        padding-left: 10px;
        background-image: none !important;
        background-color: #fafafa;
        height: 45px;
        border: 1px solid #ddd;
    }
    .form-control-feedback{
        top: 5px !important;
        right: 15px !important;
    }
</style>

<div class="col-md-6 col-md-offset-3">
    <div class="login-box">
        <br><br> <br><br> <br>
        <div class="login-box-body">
            <h2 class="text-center"><?php echo lang('change_password'); ?></h2>
            <div class="clearfix"></div><br>
            <form novalidate="novalidate" id="da-login-form" method="post" action="<?php echo site_url('home/change_pass'); ?>">
                <div class="form-group has-feedback col-md-10 col-md-offset-1 <?php echo (form_error('password') || isset($password_error)) ? 'text-danger' : ''; ?>">
                    <input name="password" placeholder="New Password" type="password" class="form-control"/>
                    <?php
                    if(form_error('password')){
                        ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback <?php echo (form_error('password') || isset($password_error)) ? 'text-danger' : ''; ?>"></span>
                    <span class="field_error"><?php echo form_error('password'); ?></span>
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group has-feedback col-md-10 col-md-offset-1 <?php echo (form_error('confirm_password') || isset($confirm_password_error)) ? 'text-danger' : ''; ?>">
                    <input name="confirm_password" type="password" class="form-control" placeholder="Confirm Password"/>
                    <?php
                    if(form_error('confirm_password')){
                        ?>
                        <span class="glyphicon glyphicon-lock form-control-feedback <?php echo (form_error('confirm_password') || isset($confirm_password_error)) ? 'text-danger' : ''; ?>"></span>
                        <span class="field_error"><?php echo form_error('confirm_password'); ?></span>
                        <?php
                    }
                    ?>
                    
                </div>
                <input name="check" type="hidden"/>
                <div class="row">
                    <div class="col-md-11">
                        <button type="submit" class="btn btn-info pull-right" style="margin-right:13px;"><?php echo lang('Submit'); ?></button>
                    </div><!-- /.col -->
                </div>
            </form>
        </div>
    </div>
</div><div class="clearfix"></div><br>
