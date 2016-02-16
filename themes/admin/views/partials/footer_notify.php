<script type="text/javascript">

<?php if ($this->session->flashdata('success')) {
	?>
	swal("Success!", '<?= $this->session->flashdata("success") ?>', "success");
	<?php
} 
if ($this->session->flashdata('error')) {
	?>

	swal("Oops!", '<?= $this->session->flashdata("error") ?>', "Error");
	<?php
} 
?>

</script>