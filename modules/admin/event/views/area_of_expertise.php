
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
<section class="content-header">
    <h1>
        Area of expertise
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Events</a></li>
        <li class="active">Area of expertise</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">    
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Add New Area of expertise</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <form name="" method="post" action="">
                                <div class="col-md-12">
                                    <div class="">
                                        <div class="col-md-5">
                                            <input type="text" name="area_of_expertise" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-primary">Add New</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>  
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <div class="box box-success">
                    <div class="box-body">
                        <table id="listtypes" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="">Sl.No</th>
                                    <th>Area of Expertise</th>
                                    <th style="width: 250px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($area_of_expertise as $value) {
                                    $i = ++$i;
                                    ?>
                                    <tr id="type<?= $value->id ?>">

                                        <td>  <span class="desp_name"><?= $i ?></span></td>
                                        <td>  <span class="desp_name"><?= $value->area_of_expertise ?></span></td>
                                        <td>                                                                                                                                                    
                                            <span data-link="<?php echo site_url('event/delete_area_of_expertise/' . $value->id) ?>" data-namevalue="<?= $value->area_of_expertise ?>" data-id="<?= $value->id ?>" class="deletetype btn btn-sm btn-danger" title="archive">
                                                <i class="fa fa-remove"></i>
                                            </span>  

                                        </td>
                                    </tr>
                                    <?php
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
<style>
    .btn i{
        height: 10px;
    }
    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
        vertical-align: middle;
    }
</style>
<script src="<?= base_url($theme_path . 'plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>
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
        $("#listtypes").dataTable({
            order: [[0, 'asc']],
            "columnDefs": [
                {"orderable": false, "targets": 2}
            ]
        });
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
                        console.log(result);
                        if (result === '1') {
                            $("#type" + id).remove();
                            swal("Archived!", "Language '" + name + "' archived successfully.", "success");
                        } else {
                            swal("Oops!", "Failed to archive", "error");
                        }
                    }, error: function () {
                        swal("Oops!", "Failed to archive", "error");
                    }
                });

            });
        });


    });
</script>
