
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>

<!-- Theme style -->
<link href="<?= base_url($theme_path . 'plugins/iCheck/flat/green.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url($theme_path . 'plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url($theme_path . 'ladda/ladda-themeless.min.css') ?>" rel="stylesheet" type="text/css" />
<style>
    .loader{
        width: 100%;
        height: 100%;
        z-index: 2000;
        background-color: #333333;
        opacity: 0.8;
        position: fixed;
        top: 0;left: 0;
        display: none;

    }
    .loader img{
        margin-left: 45%;
        margin-top: 20%;
    }
    .select2-container{
        width: 29.4% !important;
        margin-bottom: 4px;
    }
    .select2-dropdown{
        width:162px !important;
    }
    input:active,input:focus{
        outline: none;
        border-color: #3c8dbc !important;
        box-shadow: none;
    }
</style>
<div class="loading-img loader">
    <img src="<?php echo base_url('/themes/admin/images/loading.gif'); ?>" width="200"/>
</div>
<section class="content-header">
    <h1>
        Promo
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Events</a></li>
        <li class="active">Promo</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- /.box -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <div class="col-md-12">
                            <div class="row"><div class="col-md-11"><label>Promo Code</label></div></div>
                            <div class="row">

                                <div class="col-md-12" style="padding-top: 24px">
                                    <button class="btn btn-primary" id="add_code" type="button">Add Code</button>

                                    <button class="btn btn-dropbox pull-right ladda-button" data-size="s" data-style="expand-left" id="import_code" type="button">
                                        <span class="ladda-label">Import Crowdfunding</span></button>
                                </div>
                            </div>
                            <div class="example-modal">
                                <div class="modal" id="editModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content"  style="padding: 10px">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title">Add Promo Range</h4>
                                            </div>
                                            <form name="" method="POST" action="" id="create_promo_form">
                                                <div class="modal-body">
                                                    <label>Value</label>
                                                    <div class="form-control <?php
if (form_error('promo_value') != '')
    echo 'has-error';
else
    echo '';
?>" style="padding: 0;border: 0;">
                                                        <input type="text" name="promo_value" value="<?= (form_error('promo_value') != '') ? set_value('promo_value') : '' ?>" placeholder="Promo Value" required class="form-control"/>

                                                        <div class="form-group"><?php echo form_error('promo_value'); ?></div>
                                                    </div>

                                                    <div class="form-group">
                                                        <br/>
                                                        <label>Low And High</label>
                                                        <div class="form-control <?php
                                                         if (form_error('promo_high') != '' || form_error('promo_low') != '')
                                                             echo 'has-error';
                                                         else
                                                             echo '';
?>" style="padding: 0;border: 0;">
                                                            <input type="text" name="promo_low" value="<?= (form_error('promo_low') != '') ? set_value('promo_low') : "" ?>" placeholder="Range Low" required style="width: 50%;padding: 6px 12px;border:1px solid #d2d6de"/>
                                                            <input type="text" name="promo_high" value="<?= (form_error('promo_high') != '') ? set_value('promo_high') : "" ?>" placeholder="Range High" required style="width: 49%;padding: 6px 12px;border:1px solid #d2d6de"/>

                                                            <div class="form-group"><?php
                                                             echo form_error('promo_low');
                                                             echo form_error('promo_high');
?></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group <?php
                                                                if (form_error('expdate') != '')
                                                                    echo 'has-error';
                                                                else
                                                                    echo '';
?>">
                                                        <br/>
                                                        <label>Expiry date</label> 
                                                        <input type="text" id="expdate" name="expdate" placeholder="Expiry Date" class="form-control"  value="<?php (form_error('expdate') != '') ? set_value('expdate') : "" ?>"> 
                                                        <div class="form-group"><?php echo form_error('expdate'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" id="update_type">Save changes</button>
                                                </div>

                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </div><!-- /.example-modal -->
                        </div>
                        <div class="col-md-11 right">
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body" style="min-height: 450px;">
                        <table id="listuser" class="table table-bordered table-striped" >
                            <thead>
                                <tr>
                                    <th style="">Range</th>
                                    <th style="">Value</th>
                                    <th style="">Expiry Date</th>
                                    <th style="width: 200px;">Actions</th>               
                                </tr>
                            </thead>
                            <tbody id="tablebody" class="promocodetable">
                                <?php
                                foreach ($promocode as $val) {
                                    echo '<tr id="type' . $val->id . '">' . '
                                        <td >' . $val->low . '-' . $val->high . '</td>
                                            <td >' . $val->value;
                                    echo ' %';
                                    echo '</td><td>';
                                    echo date(FORMAT_DATE, strtotime($val->expire_time));
                                    ?>
                                    </td>
                                <td>
                                    <span data-link="<?php echo site_url('event/delete_promo_crowd/' . $val->id) ?>" data-namevalue="<?= $val->low . '-' . $val->high ?>" data-id="<?= $val->id ?>" class="deletetype btn btn-sm btn-danger" title="archive">
                                        <i class="fa fa-remove"></i>
                                    </span>  
                                </td>
                                <tr>
                                    <?php
                                }
                                ?>   
                                </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <form name="uploadexcel" id="uploadexcel" method="post" enctype="multipart/form-data">
                <input type="file" name="file" id="uploadfiledata">
            </form>
        </div><!-- /.row -->

    </section>
</section>
<script src="<?= base_url($theme_path . 'plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>

<script src="<?= base_url($theme_path . 'plugins/select2/select2.full.min.js') ?>" type="text/javascript"></script>
<!-- iCheck 1.0.1 -->
<script src="<?= base_url($theme_path . 'plugins/iCheck/icheck.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url($theme_path . 'ladda/spin.min.js') ?>"></script>
<script src="<?= base_url($theme_path . 'ladda/ladda.min.js') ?>"></script>
<style>
    .datepicker.dropdown-menu {
        z-index: 1200!important;
    }
</style>
<?php
if ($create_promo_form) {
    ?>
    <script>    
        $(window).load(function () {
            $("#editModal").modal('show');
        });
    </script>
    <?php
}
?>
<script>
    var l;
    $(window).load(function () {        
        l = Ladda.create(document.querySelector( '#import_code' ));
        $(".select2").select2();        
        $("#expdate").datepicker({format: 'dd M yyyy',autoclose: true});
        $('.deletetype').click(function () {
            var href = $(this).data('link');
            var id = $(this).data('id');
            var name = $(this).data("namevalue");
            swal({
                title: "Are you sure?",
                text: "You will not be able to undo this action!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, archive it!",
                closeOnConfirm: false
            },
            function () {
                $.ajax({
                    url: href,
                    method: "post",
                    success: function (result) {
                        if (result === '1') {
                            $("#type" + id).remove();
                            swal("Archived!", "Promo code '" + name + "' archived successfully.", "success");
                        } else {
                            swal("Oops!", "Failed to archive", "error");
                        }
                    }, error: function (error) {
                        swal("Oops!", "Failed to archive", "error");
                    }
                });

            });
        });
        
        $("#add_code").click(function () {
            $('#editModal #event_id').val($("#eventid").val());
            $("#editModal").modal('show');
        });
        $('#editModal').on('hidden.bs.modal', function (e) {
            window.location.replace("<?php echo current_url() ?>");
        });
        
    });
    $("#import_code").click(function(){
        $("#uploadfiledata").click();
    });
    $("#uploadfiledata").change(function(){
        //        $(".loader").show();
        l.start();
        var url="<?php echo site_url('event/importcrowdfunding') ?>"
        var formdata = new FormData(document.forms.namedItem("uploadexcel"));
        $.ajax({
            url: url,
            type: "post",
            data: formdata,
            success: function(data) { 
                l.stop();
                if(data=='true'){
                    $('#uploadfiledata').val('');
                    swal("Uploaded", "Crowd funding users added successfully", "success");
                }
            },
            error:function(xhr, ajaxOptions, thrownError){
                l.stop();
                swal("Oops!", "Failed to upload" + thrownError+'=='+url, "error");
            },
            cache: false,
            xhr: function() {  // custom xhr
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // check if upload property exists
                    myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
                }
                return myXhr;
            },
            contentType: false,
            processData: false
        });
    });
    function progressHandlingFunction(e){
        if(e.lengthComputable) {
            var pct = (e.loaded / e.total);
            l.setProgress( pct );
                            
        } 
    }
</script>