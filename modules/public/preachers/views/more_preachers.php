<div class="row">

	<?php
	foreach ($preachers as $preacher) {
		?>
		<div class="col-sm-3 col-md-3">
			<div class="card">
				<!-- <div class="card-height-indicator"></div> -->
				<div class="card-content">
                    <div class="img-description explore"><a href="<?=site_url('preachers/preachers_profile')?>/<?=$preacher->id?>"><span class="explore">- VIEW PROFILE -</span></a></div>
                    <div class="card-image">
						<img src="<?=base_url($preacher->image)?>" alt="Loading image...">
					</div>
					<div class="card-body">
						<div class="centre-info" style="margin-bottom: 0px;">
							<h4> <?= $preacher->name ?></h4>
						</div>
						<p><?php echo substr($preacher->address, 0, 20);
						if(strlen($preacher->address) > 20){
                            echo '...';
                        } 
                        ?></p>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<?php    
	}
	?>

</div>

