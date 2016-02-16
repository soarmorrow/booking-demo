<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>
<section class="content-header">
    <h1>
        View Bookings
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Bookings</a></li>
        <li class="active">View</li>
    </ol>
</section>
<?php
$event = $data['event'];
$orders = $data['order'];
?>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">                    
                    <div class="box-header">
                    </div><!-- /.box-header -->
                    <div class="box-body" style="padding-top: 0px">
                        <div id="map_canvas" style="height: 200px;">


                        </div>
                        <input id="map" class="form-control hidden" disabled value="<?= $event->address ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header">
                                <h3 style="margin-left: 10px"><?= $event->name ?></h3>   
                            </div>
                        </div><!-- /.box-header -->
                    </div>
                    <div class="row">
                        <div class="col-md-3" >
                            <div class="logo_wrapper">
                                <?php
                                if (!empty($event->image)) {
                                    $src = $event->image;
                                } else {
                                    $src = base_url($theme_path . 'images/dlogo.jpg');
                                }
                                ?>
                                <img src="<?= $src ?>" alt="">                                   
                            </div>

                        </div>
                        <div class="col-md-9">
                            <div class="box-body">

                                <div class="row">

                                    <div class="col-md-12">
                                        <table class="table table-striped">
                                            <tr>
                                                <td style="width: 200px;">Event Name</td>
                                                <td><?= $event->name ?></td>
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
                                                <td>Attendance Fee</td>
                                                <td><?= $event->currrency_symbol . $event->attendance_fee; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>  </div><!-- /.box-body -->
                        </div>
                    </div>

                </div><!-- /.box -->

                <div class="box  box-success">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="pull-left">Bookings</h4>

                                <div class="dropdown pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary">Download</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <!--<span class="sr-only">Toggle Dropdown</span>-->
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= site_url('booking/downloadbooking/' . $event_id.'?type=excel') ?>">Excel File</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class=" col-md-12 table-responsive">
                                    <table class="table table-striped" id="bookings">
                                        <thead>
                                            <tr>
                                                <th>Name</th> 
                                                <th>Email</th> 
                                                <th style="width:100px;">Count</th>
                                                <th>Gateway</th> 
                                                <th style="width: 100px">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($orders as $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $value->first_name . " " . $value->last_name ?></td>
                                                    <td><?= $value->email ?></td>
                                                    <td><?= $value->attend ?></td>
                                                    <td><?= $value->gateway_name ?></td>
                                                    <td><?= date(FORMAT_DATE, strtotime($value->timestamp)) ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>  </div><!-- /.box-body -->

                    <div class="box-footer"> 
                        <div class="col-md-12">
                            <!--<a href="<?= site_url('event/update/' . $event_id) ?>" class="btn btn-primary" onclick="">Edit</a>-->
                            <a onclick="history.go(-1);" class="btn-default btn">
                                Back
                            </a>
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
        margin: 10px auto;
        border-radius: 5px;
        overflow: hidden;
    }
    .logo_wrapper img{
        width: 100%; border-radius: 5px;
    }

</style>

<script src="<?= base_url($theme_path . 'plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>


<script>
                                $(window).load(function () {
                                    $("#bookings").dataTable({
                                        searching: false,
                                        paging: false
                                    });
                                });
</script>

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

</script>