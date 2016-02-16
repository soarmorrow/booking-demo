<section class="team" style="margin-top:50px;">


    <!--Preachers and Guides-->
    <div class="clearfix"></div><br><br>
    <div class="container">
        <div class="row"> 
            <form enctype="multipart/form-data" action="<?= site_url('home/profile_update') ?>/<?= $current_user->id ?>" method="post" class="form-horizontal" id="update_form" role="form" style="padding-top:25px;">

                <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1" style="background-color:#fff;border-radius:5px;padding-top: 30px;">
                    <div class="col-sm-5 col-md-3 profile-image" id="profileimage">
                        <div class="pro_img update"><a href="#"><span class="change">Change profile image</span></a></div>
                        <img class="img-responsive profile_pic" src="<?= base_url($details->avatar) ?>">
                        <input type="file" name="newAvatar" id="newAvatar" style="display:none;">
                        <input type="hidden" name="oldAvatar" value="<?= $details->avatar ?>" style="display:none;">
                    </div>
                    <div class="col-sm-7 col-md-9 nopadding">
                        <div class="form-group <?php echo (form_error('first_name') || isset($first_name_error)) ? 'text-danger' : ''; ?>">
                            <label class="control-label col-sm-3" for="first_name">First Name:</label>
                            <div class="col-sm-8">
                                <input type="text" name="first_name" class="form-control" id="first_name" value="<?= $details->first_name ? $details->first_name : set_value('first_name') ?>">
                                <?php if (form_error('first_name') || isset($first_name_error)) : ?>
                                    <span class="help-inline <?php echo (form_error('first_name') || isset($first_name_error)) ? 'text-danger' : ''; ?>">
                                        <?php echo form_error('first_name'); ?>
                                        <?php if (isset($first_name_error)) : ?>
                                            <span class="field_error"><?php echo $first_name_error; ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (form_error('last_name') || isset($last_name_error)) ? 'text-danger' : ''; ?>">
                            <label class="control-label col-sm-3" for="last_name">Last Name:</label>
                            <div class="col-sm-8">
                                <input type="text" name="last_name" class="form-control" id="last_name" value="<?= $details->last_name ? $details->last_name : set_value('last_name') ?>">
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
                        <div class="form-group <?php echo (form_error('username') || isset($username_error)) ? 'text-danger' : ''; ?>">
                            <label class="control-label col-sm-3" for="username">User Name:</label>
                            <div class="col-sm-8">
                                <input type="text" name="username" class="form-control" id="username" value="<?= $details->username ? $details->username : set_value('username') ?>">
                                <?php if (form_error('username') || isset($username_error)) : ?>
                                    <span class="help-inline <?php echo (form_error('username') || isset($username_error)) ? 'text-danger' : ''; ?>">
                                        <?php echo form_error('username'); ?>
                                        <?php if (isset($username_error)) : ?>
                                            <span class="field_error"><?php echo $username_error; ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (form_error('email') || isset($email_error)) ? 'text-danger' : ''; ?>">
                            <label class="control-label col-sm-3" for="email">Email:</label>
                            <div class="col-sm-8">
                                <input type="text" name="email" class="form-control" id="email" value="<?= $details->email ? $details->email : set_value('email') ?>">
                                <?php if (form_error('email') || isset($email_error)) : ?>
                                    <span class="help-inline <?php echo (form_error('email') || isset($email_error)) ? 'text-danger' : ''; ?>">
                                        <?php echo form_error('email'); ?>
                                        <?php if (isset($email_error)) : ?>
                                            <span class="field_error"><?php echo $email_error; ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (form_error('phone') || isset($phone_error)) ? 'text-danger' : ''; ?>">
                            <label class="control-label col-sm-3" for="phone">Phone Number:</label>
                            <div class="col-sm-8">
                                <input type="text" name="phone" class="form-control" id="phone" value="<?= $details->contact_number ? $details->contact_number : set_value('phone') ?>">
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

                        <div class="form-group"> 
                            <div class="col-sm-offset-7 col-sm-4" style="text-align:right">
                                <a  href="<?=site_url('home/change_pass_profile')?>">Change Password</a>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-sm-offset-3 col-sm-3">
                                <input type="button" class="btn btn-info" value="Update" id="update_profile">
                            </div>
                            <div class="col-sm-offset-3 col-sm-3">
                                <a class="btn btn-default" href="<?=site_url('home')?>">Cancel</a>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--./ Preachers and Guides-->
<div class="clearfix"></div><br><br><br>

<!--./Header End-->

<!--Application Scripts-->
<script src="resources/assets/js/common.js"></script>
<script type="text/javascript">
    var filedata;
    $(document).ready(function () {
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.profile_pic').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
                filedata = input.files[0];
            }
        }
        $("#newAvatar").change(function () {
            readURL(this);
        });
        $(".pro_img").click(function () {
            $("#newAvatar").trigger("click");
        });

        $('#update_profile').click(function () {
            $('#update_form .text-danger').remove()
            var form = document.getElementById('update_form')
            var formData = new FormData(form);
            formData.append('newAvatar', filedata);
            var url = $('#update_form ').attr('action');
            $.ajax({
                data: formData,
                type: 'POST',
                url: url,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function (data, textStatus, jqXHR)
                {
                    if (data.status != 'false')
                    {
                        swal({
                            title: "Success",
                            text: "Profile Updated Successfully",
                            type: "success",
                            timer: 3000,
                            animation: false,
                            showConfirmButton: false
                        });
                    }
                    else
                    {
                        $.each(data.error, function (key, obj) {
                            $('input[name=' + key + ']').parent().append('<span class="text-danger">' + obj + '<span>');
//                            alert(key + ' is ' + obj);
                        });
                        // Handle errors here
                        console.log('ERRORS: ' + data.status);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    // Handle errors here
                    console.log('ERRORS: ' + textStatus);
                    // STOP LOADING SPINNER
                }
            });
        });
    });
    function readfiles(files) {
        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = function (event) {
                $('.profile_pic').attr('src', event.target.result);
            };
            reader.readAsDataURL(files[i]);
        }
        filedata = files[0];
    }

    var holder = document.getElementById('profileimage');
    holder.ondragover = function () {
//        this.className = '';
        return false;
    };
    holder.ondragend = function () {
//        this.className = '';
        return false;
    };
    holder.ondrop = function (e) {
//        this.className = '';
        e.preventDefault();
        readfiles(e.dataTransfer.files);
    }
</script>

</body>
</html>