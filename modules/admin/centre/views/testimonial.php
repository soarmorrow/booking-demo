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
		Centres Testimonial
		<small></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Centre</a></li>
		<li class="active">Testimonial</li>
	</ol>
</section>
<section class="content">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success">
					<div class="box-body">
						<div class=" col-md-12 table-responsive">
							<table id="listcentres" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Logo</th>
										<th style="">Name</th>
										<th>Email</th>
										<th>Reg No.</th>
										<th>Address</th>   
										<th>Category</th>
										<th>Type</th>
										<th style="width: 100px">Testimonial</th>
										<th style="width:120px;">Actions</th>
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
											<td>
											<?= $value->rc_category ?>
										</td>
										<td><?= $value->rc_type ?></td>
										<td class="text-center"><?=$value->count?></td>
										<td class="text-center">
											<a href="<?php echo site_url('centre/testimonial_view/' . $value->id) ?>" class="btn btn-sm btn-primary" title="view">
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
          $("#listuser").dataTable({
          	order: [[1, 'asc']],
          	"columnDefs": [
          	{"orderable": false, "targets": [0, 8]}
          	]
          });
      });
</script>
