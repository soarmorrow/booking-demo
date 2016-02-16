<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
<link href="<?= base_url($theme_path . 'plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Add New Centre
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Centre</a></li>
        <li class="active">New Centre</li>
    </ol>
</section>

<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box  box-success">
                    <div class="box-header">
                    </div><!-- /.box-header -->
                    <form name="createuser" method="post" action="" id="createuser" enctype="multipart/form-data">
                        <div class="box-body" style="padding-top: 0px">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="map_canvas" style="height: 200px;">


                                    </div>
                                    <input id="map" class="form-control">
                                </div>
                            </div>
                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-group <?php
                                    if (form_error('cname') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                    <label class="h5">Centre Name</label>
                                    <input type="text" name="cname" placeholder="Centre Name" required class="form-control" value="<?= set_value('cname'); ?>"/>
                                    <?php echo form_error('cname'); ?>
                                </div>
                                <div class="form-group <?php
                                if (form_error('established') != '')
                                    echo 'has-error';
                                else
                                    echo '';
                                ?>">
                                <label class="h5">Established year</label>
                                <input type="text" name="established" placeholder=" Established in the year" required class="form-control" value="<?= set_value('established'); ?>"/>
                                <?php echo form_error('established'); ?>
                            </div>
                            <div class="form-group <?php
                            if (form_error('street_address1') != '')
                                echo 'has-error';
                            else
                                echo '';
                            ?>">
                            <label class="h5">Address Line 1</label>
                            <input type="text"  id="address1" data-geo="administrative_area_level_3" name="street_address1" placeholder="Address line 1" required class="form-control" value="<?= set_value('street_address1'); ?>"/>
                            <?php echo form_error('street_address1'); ?>
                        </div>
                        <div class="form-group <?php
                        if (form_error('street_address2') != '')
                            echo 'has-error';
                        else
                            echo '';
                        ?>">
                        <label class="h5">Address Line 2</label>
                        <input type="text" id="address2"  data-geo="locality" name="street_address2" placeholder="Address line 2" required class="form-control" value="<?= set_value('street_address2'); ?>"/>
                        <?php echo form_error('street_address2'); ?>
                    </div>                                            
                    <div class="form-group <?php
                    if (form_error('city') != '')
                        echo 'has-error';
                    else
                        echo '';
                    ?>">
                    <label class="h5">City</label>
                    <input type="text"  id="city" data-geo="administrative_area_level_2" name="city" placeholder="City" required class="form-control" value="<?= set_value('city'); ?>"/>
                    <?php echo form_error('city'); ?>
                </div>
                <div class="form-group <?php
                if (form_error('state') != '')
                    echo 'has-error';
                else
                    echo '';
                ?>">
                <label class="h5">State</label>
                <input type="text" id="state"  data-geo="administrative_area_level_1" name="state" placeholder="State" required class="form-control" value="<?= set_value('state'); ?>"/>
                <?php echo form_error('state'); ?>
            </div> 
            <div class="form-group <?php
            if (form_error('zipcode') != '')
                echo 'has-error';
            else
                echo '';
            ?>">
            <label class="h5">Zipcode</label>
            <input type="text" id="zip"  data-geo="postal_code" name="zipcode" placeholder="Zipcode" required class="form-control" value="<?= set_value('zipcode'); ?>"/>
            <?php echo form_error('zipcode'); ?>
        </div>
        <div class="form-group <?php
        if (form_error('country') != '')
            echo 'has-error';
        else
            echo '';
        ?>">
        <label class="h5">Country</label>
        <input type="text" data-geo="country" name="country" placeholder="Country" required class="form-control" value="<?= set_value('country'); ?>"/>
        <?php echo form_error('country'); ?>
    </div>
    <div class="form-group <?php
    if (form_error('key_person') != '')
        echo 'has-error';
    else
        echo '';
    ?>">
    <label class="h5">Key contact person</label>
    <input type="text" name="key_person" placeholder=" Key Contact Person" required class="form-control" value="<?= set_value('key_person'); ?>"/>
    <?php echo form_error('key_person'); ?>
</div>
<div class="form-group hidden <?php
if (form_error('latitude') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Latitude</label>
<input type="text" data-geo="lat" name="latitude" value="0" placeholder="Latitude" class="form-control" value="<?= set_value('latitude'); ?>"/>
<?php echo form_error('latitude'); ?>
</div>
<div class="hidden form-group <?php
if (form_error('logitude') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Longitude</label>
<input type="text" data-geo="lng" name="longitude" value="0" placeholder="Longitude" class="form-control" value="<?= set_value('longitude'); ?>"/>
<?php echo form_error('logitude'); ?>
</div>
<div class="form-group <?php
if (form_error('etype') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Preachers</label>
<select name="preachers[]" class="form-control select2" required multiple="multiple">
    <?php

    if (isset($preacherslist)) {
        foreach ($preacherslist as $pr) {
            ?>
            <option value="<?= $pr->id ?>" <?=in_array($pr->id, $preacherarray)?'selected':'' ?>><?= $pr->name ?></option>
            <?php
        }
    }
    ?>
</select>                                                
<?php echo form_error('etype'); ?>
</div>
<div class="form-group">
    <label class="h5">Add Centre Logo</label>
    <div class="">
        <div class="form-group">
            <div id="imagePreview"></div>
        </div>
    </div>
    <label for="uploadFile" class="btn btn-default">Upload</label>
    <input type="file" name="logo" id="uploadFile" class="hidden"/>
</div>
</div>

<div class="col-md-6">
    <div class="form-group <?php
    if (form_error('reg_no') != '')
        echo 'has-error';
    else
        echo '';
    ?>">
    <label class="h5">Register Number</label>
    <input type="text" name="reg_no" placeholder="Register Number" required class="form-control" value="<?= set_value('reg_no'); ?>"/>
    <?php echo form_error('reg_no'); ?>
</div>
<div class="form-group <?php
if (form_error('email') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Email</label>
<input type="email" name="email" placeholder="Email" required class="form-control" value="<?= set_value('email'); ?>"/>
<?php echo form_error('email'); ?>
</div>
<div class="form-group <?php
if (form_error('phonenumber') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Phone Number</label>
<input type="text" name="phonenumber" placeholder="Contact Number" required class="form-control" value="<?= set_value('phonenumber'); ?>"/>
<?php echo form_error('phonenumber'); ?>
</div>
<div class="form-group <?php
if (form_error('description') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Description</label>
<textarea class="form-control" rows="5" name="description" placeholder="description" style="height:120px;"><?= set_value('description'); ?></textarea>
<?php echo form_error('description'); ?>
</div>

<div class="form-group <?php
if (form_error('facility') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Facilities</label>
<textarea class="form-control" rows="5" name="facility" placeholder="Write down the facilities here" style="height:120px;"><?= set_value('facility'); ?></textarea>
<?php echo form_error('facility'); ?>
</div>

<div class="form-group <?php
if (form_error('rctype') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Centre Type</label>
<select name="rctype" class="form-control" required>
    <option value="">select type</option>
    <?php
    if (isset($rctypes)) {
        foreach ($rctypes as $type) {
            ?>
            <option value="<?= $type->id ?>" <?php if (set_value('rctype') == $type->id) echo 'selected'; ?>><?= $type->name ?></option>
            <?php
        }
    }
    ?>
</select>                                                
<?php echo form_error('rctype'); ?>
</div>
<div class="form-group <?php
if (form_error('rc_cat') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Centre Category</label>
<select name="rc_cat" class="form-control" required>
    <option value="">select category</option>
    <?php
    if (isset($rccats)) {
        foreach ($rccats as $cat) {
            ?>
            <option value="<?= $cat->id ?>" <?php if (set_value('rc_cat') == $cat->id) echo 'selected'; ?>><?= $cat->rc_category ?></option>
            <?php
        }
    }
    ?>
</select>                                                
<?php echo form_error('rc_cat'); ?>
</div>

<div class="form-group <?php
if (form_error('key_person') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Website</label>
<input type="text" name="website" placeholder=" Website" class="form-control" value="<?= set_value('website'); ?>"/>
<?php echo form_error('website'); ?>
</div>
</div>
</div>

<div class="row">
    <div class="col-md-12"><label>Gallery Images</label></div>
    <div class="col-md-12">
        <div id="dropzone" class="dropzone"></div>
        <div id="hiddenimages" class="hide"></div>
    </div>
</div>


</div><!-- /.box-body -->
<div class="box-footer">  
    <a onclick="history.go(-1);" class="btn-default btn">
        Back
    </a>
    <button type="submit" class="btn btn-primary" id="submit2" onclick="return validatethis();">Submit</button>
</div>
</form>
</div><!-- /.box -->
</div><!-- /.col -->

</div><!-- /.row -->

</section>
</section>

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

<script src="<?= base_url($theme_path . 'plugins/select2/select2.full.min.js') ?>" type="text/javascript"></script>
<?php
if ($this->session->flashdata('message')) {
    ?>
    <script>
    $(document).ready(function(){
    $('select').chosen();
});
       $(window).load(function () {
           swal({
               title: "<?= $this->session->flashdata('message') ?>",
               text: "",
               type: "success",
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
    $(window).load(function () {
        $(".select2").select2();
    })
    var geocoder = new google.maps.Geocoder();
    var map;
    var options = {
        map: "#map_canvas",
        location: [0, 0],
        markerOptions: {
            draggable: true
        }
    };
    $("#map").geocomplete(options)
    .bind("geocode:result", function (event, result) {
        $("input[name=latitude]").val(result.geometry.location.lat());
        $("input[name=longitude]").val(result.geometry.location.lng());
        codeLatLng(result.geometry.location, false);
    });

    $("#map").bind("geocode:dragged", function (event, latLng) {
        $("input[name=latitude]").val(latLng.lat());
        $("input[name=longitude]").val(latLng.lng());
        codeLatLng(latLng, true);
    });

    function codeLatLng(latlng, update_text_field) {
        geocoder.geocode({'latLng': latlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    if (update_text_field) {
                        $("#map").val(results[0].formatted_address);
                    }
                    var address = results[0].address_components;
                    for (var i = 0; i < address.length; i++) {
                        if (jQuery.inArray("country", address[i].types) != -1) {
                            $("input[name='country']").val(address[i].long_name)
                        }
                        else if (jQuery.inArray("postal_code", address[i].types) != -1) {
                            $('#zip').val(address[i].long_name)
                        }
                        else if (jQuery.inArray("administrative_area_level_1", address[i].types) != -1) {
                            $('#state').val(address[i].long_name)
                        }
                        else if (jQuery.inArray("locality", address[i].types) != -1) {
                            $('#address2').val(address[i].long_name)
                        }
                        else if (jQuery.inArray("administrative_area_level_2", address[i].types) != -1) {
                            $('#city').val(address[i].long_name)
                        }
                        else if (jQuery.inArray("sublocality_level_1", address[i].types) != -1) {
                            $('#address1').val(address[i].long_name)
                        }
                    }
                } else {
                    //alert('No results found');
                }
            } else {
                //alert('Geocoder failed due to: ' + status);
            }
        }
        );
}


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
if ('<?php echo $typealert ?>' == 'success') {
    alertify.success('<?php echo $message; ?>')
} else if ('<?php echo $typealert ?>' == 'error') {
    alertify.error('<?php echo $message; ?>')
}
</script>
<script type="text/javascript">
    $("#dropzone").dropzone({
        url: "uploadfiles",
        maxFilesize: 500,
        acceptedFiles: 'image/*',
        accept: function(file, done) {
          file.acceptDimensions = done;
          file.rejectDimensions = function() {
              done('The image must be at least 1024 X 428 Size');
          };
      },
      success: function (result, xhr) {
        var obj = jQuery.parseJSON(xhr);
        result.customid = obj.path;
        if (obj.type == 0) {
            $("#hiddenimages").append('<input type="hidden" name="centerimages[]" value="' + obj.path + '">');
        }
    },
    addRemoveLinks: true,
    removedfile: function (file) {
        var path = file.customid;
        $.ajax({
            type: 'POST',
            url: "deletefiles",
            data: {path: path},
            success: function (data) {
                $("#hiddenimages input[value='" + path + "']").remove();
            }
        });
        var _ref;
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
    },
    init: function () {
        var submit2 = document.getElementById('submit2');
        if (this.getUploadingFiles().length != 0 && this.getQueuedFiles().length != 0) {
            submit2.disabled = true;
        }
        this.on("complete", function (file) {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                submit2.disabled = false;
            }
        });
        this.on('success', function( file, resp ){
          console.log( file );
          console.log( resp );
      });
        this.on('thumbnail', function(file) {
          if ( file.width < 1024 || file.height < 425 ) {
            file.rejectDimensions();
        }
        else {
            file.acceptDimensions();
        }
    });
    },
    sending: function () {
        var submit2 = document.getElementById('submit2');
        submit2.disabled = true;
    }
});
</script>
<style type="text/css">
    .select2 {
        /*margin-top: -3px !important;*/
    }
</style>