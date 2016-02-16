
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>

<!-- Theme style -->
<link href="<?= base_url($theme_path . 'plugins/iCheck/flat/green.css') ?>" rel="stylesheet" type="text/css" />
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
                        <h3 class="box-title">Assign modules to roles</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="listuser" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="">Module/Role</th>
                                    <?php
                                    foreach ($roles as $val) {
                                        if ($val['role_name'] != "GR Admin") {
                                            echo '<th style="font-weight:100;text-align:center">' . $val['role_name'] . '</th>';
                                        }
                                    }
                                    ?>                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($modules as $value) {
                                    echo '<tr>
                                    <td>' . $value->name . '</td>';
                                    foreach ($roles as $val) {                                        
                                        if ($val['role_name'] != "GR Admin") {
                                        if (_is("GR Admin")) {
                                            echo '<td style="text-align:center"><input ' . (in_array_r($value->id, $val['assignedModules'], true) ? 'checked' : '') . ' data-module="' . $value->id . '" data-role="' . $val['id'] . '" data-name="' . $value->name . '" data-rname="' . $val['role_name'] . '" type="checkbox" class="iCheckmodule minimal"></td>';
                                        } else {
                                            if (in_array_r($value->id, $val['allowedmodules'], true)) {
                                                echo '<td style="text-align:center"><input ' . (in_array_r($value->id, $val['assignedModules'], true) ? 'checked' : '') . ' data-module="' . $value->id . '" data-role="' . $val['id'] . '" data-name="' . $value->name . '" data-rname="' . $val['role_name'] . '" type="checkbox" class="iCheckmodule minimal"></td>';
                                            } else {
                                                echo '<td></td>';
                                            }
                                        }
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
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_flat-green'
        });

        $('input').on('ifChecked', function (event) {
            var modulename=$(this).attr('data-name');
            var rolename=$(this).attr('data-rname');
            var thisinput=$(this);
            var data = {role_id: $(this).attr('data-role'), module_id: $(this).attr('data-module')};
            $.ajax({
                url: "<?php echo site_url('relation/checkrolemodule') ?>",
                type: 'POST',
                data: data,
                dataType: 'html',
                success: function (result) {
                    if(result=='true'){
                        toastr["success"](modulename+" module added to "+rolename);
                    }else{           
                        toastr["error"]("Failed to add "+modulename+" to "+rolename);   
                    }
                }
            });
        });

        $('input').on('ifUnchecked', function (event) {
        var thisinput=$(this);
            var modulename=$(this).attr('data-name');
            var rolename=$(this).attr('data-rname');
            var data = {role_id: $(this).attr('data-role'), module_id: $(this).attr('data-module')};
            $.ajax({
                url: "<?php echo site_url('relation/uncheckrolemodule') ?>",
                type: 'POST',
                data: data,
                dataType: 'html',
                success: function (result) {
                    if(result=='true'){
                        toastr["success"](modulename + " module removed from "+rolename);
                    }else{              
                        toastr["error"]("Failed to remove "+modulename+" to "+rolename);
                    }
                }
            });
        });
    });
</script>