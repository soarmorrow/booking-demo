
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
<!-- Select2 -->
<link href="<?= base_url($theme_path . 'plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Preachers
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Events</a></li>
        <li class="active">List Preachers</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-body">    
                        <div class=" col-md-12 table-responsive">
                            <a style="margin-bottom: 5px;" class="btn btn-sm btn-success pull-right" href="<?= site_url('event/preacher_add') ?>">Add new Preacher</a>
                            <?php 
                            if(_is("RC Admin")){
                            ?>
                            <a style="margin-bottom: 5px;" class="btn btn-sm btn-success " href="<?= site_url('event/add_existing_preacher') ?>">Add an existing Preacher</a>
                            <?php }
                            ?>
                            <table id="listevents" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th style="">Name</th>
                                        <th>Description</th>
                                        <?php
                                    if (_is("GR Admin")) {
                                        ?>
                                        <th style="width: 100px">Status</th>
                                        <?php
                                    }
                                    ?>
                                        <th style="width:100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    foreach ($preachers as $value) {
                                        ?>
                                        <tr id="centre<?= $value->id ?>">
                                            <td>
                                                <?php
                                                if (!empty($value->image)) {
                                                    $src = $value->image;
                                                } else {
                                                    $src = base_url($theme_path . 'images/dlogo.jpg');
                                                }
                                                ?><img src="<?= base_url($src) ?>" alt="" style="height: 50px; width: 50px;">
                                            </td>
                                            <td><?= $value->name ?></td>
                                            <td><?php
                                                echo closetags(sub_str($value->description, 0, 45));
                                                echo (strlen($value->description) > 45) ? "..." : '';
                                                ?></td>
                                                <?php
                                        if (_is("GR Admin")) {
                                            ?>
                                            <td>
                                                <?php
                                                if ($value->published == 1) {
                                                    echo '<input checked type = "checkbox" class = "statuschanger" data-size = "small" data-onstyle = "success" data-offstyle="danger" value = "' . $value->id . '" >';
                                                } else {
                                                    echo '<input type = "checkbox" class = "statuschanger" data-size = "small" data-onstyle = "success" data-offstyle="danger"  value = "' . $value->id . '" >';
                                                }
                                                ?>
                                            </td>

                                            <?php
                                        }
                                        ?>

                                                <td>
<!--                                                <a href="<?php // echo site_url('event/view/' . $value->id) ?>" class="btn btn-sm btn-primary" title="view">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="<?php // echo site_url('event/update/' . $value->id) ?>" class="btn btn-sm bg-green" title="edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>-->
                                                <a href="<?= site_url('event/preacher_edit') ?>/<?= $value->id ?>" class="editimage btn btn-sm bg-green" title="edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a> 
                                                    <?php
                                                    if(_is("GR Admin")){
                                                    ?>
                                                    <span  data-link="<?php echo site_url('event/delete_preachers/' . $value->id) ?>" data-namevalue="<?= $value->name ?>" data-id="<?= $value->id ?>" class="deleteevent btn btn-sm btn-danger" title="delete">
                                                    <i class="fa fa-remove"></i>
                                                </span>
                                                    <?php
                                                    }
                                                    ?>
                                                
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>


                    </div><!-- /.box-body -->

                </div><!-- /.box -->
            </div><!-- /.col -->

        </div><!-- /.row -->

    </section>
</section>
<style>
    .btn i{
        height: 10px;
    }
    .table > tbody > tr > td, .table > tfoot > tr > td,  .table > thead > tr > td{
        vertical-align: middle;
    }
</style>
<script src="<?= base_url($theme_path . 'plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>

<!-- Select2 -->
<script src="<?= base_url($theme_path . 'plugins/select2/select2.full.min.js') ?>" type="text/javascript"></script>
<script>
    $(window).load(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
        $("#listevents").dataTable({
            searching: false,
            paging: false,
            "bSort": false,
            "bInfo": false
        });
        $('.statuschanger').change(function () {
            var value1,message;
            if ($(this).prop('checked')) {
                value1 = 1;
                message="Preacher has been published";
            } else {
                value1 = 0;
                message="Preacher has been unpublished";
            }
            var variablee = $(this);
            $.ajax({
                url: "<?= site_url('event/verify_preacher') ?>/" + $(this).val() + '/' + value1,
                method: "post",
                success: function (result) {

                    if (result === '1') {
                        swal("Success!", message, "success");
                    } else {
                        if (variablee.prop('checked')) {
                            variablee.removeAttr('checked');
                        } else {
                            variablee.prop('checked');
                        }
                    }
                }
            });
        });

        $('.statuschanger').bootstrapToggle({
            on: 'Published',
            off: 'Not Published'
        });
        $(".startdate,.enddate").datepicker({format: 'dd M yyyy', autoclose: true});
        //        $('.startdate,.enddate').on('change', function () {
        //            $('.datepicker').hide();
        //        });
$("#perpage").change(function () {
    $.ajax({
        url: "<?= site_url('event/change_perpage') ?>/" + $(this).val() + '',
        method: "post",
        success: function () {
            location.reload();
        }
    });
});

$('.deleteevent').click(function () {
    var href = $(this).data('link');
    var id = $(this).data('id');
    var name = $(this).data("namevalue");
    swal({
        title: "Are you sure?",
        text: "You will not be able to undo this action!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
    function () {
        $.ajax({
            url: href,
            method: "post",
            success: function (result) {
                if (result === '1') {
                    $("#centre" + id).remove();
                    swal("Deleted!", "Preacher '" + name + "' has been deleted.", "success");
                } else {
                    swal("Oops!", "Failed to delete", "error");
                }
            }
        });
    });
});
});
</script>
