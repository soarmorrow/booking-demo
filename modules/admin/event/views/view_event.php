<section class="content-header">
    <h1>
        View Event
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Event</a></li>
        <li class="active">View event</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box  box-success">                    
                    <div class="box-header">
                    </div><!-- /.box-header -->
                    <div class="box-body" style="padding-top: 0px">
                        <div id="map_canvas" style="height: 200px;">


                        </div>
                        <input id="map" class="form-control hidden" disabled value="<?= $event->address ?>">
                    </div>
                    <div class="box-header">
                        <h3 class="text-center"><?= $event->name ?>(<?=$views?>)</h3>                                  
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="logo_wrapper">
                                    <?php
                                    if (!empty($event->image)) {
                                        $src = base_url($event->image);
                                    } else {
                                        $src = base_url($theme_path . 'images/dlogo.jpg');
                                    }
                                    ?>
                                    <img src="<?= $src ?>" alt="">                                   
                                </div>

                            </div>
                            <div class="col-md-9">
                                <table class="table table-striped">
                                    <tr>
                                        <td style="min-width: 150px;">Event Name</td>
                                        <td><?= $event->name ?></td>
                                    </tr>
                                    <tr>
                                        <td>Event Type</td>
                                        <td><?= $event->event_type ?></td>
                                    </tr>
                                    <tr>
                                        <td>Event Location</td>
                                        <td><?= $event->address ?></td>
                                    </tr>

                                    <tr>
                                        <td>Start Date</td>
                                        <td><?= date(FORMAT_DATE, strtotime($event->start_date)) ?></td>
                                    </tr>

                                    <tr>
                                        <td>End date</td>
                                        <td><?= date(FORMAT_DATE, strtotime($event->end_date)) ?></td>
                                    </tr>

                                    <tr>
                                        <td>Timing</td>
                                        <td><?php
                                            if ($event->start_time != '') {
                                                echo $event->start_time . ' to ' . $event->end_time;
                                            } else {
                                                echo 'Not Disclosed';
                                            }
                                            ?></td>
                                        </tr>

                                        <tr>
                                            <td>Attendance Fee</td>
                                            <td><?= $event->currrency_symbol . $event->attendance_fee; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Total seats</td>
                                            <td><?= $event->total_seats; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Description</td>
                                            <td class="text-justify"><?= $event->description ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-12" id="thumbnails">
                                    <?php
                                    foreach ($images as $value) {
                                        echo '<a href="' . base_url($value->image) . '" rel="prettyPhoto[gallery2]"><img class="col-md-2 thumbnail"  src="' . base_url($value->image) . '" alt="" ></a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer"> 
                            <!--<div class="col-md-3"></div>-->
                            <div class="col-md-9">
                                <a onclick="history.go(-1);" class="btn-default btn">
                                    Back
                                </a>
                                <a href="<?= site_url('event/update/' . $event_id) ?>" class="btn btn-primary" onclick="">Edit</a>
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div><!-- /.col -->

            </div><!-- /.row -->

        </section>
    </section>
    <style>
        .logo_wrapper{
            height: 200px;
            width: 200px;
            border:1px solid #ddd;
            margin: 20px auto;
            border-radius: 5px;
            overflow: hidden;
        }
        .logo_wrapper img{
            width: 100%; border-radius: 5px;
        }
        .thumbnail{
            height: 130px;
            width: 180px;
        }

    </style>

    <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
    <script src="<?= base_url($theme_path . 'plugins/geocomplete/jquery.geocomplete.min.js') ?>"></script>
    <script>

        var geocoder = new google.maps.Geocoder();
        var map;
        var options = {
            map: "#map_canvas",
            mapOptions: {
                zoom: 8
            }, location: [<?= $event->lattitude ?>,<?= $event->longitude ?>],
            markerOptions: {
                draggable: false
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
<script>
    $(window).load(function () {
        $("#thumbnails:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000,social_tools: false});
        $("#thumbnails:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true,social_tools: false});
    });
    $(document).ready(function(){				
    });
</script>