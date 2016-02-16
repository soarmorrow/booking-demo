<div class="example-modal">
	<div class="modal" id="editModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Update Accomodation</h4>
				</div>
				<div class="modal-body">
					<label>Accomodation type</label>
					<div class="form-group">
						<input type="hidden" id="typeid" class="">  
						<input type="text" id="typename" placeholder="Accomodation type" class="form-control">
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
		Event
		<small></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Accomodation type</a></li>
	</ol>
</section>
<section class="content">
	<section class="content">
		<div class="row">
			<div class="col-md-12">    
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Accomodation details</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<form name="" method="post" action="">
								<div class="col-md-12">
									<div class="">
										<div class="col-md-4">
											<label>Accomodation type</label>
											<input type="text" name="accomodation" class="form-control" required>
										</div>
										
										<div class="col-md-2">
											<label></label>
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
									<th style="">Accomodation type</th>
									<th style="width: 250px;">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($accomodations as $value) {
									?>
									<tr id="type<?= $value->id ?>">

										<td>  <span class="desp_name type"><?= $value->accomodation_type ?></span></td>
<!--										<td>  <span class="desp_name rate"><?= $value->rate ?></span></td>
										<td>  <span class="desp_name currency"><?= $value->name.'('.$value->currency_code.')' ?></span></td>-->
										<td> 
											<span class="edittype btn btn-sm bg-green" data-id="<?php echo $value->id; ?>" data-name="<?php echo $value->accomodation_type; ?>" data-rate="<?=$value->rate?>" data-currency="<?=$value->currency?>"  title="edit">
												<i class="fa fa-pencil"></i>
											</span>                                                                                                                                                     
											<span data-link="<?php echo site_url('event/delete_accomodation/'  . $value->id) ?>" data-namevalue="<?= $value->accomodation_type ?>" data-id="<?= $value->id ?>" class="deletetype btn btn-sm btn-danger" title="archive">
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
			{"orderable": false, "targets": 1}
			]
		});
		$(".edittype").click(function () {
			$('#editModal #typeid').val($(this).data('id'));
			$('#editModal #typename').val($(this).data('name'));
			$('#editModal #rate').val($(this).data('rate'));
			$('#editModal #currency').val($(this).data('currency'));
			$("#editModal").modal('show');
		});
		$('#editModal').on('hidden.bs.modal', function (e) {
			$('#editModal #typeid').val("");
			$('#editModal #typename').val("");
			$('#editModal #rate').val("");
			$('#editModal #currency').val("");
		});
		$("#update_type").click(function () {
			var id = $('#editModal #typeid').val();
			var accomodation = $('#editModal #typename').val();
			var rate = $('#editModal #rate').val();
			var currency = $('#editModal #currency').val();
			var currency_code = $('#currency option:selected').text();
			console.log(currency);
			$.ajax({
				url: "<?= site_url('event/update_accomodation') ?>",
				method: "post",
				data: {"id":id,"accomodation":accomodation,"rate":rate,"currency":currency},
				success: function (result) {
					result = JSON.parse(result);
					$("#editModal").modal('hide');
					if ( result.code == 200) {
						$("#type" + id + " .type").text(accomodation);
						$("#type" + id + " .rate").text(rate);
						$("#type" + id + " .currency").text(currency_code);
						swal("Updated!", "Type  updated successfully.", "success");
					} else {
						swal("Oops!", result.message, "error");
					}
				}, error: function () {
					swal("Oops!", "Failed to update", "error");
				}
			});
		});
		$('.deletetype').click(function () {
			var href = $(this).data('link');
			var id = $(this).data('id');
			console.log(id);
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
						// console.log(result);
						if (result === '1') {
							$("#type" + id).remove();
							swal("Archived!", "Type '" + name + "' archived successfully.", "success");
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
