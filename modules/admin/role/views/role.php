
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
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
                        <h3 class="box-title"></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="listuser" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="">User role</th>
                                    <th>Modules</th>                            
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($modules as $value) {
                                    echo '<tr>
                                    <td>' . $value['roles']->name . '</td>
                                    <td>';
                                    $i=0;
                                    foreach ($value['module'] as $module) {
                                        if($i!=0){
                                            echo ' , ';
                                        }
                                        $i++;
                                        echo $module->name;
                                    }
                                    echo '</td>
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