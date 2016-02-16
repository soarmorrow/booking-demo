
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
<section class="content-header">
    <h1>
        Modules
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Modules</a></li>
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
                        <h3 class="box-title"></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="listuser" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="">Name</th>
                                    <th>Email</th>                                    
                                    <th>Center</th>
                                    <th style="width: 50px">Status</th>
                                    <th style="width: 250px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($usersarray as $value) {
                                    echo '<tr>
                                    <td>' . $value->first_name . ' ' . $value->last_name . '</td>
                                    <td>' . $value->email . '</td>
                                    <td>';
                                    if ($value->center_name == '0') {
                                        echo '';
                                    } else {
                                        echo $value->center_name;
                                    }
                                    echo '</td>
                                    <td>';
                                    if ($value->active == 1) {
                                        if($user_id==$value->id){
                                            echo '<input checked disabled type = "checkbox" class = "statuschanger" data-size = "small" value = "' . $value->id . '" >';
                                        }else{
                                            echo '<input checked type = "checkbox" class = "statuschanger" data-size = "small" value = "' . $value->id . '" >';
                                        }
                                    } else {
                                        if ($value->activation_code != '') {
                                            echo '<input type = "checkbox" disabled class = "statuschanger" data-size = "small" value = "' . $value->id . '" >';
                                        } else {
                                            echo '<input type = "checkbox" class = "statuschanger" data-size = "small" value = "' . $value->id . '" >';
                                        }
                                    }

                                    echo '<div id="console-event"></div>
                                    </td>
                                    <td><a href="' . site_url('user/view/' . $value->id) . '"><button class="btn btn-sm btn-primary">View</button></a>&nbsp;<a href="' . site_url('user/edit/' . $value->id) . '"><button class="btn btn-sm bg-green">Edit</button></a>&nbsp;<a href="' . site_url('user/edit/' . $value->id) . '"><button class="btn btn-sm bg-orange">Reset Password</button></a></a>&nbsp;<a href="' . site_url('user/deleteuser/' . $value->id) . '"  class="deleteuser"><button class="btn btn-sm btn-danger">Delete</button></a></td>
                                </tr>';
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
<script>
    $(window).load(function () {
        $('.statuschanger').bootstrapToggle({
            on: 'Enabled',
            off: 'Disabled'
        });
        $('.statuschanger').change(function () {
            var value1;
            if ($(this).prop('checked')) {
                value1 = 1;
            } else {
                value1 = 0;
            }
            var variablee = $(this);
            $.ajax({
                url: "<?= site_url('user/disable') ?>/" + $(this).val() + '/' + value1,
                method: "post",
                success: function (result) {
                    if (result == 'true') {
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
        $("#listuser").dataTable();

        $('.deleteuser').click(function (me) {
            me.preventDefault();
            var href = $(this).attr('href');
            var name = $(this).attr("data-namevalue");
            alertify.confirm("Do you really want to delete " + name, function (e) {
                if (e) {
                    $.ajax({
                        url: href,
                        method: "post",
                        success: function (result) {
                            if (result == 'true') {
                                alertify.success("User deleted successfully", 1000)
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else {
                                alertify.error("Failed to delete")
                            }
                        }
                    });
                } else {
                }
            });
        });
    });
</script>