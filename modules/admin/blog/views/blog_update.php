<section class="content-header">
    <h1>
        Add Blog
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Blog</a></li>
        <li class="active">Add blog</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box  box-success">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body" style="padding-top: 0px">

                    <form name="updateblog" method="post" action="" id="createBLOG" >                        
                        <input type="hidden"  value="<?= $blog->id ?>"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group <?php
                                if (form_error('title') != '')
                                    echo 'has-error';
                                else
                                    echo '';
                                ?>">
                                    <div class='box-header'>
                                        <label class="h5">Title</label>
                                    </div><div class='box-body pad'>
                                        <textarea name="title" placeholder="Title" class="form-control" ><?= $blog->title ?></textarea>
                                        <?php echo form_error('title'); ?>
                                    </div>
                                </div>
                                <div class="form-group <?php
                                if (form_error('author') != '')
                                    echo 'has-error';
                                else
                                    echo '';
                                ?>">
                                    <div class='box-header'>
                                        <label class="h5">Author</label>
                                    </div><div class='box-body pad'>
                                        <input type="text" name="author" placeholder="Author" required class="form-control" value="<?= $blog->author ?>"/>
                                        <?php echo form_error('author'); ?>
                                    </div>
                                </div>

                                <div class="form-group<?php
                                if (form_error('content') != '')
                                    echo 'has-error';
                                else
                                    echo '';
                                ?>">
                                    <div class='box-header'>
                                        <h3 class='h5'>Content</h3>
                                        <!-- tools box -->
                                    </div><!-- /.box-header -->
                                    <div class='box-body pad'>
                                        <textarea name="content" class="textarea form-control" placeholder="Content text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= $blog->content ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="dropzone" class="dropzone"></div>
                                <div id="hiddenimages" class="hide"></div>
                            </div>
                        </div>

                        <div>

                            <div class="box-footer">  
                                <a onclick="history.go(-1);" class="btn-default btn">
                                    Back
                                </a>
                                <button type="submit" class="btn btn-primary" onclick="return validatethis();">Submit</button>
                            </div>
                        </div>


                    </form>
                </div><!-- /.box-body --> 
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div><!-- /.row -->

</section>

<style>
    .imagePreview {
        /*display: none;*/
        width: 100px;
        height: 100px;
        background-position: center center;
        background-size: cover;
        margin: 5px;
        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
        /*display: ;*/
    }
</style>
<script>
    $(window).load(function () {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "500",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        message = '<?= isset($message) ? $message : ''; ?>';
        if (message != null) {
            toastr["success"](message);
        }

        $('#browse').click(function () {
            $('#uploadFile').click();
        });
        $('#uploadFile').change(function () {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) {
                $("#imagePreview").css("display", "none");
                return; // no file selected, or no FileReader support
            }
            $("#imagePreview").html('');
            $("#imagePreview").css("display", "inline-block");

            $.each(files, function (j, image) {
                if (/^image/.test(image.type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(image); // read the local file

                    reader.onloadend = function () { // set image data as background of div
                        $("#imagePreview").append('<img class="imagePreview" src="' + this.result + '">');
                    }
                }
            });

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


    });
</script>
<script type="text/javascript">
    //    window.files=[];
    var base = '<?= base_url() ?>';
    $("#dropzone").dropzone({
        url: "../uploadfiles",
        maxFilesize: 500,
        acceptedFiles: 'image/*,video/*',
        init: function () {

            var thisDropzone = this;
            var id = '<?= $blog->id ?>';
            var path = '<?= site_url() ?>' + "/blog/get_item_images/" + id
            $.getJSON(path, function (data) { // get the json response
                $.each(data, function (key, value) { //loop through it                    
                    var mockFile = {name: value.name, size: value.size, customid: value.path, blog_id: value.blog_id};
                    thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                    if (value.attachment_type == 1) {

                    } else {
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.path);//uploadsfolder is the folder where you have all those uploaded files
                    }
                    thisDropzone.emit("complete", mockFile);
                    thisDropzone.files.push(mockFile);
                });

            });
        },
        success: function (result, xhr) {
            var obj = jQuery.parseJSON(xhr);
            result.customid = obj.path;
            if (obj.type == 0) {
                $("#hiddenimages").append('<input type="hidden" name="blogimages[]" value="' + obj.path + '">');
            } else {
                $("#hiddenimages").append('<input type="hidden" name="blogvideos[]" value="' + obj.path + '">');
            }
        },
        addRemoveLinks: true,
        removedfile: function (file) {
            var path = file.customid;
            var res = path.replace(base, '');

            var id = '<?= $blog->id ?>';
            $.ajax({
                type: 'POST',
                url: "../deletefiles/" + id,
                data: {path: res},
                success: function (data) {
                    $("#hiddenimages input[value='" + path + "']").remove();
                }
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        }
    });

    $(function () {
    });
</script>
<script type="text/javascript">
//<![CDATA[
            bkLib.onDomLoaded(function () {
                nicEditors.allTextAreas();
            });
    //]]>
</script>
