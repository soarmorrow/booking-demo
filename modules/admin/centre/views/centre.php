<style type="text/css">
  .select2{
    width: 100% !important;
  }
</style>
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
<!-- Select2 -->
<link href="<?= base_url($theme_path . 'plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<section class="content-header">
     <h1>
          Centres
          <small></small>
     </h1>
     <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Centre</a></li>
          <li class="active">List Centres</li>
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
                                        <div class="col-md-3">
                                             <label class="h5">Name</label>
                                             <input type="text" name="name" placeholder="Name" class="form-control" value="<?= isset($filters['name']) ? $filters['name'] : "" ?>">
                                        </div>
                                        <div class="col-md-3">
                                             <label class="h5">Email</label>
                                             <input type="text" name="email" placeholder="email" class="form-control" value="<?= isset($filters['email']) ? $filters['email'] : "" ?>">
                                        </div>
                                        <div class="col-md-3">
                                             <label class="h5">Reg No</label>
                                             <input type="text" name="reg_no" placeholder="Reg No" class="form-control" value="<?= isset($filters['reg_no']) ? $filters['reg_no'] : "" ?>">
                                        </div>
                                        <div class="col-md-3">
                                             <label class="h5">Address</label>
                                             <input type="text" name="address" placeholder="Address" class="form-control" value="<?= isset($filters['address']) ? $filters['address'] : "" ?>">
                                        </div> </div>
                                   <div class="row">

                                        <div class="col-md-3">
                                             <label class="h5">Category</label>
                                             <select name="rc_cat" class="form-control select2">
                                                  <option value="">All Categories</option>
                                                  <?php
                                                    if (isset($rccats)) {
                                                         foreach ($rccats as $cat) {
                                                              ?>
                                                              <option value="<?= $cat->id ?>" <?php if ((isset($filters['rc_cat']) ? $filters['rc_cat'] : "") == $cat->id) echo 'selected'; ?>><?= $cat->rc_category ?></option>
                                                              <?php
                                                         }
                                                    }
                                                  ?>
                                             </select>
                                        </div>
                                        <div class="col-md-3">
                                             <label class="h5">Type</label>
                                             <select name="rc_type" class="form-control select2">
                                                  <option value="">All types</option>
                                                  <?php
                                                    if (isset($rctypes)) {
                                                         foreach ($rctypes as $type) {
                                                              ?>
                                                              <option value="<?= $type->id ?>" <?php if ((isset($filters['rc_type']) ? $filters['rc_type'] : "") == $type->id) echo 'selected'; ?>><?= $type->name ?></option>
                                                              <?php
                                                         }
                                                    }
                                                  ?>
                                             </select> 
                                        </div>
                                        <div class="col-md-3">
                                             <label class="h5">Status</label>
                                             <select name="status" class="form-control select2">
                                                  <option value="">All</option>
                                                  <option value="1" <?php if ((isset($filters['status']) ? $filters['status'] : "") === "1") echo 'selected'; ?>>Verified</option>
                                                  <option value="0" <?php if ((isset($filters['status']) ? $filters['status'] : "") === "0") echo 'selected'; ?>>Not verified</option>
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
                         <div class="box-body">    
                              <a href="<?= site_url('centre/add') ?>" class="btn btn-sm btn-success pull-right" style="margin-bottom: 5px;">Add new centre</a>
                              
                        <div class="col-md-12 table-responsive">
                              <table id="listcentres" class="table table-bordered table-striped">
                                   <thead>
                                        <tr>
                                             <th>Logo</th>
                                             <th>Name</th>
                                             <th style="width:100px !important">Email</th>
                                             <th>Reg No.</th>
                                             <th>Address</th>   
                                             <th>Category</th>
                                             <th>Type</th>
                                             <th>Status</th>
                                             <th>Popularity</th>
                                             <th>Actions</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                          foreach ($centers as $value) {
                                               ?>
                                               <tr id="centre<?= $value->id ?>">
                                                    <td>
                                                         <?php
                                                         if (!empty($value->logo)) {
                                                              $src = $value->logo;
                                                         } else {
                                                              $src = base_url($theme_path . 'images/dlogo.jpg');
                                                         }
                                                         ?><img src="<?= $src ?>" alt="" style="height: 50px;">
                                                    </td>
                                                    <td><?= $value->name ?></td>
                                                    <td><?= $value->email ?></td>
                                                    <td><?= $value->reg_num ?></td>
                                                    <td><?php echo $value->street_address1 . ", " . $value->street_address2 . "<br>" . $value->city . ", " . $value->state . "<br>" . $value->country ?></td>
                                                    <td><?php
//                                                         if (strlen($value->description) > 150) {
//                                                              $length = strpos($value->description, ' ', 150);
//                                                              echo substr($value->description, 0, $length) . '&hellip;';
//                                                         } else
//                                                              echo $value->description;
//                                                         
                                                         ?>
                                                         <?= $value->rc_category ?>
                                                    </td>
                                                    <td><?= $value->rc_type ?></td>
                                                    <td>
                                                         <?php
                                                         if ($value->verified == 1) {
                                                              echo '<input checked type = "checkbox" class = "statuschanger" data-size = "small" data-onstyle = "success" data-offstyle="danger" value = "' . $value->id . '" >';
                                                         } else {
                                                              echo '<input type = "checkbox" class = "statuschanger" data-size = "small" data-onstyle = "success" data-offstyle="danger"  value = "' . $value->id . '" >';
                                                         }
                                                         ?>
                                                    </td>
                                                    <td>
                                                         <?php
                                                         if ($value->popularity == 1) {
                                                              echo '<input checked type = "checkbox" class = "popularitychanger" data-size = "small" data-onstyle = "success" data-offstyle="danger" value = "' . $value->id . '" >';
                                                         } else {
                                                              echo '<input type = "checkbox" class = "popularitychanger" data-size = "small" data-onstyle = "success" data-offstyle="danger"  value = "' . $value->id . '" >';
                                                         }
                                                         ?>
                                                    </td>
                                                    <td>
                                                         <a href="<?php echo site_url('centre/view/' . $value->id) ?>" class="btn btn-sm btn-primary" title="view">
                                                              <i class="fa fa-eye"></i>
                                                         </a>
                                                         <a href="<?php echo site_url('centre/update/' . $value->id) ?>" class="btn btn-sm bg-green" title="edit">
                                                              <i class="fa fa-pencil"></i>
                                                         </a>

                                                         <span  data-link="<?php echo site_url('centre/delete_centre/' . $value->id) ?>" data-namevalue="<?= $value->name ?>" data-id="<?= $value->id ?>" class="deletecentre btn btn-sm btn-danger" title="delete">
                                                              <i class="fa fa-remove"></i>
                                                         </span>

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
          $("#listcentres").dataTable({
               "bInfo": false,
               searching: false,
               sortable:false,
               paging: false
          });
          $('.statuschanger').bootstrapToggle({
               on: 'Verified',
               off: 'Not verified'
          });
          $('.popularitychanger').bootstrapToggle({
               on: 'Popular',
               off: 'Not popular'
          });
          $("#perpage").change(function () {
               $.ajax({
                    url: "<?= site_url('centre/change_perpage') ?>/" + $(this).val() + '',
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
                    url: "<?= site_url('centre/verify') ?>/" + $(this).val() + '/' + value1,
                    method: "post",
                    success: function (result) {

                         if (result === '1') {
                              swal("Success!", "Centre status has been changed.", "success");
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
          $('.popularitychanger').change(function () {
               var value1;
               if ($(this).prop('checked')) {
                    value1 = 1;
               } else {
                    value1 = 0;
               }
               var variablee = $(this);
               $.ajax({
                    url: "<?= site_url('centre/popularity_verify') ?>/" + $(this).val() + '/' + value1,
                    method: "post",
                    success: function (result) {

                         if (result === '1') {
                              swal("Success!", "Centre status has been changed.", "success");
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
                    {"orderable": false, "targets": [0, 8]}
               ]
          });

          $('.deletecentre').click(function () {
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
