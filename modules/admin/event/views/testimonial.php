
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
<!-- Select2 -->
<link href="<?= base_url($theme_path . 'plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Testimonial
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Events</a></li>
        <li class="active">Testmonial</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-body">    
                        <div class=" col-md-12 table-responsive">

                        <table id="listevents" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th style="">Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th style="width: 150px">Address</th>   
                                    <th>Description</th>
                                    <?php
                                    if (_is("GR Admin")) {
                                        ?>
                                        <th style="width: 100px">Testimonial</th>
                                        <?php
                                    }
                                    ?>
                                    <th style="width:100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($events as $value) {
                                    ?>
                                    <tr id="centre<?= $value->id ?>">
                                        <td>
                                            <?php
                                            if (!empty($value->image)) {
                                                $src = base_url($value->image);
                                            } else {
                                                $src = base_url($theme_path . 'images/dlogo.jpg');
                                            }
                                            ?><img src="<?= $src ?>" alt="" style="height: 50px;">
                                        </td>
                                        <td><?= $value->name ?></td>
                                        <td><?= date(FORMAT_DATE, strtotime($value->start_date)) ?></td>
                                        <td><?= date(FORMAT_DATE, strtotime($value->end_date)) ?></td>
                                        <td><?php
                                        echo closetags(substr($value->address, 0, 45));
                                        echo (strlen($value->address) > 45) ? "..." : '';
                                            ?></td>
                                        <td>
                                            <?=
                                            closetags(substr($value->description, 0, 45));
                                            echo (strlen($value->description) > 45) ? "..." : '';
                                            ?>
                                        </td>
                                        <?php
                                        if (_is("GR Admin")) {
                                            ?>
                                            <td><?=$value->count?></td>

                                            <?php
                                        }
                                        ?>
                                        <td>
                                            <a href="<?php echo site_url('event/testimonial_view/' . $value->id) ?>" class="btn btn-sm btn-primary" title="view">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
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
        $('.statuschanger').bootstrapToggle({
            on: 'Published',
            off: 'Not Published'
        });
        $(".startdate,.enddate").datepicker({format: 'dd M yyyy',autoclose: true});
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
        $('.statuschanger').change(function () {
            var value1,message;
            if ($(this).prop('checked')) {
                value1 = 1;
                message="Event has been published";
            } else {
                value1 = 0;
                message="Event has been unpublished";
            }
            var variablee = $(this);
            $.ajax({
                url: "<?= site_url('event/verify') ?>/" + $(this).val() + '/' + value1,
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

        
    });
</script>
