
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
<!-- Select2 -->
<link href="<?= base_url($theme_path . 'plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Bookings
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Bookings</a></li>
        <li class="active">List</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <form name="searchform" method="get" action="<?= site_url('booking') ?>">
                        <div class="box-header">
                            <h3 class="box-title">Search</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="row" style="padding-bottom: 20px;">

                                <div class="col-md-5">
                                    <label class="h5">Name</label>
                                    <input type="text" name="key" placeholder="Search key like Name of event, Name of center etc.." class="form-control" value="<?= isset($filters['key']) ? $filters['key'] : "" ?>">
                                </div>
                                <?php if (!_is("RC Admin")) { ?>
                                <div class="col-md-5">
                                    <label class="h5">Center</label>
                                    <select placeholder="Select Center" class="center_id form-control" name="center_id">
                                        <option value="">All</option>
                                        <?php
                                        foreach ($centers as $value) {
                                            ?>
                                            <option value="<?= $value->id ?>" <?= (isset($filters['center_id']) && $filters['center_id'] == $value->id) ? "selected" : "" ?>><?= $value->name ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-md-2" style="margin-top: 34px;">                                    
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </form>
            </div><!-- /.box -->
            <div class="box box-success">
                <div class="box-body">    

                    <div class=" col-md-12 table-responsive">
                        <table id="listcentres" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Event Name</th> 
                                    <th>Center name</th>
                                    <th style="width:80px;">Total seats</th> 
                                    <th style="width:100px;">Booked seats</th>
                                    <th style="width:100px;">Veg Meals</th> 
                                    <th style="width:100px;">Non-veg Meals</th>  
                                    <th style="width:140px;">Created Time of Event</th>
                                    <th style="width: 100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($eventdata as $value) {
                                    ?>
                                    <tr id="booking<?= $value->id ?>">
                                        <td><?= isset($filters['key'])?str_replace($filters['key'], '<b>'.$filters['key'].'</b>', $value->name):$value->name ?></td>
                                        <td><?= isset($filters['key'])?str_replace($filters['key'], '<b>'.$filters['key'].'</b>', $value->center_name):$value->center_name  ?></td>
                                        <td><?= $value->total_seats ?></td>
                                        <td><?= ($value->booked) ? $value->booked : 0 ?></td>
                                        <td><?= ($value->veg->meals) ? $value->veg->meals : 0 ?></td>
                                        <td><?= ($value->non_veg->meals) ? $value->non_veg->meals : 0 ?></td>

                                        <td><?= date(FORMAT_DATE, strtotime($value->added_date)) ?></td>

                                        <td>
                                            <a href="<?php echo site_url('booking/view_booking/' . $value->id) ?>" class="btn btn-sm btn-primary" title="View Bookings">
                                                <i class="fa fa-eye"></i>
                                            </a>
    <!--                                            <a href="<?php // echo site_url('event/update/' . $value->id)        ?>" class="btn btn-sm bg-green" title="edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <span  data-link="<?php // echo site_url('event/delete_event/' . $value->id)        ?>" data-namevalue="<?= $value->name ?>" data-id="<?= $value->id ?>" class="deleteevent btn btn-sm btn-danger" title="delete">
                                                <i class="fa fa-remove"></i>
                                            </span>-->

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>


                    </div><!-- /.box-body -->
                </div>
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
        $('select[name="center_id"]').select2();
        $("#listcentres").dataTable({
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
$("#listuser").dataTable({
    order: [[1, 'asc']],
    "columnDefs": [
    {"orderable": false, "targets": [0, 7]}
    ]
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
