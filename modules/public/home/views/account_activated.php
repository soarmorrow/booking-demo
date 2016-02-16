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
                        <h2>Email Activated</h2>
                        </div>
                        <hr>
                        
                        <div class="clearfix"></div><br>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <center>
                                        <?php echo lang('account_activated'); ?></br>
                                        <a href="<?php echo site_url('home/sign_in'); ?>"><?php echo lang('redirect_login'); ?></a>
                                    </center>
                                </div><!-- /.login-box-body -->
                            </div><!-- /.login-box -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>