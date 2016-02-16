<!DOCTYPE html>

<html>
    <div class="login-box">
        <div class="login-logo" align="center">
            <a><img src="<?php echo base_url($theme_path); ?>/images/logo.png" class="img-responsive" align="center"></a>
            <div id="fb-root"></div>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg"></p>
            <?php if ($message != ''): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <button type="button"  class="btn btn-primary btn-block form-control" onclick="fb_login();"><i class="fa fa-facebook"></i>&nbsp;Login with Facebook</button>
            </div>
            <form novalidate="novalidate" id="da-login-form" method="post" action="">
                <div class="form-group <?= ($error == "error") ? 'has-error' : 'has-feedback' ?>">
                    <input type="text" class="form-control" placeholder="Username"name="username" />
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input name="password" type="password" class="form-control" placeholder="Password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group">
                    <div class="g-recaptcha"  style="text-align: center" data-sitekey="6Lcq5AkTAAAAAIchyV4eJEqIfv4BpfJTgPlUUL6Y"></div>
                </div>
                <div class="row">
                    <div class="col-xs-7">    
                        <a href="<?php echo site_url('system/forgot_password') ?>" style="float:left;margin-top:7px;"><?php echo lang('forgot_your_password'); ?></a>
                    </div><!-- /.col -->
                    <div class="col-xs-5">
                        <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo lang('login'); ?></button>
                    </div><!-- /.col -->
                </div>
            </form>

        </div><!-- /.login-box-body -->
    </div>
    <style>
        .g-recaptcha iframe{        
            max-width: 100% !important;
        }
        .g-recaptcha div {
            display: inline-block;
            width: 100% !important;
        }

    </style><!-- /.login-box -->

    <?php // echo $this->load->view('footer'); ?>
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                appId: '<?php echo $this->facebook->getAppID() ?>',
                cookie: true,
                xfbml: true,
                oauth: true
            });
        };

        (function () {
            var e = document.createElement('script');
            e.async = true;
            e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
            document.getElementById('fb-root').appendChild(e);
        }());
        function fb_login() {

            $.ajax({
                url: "<?= site_url("customer/setLoginFb/true") ?>",
                data: {},
                success: function (data) {
                    FB.Event.subscribe('auth.login', function (response) {
                        window.location.reload();
                    });
                    FB.Event.subscribe('auth.logout', function (response) {
                        window.location.reload();
                    });
                    FB.login(function (response) {
                        if (response.authResponse) {
                            FB.api('/me', function (response) {
//                    console.error('test')
                            location.reload();
//                                if (response.status == "connected") {
//                                    location.reload();
//                                }
                            });
                        }
                    }, {scope: 'email'});
                }
            });

        }
    </script>
</html>
