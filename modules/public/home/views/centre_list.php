	<style type="text/css">
		.form-control{
			border: 1px solid #cecece;
			height: 45px;
			background-color: #fff;
			margin: 10px;
		}
		select.form-control{
			border: 1px solid #cecece;
			height: 45px;
			background-color: #fff;
			margin: 10px;
			border-radius: 5px;
		}
		.form-control:focus{
			background-color: #fff;
			border: 1px solid #cecece;
		}
		select.form-control:focus{
			border: 1px solid #cecece;
		}
		.form-group{
			padding-left: 0;
		}
	</style>
	<div class="clearfix"></div><br><br><br><br>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 center_list nopadding">
						<div class="col-md-12 list_center">
							<h2>List Your Center with goRetreat.com</h2>
							<span>Welcome to goretreat. Kindly fill in the form below to enlist yourself with us.</span>
						</div>
						<div class="col-md-12 form_section">
							<div class="col-md-12">
								<div class="col-md-12 nopadding">
									<h5>Fill in the form below</h5>
									<div class="clearfix"></div><br>
									<form action="<?=site_url('home/centre_list')?>" enctype="multipart/form-data" method="POST">

										<div class="form-group col-md-6 <?php echo (form_error('centre_name') || isset($centre_name_error)) ? 'text-danger' : ''; ?>">
											<input type="text" name="centre_name" id="centre_name" class="form-control" placeholder="Name of the retreat center" value="<?= set_value('centre_name') ?>">
											<?php if (form_error('centre_name') || isset($centre_name_error)) : ?>
												<span class="help-inline <?php echo (form_error('centre_name') || isset($centre_name_error)) ? 'text-danger' : ''; ?>">
													<?php echo form_error('centre_name'); ?>
													<?php if (isset($centre_name_error)) : ?>
														<span class="field_error"><?php echo $centre_name_error; ?></span>
													<?php endif; ?>
												</span>
											<?php endif; ?>
										</div>

										<div class="form-group col-md-6 <?php echo (form_error('place') || isset($place_error)) ? 'text-danger' : ''; ?>">
											<input type="text" name="place" id="place" class="form-control" placeholder="place/parish" value="<?= set_value('place') ?>">
											<?php if (form_error('place') || isset($place_error)) : ?>
												<span class="help-inline <?php echo (form_error('place') || isset($place_error)) ? 'text-danger' : ''; ?>">
													<?php echo form_error('place'); ?>
													<?php if (isset($place_error)) : ?>
														<span class="field_error"><?php echo $place_error; ?></span>
													<?php endif; ?>
												</span>
											<?php endif; ?>
										</div>
										<div class="clearfix"></div>
										<div class="form-group col-md-6 <?php echo (form_error('address1') || isset($address1_error)) ? 'text-danger' : ''; ?>">
											<input type="text" name="address1" id="address1" class="form-control" placeholder="Address line 01" value="<?= set_value('address1') ?>">
											<?php if (form_error('address1') || isset($address1_error)) : ?>
												<span class="help-inline <?php echo (form_error('address1') || isset($address1_error)) ? 'text-danger' : ''; ?>">
													<?php echo form_error('address1'); ?>
													<?php if (isset($address1_error)) : ?>
														<span class="field_error"><?php echo $address1_error; ?></span>
													<?php endif; ?>
												</span>
											<?php endif; ?>
										</div>
										<div class="form-group col-md-6 <?php echo (form_error('address2') || isset($address2_error)) ? 'text-danger' : ''; ?>">
											<input type="text" name="address2" id="address2" class="form-control" placeholder="Address line 02" value="<?= set_value('address2') ?>">
											<?php if (form_error('address2') || isset($address2_error)) : ?>
												<span class="help-inline <?php echo (form_error('address2') || isset($address2_error)) ? 'text-danger' : ''; ?>">
													<?php echo form_error('address2'); ?>
													<?php if (isset($address2_error)) : ?>
														<span class="field_error"><?php echo $address2_error; ?></span>
													<?php endif; ?>
												</span>
											<?php endif; ?>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-12 nopadding">
											
											<div class="form-group col-md-6 <?php echo (form_error('country') || isset($country_error)) ? 'text-danger' : ''; ?>">
												<select id="country" name ="country" class="form-control"></select>
												<?php if (form_error('country') || isset($country_error)) : ?>
													<span class="help-inline <?php echo (form_error('country') || isset($country_error)) ? 'text-danger' : ''; ?>">
														<?php echo form_error('country'); ?>
														<?php if (isset($country_error)) : ?>
															<span class="field_error"><?php echo $country_error; ?></span>
														<?php endif; ?>
													</span>
												<?php endif; ?>
											</div>
											<div class="form-group col-md-6">
												<select name ="state" id ="state" class="form-control">
													<option value="">Select State</option>
												</select>
											</div>
										</div>
										<script language="javascript">
											populateCountries("country", "state");
										</script>
										<div class="clearfix"></div>
										<div class="form-group col-md-6 <?php echo (form_error('contact') || isset($contact_error)) ? 'text-danger' : ''; ?>">
											<input type="text" name="contact" id="contact" class="form-control" placeholder="Key contact person" value="<?= set_value('contact') ?>">
											<?php if (form_error('contact') || isset($contact_error)) : ?>
												<span class="help-inline <?php echo (form_error('contact') || isset($contact_error)) ? 'text-danger' : ''; ?>">
													<?php echo form_error('contact'); ?>
													<?php if (isset($contact_error)) : ?>
														<span class="field_error"><?php echo $contact_error; ?></span>
													<?php endif; ?>
												</span>
											<?php endif; ?>
										</div>
										<div class="form-group col-md-6 <?php echo (form_error('phone') || isset($phone_error)) ? 'text-danger' : ''; ?>">
											<input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number" value="<?= set_value('phone') ?>">
											<?php if (form_error('phone') || isset($phone_error)) : ?>
												<span class="help-inline <?php echo (form_error('phone') || isset($phone_error)) ? 'text-danger' : ''; ?>">
													<?php echo form_error('phone'); ?>
													<?php if (isset($phone_error)) : ?>
														<span class="field_error"><?php echo $phone_error; ?></span>
													<?php endif; ?>
												</span>
											<?php endif; ?>
										</div>
										<div class="clearfix"></div>
										<div class="form-group col-md-6 <?php echo (form_error('email') || isset($email_error)) ? 'text-danger' : ''; ?>">
											<input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?= set_value('email') ?>">
											<?php if (form_error('email') || isset($email_error)) : ?>
												<span class="help-inline <?php echo (form_error('email') || isset($email_error)) ? 'text-danger' : ''; ?>">
													<?php echo form_error('email'); ?>
													<?php if (isset($email_error)) : ?>
														<span class="field_error"><?php echo $email_error; ?></span>
													<?php endif; ?>
												</span>
											<?php endif; ?>
										</div>
										<div class="form-group col-md-6 <?php echo (form_error('established') || isset($established_error)) ? 'text-danger' : ''; ?>">
											<input type="text" name="established" id="established" class="form-control" placeholder="Established in the year" value="<?= set_value('established') ?>">
											<?php if (form_error('established') || isset($established_error)) : ?>
												<span class="help-inline <?php echo (form_error('established') || isset($established_error)) ? 'text-danger' : ''; ?>">
													<?php echo form_error('established'); ?>
													<?php if (isset($established_error)) : ?>
														<span class="field_error"><?php echo $established_error; ?></span>
													<?php endif; ?>
												</span>
											<?php endif; ?>
										</div>

										<div class="clearfix"></div>
										<div class="col-md-12 nopadding">
											<!-- <div class="form-group col-md-6">
												<select name ="type" id ="type" class="form-control">
													<option value="">Select a suitable type of retreat</option>
													<?php
													foreach ($type as $value) {

														?>
														<option value='<?=$value->id?>'><?=$value->name?></option>
														<?php
													}
													?>
												</select>
											</div> -->
											<div class="form-group col-md-6 <?php echo (form_error('type') || isset($type_error)) ? 'text-danger' : ''; ?>">
												<select name ="type" id ="type" class="form-control">
													<option value="">Select a suitable type of retreat</option>
													<?php
													foreach ($type as $value) {

														?>
														<option value='<?=$value->id?>'><?=$value->name?></option>
														<?php
													}
													?>
												</select>
												<?php if (form_error('type') || isset($type_error)) : ?>
													<span class="help-inline <?php echo (form_error('type') || isset($type_error)) ? 'text-danger' : ''; ?>">
														<?php echo form_error('type'); ?>
														<?php if (isset($type_error)) : ?>
															<span class="field_error"><?php echo $type_error; ?></span>
														<?php endif; ?>
													</span>
												<?php endif; ?>
											</div>


											<div class="form-group col-md-6 <?php echo (form_error('zipcode') || isset($zipcode_error)) ? 'text-danger' : ''; ?>">
												<input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zipcode" value="<?= set_value('zipcode') ?>">
												<?php if (form_error('zipcode') || isset($zipcode_error)) : ?>
													<span class="help-inline <?php echo (form_error('zipcode') || isset($zipcode_error)) ? 'text-danger' : ''; ?>">
														<?php echo form_error('zipcode'); ?>
														<?php if (isset($zipcode_error)) : ?>
															<span class="field_error"><?php echo $zipcode_error; ?></span>
														<?php endif; ?>
													</span>
												<?php endif; ?>
											</div>
										</div>


										<div class="clearfix"></div>
										<div class="col-md-12 nopadding">
											<div class="form-group col-md-6 <?php echo (form_error('category') || isset($category_error)) ? 'text-danger' : ''; ?>">
												<select name ="category" id ="category" class="form-control">
													<option value="">Select a suitable category</option>
													<?php
													foreach ($category as $value) {
														?>
														<option value='<?=$value->id?>'><?=$value->rc_category?></option>
														<?php
													}
													?>
												</select>
												<?php if (form_error('category') || isset($category_error)) : ?>
													<span class="help-inline <?php echo (form_error('category') || isset($category_error)) ? 'text-danger' : ''; ?>">
														<?php echo form_error('category'); ?>
														<?php if (isset($category_error)) : ?>
															<span class="field_error"><?php echo $category_error; ?></span>
														<?php endif; ?>
													</span>
												<?php endif; ?>
											</div>


											<div class="form-group col-md-6 <?php echo (form_error('website') || isset($website_error)) ? 'text-danger' : ''; ?>">
												<input type="text" name="website" id="website" class="form-control" placeholder="Website" value="<?= set_value('website') ?>">
												<?php if (form_error('website') || isset($website_error)) : ?>
													<span class="help-inline <?php echo (form_error('website') || isset($website_error)) ? 'text-danger' : ''; ?>">
														<?php echo form_error('website'); ?>
														<?php if (isset($website_error)) : ?>
															<span class="field_error"><?php echo $website_error; ?></span>
														<?php endif; ?>
													</span>
												<?php endif; ?>
											</div>
										</div>
										<div class="clearfix"></div>
										<!-- <div class="form-group col-md-12" style="padding-bottom:20px;border-bottom:1px solid #d9d9d9;"> -->
											<!-- <textarea class="form-control" name="description" placeholder="Describe the center in 160 words"></textarea> -->
										</div>
										<div>
										<!-- border-bottom:1px solid #d9d9d9; -->
											<div style="padding-bottom:20px;" class="form-group col-md-12 <?php echo (form_error('description') || isset($description_error)) ? 'text-danger' : ''; ?>">
												<textarea class="form-control" name="description" style="max-width:100%" placeholder="Describe the center in 160 words"><?= set_value('description') ?></textarea>
												<?php if (form_error('description') || isset($description_error)) : ?>
													<span class="help-inline <?php echo (form_error('description') || isset($description_error)) ? 'text-danger' : ''; ?>">
														<?php echo form_error('description'); ?>
														<?php if (isset($description_error)) : ?>
															<span class="field_error"><?php echo $description_error; ?></span>
														<?php endif; ?>
													</span>
												<?php endif; ?>
											</div>
											<!-- <div class="form-group col-md-6 <?php echo (form_error('reg_number') || isset($reg_number_error)) ? 'text-danger' : ''; ?>">
												<input type="text" name="reg_number" id="reg_number" class="form-control" placeholder="Register Number" value="<?= set_value('reg_number') ?>">
												<?php if (form_error('reg_number') || isset($reg_number_error)) : ?>
													<span class="help-inline <?php echo (form_error('reg_number') || isset($reg_number_error)) ? 'text-danger' : ''; ?>">
														<?php echo form_error('reg_number'); ?>
														<?php if (isset($reg_number_error)) : ?>
															<span class="field_error"><?php echo $reg_number_error; ?></span>
														<?php endif; ?>
													</span>
												<?php endif; ?>
											</div> -->
										</div><div class="clearfix"></div>
										<div class="form-group col-sm-6">
                                        <label class="h5">Add Centre Logo</label>
                                        <div class="">
                                            <div class="form-group">
                                                <div id="imagePreview"></div>
                                            </div>
                                        </div>
                                        <label for="uploadFile" class="btn btn-default">Upload</label>
                                        <input type="file" name="logo" id="uploadFile" class="hidden"/>
                                    </div>


										<!-- <div class="col-md-12 nopadding" style="padding-top:20px;">
											<div class="form-group col-md-6 <?php echo (form_error('key_preacher') || isset($key_preacher_error)) ? 'text-danger' : ''; ?>">
												<input type="text" name="key_preacher" id="key_preacher" class="form-control" placeholder="Name of the key preacher" value="<?= set_value('key_preacher') ?>">
												<?php if (form_error('key_preacher') || isset($key_preacher_error)) : ?>
													<span class="help-inline <?php echo (form_error('key_preacher') || isset($key_preacher_error)) ? 'text-danger' : ''; ?>">
														<?php echo form_error('key_preacher'); ?>
														<?php if (isset($key_preacher_error)) : ?>
															<span class="field_error"><?php echo $key_preacher_error; ?></span>
														<?php endif; ?>
													</span>
												<?php endif; ?>
											</div>
											<div class="form-group col-md-6">
												<input type="file" name="file" class="form-control" style="visibility:hidden;" id="pdffile" />
												<div class="input-append">
													<input type="text" name="subfile" id="subfile" placeholder="Attach Profile" class="input-xlarge form-control">
													<a class="btn browse" onclick="$('#pdffile').click();">Browse</a>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="form-group col-md-12">
												<textarea class="form-control" placeholder="Or Enter the text here"></textarea>
											</div>
										</div> -->
										<!-- <div class="form-group">
											<div class="row">
												<div class="col-md-4">
													<span class="icon-input-btn"><span class="glyphicon glyphicon-plus"></span>
													<input type="button" name="button" id="button" class="form-control btn btn-info" value="Add More Preachers" style="background-color:#666666;">
												</div>

											</div>
										</div> --><!-- 
										<div class="clearfix"></div><br><br> -->
										<div class="form-group">
											<div class="row">
												<div class="col-sm-4 col-sm-offset-4">
													<input type="submit" name="submit" id="submit" class="form-control btn btn-info" value="Submit Your Center" style="background-color:#106fa4;">
												</div>

											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<style>
    #imagePreview {
        display: none;
        width: 100px;
        height: 100px;
        background-position: center center;
        background-size: cover;
        /*-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);*/
        /*display: ;*/
    }
</style>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<script src="<?= base_url($theme_path . 'plugins/geocomplete/jquery.geocomplete.min.js') ?>"></script>
		<script>
                    $(document).ready(function(){
                        var country="<?= set_value('country') ?>";
                        $('select[name=country] option[value='+country+']').attr('selected','selected');
                         $('select[name=country]').change();
                    });
                    $(document).ready(function(){
                        var state="<?= set_value('state') ?>";
                        console.log(state);
                        $('select[name=state] option[value='+state+']').attr('selected','selected');
                         $('select[name=state]').change();
                    });
                    $(document).ready(function(){
                        var category="<?= set_value('category') ?>";
                        $('select[name=category] option[value='+category+']').attr('selected','selected');
                         $('select[name=category]').change();
                    });
                    $(document).ready(function(){
                        var type="<?= set_value('type') ?>";
                        $('select[name=type] option[value='+type+']').attr('selected','selected');
                         $('select[name=type]').change();
                    });

                </script>
	</div>
	<div class="clearfix"></div><br><br>
	<?php
	if ($this->session->flashdata('message')) {
		$message=$this->session->flashdata('message');
		?>
		<script>
			$(window).load(function () {
				swal({
					title: "<?= $message['message'] ?>",
					text: "",
					type: "<?= $message['class'] ?>",
					timer: 3000,
					animation: false,
					showConfirmButton: false
				});
			});
		</script>
		<?php
	}
	?>


	<script>
	$('#uploadFile').change(function () {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) {
            $("#imagePreview").css("display", "none");
            return; // no file selected, or no FileReader support
        }
        if (/^image/.test(files[0].type)) { // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function () { // set image data as background of div
                $("#imagePreview").css("display", "inline-block");
                $("#imagePreview").css("background-image", "url(" + this.result + ")");
            }
        }
    });
</script>
