<div class="login-box">
    <div class="login-logo">
        <a><h3>Logo</h3></a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">


        <?php if (isset($customer)): ?>
            <form class="form-signin" action="" method="post" style="max-width: 600px">
                <?php if (isset($show_reset_form)): ?>
                    <h2 class="form-signin-heading">Choose a new password</h2>  

                    <p>A strong password is a combination of letters and punctuation marks. It must be at least 6 characters long.</p>

                    <span class="label label-important" style="width: 100%; margin-bottom: 20px; padding: 0px"><?php echo $message; ?></span>

                    <div>
                        <label for="password">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Password: <input type="password" id="password" name="password" class="input"></label>
                        <span class="text-red"><?php echo form_error('password'); ?></span>
                    </div>
                    <div>
                        <label for="confirm_password">Confirm Password: <input type="password" id="confirm_password" name="confirm_password" class="input"></label>
                        <span class="text-red"><?php echo form_error('confirm_password'); ?></span>
                    </div>
                    <input type="text" name="code" value="<?php echo $code; ?>" />
                    <input type="submit" value="Continue" name="submit" class="btn btn-primary">

                    <a href="<?php echo site_url('admin') ?>" class="btn">Cancel</a>
                <?php else: ?>
                    <center><h2 class="">Check Your Email</h2>  </center>

                    <p>Check your email - we sent you an email with a confirmation code. Enter it below to continue to reset your password.</p>

                            <!--<span class="text-red" style="width: 100%; margin-bottom: 20px; padding: 0px"><?php echo $message; ?></span>-->
                    <div class="form-group has-feedback">
                        <input name="code" placeholder="Confirmation Code" id="code" type="text" class="form-control"/>
                        <?php echo form_error('password'); ?>
                    </div>
                    
                    <p>We sent your code to: <?php echo $customer->email; ?></p>

                    <p style="float: right;"><a href="<?php echo site_url('home/forgot_password') ?>">I didn't receive a code</a></p>

                    <input type="submit" value="Continue" name="submit" class="btn btn-primary">

                    <a href="<?php echo site_url('home') ?>" class="btn">Cancel</a>
                <?php endif; ?>
            </form>
        <?php else: echo (isset($customer))? $customer:'' ?>
            <div class="form-signin" style="max-width: 600px">

                <h2 class="form-signin-heading">Password Reset</h2>  

                <span class="label label-important" style="width: 100%; margin-bottom: 20px; padding: 0px"><?php echo $message; ?></span>

                Back to <a href="<?php echo site_url('home') ?>">Login</a>

            </div>
        <?php endif; ?>
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->