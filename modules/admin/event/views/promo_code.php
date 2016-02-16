
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>

<!-- Theme style -->
<link href="<?= base_url($theme_path . 'plugins/iCheck/flat/green.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url($theme_path . 'plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
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
    .full-width span.select2-container{
        width: 100%!important;
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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="col-md-12">
                            <form method="post" action="" id="loadpromo">
                                <div class="row"><div class="col-md-12"><label>Search</label></div></div>
                                <div class="row" style="padding-bottom: 20px;">
                                    <div class="col-md-5">
                                        <label><small>Events</small></label>
                                        <select class="form-control" name="eventid" id="idforcenter">
                                            <option value="">All</option>
                                            <?php
                                            foreach ($events as $val1) {
                                                if ($val1->id == $filters['event_id']) {
                                                    echo '<option selected  value="' . $val1->id . '">' . $val1->name . '</option>';
                                                } else {
                                                    echo '<option  value="' . $val1->id . '">' . $val1->name . '</option>';
                                                }
                                            }
                                            ?> 
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label><small>Keyword</small></label>
                                        <input class="form-control" name="key" id="key" placeholder="Key word to search" value="<?= $filters['promo_key'] ?>"/>
                                    </div>
                                    <div class="col-md-2">   
                                        <div class="col-md-12">
                                            <label><small>&nbsp; </small></label></div>

                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- /.box -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Promo Code</label>
                                    <div class="pull-right">
                                        <button class="btn btn-primary" id="add_code" type="button" style="margin-right: 5px;">Add Code</button>

                                        <div class="dropdown pull-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default">Import</button>
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <!--<span class="sr-only">Toggle Dropdown</span>-->
                                                </button>
                                                <ul class="dropdown-menu" role="menu" style="right: 0!important;left: auto;max-width: 112px">
                                                    <li id="upload_code" role="presentation" style="cursor: pointer"><a role="menuitem" tabindex="-1">Import promo</a></li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1"  href="<?= base_url('themes/admin/resource/Promo_code_template.xlsx') ?>">Download format</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
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
                                                <h4 class="modal-title">Add Promo Code</h4>
                                            </div>
                                            <form name="" method="POST" action="" id="create_promo_form">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Select Event</label>
                                                        <select class="form-control" name="event_id" id="eventid" style="width: 100%">
                                                            <!--<option value="">Root</option>-->
                                                            <?php
                                                            foreach ($events as $val1) {
                                                                echo '<option  value="' . $val1->id . '">' . $val1->name . '</option>';
                                                            }
                                                            ?> 
                                                        </select>
                                                    </div>
                                                    <div class="form-group <?php
                                                    if (form_error('promo_code') != '')
                                                        echo 'has-error';
                                                    else
                                                        echo '';
                                                    ?>">
                                                        <label>Promo code</label>
                                                        <input type="text" name="promo_code" id="promoname" value="<?= ($create_promo_form) ? set_value('promo_code') : '' ?>" placeholder="Promo Code" class="form-control" style="margin-bottom: 3px;"> 
                                                        <input type="checkbox" name="generatecode"   class="iCheckmodule minimal" value="1" id="generatecode"/>&nbsp;Generate Code
                                                        <div class="form-group"><?php echo form_error('promo_code'); ?></div>
                                                    </div>

                                                    <label>Value</label>
                                                    <div class="form-control <?php
                                                    if (form_error('promo_value') != '' || form_error('country') != '')
                                                        echo 'has-error';
                                                    else
                                                        echo '';
                                                    ?>" style="padding: 0;border: 0;">
                                                        <div class="input-group">
                                                            <input type="text" name="promo_value" value="<?= ($create_promo_form) ? set_value('promo_value') : '' ?>" placeholder="Promo Value" required class="form-control"/>
                                                            <div class="input-group-addon" style="padding: 0px;border: 0px">
                                                                <select class="select2" name="country" style="width: 162px">
                                                                    <option value="0" selected="">%(Percentage)</option>
                                                                    <?php
                                                                    foreach ($country as $type) {
                                                                        ?>
                                                                        <option value="<?= $type->id_countries ?>" <?php if (set_value('country') == $type->id_countries) echo 'selected'; ?>><?= $type->name ?>(<?= $type->currency_code ?>)</option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group"><?php echo form_error('promo_value'); ?></div>
                                                    </div>
                                                    <div class="form-group <?php
                                                    if (form_error('expdate') != '')
                                                        echo 'has-error';
                                                    else
                                                        echo '';
                                                    ?>">
                                                        <br/>
                                                        <label>Expiry date</label> 
                                                        <input type="text" id="expdate" name="expdate" placeholder="Expiry Date" class="form-control"> 
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

                                <div class="modal" id="uploadModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content"  style="padding: 10px">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title">Upload Promo Code</h4>
                                            </div>
                                            <form name="" method="POST" action="" id="upload_promo_form" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Select Event</label>
                                                        <select class="form-control" name="event_idup" id="eventid" style="width: 100%">
                                                            <!--<option value="">Root</option>-->
                                                            <?php
                                                            foreach ($events as $val1) {
                                                                echo '<option  value="' . $val1->id . '">' . $val1->name . '</option>';
                                                            }
                                                            ?> 
                                                        </select>
                                                    </div>
                                                    <div class="form-group full-width">
                                                        <select class="select2 form-control " name="countryup">
                                                            <option value="-1" selected="">Select By Ip</option>
                                                            <option value="0">%(Percentage)</option>
                                                            <?php
                                                            foreach ($country as $type) {
                                                                ?>
                                                                <option value="<?= $type->id_countries ?>" <?php if (set_value('country') == $type->id_countries) echo 'selected'; ?>><?= $type->name ?>(<?= $type->currency_code ?>)</option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group" style="">
                                                        <label>Excel file</label> 
                                                        <input type="file" id="excelsheet" name="file" class="form-control"> 
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
                        <input type="hidden" value="<?= $event_id ?>" id="center_id"/>
                        <table id="listuser" class="table table-bordered table-striped" >
                            <thead>
                                <tr>
                                    <th style="">Code</th>
                                    <th style="">Value</th>
                                    <th style="">Expiry Date</th>
                                    <th style="">Event</th>
                                    <th style="width: 200px;">Actions</th>               
                                </tr>
                            </thead>
                            <tbody id="tablebody" class="promocodetable">
                                <?php
                                foreach ($promocode as $val) {
                                    echo '<tr id="type' . $val->id . '"><td >' . $val->promo_code . '</td>' . '<td >' . $val->value;
                                    if ($val->type == 0) {
                                        echo ' %';
                                    } else {
                                        echo ' (' . $val->currency_code . ')';
                                    }
                                    echo '</td><td>';
                                    echo date(FORMAT_DATE, strtotime($val->expire_time)) . '</td>';
                                    echo '<td>' . $val->event_name . '</td>';
                                    ?>

                                <td>
                                    <span data-link="<?php echo site_url('event/delete_promo/' . $val->id) ?>" data-namevalue="<?= $val->promo_code ?>" data-id="<?= $val->id ?>" class="deletetype btn btn-sm btn-danger" title="archive">
                                        <i class="fa fa-remove"></i>
                                    </span>  
                                </td>
                                <tr>
                                    <?php
                                }
                                ?>   
                                </tbody>
                        </table>
                        <div class="col-md-12">   
                            <div class="col-md-2" style="margin: 20px auto;">
                                <select class="form-control" id="perpage" style="max-width:80px;">
                                    <?php
                                    if (isset($perpages)) {
                                        foreach ($perpages as $perpage) {
                                            if ($perpage === $per_page) {
                                                echo '<option value="' . $perpage . '" selected>' . $perpage . '</option>';
                                            } else {
                                                echo '<option value="' . $perpage . '">' . $perpage . '</option>';
                                            }
                                        }
                                    }
                                    ?>                                            
                                </select>
                            </div>
                            <div class="col-md-10 text-right">
                                <?= $pagination ?>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->

        </div><!-- /.row -->

    </section>
</section>
<script src="<?= base_url($theme_path . 'plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>

<script src="<?= base_url($theme_path . 'plugins/select2/select2.full.min.js') ?>" type="text/javascript"></script>
<!-- iCheck 1.0.1 -->
<script src="<?= base_url($theme_path . 'plugins/iCheck/icheck.min.js') ?>" type="text/javascript"></script>
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
} else {
    ?>
    <script>
        $(window).load(function () {
            $('#create_promo_form')[0].reset();
        });
    </script>
    <?php
}
?>

<?php
if ($this->session->flashdata('message')) {
    ?>
    <script>
        $(window).load(function () {
            swal({
                title: "",
                text: "<?= $this->session->flashdata('message')['message'] ?>",
                type: "<?= $this->session->flashdata('message')['class'] ?>",
                timer: 2000,
                animation: false,
                showConfirmButton: false
            });
        });

    </script>
    <?php
}
?>
<script>

    $(window).load(function () {
        $("#upload_code").click(function () {
            $("#uploadModal").modal("show");
        });
        $(".select2").select2({dropdownCssClass: 'smalldrop'});
        $("#eventid").select2({dropdownCssClass: 'bigdrop', dropdownAutoWidth: true});
        $("#expdate").datepicker({format: 'dd M yyyy', autoclose: true});
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
                    }, error: function () {
                        swal("Oops!", "Failed to archive", "error");
                    }
                });

            });
        });
        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_flat-green'
        });
        $("#add_code").click(function () {
            $('#editModal #event_id').val($("#eventid").val());
            $("#editModal").modal('show');
        });
        $('#editModal').on('hidden.bs.modal', function (e) {
            $('input').iCheck('uncheck');
            $('#create_promo_form')[0].reset();
        });
    });


    $('input').on('ifChecked', function (event) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for (var i = 0; i < 6; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        $("#promoname").val(text);
    });

    $('input').on('ifUnchecked', function (event) {
        $("#promoname").val('');
    });
    $("#perpage").change(function () {
        $.ajax({
            url: "<?= site_url('event/change_promo_perpage') ?>/" + $(this).val() + '',
            method: "post",
            success: function () {
                var href = "<?= site_url('event/promocode') ?>";
                window.location.replace(href);
            }
        });
    });
</script>