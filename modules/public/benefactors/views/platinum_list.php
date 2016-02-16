<div class="col-sm-10 nopadding border_bottom">
	<h3><font id="benType"><?= $benefactor_type->name?></font> Benefactors</h3>
	<div class="clearfix"></div>
	<div class="col-md-12">
		<p style="padding-left:0"><?= $benefactor_type->description?></p>	
	</div>
</div>

<?php
foreach ($benefactors as $benefactor) {
	?>
	<div class="col-sm-10 nopadding border_bottom padding-top-30">
		<div class="col-sm-5 col-md-4">
			<img src="<?=base_url($benefactor->avatar)?>">
		</div>
		<div class="col-sm-7 col-md-8">
			<h3><?=$benefactor->first_name?></h3>
			<span><?=$benefactor->country?></span>
			<div class="clearfix"></div><br>
			<p>Address : <?=$benefactor->address?></p> 
			<p>District : <?=$benefactor->district?></p> 
			<p>State : <?=$benefactor->state?></p>
			<p>Pincode : <?=$benefactor->pincode?></p>
			<p>Email : <?=$benefactor->email?></p>
			<p>Contact Number : <?=$benefactor->contact_number?></p>
		</div>
	</div>
	<div class="clearfix"></div><br>
	<?php
}
?>
