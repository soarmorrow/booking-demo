<section class="content-header">
    <h1>
        Edit Preacher
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users</a></li>
        <li class="active">Edit users</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box  box-success">
                    <form name="createuser" method="post" action="<?= site_url('event/preacher_edit') ?>/<?= $details->id ?>" id="createuser" enctype="multipart/form-data">
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
                                        <label class="h5">Name</label>
                                        <input type="text" name="fname" placeholder="First Name" required class="form-control" value="<?= $details->name ?>"/>
                                        <?php echo form_error('fname'); ?>
                                    </div>
                                    <div class="form-group <?php
                                    if (form_error('description') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">Description</label>
                                        <textarea name="description" placeholder="Description" required class="form-control" value="<?= $details->description ?>"><?= $details->description ?></textarea>
                                        <?php echo form_error('description'); ?>
                                    </div>
                                    <div class="form-group <?php
                                    if (form_error('language') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">Language</label>
                                        <select name="language[]" multiple="multiple" class="form-control">
                                            <option value="">Language</option>
                                            <?php
                                            $languarray = explode(',', $details->language);
                                            foreach ($languages as $value) {
                                                ?>
                                                <option value="<?= $value->id ?>" <?= (in_array($value->id, $languarray)) ? 'selected' : '' ?>><?= $value->language ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php echo form_error('language'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group <?php
                                    if (form_error('address') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">Address</label>
                                        <textarea name="address" placeholder="Address" required class="form-control" value="<?= $details->address ?>"><?= $details->address ?></textarea>
                                        <?php echo form_error('address'); ?>
                                    </div>
                                    <div class="form-group <?php
                                    if (form_error('preacher_status') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">Preacher Status</label>
                                        <select name="preacher_status" class="form-control">
                                            <option value="">Preacher Status</option>
                                            <?php
                                            foreach ($status as $value) {
                                                ?>
                                                <option value="<?= $value->id ?>" <?= $details->status == $value->id ? 'selected' : '' ?>><?= $value->status ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php echo form_error('preacher_status'); ?>
                                    </div>
                                    <div class="form-group <?php
                                    if (form_error('expertise') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">Area of expertise</label>
                                        <select name="expertise[]" multiple="multiple" class="form-control">
                                            <option value="">Area of Expertise</option>
                                            <?php
                                            $expertisearray = explode(',', $details->areas_of_expertise);
                                            foreach ($expertise as $value) {
                                                ?>
                                                <option value="<?= $value->id ?>" <?= in_array($value->id, $expertisearray) ? 'selected="selected"' : '' ?>><?= $value->area_of_expertise ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php echo form_error('expertise'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer" style="padding-left: 0px;">

                                <div class="row">
                                    <div class="form-group col-md-6 ">
                                        <label class="h5" for="exampleInputFile">Profile image</label>
                                        <div class="">
                                            <div class="form-group">
                                                <?php
                                                if (!empty($details->image)) {
                                                    $src = base_url($details->image);
                                                } else {
                                                    $src = base_url($theme_path . 'images/dlogo.jpg');
                                                }
                                                ?>
                                                <div id="imagePreview" style="display: inline-block;background-image: url('')"> <img src="<?php echo $src; ?>"/></div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="" name="uploadImage"/>
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


        <div class="example-modal">
            <div class="modal" id="editModal">
                <div class="modal-dialog">
                    <!--<form method="post" enctype="multipart/form-data" action="" id="updateHome">-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Update Home Slider Image</h4>
                        </div>
                        <div class="modal-body">
                            <div class="" style="width: 100%">
                                <img id="image" class="cropperImage"  style="width: 100%"  src="" alt="Picture">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="update_type">Save changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                    <!--</form>  Form end -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div><!-- /.example-modal -->

    </section>
</section>

<style>
    #imagePreview {
        width: 100px;
        max-width: 100px;
        background-position: center center;
        background-size: cover;
        /*-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);*/
        /*display: ;*/
    }
    #imagePreview img{
        max-width: 100px;
    }

    #imagePreview canvas{
        width: 100%;
    }
    .pwstrength_viewport_progress{
        display: none;
    }
</style>
<script>
    $(document).ready(function () {
        $('select').chosen();
    });
    $(window).load(function () {
        $('#uploadimage').click(function () {
            $('#uploadFile').click()
        });
        $('.statuschanger').bootstrapToggle({
            on: 'Enabled',
            off: 'Disabled'
        });
        $('#password').focus(function () {
            $(".pwstrength_viewport_progress").css("display", 'block');
        });
        $('#password').focusout(function () {
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
//                    $("#imagePreview").css("display", "inline-block");
//                    $("#imagePreview").css("background-image", "url(" + this.result + ")");
                    $("#imagePreview").css("display", "inline-block");
                    $('#image').cropper('destroy');
                    $('#image').removeAttr('src');
                    $('#image').attr('src', this.result);
                    $("#editModal").modal('show');
                    $('#image').cropper({
                        aspectRatio: 236 / 200,
                        crop: function (e) {
                            $('#update_type').click(function () {
                                var canvas = $('#image').cropper('getCroppedCanvas');
                                $("#imagePreview").html(canvas);
                                $('input[name=uploadImage]').val(canvas.toDataURL());
                                $("#editModal").modal('hide');
                                ;
                            });
                        }
                    });
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
