<section class="content-header">
    <h1>
        Add Users
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users</a></li>
        <li class="active">Add users</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box  box-success">
                    <form name="createuser" method="post" action="" id="createuser" enctype="multipart/form-data">
                        <div class="box-header">
                            <!--<h3 class="box-title">Condensed Full Width Table</h3>-->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group <?php
if (form_error('fname') != '')
    echo 'has-error';
else
    echo '';
?>">
                                        <label class="h5">First Name</label>
                                        <input type="text" name="fname" placeholder="First Name" required class="form-control" value="<?= $userpostedarray['fname'] ?>"/>
                                        <?php echo form_error('fname'); ?>
                                    </div>
                                    <div class="form-group <?php
                                        if (form_error('email') != '')
                                            echo 'has-error';
                                        else
                                            echo '';
                                        ?>">
                                        <label class="h5">E-mail</label>
                                        <input type="email" name="email" placeholder="E mail" required class="form-control" value="<?= $userpostedarray['email'] ?>"/>
                                        <?php echo form_error('email'); ?>
                                    </div>
                                    <div class="form-group <?php
                                        if (form_error('username') != '')
                                            echo 'has-error';
                                        else
                                            echo '';
                                        ?>">
                                        <label class="h5">Username</label>
                                        <input type="text" name="username" placeholder="User name" required class="form-control" value="<?= $userpostedarray['username'] ?>"/>
                                        <?php echo form_error('username'); ?>
                                    </div>


                                    <div class="form-group <?php
                                        if (form_error('cpassword') != '')
                                            echo 'has-error';
                                        else
                                            echo '';
                                        ?>">
                                        <label class="h5">Confirm password</label>
                                        <input type="password" name="cpassword" placeholder="Confirm Password" required class="form-control"/>
                                        <?php echo form_error('cpassword'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group <?php
                                        if (form_error('lname') != '')
                                            echo 'has-error';
                                        else
                                            echo '';
                                        ?>">
                                        <label class="h5">Last Name</label>
                                        <input type="text" name="lname" placeholder="Last Name" required class="form-control" value="<?= $userpostedarray['lname'] ?>"/>
                                        <?php echo form_error('lname'); ?>
                                    </div>
                                    <div class="form-group <?php
                                        if (form_error('phonenumber') != '')
                                            echo 'has-error';
                                        else
                                            echo '';
                                        ?>">
                                        <label class="h5">Phone Number</label>
                                        <input type="text" name="phonenumber" placeholder="Contact Number" required class="form-control" value="<?= $userpostedarray['phonenumber'] ?>"/>
                                        <?php echo form_error('phonenumber'); ?>
                                    </div>
                                    <div class="form-group <?php
                                        if (form_error('password') != '')
                                            echo 'has-error';
                                        else
                                            echo '';
                                        ?>">
                                        <label class="h5">Enter Password</label>
                                        <input type="password" id="password" name="password" placeholder="Password" required class="form-control"/>
                                        <?php echo form_error('password'); ?>
                                        <div class="pwstrength_viewport_progress" style="margin-top: 2px"></div>
                                    </div>
                                    <div class="hidden form-group <?php
                                        if (form_error('userrole') != '')
                                            echo 'has-error';
                                        else
                                            echo '';
                                        ?>">
                                        <label class="h5">User Role</label>
                                        <select name="userrole[]" class="form-control chosen-select" id="userrole" data-placeholder="Select roles to assign this user"  tabindex="8" multiple>
                                            <?php
                                            foreach ($roles as $value) {
                                                echo '<option value="' . $value->id . '">' . $value->name . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <?php echo form_error('userrole'); ?>
                                    </div>

                                </div>
                            </div>
                            <div class="box-footer" style="padding-left: 0px;">

                                <div class="row">
                                    <div class="form-group col-md-6 ">
                                        <label class="h5" for="exampleInputFile">Add profile image</label>
                                        <div class="">
                                            <div class="form-group">
                                                <div id="imagePreview"></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-default" onclick="" id="uploadimage">Upload</button>
                                        <input type="file" name="avatar" id="uploadFile" class="hidden"/>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">  
                            <button type="submit" class="btn btn-primary" onclick="return validatethis();">Submit</button>

                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!-- /.col -->

        </div><!-- /.row -->

    </section>
</section>

<style>
    #imagePreview {
        display: none;
        width: 100px;
        height: 100px;
        background-position: center center;
        background-size: cover;
        /*-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);*/
        /*display: ;*/
    }
    .pwstrength_viewport_progress{
        display: none;
    }
</style>
<script>
    $(window).load(function () {
        $('#uploadimage').click(function(){
            $('#uploadFile').click()
        });
        $('.statuschanger').bootstrapToggle({
            on: 'Enabled',
            off: 'Disabled'
        });
        $('#password').focus(function () {
            $(".pwstrength_viewport_progress").css("display", 'block');
        });
        $('#password').focusout(function(){
            $(".pwstrength_viewport_progress").css("display", 'none')
        });
        
        "use strict";
        var options = {};
        options.ui = {
            container: "#pwd-container",
            showVerdictsInsideProgressBar: true,
            viewports: {
                progress: ".pwstrength_viewport_progress"
            }
        };
        options.common = {
            debug: true,
            onLoad: function () {
            }
        };
        $(':password').pwstrength(options);
        
        $('#uploadFile').change(function () {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) {
                $("#imagePreview").css("display", "none");
                return; // no file selected, or no FileReader support
            }
            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function () { // set image data as background of div
                    $("#imagePreview").css("display", "inline-block");
                    $("#imagePreview").css("background-image", "url(" + this.result + ")");
                }
            }
        });
        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        }
        for (var selector in config) {
            $(selector).chosen();
        }

        if ('<?php echo $typealert ?>' == 'success') {
            swal("Success!", '<?= $message; ?>', "success");
        } else if ('<?php echo $typealert ?>' == 'error') {
            swal("Oops!", '<?= $message; ?>', "error");
            
        }
    });
</script>
