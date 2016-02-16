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
                    <!--<h3 class="box-title">Condensed Full Width Table</h3>-->
                </div><!-- /.box-header -->
                <div class="box-body">

                    <form name="createblog" method="post" action="" id="createBLOG" >
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
                                        <textarea  name="title" placeholder="Title" class="form-control" value="" rows="2"><?= $userpostedarray['title'] ?></textarea>
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
                                        <input type="text" name="author" placeholder="Author" required class="form-control" value="<?= $userpostedarray['author'] ?>"/>
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
                                        <textarea name="content" class="textarea form-control" placeholder="Content text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="editor1"><?= $userpostedarray['content'] ?></textarea>
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
                                <button type="submit" id="submit2" class="btn btn-primary" onclick="return validatethis();">Submit</button>

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

<!--<script src="../../" type="text/javascript"></script>-->
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
        message = '<?php echo $message; ?>';
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
    $("#dropzone").dropzone({
        url: "uploadfiles",
        maxFilesize: 500,
        acceptedFiles: 'image/*,video/*',
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
            $.ajax({
                type: 'POST',
                url: "deletefiles",
                data: {path: path},
                success: function (data) {
                    $("#hiddenimages input[value='" + path + "']").remove();
                }
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
        init: function () {
            var submit2 = document.getElementById('submit2');
            if (this.getUploadingFiles().length != 0 && this.getQueuedFiles().length != 0) {
                submit2.disabled = true;
            }
            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    submit2.disabled = false;
                }
            });
        },
        sending: function () {
            var submit2 = document.getElementById('submit2');
            submit2.disabled = true;
        }
    });
</script>
<script type="text/javascript">
    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
//       CKEDITOR.replace('editor1');
        //bootstrap WYSIHTML5 - text editor
        // $(".textarea").wysihtml5();
    });


</script>


<script type="text/javascript">
//<![CDATA[
    bkLib.onDomLoaded(function () {
        nicEditors.allTextAreas();
    });
    //]]>
</script>