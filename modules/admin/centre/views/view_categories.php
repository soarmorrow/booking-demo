<div class="example-modal">
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Update Centre Category</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="hidden" id="categoryid">  
                        <input type="text" id="categoryname" class="form-control">  

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update_cat">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div><!-- /.example-modal -->
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
<section class="content-header">
    <h1>
        Centres
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Centre</a></li>
        <li class="active">View Categories</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">     
                <div class="box box-primary">
                    <!-- Button trigger modal -->
                    <div class="box-header">
                        <h3 class="box-title">Add New Category</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">                                 
                            <div class="col-md-12">
                                <form name="" method="post" action="">                                         
                                    <div class="input-group <?php echo form_error('catname') ? "error" : "" ?>">
                                        <input type="text" name="catname" class="form-control" required placeholder="Name of new category">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary">Add New</button>
                                        </div>
                                        <?php
                                        if (form_error('catname')) {
                                            echo form_error('catname');
                                        }
                                        ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <div class="box box-success">
                    <div class="box-body">
                        <table id="listcategories" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="">Name</th>
                                    <th style="width: 250px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($rccats as $value) {
                                    ?>
                                    <tr id="cat<?= $value->id ?>">

                                        <td>
                                            <span class="desp_name">
                                                <?= $value->rc_category ?>
                                            </span>


                                        </td>
                                        <td>
    <!--                                                         <a href="<?php echo site_url('centre/view_category/' . $value->id) ?>" class="btn btn-sm btn-primary" title="view">
                                                  <i class="fa fa-eye"></i>
                                             </a>-->
    <!--                                                         <a href="<?php echo site_url('centre/update_category/' . $value->id) ?>" class="btn btn-sm bg-green" title="edit">
                                                  <i class="fa fa-pencil"></i>
                                             </a>-->
                                            <span class="editcategory btn btn-sm bg-green" data-id="<?php echo $value->id; ?>" data-name="<?php echo $value->rc_category; ?>" title="edit">
                                                <i class="fa fa-pencil"></i>
                                                </a></span>
                                            <span data-link="<?php echo site_url('centre/delete_category/' . $value->id) ?>" data-namevalue="<?= $value->rc_category ?>" data-id="<?= $value->id ?>" class="deletecat btn btn-sm btn-danger" title="archive">
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
        });</script>
    <?php
}
?>
<script>
    $(window).load(function () {

        $("#listcategories").dataTable({
            order: [[0, 'asc']],
            "columnDefs": [
                {"orderable": false, "targets": 1}
            ]
        });
        $(document).on('click', ".editcategory", function () {
            $('#editModal #categoryid').val($(this).data('id'));
            $('#editModal #categoryname').val($(this).data('name'));
            $("#editModal").modal('show');
        });
        $('#editModal').on('hidden.bs.modal', function (e) {
            $('#editModal #categoryid').val("");
            $('#editModal #categoryname').val("");
        });
        $(document).on('click', '#update_cat', function () {
            var id = $('#editModal #categoryid').val();
            var name = $('#editModal #categoryname').val();
            $.ajax({
                url: "<?= site_url('centre/update_category') ?>",
                method: "post",
                data: {"id": id, "name": name},
                success: function (result) {
                    $("#editModal").modal('hide');
                    if (result === '1') {
                        $("#cat" + id + " .desp_name").text(name);
                        $("#cat" + id + " .editcategory").data("name", name);
                        swal("Updated!", "Category  updated successfully.", "success");
                    } else {
                        swal("Oops!", "Failed to update", "error");
                    }
                }, error: function () {
                    swal("Oops!", "Failed to update", "error");
                }
            });
        });
        $(document).on('click', '.deletecat', function () {
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
                        if (result === '1') {
                            $("#cat" + id).remove();
                            swal("Archived!", "Category '" + name + "' archived successfully.", "success");
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
