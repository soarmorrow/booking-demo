
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
<section class="content-header">
    <h1>
        Users
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users</a></li>
        <li class="active">List users</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <form name="searchform" method="post" action="">
                        <div class="box-header">
                            <!--<h3 class="box-title">Condensed Full Width Table</h3>-->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4" style="float: left;">
                                    <label class="h5">Name of user</label>
                                    <input type="text" name="name" placeholder="Name" class="form-control" value="<?= $name ?>"/>
                                </div>
                                <div class="col-md-4" style="float: left;">
                                    <label  class="h5">Email</label>
                                    <input type="text" name="email" placeholder="E mail" class="form-control" value="<?= $email ?>"/>
                                </div>
                                <?php
//                                debug($this->session->userdata('origin_centre_id'));
                                if ($this->session->userdata('origin_centre_id') == 0) {
                                    ?>
                                    <div class="form-group col-md-4" style="float: left;">
                                        <label class="h5">Retreat Center</label>
                                        <select class="form-control" id="rc-centers" name="rc_centers">
                                            <option value="0">All</option>
                                            <?php
                                            foreach ($allcenters as $value1) {
                                                if ($rc_centers == $value1->id) {
                                                    echo '<option selected value="' . $value1->id . '">' . $value1->name . '</option>';
                                                } else {
                                                    echo '<option value="' . $value1->id . '">' . $value1->name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="form-group col-md-4" style="float: left;">
                                    <label class="h5">User Role</label>
                                    <select class="form-control" id="userrole" name="role">
                                        <option value="0">All</option>
                                        <?php
                                        foreach ($allroles as $value) {
                                            if ($role == $value->id) {
                                                echo '<option selected value="' . $value->id . '">' . $value->name . '</option>';
                                            } else {
                                                echo '<option value="' . $value->id . '">' . $value->name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div><!-- /.box -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class=" col-md-12 table-responsive">
                        <table id="listuser" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="">Name</th>
                                    <th>Email</th>                                    
                                    <th>Center</th>                                
                                    <th>Role</th>
                                    <th style="width: 50px">Status</th>
                                    <th style="width: 130px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($usersarray as $value) {
                                    echo '<tr id="user' . $value->id . '">
                                    <td>' . $value->first_name . ' ' . $value->last_name . '</td>
                                    <td>' . $value->email . '</td>
                                    <td>';
                                    if ($value->center_name == '0') {
                                        echo '';
                                    } else {
                                        echo $value->center_name;
                                    }
                                    echo '</td><td>';
                                    if ($value->role_name == '0') {
                                        echo '';
                                    } else {
                                        echo $value->role_name;
                                    }
                                    echo '</td><td>';
                                    if ($value->active == 1) {
                                        echo '<input checked type = "checkbox" class = "statuschanger" data-size = "small" value = "' . $value->id . '" >';
                                    } else {
                                        echo '<input type = "checkbox" class = "statuschanger" data-size = "small" value = "' . $value->id . '" >';
                                    }

                                    echo '<div id="console-event"></div>
                                    </td>';
                                    ?>
                                <td>
                                    <a href="<?php echo site_url('user/view/' . $value->id) ?>" class="btn btn-sm btn-primary" title="view">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?php echo site_url('user/edit/' . $value->id) ?>" class="btn btn-sm bg-green" title="edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <span  data-link="<?php echo site_url('user/deleteuser/' . $value->id) ?>" data-namevalue="<?= $value->first_name . ' ' . $value->last_name ?>" data-id="<?= $value->id ?>" class="deleteuser btn btn-sm btn-danger" title="delete">
                                        <i class="fa fa-remove"></i>
                                    </span>

                                </td>
                                <?php
                                echo '</tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                        </div>
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
<script>
    $(window).load(function () {
        $('.statuschanger').bootstrapToggle({
            on: 'Enabled',
            off: 'Disabled'
        });
        $("#perpage").change(function () {
            $.ajax({
                url: "<?= site_url('user/change_perpage') ?>/" + $(this).val() + '',
                method: "post",
                success: function () {
                    location.reload();
                }
            });
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
        $("#listuser").dataTable({
        "order": [[1, "asc"]],
               "bInfo": false,
               searching: false,
               columnDefs: [{"orderable": false,
                         "targets": [4, 5]
                    }],
               paging: false
        });

        $('.deleteuser').click(function (me) {
            me.preventDefault();
            var href = $(this).data('link');
            var id = $(this).data('id');
            var name = $(this).data("namevalue");
            swal({
                title: "Are you sure?",
                text: "You will not be able to undo this action!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete User!",
                closeOnConfirm: false
            },
            function () {
                $.ajax({
                    url: href,
                    method: "post",
                    success: function (result) {
                        if (result == 'true') {
                            $("#user" + id).remove();
                            swal("Deleted!", "Centre '" + name + "' has been deleted.", "success");
                        } else {
                            swal("Oops!", "Failed to delete", "error");
                        }
                    }
                });
            });
        });
    });
</script>
