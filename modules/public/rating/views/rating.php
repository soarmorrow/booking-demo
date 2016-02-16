
<style type="text/css">
	.panel-login>.panel-heading {
		color: #00415d;
		background-color: #fff;
		border-color: #fff;
		text-align:center;
	}
	.text-red{
		color: red;
	}
	#da-login-form input {
		border-radius: 5px;
		padding-left: 10px;
		background-image: none !important;
		background-color: #fafafa;
		height: 45px;
		border: 1px solid #ddd;
	}
</style>
<div class="clearfix"></div><br><br><br><br>
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-login">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<h2>Rate the event now</h2>
						</div>
						<hr>

						<div class="clearfix"></div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-10 col-lg-offset-1">
									<center>
										<div class="rating"><span data-value="5">&star;</span><span data-value="4">&star;</span><span data-value="3">&star;</span><span data-value="2">&star;</span><span data-value="1">&star;</span></div>
									</center>
								</div><!-- /.login-box-body -->
							</div><!-- /.login-box -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var rates = {
			update: function(current_rate){
				for(var i = 1 ; i <= current_rate; i++){
					$("span[data-value='"+i+"']").css('color','#f90').html("&starf;");
				}
			},
			clear: function(){
				for(var i = 1 ; i <= 5; i++){
					$("span[data-value='"+i+"']").css('color','#00415d').html("&star;");
				}
			}
		}
		<?php
		if(!empty($current_rating)){
		?>
		rates.update(<?=$current_rating->rating?>);
		<?php
	}
		?>
		$('.rating span').on('click',function(){
			var rate = $(this).data('value');
			rates.clear();
			rates.update(parseInt(rate));
			$.post("<?= site_url('rating/rate_event/'.$event_id) ?>", {'rate':rate}, function(result){
				swal({title:"",text:"Rating marked", type:'success',timer:2000});
			});
		});
		$('.rating').hover(function(){
			rates.clear();
		}, function(){
			$.getJSON("<?= site_url('rating/get_counts/'.$event_id) ?>",function(data){
					rates.update(data);
			});
			
		});
	});
</script>
