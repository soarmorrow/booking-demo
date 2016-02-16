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
        text-transform: uppercase;
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
        text-transform: uppercase;
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
    select.form-control{
        border-radius: 5px !important;
    }

</style>

<div class="container">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12">
                            <h3>Register with Goretreat</h3>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <?php
                                if (isset($error) && $error) {
                                    ?>
                                    <span style="color:red"><?= $error ?></span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <form id="login-form" action="<?= site_url('home/sign_up') ?>" method="post" role="form" style="display: block;">
                                <div class="row">

                                    <div class="form-group col-lg-6 <?php echo (form_error('first_name') || isset($first_name_error)) ? 'text-danger' : ''; ?>">
                                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?= set_value('first_name') ?>">
                                        <?php if (form_error('first_name') || isset($first_name_error)) : ?>
                                            <span class="help-inline <?php echo (form_error('first_name') || isset($first_name_error)) ? 'text-danger' : ''; ?>">
                                                <?php echo form_error('first_name'); ?>
                                                <?php if (isset($first_name_error)) : ?>
                                                    <span class="field_error"><?php echo $first_name_error; ?></span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-lg-6 <?php echo (form_error('last_name') || isset($last_name_error)) ? 'text-danger' : ''; ?>">
                                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="<?= set_value('last_name') ?>">
                                        <?php if (form_error('last_name') || isset($last_name_error)) : ?>
                                            <span class="help-inline <?php echo (form_error('last_name') || isset($last_name_error)) ? 'text-danger' : ''; ?>">
                                                <?php echo form_error('last_name'); ?>
                                                <?php if (isset($last_name_error)) : ?>
                                                    <span class="field_error"><?php echo $last_name_error; ?></span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-6 <?php echo (form_error('password') || isset($password_error)) ? 'text-danger' : ''; ?>">
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
                                    <div class="form-group col-lg-6 <?php echo (form_error('confirm_password') || isset($confirm_password_error)) ? 'text-danger' : ''; ?>">
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" value="">
                                        <?php if (form_error('confirm_password') || isset($confirm_password_error)) : ?>
                                            <span class="help-inline <?php echo (form_error('confirm_password') || isset($confirm_password_error)) ? 'text-danger' : ''; ?>">
                                                <?php echo form_error('confirm_password'); ?>
                                                <?php if (isset($confirm_password_error)) : ?>

                                                    <span class="field_error"><?php echo $confirm_password_error; ?></span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12 <?php echo (form_error('address') || isset($address_error)) ? 'text-danger' : ''; ?>">
                                        <textarea name="address" id="address" tabindex="1" class="form-control" placeholder="Full Address" ><?php echo set_value('address'); ?></textarea>
                                        <?php if (form_error('address') || isset($address_error)) : ?>
                                            <span class="help-inline <?php echo (form_error('address') || isset($address_error)) ? 'text-danger' : ''; ?>">
                                                <?php echo form_error('address'); ?>
                                                <?php if (isset($address_error)) : ?>

                                                    <span class="field_error"><?php echo $address_error; ?></span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 <?php echo (form_error('district') || isset($district_error)) ? 'text-danger' : ''; ?>">
                                        <input type="text" name="district" id="district" tabindex="1" class="form-control" placeholder="Suburb/District" value="<?= set_value('district') ?>">
                                        <?php if (form_error('district') || isset($district_error)) : ?>
                                            <span class="help-inline <?php echo (form_error('district') || isset($district_error)) ? 'text-danger' : ''; ?>">
                                                <?php echo form_error('district'); ?>
                                                <?php if (isset($district_error)) : ?>

                                                    <span class="field_error"><?php echo $district_error; ?></span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-lg-6 <?php echo (form_error('pincode') || isset($pincode_error)) ? 'text-danger' : ''; ?>">
                                        <input type="text" name="pincode" id="pincode" tabindex="1" class="form-control" placeholder="Pincode" value="<?= set_value('pincode') ?>">
                                        <?php if (form_error('pincode') || isset($pincode_error)) : ?>
                                            <span class="help-inline <?php echo (form_error('pincode') || isset($pincode_error)) ? 'text-danger' : ''; ?>">
                                                <?php echo form_error('pincode'); ?>
                                                <?php if (isset($pincode_error)) : ?>

                                                    <span class="field_error"><?php echo $pincode_error; ?></span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 <?php echo (form_error('country') || isset($country_error)) ? 'text-danger' : ''; ?>">
                                        <select id="country" name ="country" class="form-control" ></select>
                                        <?php if (form_error('country') || isset($country_error)) : ?>
                                            <span class="help-inline <?php echo (form_error('country') || isset($country_error)) ? 'text-danger' : ''; ?>">
                                                <?php echo form_error('country'); ?>
                                                <?php if (isset($country_error)) : ?>

                                                    <span class="field_error"><?php echo $country_error; ?></span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-lg-6 <?php echo (form_error('state') || isset($state_error)) ? 'text-danger' : ''; ?>">
                                        <select name ="state" id ="state" class="form-control">
                                            <option value="">Select State</option>
                                        </select>
                                        <?php if (form_error('state') || isset($state_error)) : ?>
                                            <span class="help-inline <?php echo (form_error('state') || isset($state_error)) ? 'text-danger' : ''; ?>">
                                                <?php echo form_error('state'); ?>
                                                <?php if (isset($state_error)) : ?><span class="field_error"><?php echo $state_error; ?></span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 <?php echo (form_error('email') || isset($email_error)) ? 'text-danger has-error' : ''; ?>">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?= set_value('email') ?>">
                                        <?php if (form_error('email') || isset($email_error)) : ?>
                                            <span class="help-inline <?php echo (form_error('email') || isset($email_error)) ? 'text-danger' : ''; ?>">
                                                <?php echo form_error('email'); ?>
                                                <?php if (isset($email_error)) : ?>
                                                    <span class="field_error"><?php echo $email_error; ?></span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-lg-6 <?php echo (form_error('phone') || isset($phone_error)) ? 'text-danger' : ''; ?>">

                                        <div class="input-group">
                                            <span class="input-group-addon"id="phone_code">+ 00</span>
                                            <input type="hidden" name="phonecode" id="phonecode" value="">
                                            <input type="text" name="phone" aria-describedby="phone_code" id="phone" class="form-control" placeholder="Mobile Phone" value="<?= set_value('phone') ?>">
                                        </div>

                                        <?php if (form_error('phone') || isset($phone_error)) : ?>
                                            <span class="help-inline <?php echo (form_error('phone') || isset($phone_error)) ? 'text-danger' : ''; ?>">
                                                <?php echo form_error('phone'); ?>
                                                <?php if (isset($phone_error)) : ?>
                                                    <span class="field_error"><?php echo $phone_error; ?></span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="checkbox"  class="" name="sms_updates" id="sms_updates" <?= set_value('sms_updates')?'checked':'' ?>>
                                    <label for="sms_updates">Send updates by SMS</label>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="checkbox"  class="" value="1" name="newsletter" id="newletter" <?= set_value('newsletter')?'checked':'' ?>>
                                    <label for="newletter">Suscribe Newsletter</label>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="checkbox"  class="" name="agreement" id="agreement" <?= set_value('agreement')?'checked':'' ?>>
                                    <label for="agreement">I agree to the terms and conditions.<a href="<?= site_url('home/terms') ?>" ><span style="color:blue">Read terms and conditions</span></a></label>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="submit" id="submit" class="form-control btn btn-info" value="Register">
                                        </div>

                                    </div>
                                </div>

                            </form>
                            <script language="javascript">
                                populateCountries("country", "state");
                            </script>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {

                            var code = {
                                update: function (country_code) {
                                    $.get('<?= site_url("home/get_phone_code") ?>', {name: country_code}, function (val) {
                                        $("#phone_code").text("+" + val);
                                        $("#phonecode").val("+" + val);
                                    });
                                }
                            };
                            var country_selector = $('select[name=country]');
                            var country = "<?= set_value('country') ? set_value('country') : 98; ?>";
//                            console.log(country);
                            $('select[name=country] option[value=' + country + ']').attr('selected', 'selected');
                            country_selector.change();
                            code.update(country);


                            country_selector.on('change', function () {
                                code.update($(this).val());
                            });


                            var state = "<?= set_value('state') ? set_value('state') : 9; ?>";
                            $('select[name=state] option[value=' + state + ']').attr('selected', 'selected');
                            $('select[name=state]').change();

                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>