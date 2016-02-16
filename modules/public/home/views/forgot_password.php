<style type="text/css">
    .panel-login>.panel-heading {
        color: #00415d;
        background-color: #fff;
        border-color: #fff;
        text-align:center;
    }
    .text-red{
        color: red;
    }
    #da-login-form input {
        border-radius: 5px;
        padding-left: 10px;
        background-image: none !important;
        background-color: #fafafa;
        height: 45px;
        border: 1px solid #ddd;
    }
</style>
<div class="clearfix"></div><br><br><br><br>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Forgot Password</h2>
                        </div>
                        <hr>
                        
                        <div class="clearfix"></div><br>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <form novalidate="novalidate" id="da-login-form" method="post" action="<?php echo site_url('home/forgot_password'); ?>">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" placeholder="Email" name="identity" value="<?php echo set_value('identity'); ?>"/>
                                            <!-- <span class="glyphicon glyphicon-user form-control-feedback"></span> -->
                                            <?php if ($message != ''): ?>
                                                <div class="text-red"><?php echo $message; ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5">    
                                                <button type="button" class="btn btn-default" onclick="window.location.href='<?php echo site_url('home'); ?>'" class="btn btn-default btn-block btn-flat"> <?php echo lang('Cancel'); ?></button>
                                            </div><!-- /.col -->
                                            <div class="col-xs-2">
                                            </div>
                                            <div class="col-xs-5">
                                                <button type="submit" class="btn btn-info btn-block btn-flat"><?php echo lang('Submit'); ?></button>
                                                
                                            </div><!-- /.col -->
                                        </div>
                                    </form>
                                </div><!-- /.login-box-body -->
                            </div><!-- /.login-box -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>