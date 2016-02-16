
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
                            <table id="listevents" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="">Center Name</th>
                                        <th>Preacher Name</th>
                                        <?php
                                    if (_is("GR Admin")) {
                                        ?>
                                        <th style="width: 100px">Status</th>
                                        <?php
                                    }
                                    ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    foreach ($approve as $value) {
                                        ?>
                                        <tr id="centre<?= $value->id ?>">
                                            <td>
                                                <?= $value->centername ?>
                                            </td>
                                            <td><?= $value->preachername ?></td>
                                            
                                                <?php
                                        if (_is("GR Admin")) {
                                            ?>
                                            <td>
                                                <input type = "checkbox" class = "statuschanger" data-size = "small" data-onstyle = "success" data-approveId="<?= $value->id ?>" data-offstyle="danger"  value = "' . $value->id . '" >
                                            </td>

                                            <?php
                                        }
                                        ?>
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
            var id=$('.statuschanger:checked').data('approveid');
            $.ajax({
                url: "<?= site_url('event/verify_existing_preacher') ?>/" + id,
                method: "post",
                success: function (result) {

                    if (result === '1') {
                        swal("Success!", "Approved Successfully", "success");
                        $('.statuschanger:checked').closest('tr').remove();
                    } else {
                        swal("Failed!", "Approval Failed", "error");
                    }
                }
            });
        });

        $('.statuschanger').bootstrapToggle({
            on: 'Approved',
            off: 'Not Approved'
        });
        
$("#perpage").change(function () {
    $.ajax({
        url: "<?= site_url('event/change_perpage') ?>/" + $(this).val() + '',
        method: "post",
        success: function () {
            location.reload();
        }
    });
});
});
</script>
