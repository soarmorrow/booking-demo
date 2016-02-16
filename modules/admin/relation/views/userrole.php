
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>

<!-- Theme style -->
<link href="<?= base_url($theme_path . 'plugins/iCheck/all.css') ?>" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Roles
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Roles</a></li>
        <li class="active">Manage</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- /.box -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <?php
                        if (_is("GR Admin")) {
                            ?>
                            <div class="col-md-6">
                                <form method="post" action="" id="loadcenter">
                                    <div class="row"><div class="col-md-11"><label>Centers</label></div></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" name="center_id" id="centerid">
                                                <option value="0">HQ</option>
                                                <?php
                                                foreach ($centers as $val1) {
                                                    if ($center_id == $val1->id) {
                                                        echo '<option selected  value="' . $val1->id . '">' . $val1->name . '</option>';
                                                    } else {
                                                        echo '<option  value="' . $val1->id . '">' . $val1->name . '</option>';
                                                    }
                                                }
                                                ?> 
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <!--<button class="btn btn-primary btn-block">Load</button>-->
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-md-11 right">
                            <!--<div class="align" style="float: right">hello</div>-->
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <input type="hidden" value="<?= $center_id ?>" id="center_id"/>
                        <table id="listuser" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="">User/Role</th>
                                    <?php
                                    foreach ($roles as $val) {
                                        if (_is('RC Admin') && $val['role_name'] == "GR Admin") {
                                            
                                        } else {
                                            echo '<th style="font-weight:100;text-align:center">' . $val['role_name'] . '</th>';
                                        }
                                    }
                                    ?>                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($users as $value) {
                                    echo '<tr>
                                    <td>' . $value->username . '</td>';
                                    foreach ($roles as $val) {
                                        if (_is('RC Admin') && $val['role_name'] == "GR Admin") {
//                                            echo '<td style="text-align:center"><input  ' . (in_array_r($value->id, $val['assignedusers'], true) ? 'checked' : '') . ' data-user="' . $value->id . '" data-role="' . $val['id'] . '" type="checkbox" class="iCheckmodule minimal"></td>';
                                        } else {
                                            echo '<td style="text-align:center"><input  ' . (in_array_r($value->id, $val['assignedusers'], true) ? 'checked' : '') . ' data-user="' . $value->id . '" data-role="' . $val['id'] . '" type="checkbox" class="iCheckmodule minimal"></td>';
                                        }
                                    }
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->

        </div><!-- /.row -->

    </section>
</section>
<script src="<?= base_url($theme_path . 'plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>

<!-- iCheck 1.0.1 -->
<script src="<?= base_url($theme_path . 'plugins/iCheck/icheck.min.js') ?>" type="text/javascript"></script>
<script>
    $(window).load(function () {

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        });
        $('input').on('ifChecked', function (event) {
            var thisinput = $(this);
            var data = {role_id: $(this).attr('data-role'), user_id: $(this).attr('data-user'), center_id: $("#center_id").val()};
            $.ajax({
                url: "<?php echo site_url('relation/checkuserrole') ?>",
                type: 'POST',
                data: data,
                dataType: 'html',
                success: function (result) {
                    if (result == 'true') {
                        alertify.success("Role Added to User")
                    } else {
                        alertify.error(result)
//                        thisinput.iCheck('uncheck');
                    }
                }
            });
        });
//
        $('input').on('ifUnchecked', function (event) {
            var thisinput = $(this);
            var data = {role_id: $(this).attr('data-role'), user_id: $(this).attr('data-user'), center_id: $("#center_id").val()};
            $.ajax({
                url: "<?php echo site_url('relation/uncheckuserrole') ?>",
                type: 'POST',
                data: data,
                dataType: 'html',
                success: function (result) {
                    if (result == 'true') {
                        alertify.success("Role removed from user")
                    } else {
                        alertify.error(result)
//                        thisinput.iCheck('check');
                    }
                }
            });
        });
        $('#centerid').change(function (event) {
            $("#loadcenter").submit();
        });
    });
</script>