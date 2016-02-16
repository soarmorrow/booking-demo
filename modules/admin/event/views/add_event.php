<style type="text/css">
    .select2 {
        /*margin-top: -3px !important;*/
    }
    .removeaccomodation{
        cursor: pointer;
    }
</style>
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>

<link href="<?= base_url($theme_path . 'plugins/select2/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Add New Event
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Event</a></li>
        <li class="active">New event</li>
    </ol>
</section>

<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box  box-success">
                    <form name="createevent" method="post" action="" id="createuser" enctype="multipart/form-data">
                        <div class="box-header">
                            <!--<h3 class="box-title">Condensed Full Width Table</h3>-->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="map_canvas" style="height: 200px;">


                                    </div>
                                    <input id="map" class="form-control" name="address" placeholder="Enter location" value="<?= set_value('address'); ?>">
                                </div>
                            </div>
                            <div class="row">


                                <?php
                                if (_is("GR Admin")) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group <?php
                                        if (form_error('center_id') != '')
                                            echo 'has-error';
                                        else
                                            echo '';
                                        ?>">
                                            <label class="h5">Centers</label>
                                            <select name="center_id" class="form-control" required id="center_id">
                                                <option value="">Select RC</option>
                                                <?php
                                                if (isset($centers)) {
                                                    foreach ($centers as $center) {
                                                        ?>
                                                        <option value="<?= $center->id ?>" <?php if (set_value('center_id') == $center->id) echo 'selected'; ?> data-long="<?= $center->logitude ?>" data-lat="<?= $center->lattitude ?>"><?= $center->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>                                                
                                            <?php echo form_error('center_id'); ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="col-md-6">
                                    <div class="form-group <?php
                                    if (form_error('ename') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">Event Name</label>
                                        <input type="text" name="ename" placeholder="Event Name" required class="form-control" value="<?= set_value('ename'); ?>"/>
                                        <?php echo form_error('ename'); ?>
                                    </div>
                                </div>
                                <div class="clearfix"> </div>

                                <div class="col-md-6">
                                    <div class="form-group <?php
                                    if (form_error('startdate') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">Start Date</label>
                                        <input type="text" name="startdate" placeholder="Start Date" required class="form-control startdate" value="<?= set_value('startdate'); ?>"/>
                                        <?php echo form_error('startdate'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group <?php
                                    if (form_error('enddate') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">End Date</label>
                                        <input type="text" name="enddate" placeholder="End Date" required class="form-control enddate" value="<?= set_value('enddate'); ?>"/>
                                        <?php echo form_error('enddate'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group <?php
                                        if (form_error('starttime') != '')
                                            echo 'has-error';
                                        else
                                            echo '';
                                        ?>">
                                            <label class="h5">Start Time</label>
                                            <input type="text" name="starttime" placeholder="Start Time" required class="form-control starttime" value="<?= set_value('starttime'); ?>"/>
                                            <?php echo form_error('starttime'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group <?php
                                        if (form_error('endtime') != '')
                                            echo 'has-error';
                                        else
                                            echo '';
                                        ?>">
                                            <label class="h5">End Time</label>
                                            <input type="text" name="endtime"  placeholder="End Time" required class="form-control endtime" value="<?= set_value('endtime'); ?>"/>
                                            <?php echo form_error('endtime'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6" style="height: 160px;">
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
                                </div>

                                <div class="col-md-6">
                                    <div class="hidden form-group <?php
                                    if (form_error('latitude') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">Latitude</label>
                                        <input type="text" data-geo="lat" name="latitude" placeholder="Latitude" required class="form-control" value="<?= $lat; ?>"/>
                                        <?php echo form_error('latitude'); ?>
                                    </div>
                                    <div class="hidden form-group <?php
                                    if (form_error('longitude') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">Longitude</label>
                                        <input type="text" data-geo="lng" name="longitude" placeholder="Longitude" required class="form-control" value="<?= $long; ?>"/>
                                        <?php echo form_error('longitude'); ?>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group <?php
                                    if (form_error('total_seats') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">Total seats</label>
                                        <input type="text" name="total_seats" placeholder="Total seats" required class="form-control" value="<?= set_value('total_seats'); ?>"/>
                                        <?php echo form_error('total_seats'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group <?php
                                    if (form_error('etype') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">Event Type</label>
                                        <select name="etype" class="form-control" required>
                                            <option value="">select type</option>
                                            <?php
                                            if (isset($eventtypes)) {
                                                foreach ($eventtypes as $type) {
                                                    ?>
                                                    <option value="<?= $type->id ?>" <?php if (set_value('etype') == $type->id) echo 'selected'; ?>><?= $type->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>                                                
                                        <?php echo form_error('etype'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">

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
                                <!--<div class="clearfix"></div>-->
                                <div class="col-md-6">
                                    <div class="form-group <?php
                                    if (form_error('country') != '')
                                        echo 'has-error';
                                    else
                                        echo '';
                                    ?>">
                                        <label class="h5">Select Currency</label>
                                        <div class="form-control" style="padding: 0;border: 0;">
                                            <select style="width: 100%" class="select2" name="country">
                                                <?php
                                                foreach ($country as $type) {
                                                    ?>
                                                    <option value="<?= $type->id_countries ?>" <?php if (set_value('country') == $type->id_countries) echo 'selected'; ?>><?= $type->name ?>(<?= $type->currency_code ?>)</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="form-group <?php
                                if (form_error('accomodationtypelist') != '')
                                    echo 'has-error';
                                else
                                    echo '';
                                ?>" id="eventPricing">
                                     <?php
                                     if (!empty($accomodation)) {
                                         $j = 0;
                                         foreach ($accomodation['type'] AS $acctype) {
                                             ?>
                                            <div class="col-md-12 no-padding accomodationRow">
                                                <div class="col-md-6">
                                                    <label class="h5">Select Accomodation Type</label>
                                                    <div class="form-control" style="padding: 0;border: 0;">
                                                        <select style="width: 100%" class="select2" name="accomodation[type][]">
                                                            <?php
                                                            foreach ($accommodation as $type) {
                                                                ?>
                                                                <option value="<?= $type->id ?>" <?= ($type->id == $acctype) ? 'selected' : '' ?>><?= $type->accomodation_type ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col-md-2">
                                                    <label class="h5">Adult Rate</label>
                                                    <div class="form-control" style="padding: 0;border: 0;">
                                                        <input type="text" name="accomodation[rate][]" placeholder="Rate" required class="form-control" value="<?= $accomodation['rate'][$j] ?>"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label class="h5">Child Rate</label>
                                                    <div class="form-control" style="padding: 0;border: 0;">
                                                        <input type="text" name="accomodation[child][]" placeholder="Child Rate" required class="form-control" value="<?= $accomodation['child'][$j] ?>"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label class="h5">Seats Available</label>
                                                    <div class="form-control" style="padding: 0;border: 0;">
                                                        <input type="text" name="accomodation[seats][]" placeholder="Seats available" required class="form-control" value="<?= $accomodation['seats'][$j] ?>"/>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($j != 0) {
                                                    ?>
                                                    <div class="col-md-12 text-right" style="position: absolute">
                                                        <i class="fa fa-remove removeaccomodation"></i>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                            </div>
                                            <?php
                                            $j++;
                                        }
                                    } else {
                                        ?>
                                        <div class="col-md-12 no-padding accomodationRow">
                                            <div class="col-md-6">
                                                <label class="h5">Select Accomodation Type</label>
                                                <div class="form-control" style="padding: 0;border: 0;">
                                                    <select style="width: 100%" class="select2" name="accomodation[type][]">
                                                        <?php
                                                        foreach ($accommodation as $type) {
                                                            ?>
                                                            <option value="<?= $type->id ?>" ><?= $type->accomodation_type ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-md-2">
                                                <label class="h5">Adult Rate</label>
                                                <div class="form-control" style="padding: 0;border: 0;">
                                                    <input type="text" name="accomodation[rate][]" placeholder="Rate" required class="form-control" />
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="h5">Child Rate</label>
                                                <div class="form-control" style="padding: 0;border: 0;">
                                                    <input type="text" name="accomodation[child][]" placeholder="Child Rate" required class="form-control" />
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="h5">Seats Available</label>
                                                <div class="form-control" style="padding: 0;border: 0;">
                                                    <input type="text" name="accomodation[seats][]" placeholder="Seats available" required class="form-control" />
                                                </div>
                                            </div>


                                        </div>
                                            <?php
                                        }
                                        echo '<div class="col-md-12">';
                                        echo form_error('accomodationtypelist');
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <span id="addMoreAccommodation" style="padding: 2px;cursor: pointer" class="btn btn-link" role="link">
                                        <i class="fa fa-plus"></i>Add more accommodation
                                    </span>
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="h5">Add Event Image</label>
                                        <div class="">
                                            <div class="form-group">
                                                <div id="imagePreview"></div>
                                            </div>
                                        </div>
                                        <label for="uploadFile" class="btn btn-default">Upload</label>
                                        <input type="file" name="logo" id="uploadFile" class="hidden" accept="image/*"/>
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
                            <button type="submit" id="submit2" class="btn btn-primary">Submit</button>

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
<script src="<?php base_url($theme_path . 'plugins/geocomplete/jquery.geocomplete.min.js') ?>"></script>

<script src="<?= base_url($theme_path . 'plugins/select2/select2.full.min.js') ?>" type="text/javascript"></script>
<?php
if ($this->session->flashdata('message')) {
    ?>
    <script>
        $(window).load(function () {
            console.log("<?= $this->session->flashdata('message') ?>")
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
    $('#center_id').change(function () {
        //        var lat_and_long = $(this).children('option:selected').data('lat').toString()+","+$(this).children('option:selected').data('long').toString();
        //        $("#map").geocomplete("find", lat_and_long);
        //alert(lat_and_long);
    });
    var geocoder = new google.maps.Geocoder();
    var map;
    var options = {
        map: "#map_canvas",
        location: [<?= $lat ?>,<?= $long ?>],
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
    $(".startdate,.enddate").datepicker({format: 'dd M yyyy', autoclose: true});
    $(".starttime,.endtime").timepicker({
        showInputs: false
    });
    $(document).ready(function () {
        $(document).on("click", ".removeaccomodation", function () {
//            $(this).parent().parent().remove();
//console.log()
            $(this).closest('.accomodationRow').remove();
        });

        $("#addMoreAccommodation").click(function () {
            $("#eventPricing").append('<div class="col-md-12 no-padding accomodationRow"> <div class="clearfix"></div><div class="col-md-6">' +
                    '<label class="h5">Select Accomodation Type</label>' +
                    '<div class="form-control" style="padding: 0;border: 0;margin-top: 3px;">' +
                    '<select style="width: 100%" class="select2" name="accomodation[type][]">' +
<?php
foreach ($accommodation as $type) {
    ?>
                '<option value="<?= $type->id ?>"><?= $type->accomodation_type ?></option>' +
    <?php
}
?>
            '</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    '<label class="h5">Adult Rate</label>' +
                    '<div class="form-control" style="padding: 0;border: 0;">' +
                    '<input type="text" name="accomodation[rate][]" placeholder="Rate" required class="form-control" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    '<label class="h5">Child Rate</label>' +
                    '<div class="form-control" style="padding: 0;border: 0;">' +
                    '<input type="text" name="accomodation[child][]" placeholder="Child Rate" required class="form-control" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    '<label class="h5">Seats Available</label>' +
                    '<div class="form-control" style="padding: 0;border: 0;">' +
                    '<input type="text" name="accomodation[seats][]" placeholder="Seats available" required class="form-control" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-12 text-right" style="position: absolute">' +
                    '<i class="fa fa-remove removeaccomodation"></i>' +
                    '</div></div>'
                    );
                    $(".select2").select2();
        });
    });
</script>
<script type="text/javascript">

    $("#dropzone").dropzone({
        url: "uploadfiles",
        maxFilesize: 500,
        acceptedFiles: 'image/*',
        accept: function (file, done) {
            file.acceptDimensions = done;
            file.rejectDimensions = function () {
                done('The image must be at least 1024 X 428 Size');
            };
        },
        success: function (result, xhr) {
            var obj = jQuery.parseJSON(xhr);
            result.customid = obj.path;
            if (obj.type == 0) {
                $("#hiddenimages").append('<input type="hidden" name="eventimages[]" value="' + obj.path + '">');
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
            this.on('success', function (file, resp) {
                console.log(file);
                console.log(resp);
            });
            this.on('thumbnail', function (file) {
                if (file.width < 1024 || file.height < 425) {
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