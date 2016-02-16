<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
<section class="content-header">
    <h1>
        Update Centre
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Centre</a></li>
        <li class="active">Update Centre</li>
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
                                    <input type="hidden" name="cid" value="<?= isset($center->id) ? $centre->id : 0 ?>">
                                    <input type="text" name="cname" placeholder="Centre Name" required class="form-control" value="<?= set_value('cname') ? set_value('cname') : (isset($centre->name) ? $centre->name : ''); ?>"/>
                                    <?php echo form_error('cname'); ?>
                                </div>
                                <div class="form-group <?php
                                if (form_error('street_address1') != '')
                                    echo 'has-error';
                                else
                                    echo '';
                                ?>">
                                <label class="h5">Address Line 1</label>
                                <input type="text"  id="address1" data-geo="administrative_area_level_3" name="street_address1" placeholder="Address line 1" required class="form-control" value="<?= set_value('street_address1') ? set_value('street_address1') : (isset($centre->street_address1) ? $centre->street_address1 : ''); ?>"/>
                                <?php echo form_error('street_address1'); ?>
                            </div>
                            <div class="form-group <?php
                            if (form_error('street_address2') != '')
                                echo 'has-error';
                            else
                                echo '';
                            ?>">
                            <label class="h5">Address Line 2</label>
                            <input type="text" id="address2"  data-geo="locality" name="street_address2" placeholder="Address line 2" required class="form-control" value="<?= set_value('street_address2') ? set_value('street_address2') : (isset($centre->street_address2) ? $centre->street_address2 : ''); ?>"/>
                            <?php echo form_error('street_address2'); ?>
                        </div>                                            
                        <div class="form-group <?php
                        if (form_error('city') != '')
                            echo 'has-error';
                        else
                            echo '';
                        ?>">
                        <label class="h5">City</label>
                        <input type="text"  id="city" data-geo="administrative_area_level_2" name="city" placeholder="City" required class="form-control" value="<?= set_value('city') ? set_value('city') : (isset($centre->city) ? $centre->city : ''); ?>"/>
                        <?php echo form_error('city'); ?>
                    </div>
                    <div class="form-group <?php
                    if (form_error('state') != '')
                        echo 'has-error';
                    else
                        echo '';
                    ?>">
                    <label class="h5">State</label>
                    <input type="text" id="state"  data-geo="administrative_area_level_1" name="state" placeholder="State" required class="form-control" value="<?= set_value('state') ? set_value('state') : (isset($centre->state) ? $centre->state : ''); ?>"/>
                    <?php echo form_error('state'); ?>
                </div> 
                <div class="form-group <?php
                if (form_error('zipcode') != '')
                    echo 'has-error';
                else
                    echo '';
                ?>">
                <label class="h5">Zipcode</label>
                <input type="text" id="zip"  data-geo="postal_code" name="zipcode" placeholder="Zipcode" required class="form-control" value="<?= set_value('zipcode') ? set_value('zipcode') : (isset($centre->zipcode) ? $centre->zipcode : ''); ?>"/>
                <?php echo form_error('zipcode'); ?>
            </div>
            <div class="form-group <?php
            if (form_error('country') != '')
                echo 'has-error';
            else
                echo '';
            ?>">
            <label class="h5">Country</label>
            <input type="text" data-geo="country" name="country" placeholder="Country" required class="form-control" value="<?= set_value('country') ? set_value('country') : (isset($centre->country) ? $centre->country : ''); ?>"/>
            <?php echo form_error('country'); ?>
        </div>
        <div class="form-group <?php
        if (form_error('rctype') != '')
            echo 'has-error';
        else
            echo '';
        ?>">
        <label class="h5">Centre Type</label>
        <?php
        $rtype = set_value('rctype') ? set_value('rctype') : (isset($centre->rc_type_id) ? $centre->rc_type_id : '');
        ?>
        <select name="rctype" class="form-control" required>
            <option value="">select type</option>
            <?php
            if (isset($rctypes)) {
                foreach ($rctypes as $type) {
                    ?>
                    <option value="<?= $type->id ?>" <?php if ($rtype == $type->id) echo 'selected'; ?>><?= $type->name ?></option>
                    <?php
                }
            }
            ?>
        </select>                                                
        <?php echo form_error('rctype'); ?>
    </div>
    <div class="hidden form-group <?php
    if (form_error('latitude') != '')
        echo 'has-error';
    else
        echo '';
    ?>">
    <label class="h5">Latitude</label>
    <input type="text" data-geo="lat" name="latitude" placeholder="Latitude" required class="form-control" value="<?= set_value('latitude') ? set_value('latitude') : (isset($centre->lattitude) ? $centre->lattitude : ''); ?>"/>
    <?php echo form_error('latitude'); ?>
</div>
<div class="hidden form-group <?php
if (form_error('logitude') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Longitude</label>
<input type="text" data-geo="lng" name="longitude" placeholder="Longitude" required class="form-control" value="<?= set_value('longitude') ? set_value('longitude') : (isset($centre->logitude) ? $centre->logitude : ''); ?>"/>
<?php echo form_error('logitude'); ?>
</div>

<div class="form-group">
    <label class="h5">Add Centre Logo</label>
    <div class="">
        <div class="form-group">
            <?php
            if (!empty($centre->logo)) {
                $src = base_url($centre->logo);
            } else {
                $src = base_url($theme_path . 'images/dlogo.jpg');
            }
            ?>
            <div id="imagePreview" style="display: inline-block;background-image: url('<?php echo $src; ?>')"></div>
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
    <input type="text" name="reg_no" placeholder="Register Number" required class="form-control" value="<?= set_value('reg_no') ? set_value('reg_no') : (isset($centre->reg_num) ? $centre->reg_num : ''); ?>"/>
    <?php echo form_error('reg_no'); ?>
</div>
<div class="form-group <?php
if (form_error('email') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Email</label>
<input type="email" name="email" placeholder="Email" required class="form-control" value="<?= set_value('email') ? set_value('email') : (isset($centre->email) ? $centre->email : ''); ?>"/>
<?php echo form_error('email'); ?>
</div>
<div class="form-group <?php
if (form_error('phonenumber') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Phone Number</label>
<input type="text" name="phonenumber" placeholder="Contact Number" required class="form-control" value="<?= set_value('phonenumber') ? set_value('phonenumber') : (isset($centre->contact) ? $centre->contact : ''); ?>"/>
<?php echo form_error('phonenumber'); ?>
</div>
<div class="form-group <?php
if (form_error('description') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Description</label>
<textarea class="form-control" rows="5" name="description" placeholder="description" style="height:120px;"><?= set_value('description') ? set_value('description') : (isset($centre->description) ? $centre->description : ''); ?></textarea>
<?php echo form_error('description'); ?>
</div>

<div class="form-group <?php
if (form_error('facility') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Facilities</label>
<textarea class="form-control" rows="5" name="facility" placeholder="Write down the facilities here" style="height:120px;"><?= set_value('facility') ? set_value('facility') : (isset($centre->facility) ? $centre->facility : ''); ?></textarea>
<?php echo form_error('facility'); ?>
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
        $rcat = set_value('rc_cat') ? set_value('rc_cat') : (isset($centre->rc_category_id) ? $centre->rc_category_id : '');
        foreach ($rccats as $cat) {
            ?>

            <option value="<?= $cat->id ?>" <?php if ($rcat == $cat->id) echo 'selected'; ?>><?= $cat->rc_category ?></option>
            <?php
        }
    }
    ?>
</select>                                                
<?php echo form_error('rc_cat'); ?>
</div>
<div class="form-group <?php
if (form_error('etype') != '')
    echo 'has-error';
else
    echo '';
?>">
<label class="h5">Preachers</label>
<select name="preachers[]" class="form-control select2" required multiple="">
    <?php
    if (isset($preacherslist)) {
        foreach ($preacherslist as $pr) {
            ?>
            <option value="<?= $pr->id ?>" <?php if (in_array($pr->id, $preacherarray)) echo 'selected'; ?>><?= $pr->name ?></option>
            <?php
        }
    }
    ?>
</select>                                                
<?php echo form_error('etype'); ?>
</div>
</div>
</div>

<div class="row">
    <div class="col-md-12">
        <label>Gallery Images</label>
    </div>
</div>

<div class="row">
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
    <button type="submit" class="btn btn-primary" onclick="return validatethis();">Submit</button>

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
<link href="<?= base_url($theme_path . 'plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<script src="<?= base_url($theme_path . 'plugins/geocomplete/jquery.geocomplete.min.js') ?>"></script>
<script src="<?= base_url($theme_path . 'plugins/select2/select2.full.min.js') ?>"></script>
<?php
if ($this->session->flashdata('message')) {
    ?>
    <script>
        $(window).load(function () {
            swal({
                title: "",
                text: "<?= $this->session->flashdata('message') ?>",
                type: "success",
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
        $(".select2").select2();
    })
    var geocoder = new google.maps.Geocoder();
    var map;
    var options = {
        map: "#map_canvas",
        mapOptions: {
            zoom: 14
        }, location: [<?= $centre->lattitude ?>,<?= $centre->logitude ?>],
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

</script>

<script type="text/javascript">
    //    window.files=[];
    var base = '<?= base_url() ?>';
    $("#dropzone").dropzone({
        url: "../uploadfiles",
        maxFilesize: 500,
        acceptedFiles: 'image/*',
        accept: function(file, done) {
          file.acceptDimensions = done;
          file.rejectDimensions = function() {
              done('The image must be at least 1024 X 428 Size');
          };
      },
      init: function () {

        var thisDropzone = this;
        var id = '<?= $centre_id ?>';
        var path = '<?= site_url() ?>' + "/centre/get_item_images/" + id
            $.getJSON(path, function (data) { // get the json response
                $.each(data, function (key, value) { //loop through it                    
                    var mockFile = {name: value.name, size: value.size, customid: value.path, image_id: value.image_id};
                    thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                    if (value.attachment_type == 1) {

                    } else {
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.path);//uploadsfolder is the folder where you have all those uploaded files
                    }
                    thisDropzone.emit("complete", mockFile);
                    thisDropzone.files.push(mockFile);
                });

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
        success: function (result, xhr) {
            var obj = jQuery.parseJSON(xhr);
            result.customid = obj.path;
            if (obj.type == 0) {
                $("#hiddenimages").append('<input type="hidden" name="centerimages[]" value="' + obj.path + '">');
            } else {
                $("#hiddenimages").append('<input type="hidden" name="centerimages[]" value="' + obj.path + '">');
            }
        },
        addRemoveLinks: true,
        removedfile: function (file) {
            var path = file.customid;
            var res = path.replace(base, '');
            $.ajax({
                type: 'POST',
                url: "../deletefiles",
                data: {path: res},
                success: function (data) {
                    $("#hiddenimages input[value='" + path + "']").remove();
                }
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        }
    });

$(function () {
});
</script>