<div class="example-modal">
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Update Customer</h4>
                </div>
                <div class="modal-body">
                    <label>Name</label>
                    <div class="form-group">
                        <input type="hidden" id="typeid" class="">  
                        <input type="text" id="typename" disabled placeholder="Customer name" class="form-control" name="customer">
                    </div>
                    <label>Benefactor type</label>
                    <div class="form-group">
                        <select id="benefactor_type"  class="form-control" name="benefactor_type">
                            <option value="1">Platinum</option>
                            <option value="2">Gold</option>
                            <option value="3">Silver</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update_type">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div><!-- /.example-modal -->
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
<section class="content-header">
    <h1>
        Customer
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Customers</a></li>
        <li class="active">List Customers</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">    
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Add New Benefactor</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <form name="" method="post" action="">
                                <div class="col-md-12">
                                    <div class="">
                                        <div class="col-md-5">
                                            <select name="customer" class="form-control" required>
                                                <option value="">Select Customer</option>
                                                <?php
                                                foreach ($customers as $customer) {
                                                    ?>
                                                    <option value="<?= $customer->id ?>"><?= $customer->first_name ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <select name="benefactor" class="form-control"  required>
                                                <option value="">Select benefactor type</option>
                                                <option value="1">Platinum</option>
                                                <option value="2">Gold</option>
                                                <option value="3">Silver</option>
                                            </select>
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
                                    <th style="">Name</th>
                                    <th>Email</th>
                                    <th>Contact number</th>
                                    <th>Benefactor type</th>
                                    <th style="width: 250px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($benefactors as $value) {
                                    ?>
                                    <tr id="type<?= $value->id ?>">

                                        <td>  <span class="desp_name"><?= $value->first_name ?></span></td>
                                        <td>  <span class="desp_name"><?= $value->email ?></span></td>
                                        <td>  <span class="desp_name"><?= $value->contact_number ?></span></td>
                                        <?php
                                        if ($value->benefactor_type == 1) {
                                            $benefactor_type = 'Platinum';
                                        } else if ($value->benefactor_type == 2) {
                                            $benefactor_type = 'Gold';
                                        } else {
                                            $benefactor_type = 'Silver';
                                        }
                                        ?>
                                        <td>  <span class="desp_name type" ><?= $benefactor_type ?></span></td>
                                        <td> 
                                            <span class="edittype btn btn-sm bg-green" data-id="<?php echo $value->id; ?>" data-type-id="<?= $value->benefactor_type ?>" data-name="<?php echo $value->first_name; ?>" data-benefactor="<?= $benefactor_type ?>" title="edit">
                                                <i class="fa fa-pencil"></i>
                                            </span>                                                                                                                                                     
                                            <span data-link="<?php echo site_url('customers/delete_benefactor/' . $value->id) ?>" data-namevalue="<?= $value->first_name ?>" data-id="<?= $value->id ?>" class="deletetype btn btn-sm btn-danger" title="archive">
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
                {"orderable": false, "targets": 4}
            ]
        });
        $(document).on('click', ".edittype", function () {
            $('#editModal #typeid').val($(this).data('id'));
            $('#editModal #typename').val($(this).data('name'));
            $('#editModal #benefactor_type').val($(this).data('type-id'));
            $("#editModal").modal('show');
        });
        $('#editModal').on('hidden.bs.modal', function (e) {
            $('#editModal #typeid').val("");
            $('#editModal #typename').val("");
            $('#editModal #benefactor_type').val("");
        });
        $(document).on('click', "#update_type", function () {
            var id = $('#editModal #typeid').val();
            var name = $('#editModal #typename').val();
            var benefactor = $('#editModal #benefactor_type').val();
            var benefactor_name = $("#benefactor_type option:selected").text();
            $.ajax({
                url: "<?= site_url('customers/update_benefactor') ?>",
                method: "post",
                data: {"id": id, "benefactor_type": benefactor},
                success: function (result) {
                    result = JSON.parse(result);
                    $("#editModal").modal('hide');
                    if (result.code == 200) {
                        $("#type" + id + " .type").text(benefactor_name);
                        $("#type" + id + " .type").attr('data-type-id', result.message.benefactor_type);
                        $("#type" + id + " .edittype").data("name", name);
                        swal("Updated!", "Type  updated successfully.", "success");
                    } else {
                        swal("Oops!", result.message, "error");
                    }
                }, error: function () {
                    swal("Oops!", "Failed to update", "error");
                }
            });
        });
        $(document).on('click', ".deletetype", function () {
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
                            swal("Archived!", "Benefactor '" + name + "' archived successfully.", "success");
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
