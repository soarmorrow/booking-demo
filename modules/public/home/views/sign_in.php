<?php echo $template['partials']['head']; ?>
<style type="text/css">
body {
	padding-top: 90px;
}
.panel-login {
	border-color: #ccc;
	-webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
}
.panel-login>.panel-heading {
	color: #00415d;
	background-color: #fff;
	border-color: #fff;
	text-align:center;
}
.panel-login>.panel-heading a{
	text-decoration: none;
	color: #666;
	font-weight: bold;
	font-size: 15px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login>.panel-heading a.active{
	color: #029f5b;
	font-size: 18px;
}
.panel-login>.panel-heading hr{
	margin-top: 10px;
	margin-bottom: 0px;
	clear: both;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}
.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"],textarea,select {
	height: 45px;
	border: 1px solid #ddd!important;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
	background-image:none;
}
.panel-login input:hover,
.panel-login input:focus {
	outline:none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border-color: #ccc;
}
.btn-login {
	background-color: #59B2E0;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	border-color: #59B2E6;
}
.btn-login:hover,
.btn-login:focus {
	color: #fff;
	background-color: #53A3CD;
	border-color: #53A3CD;
}
.forgot-password {
	text-decoration: underline;
	color: #888;
}
.forgot-password:hover,
.forgot-password:focus {
	text-decoration: underline;
	color: #666;
	}.btn-register {
		background-color: #1CB94E;
		outline: none;
		color: #fff;
		font-size: 14px;
		height: auto;
		font-weight: normal;
		padding: 14px 0;
		border-color: #1CB94A;
	}
	.btn-register:hover,
	.btn-register:focus {
		color: #fff;
		background-color: #1CA347;
		border-color: #1CA347;
	}
	.help-inline{
		bottom: -26;
		left: 16;
	}

	</style>
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12">
								<h3>Sign Up</h3>
								<h6>Sign-in with your social accounts</h6>
							</div>
							<div onclick="fb_login()"  class=" btn btn-info" ><span class="fa fa-facebook "> </span>&emsp;Facebook</div>
							<a href="<?= site_url('twitter/redirect') ?>" class="btn btn-social btn-info"> <span class="fa fa-twitter"></span>&emsp;Twitter </a>
							<a href="<?=site_url('social/linkedin')?>" class=" btn btn-info" ><span class="fa fa-linkedin"> </span>&emsp;Linked in</a><br>
							<span class="or">or</span><br>
							<a href="<?=site_url('home/sign_up')?>" class=" btn btn-info" >Sign-up with your email</a>
						</div>
						<br><br>
						<div class="col-md-12 nopadding">
							<h2 class="middle_line"><span class="line"></span><span class="text">If you are already a member sign-in<span></h2>
						</div>
						<div class="clearfix"></div><br>
						<h3>Sign In</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-10 col-lg-offset-1">
								<form id="login-form" action="<?=site_url('home/sign_in')?>" method="post" role="form" style="display: block;">
									<?php
									if(isset($error)&&$error){
										?>
										<span style="color:red"><?=$error?></span>
										<?php
									}
									?>
									
									<div class="form-group  <?php echo (form_error('user_name') || isset($user_name_error)) ? 'text-danger' : ''; ?>">
										<input type="text" name="user_name" id="user_name" class="form-control" placeholder="User Name" value="<?= set_value('user_name') ?>">
										<?php if (form_error('user_name') || isset($user_name_error)) : ?>
										<span class="help-inline <?php echo (form_error('user_name') || isset($user_name_error)) ? 'text-danger' : ''; ?>">
											<?php echo form_error('user_name'); ?>
											<?php if (isset($user_name_error)) : ?>
											<span class="field_error"><?php echo $user_name_error; ?></span>
										<?php endif; ?>
											</span>
										<?php endif; ?>
									</div>
							
							
							
									<div class="form-group  <?php echo (form_error('password') || isset($password_error)) ? 'text-danger' : ''; ?>">
										<input type="password" name="password" id="password" class="form-control" placeholder="Password" value="">
										<?php if (form_error('password') || isset($password_error)) : ?>
										<span class="help-inline <?php echo (form_error('password') || isset($password_error)) ? 'text-danger' : ''; ?>">
											<?php echo form_error('password'); ?>
											<?php if (isset($password_error)) : ?>
											<span class="field_error"><?php echo $password_error; ?></span>
										<?php endif; ?>
										</span>
										<?php endif; ?>
									</div>
									<!-- <div class="form-group">
										<input type="checkbox"  class="" name="agreement" id="agreement">
										<label for="agreement">I agree to the terms and conditions</label><br><a href="<?=site_url('home/terms')?>" ><span style="color:blue">Read terms and conditions</span></a>
									</div> -->
									<div class=" form-group">    
					                    <a href="<?php echo site_url('home/forgot_password') ?>" style="float:left;margin-top:7px;"><?php echo "Forgot your password?"; ?></a>
					                </div>
					                <div class="clearfix"></div><br>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="submit" id="submit" class="form-control btn btn-info" value="Sign In">
											</div>
										</div>
									</div>

								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
