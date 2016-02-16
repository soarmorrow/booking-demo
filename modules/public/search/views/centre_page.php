<style type="text/css">
    .filter-white .col-xs-1, .filter-white .col-sm-1, .filter-white .col-md-1, .filter-white .col-lg-1, .filter-white .col-xs-2, .filter-white .col-sm-2, .filter-white .col-md-2, .filter-white .col-lg-2, .filter-white .col-xs-4, .filter-white .col-sm-4, .filter-white .col-md-4, .filter-white .col-lg-4, .filter-white .col-xs-5, .filter-white .col-sm-5, .filter-white .col-md-5, .filter-white .col-lg-5, .filter-white .col-xs-6, .filter-white .col-sm-6, .filter-white .col-md-6, .filter-white .col-lg-6, .filter-white .col-xs-7, .filter-white .col-sm-7, .filter-white .col-md-7, .filter-white .col-lg-7, .filter-white .col-xs-8, .filter-white .col-sm-8, .filter-white .col-md-8, .filter-white .col-lg-8, .filter-white .col-xs-9, .filter-white .col-sm-9, .filter-white .col-md-9, .filter-white .col-lg-9, .filter-white .col-xs-10, .filter-white .col-sm-10, .filter-white .col-md-10, .filter-white .col-lg-10, .filter-white .col-xs-11, .filter-white .col-sm-11, .filter-white .col-md-11, .filter-white .col-lg-11, .filter-white .col-xs-12, .filter-white .col-sm-12, .filter-white .col-md-12, .filter-white .col-lg-12 {
        padding-right: 3px;
        padding-left: 1px;
    }
    .rating span{
        width: 0.8em !important;
        cursor: pointer;
    }
    .active a{
        color: #09f !important;
    }
    .centerDetails li a{
        color: #333;
    }
    .popular-centres .card-header {
        bottom: 0px;
        top:auto;
        padding: 0px 5px;
    }
    .img-thumbnail{
        padding: 0px!important;
    }
    .card{
        margin-bottom: 0 !important;
    }
    .card a, .card a:hover, .card a:focus {
        color: #F3F8F7;
    }
    .table tr td{
        border-top: 0 !important;
        border-bottom: 1px solid #ddd;
    }
    .rating{
        font-size: 40px !important;
    }
    .rating > span:hover:before,
    .rating > span:hover ~ span:before{
        font-size: 40px;
    }
    .nomatch {
        background-color: #fff;
        text-align: center;
        padding: 50px 0 50px 0;
        border-radius: 5px;
        margin-top: 5px;
    }
</style>

<div class="example-modal">
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2>Your Testimonial</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="itemid" class="">                   
                        <input type="hidden" value="0" class="ratevalue"> 

                        <textarea id="review" rows="5" placeholder="<?= $user_id == 0 ? 'Login to continue' : ' Testimonial for this event' ?>" class="form-control" style=" border: 1px solid #ccc;"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>

                        <button type="button"class="btn btn-info" id="update_type" style="margin-right:5px;">Submit</button>
                    </div><br>
                    <?php
                    if (!empty($reviews)) {
                        ?>
                        <div class="col-xs-12 col-md-12" style="height:200px;overflow-x:hidden;overflow-y:auto">
                            <?php
                            foreach ($reviews as $value) {
                                ?>
                                <div class="row">
                                    <img src="<?= base_url($value->avatar) ?>" width="50px" height="50px" style="float:left">
                                    <p style="padding-left:60px;width: 500px;word-wrap: break-word;"><strong><?= ucwords(strtolower($value->first_name)) . ' ' . ucwords(strtolower($value->last_name)) ?>&nbsp;&nbsp;&nbsp;&nbsp;</strong><br>
                                        <?= date('d M Y', strtotime($value->created_at)) ?><br>
                                        <?= $value->comment ?></p>

                                </div>
                                <hr>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="clearfix"></div><br>
                </div>




            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div><!-- /.example-modal -->

<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="go-slider">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="row">
                        <?php
                        $status = true;
                        foreach ($rc_images as $value) {
                            $exists = remoteFileExists(base_url($value->path));
                            if ($exists) {
                                $status = false;
                            }
                        }
                        $i = 0;
                        if ($status) {
                            echo '<div style="height:100px;"></div>';
                        }
                        ?>
                        <div class="carousel-inner img-thumbnail" role="listbox">
                            <!-- First slide -->
                            <?php
                            foreach ($rc_images as $value) {
                                $exists = remoteFileExists(base_url($value->path));
                                if ($exists) {
                                    ?>

                                    <div class="item <?= ($i == 0) ? 'active' : '' ?>">
                                        <img src="<?= base_url($value->path) ?>" alt="" class="img-responsive" />
                                        <div class="carousel-caption">

                                        </div>
                                    </div>
                                    <!-- /.item -->
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                            <section class="filter-white">

                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group col-md-6 col-xs-12 col-sm-6">
                                        <h4 class="centre-info"><?= $centre->name ?></h4>
                                        <h5><?= $centre->street_address1 . ', ' . $centre->street_address2 . ', ' . $centre->city ?></h5><br>
                                    </div>
                                    <div class="col-md-1 col-sm-2 col-xs-4">


                                        <a href="#" class="like"><i class="fa head-blue  <?= (empty($liked)) ? "fa-heart-o" : "fa-heart" ?>" style="padding-top:15px;">&nbsp;<span id="likes"><?= $likes ?></span></i></a>
                                    </div>
                                    <div class="col-md-1 col-sm-2 col-xs-4">
                                        <span class=" fa head-blue" style="padding-top:15px;">
                                            <i class="fa fa-check-circle-o head-red">  </i>
                                            verified
                                        </span>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-4 text-center">
                                        <a href="#"><i class="fa fa fa-pencil-square-o head-blue review" style="padding-top:15px;">
                                                <span class="small" id="reviews"><?= $review_count ?></span>Testimonial
                                            </i></a>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="rate">
                                            <span class="<?= (round($rate->average) == 5) ? "active" : '' ?>">☆</span>
                                            <span class="<?= (round($rate->average) == 4) ? "active" : '' ?>">☆</span>
                                            <span class="<?= (round($rate->average) == 3) ? "active" : '' ?>">☆</span>
                                            <span class="<?= (round($rate->average) == 2) ? "active" : '' ?>">☆</span>
                                            <span class="<?= (round($rate->average) == 1) ? "active" : '' ?>">☆</span>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- /.item -->
                        </div>
                    </div>
                    <!-- /.carousel-inner -->
                </div>
                <!-- /.carousel -->
            </section>
        </div>
    </div>
</div><br>
<!--./ Slider-->

<div class="container nopadding">
    <div class="row">

        <div class="col-md-12 back-non nopadding">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12 widget-item pull-left box-round" style="background-color: white;">
                    <label class="head-blue text-centre">Type of Retreat Available</label>
                    <table class=" table table-responsive">
                        <?php
                        foreach ($types as $type) {
                            ?>
                            <tr>
                                <td><?= $type->name ?></td><td><input class="option pull-right" data-choice="<?= $type->name ?>" value="<?= $type->id ?>" type="radio" name="type"/></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>   
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-left widget-item box-round" style="background-color: white;">
                    <label class="head-blue text-centre">Preferred Month</label>
                    <table class=" table table-responsive">
                        <?php
                        foreach ($dates as $date) {
                            ?>  
                            <tr>
                                <td><?= $date->month ?>&nbsp;<?= $date->year ?></td><td><input class="option pull-right" data-date="<?= $date->month ?>&nbsp;&nbsp;<?= $date->year ?>" name="month" value="<?= $date->month ?>" type="radio"/></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>   
                </div> 
                <!-- <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="center-block">
                                    <a href="#!/showmore" class="show-more">Show More <img src="<?= base_url('themes/user/resources/assets/images/show_more.png') ?>" /></a><br />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                -->
            </div>   
            <!--./side blue End-->
            <div class="col-md-7 col-sm-9 col-xs-12 back-non nopadding">
                <span id="eventslist">
                    <?php
                    $i = 0;
                    foreach ($events as $event) {
                        // if($event->start_date )
                        ?>    

                        <div class="col-md-12 col-sm-12 nopadding" style="background-color: white;margin-bottom:5px;margin-top:5px;">
                            <div class="col-sm-3 col-md-3 nopadding">
                                <div class="card">
                                    <!-- <div class="card-height-indicator"></div> -->
                                    <div class="card-content">
                                        <div class="card-image">
                                            <img src="<?= base_url($event->image) ?>" alt="Loading image..." style="height:185px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9 col-md-9" style="padding-top:15px;">
                                <h4 class="centre-info"><?= $event->name ?></h4>
                                <h5>All are welcome</h5>
                                <div class="clearfix"></div>
                                <input class="btn btn-default" style="background-color:#999999;color:#fff;" type="button" value="<?= date('d', strtotime($event->start_date)) ?>  <?= (date('M', strtotime($event->start_date)) != date('M', strtotime($event->end_date))) ? date('M', strtotime($event->start_date)) : '' ?>&nbsp;<?= (date('Y', strtotime($event->start_date)) != date('Y', strtotime($event->end_date))) ? date('Y', strtotime($event->start_date)) : '' ?>&nbsp;-&nbsp;<?= date('d', strtotime($event->end_date)) ?>&nbsp;<?= date('M', strtotime($event->end_date)) ?>&nbsp;<?= date('Y', strtotime($event->end_date)) ?> " />
                                <div class="clearfix"></div>
                                <div class="col-sm-12 col-md-12 nopadding">
                                    <p class="col-sm-8 col-md-8 nopadding blue"><?= substr($event->description, 0, 80) ?>...</p>
                                    <a href="<?= site_url('event_public/single_event') ?>/<?= $event->id ?>" class="col-sm-3 col-md-3"><input class="btn btn-primary" type="button" value="view event" style="background-color:#106fa4;padding:5px 15px;"/></a>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                    ?>
                
            </span>
            <?php
            if ($i > 0) {
                ?>
                <div class="row">
                    <div class="col-md-10 col-sm-12 col-xs-12 col-md-offset-1">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if ($i >= 3) {
                                    ?>
                                    <div class="center-block eventslistshowmore">
                                        <a href="#!/showmore" data-url="<?= site_url('search/getMoreEvents') ?>/<?= $id ?>" data-target="eventslist" data-page="1"  class="loadmore show-more">Show More<img src="<?= base_url('themes/user/resources/assets/images/show_more.png') ?>"></a><br />
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>   
                <?php
            } else {
                echo '<div class="col-md-12 col-sm-12 col-xs-12 back-non nopadding nomatch"><h3>No Events Scheduled</h3></div>';
            }
            ?>
        </div>

            <!--.side blue-->
            <div class="col-md-2 col-sm-12 col-xs-12 back-non pull-right">                
                <div class="raw">
                    <div class="col-sm-12 col-md-12 col-xs-12 widget-yellow" style="height: 550px; margin-top:8px;">                       
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>


<!--./Header End-->
<div class="container" style="border-top:2px solid #CCC">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 back-non">

            <?php
            if (!empty($preachers)) {
                ?>
                <h3 class=" text-center title pull-left" style="margin-top:0px !important">Preachers and Guides</h3>
                <?php
            }
            ?>
            <div class="col-md-10 col-sm-12 col-xs-12" >
                <div class="row">
                    <span id="preacherslist" class="popular-centres">

                        <?php
                        $j = 1;
                        foreach ($preachers as $preacher) {
                            ?>
                            <div class="col-sm-3 col-md-3">
                                <div class="card">
                                    <!-- <div class="card-height-indicator"></div> -->
                                    <div class="card-content">
                                        <div class="card-header">

                                            <h2 class="card-image-headline"><a href="<?= site_url('preachers/preachers_profile') ?>/<?= $preacher->id ?>"> <?= $preacher->name ?></a></h2>
                                        </div>
                                        <div class="card-image">
                                            <img style="min-height:200px; height:200px;" src="<?= base_url($preacher->image) ?>" alt="Loading image...">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                            $j++;
                        }
                        ?>


                    </span>
                </div>
                <div class="row">

                    <?php
                    if (!empty($preachers)) {
                        if ($j > 3) {
                            ?>
                            <div class="col-md-12">
                                <div class="center-block">
                                    <a href="#!/showmore" data-url="<?= site_url('search/getMorePreachers') ?>/<?= $id ?>" data-target="preacherslist" data-page="1"  class="loadmore show-more">Show More<img src="<?= base_url('themes/user/resources/assets/images/show_more.png') ?>"></a><br />
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>

                <article class="col-md-12 col-sm-12 col-xs-12 maincontent box-round nopadding">
                    <iframe  src="https://www.google.com/maps?q=<?= $centre->lattitude ?>,<?= $centre->logitude ?>&z=12&output=embed" width="100%" height="400px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" ></iframe>     
                </article><br>
                <div class="col-xs-12 col-md-12 widget-item" style="background-color:white; padding:30px 10px 10px 10px; margin-bottom:20px;border-radius:5px;">
                    <div class="col-md-3 col-sm-4">
                        <ul class="nav left-side-menu tab centerDetails">
                            <li class="active"><a href="#about" id="1" data-toggle="tab">About the Centre</a></li>
                            <li class=""><a href="#management" id="2" data-toggle="tab">Management</a></li>
                            <li class=""><a href="#facilities" id="3" data-toggle="tab">Facilities</a></li>
                            <li class=""><a href="#contact" id="4" data-toggle="tab">Contact us</a></li>
                        </ul>
                        <!-- Divin Retreate Centre<br>
                        <div class="centre-info" style="margin-border-bottom:0px; !important">Divin Retreate Centre</div>
                        Divin Retreate Centre<br>
                        Divin Retreate Centre<br> -->
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="about">
                            <h4 class="blue">About the Centre</h4><br>
                            <p class='justify'><?= $centre->description ?>
                            </p>       
                        </div>
                        <div class="tab-pane" id="management">
                            <h4 class="blue">Management</h4><br>
                            <p class='justify'><?= $centre->description ?>
                            </p>       
                        </div>
                        <div class="tab-pane" id="facilities">
                            <h4 class="blue">Facilities</h4><br>
                            <p class='justify'><?= $centre->description ?>
                            </p>       
                        </div>
                        <div class="tab-pane" id="contact">
                            <h4 class="blue">Contact</h4><br>
                            <p class='justify'><?= $centre->street_address1 ?></p>
                            <p class='justify'><?= $centre->street_address2 ?></p>
                            <p class='justify'><?= $centre->city ?></p>
                            <p class='justify'><?= $centre->state ?></p>  
                            <p class='justify'><?= $centre->country ?></p>          
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12 right-blue-side-bar" style="margin-top:0px"></div>


            <!--./side blue End-->

        </div>
    </div>
</div>
</div>

<script>

    // $(document).ready(function() {
    //     $(".filter").sticky({topSpacing: 63,className:"sticky-filter"});
    // });
    $(document).ready(function () {
        $.getJSON("<?= site_url('rating/get_counts/' . $id) ?>", function (data) {
            rates.update(data);
        });
        $(".review").click(function () {
            $('#editModal #itemid').val($(this).data('id'));
            $('#editModal #review').val($(this).data('name'));
            $("#editModal").modal('show');
        });
        $('#editModal').on('hidden.bs.modal', function (e) {
            $('#editModal #itemid').val("");
            $('#editModal #review').val("");

        });
        $("#update_type").click(function () {
            var id = $('#editModal #itemid').val();
            var review = $('#editModal #review').val();

            var rate = $('.ratevalue').val();
            // $.post("<?= site_url('rating/rate_event/' . $id) ?>", {'rate':rate}, function(result){
            //     swal({title:"",text:"Rating marked", type:'success',timer:2000});
            // });

            $.ajax({
                url: "<?= site_url('search/review') ?>/<?= $id ?>",
                                method: "post",
                                data: {"id": id, "review": review, "rate": rate},
                                success: function (result) {
                                    result = JSON.parse(result);
                                    $("#editModal").modal('hide');
                                    if (result.code == 200) {
                                        swal({
                                            title: "Success",
                                            text: "Review Updated Successfully",
                                            type: "success",
                                            timer: 3000,
                                            animation: false,
                                            showConfirmButton: false
                                        });
                                        window.location.reload();
                                    } else if (result.code == 300) {
                                        swal("Oops!", result.message, "error");
                                    } else {
                                        swal("Oops!", result.message, "error");
                                    }
                                    $.getJSON("<?= site_url('rating/get_counts/' . $id) ?>", function (data) {
                                        $('.ratevalue').val(data);
                                        rates.clear();
                                        rates.update(parseInt(data));
                                    });

                                    $.getJSON("<?= site_url('search/get_counts/' . $id) ?>", function (data) {
                                        $('span#reviews').text(data);
                                    });
                                }, error: function () {
                                    swal("Oops!", "Failed to Comment", "error");
                                }
                            });
                        });
                        var rates = {
                            update: function (current_rate) {
                                for (var i = 1; i <= current_rate; i++) {
                                    $("span[data-value='" + i + "']").css('color', '#f90').html("&starf;");
                                }
                            },
                            clear: function () {
                                for (var i = 1; i <= 5; i++) {
                                    $("span[data-value='" + i + "']").css('color', '#00415d').html("&star;");
                                }
                            }
                        }
<?php
if (!empty($current_rating)) {
    ?>
                            rates.update(<?= $current_rating->rating ?>);
    <?php
}
?>
                        $('.rating span').on('click', function () {
                            var rate = $(this).data('value');
                            $('.ratevalue').val(rate);
                            rates.update(parseInt(rate));
                            rates.clear();
                            // rates.update(parseInt(rate));
                            // var rate=$('.ratevalue').val();
                            // $.post("<?= site_url('rating/rate_event/' . $id) ?>", {'rate':rate}, function(result){
                            //     swal({title:"",text:"Rating marked", type:'success',timer:2000});
                            // });
                        });
                        $('.rating').hover(function () {
                            rates.clear();
                        }, function () {
                            getDefaultCount();
                        });
// function getReviewCount(){
//     $.getJSON("<?= site_url('event_public/get_counts/' . $id) ?>",function(data){
//         $('#reviews').find('span').text(data);
//     });
// }

                        function getDefaultCount() {
                            $.getJSON("<?= site_url('rating/get_counts/' . $id) ?>", function (data) {
                                var rate = $('.ratevalue').val();
                                rates.update(rate);
                            });
                        }


                        $('.like').on('click', function (evt) {
                            evt.preventDefault();
                            var url = "<?= site_url('search/like') ?>/<?= $id ?>";
                                        var that = $(this);

                                        $.ajax({
                                            url: url,
                                            type: 'GET',
                                            success: function (data) {
                                                data = JSON.parse(data);
                                                if (data.code == 200) {
                                                    swal("Success", data.message, "success");
                                                    // update the like count on view page

                                                    // get current like count
                                                    var likes = that.find('span').text();
                                                    likes = parseInt(likes) + 1; // add likes
                                                    that.find('#likes').text(likes); // place like to the span inside clicked anchor tag
                                                    $(".like i").removeClass('fa-heart-o').addClass('fa-heart');
                                                    // that.removeClass('fa-heart-o');
                                                } else {
                                                    swal("Oops!", data.message, "error");
                                                }
                                            },
                                            error: function (data) {
                                                console.log(data);
                                            }
                                        });

                                    });

//        var eventpage = 1, centerpage = 1;

                                    $('.loadmore').click(function (e) {
                                        e.preventDefault();
                                        var obj = $(this);
                                        var url = obj.data('url');
                                        var target = obj.data('target');
                                        var centerpage = parseInt(obj.data('page'));
                                        var type = $('input:radio[name=type]:checked').val();
                                        var month = $('input:radio[name=month]:checked').val();
                                        var postdata = {'type': type,
                                            'month': month
                                        };
                                        obj.children('img').attr('src', THEME_PATH + '/resources/assets/images/loading.gif');
                                        $.ajax({
                                            url: url + '/' + centerpage,
                                            type: 'POST',
                                            data: postdata,
                                            dataType: 'JSON',
                                            success: function (data) {
                                                if (data['status'] == false) {
                                                    obj.hide();
                                                } else {
                                                    centerpage++;
                                                    obj.data("page", centerpage);
                                                }
                                                $('#' + target).append(data['data']);
                                                obj.children('img').attr('src', THEME_PATH + '/resources/assets/images/show_more.png');

                                            }
                                        });
                                    });
                                    $('.option').on('change', function (e) {
                                        e.stopImmediatePropagation();
                                        e.stopPropagation();
                                        var type = '';
                                        var month = '';

                                        var choice_type = $('input:radio[name=type]:checked').data('choice');
                                        var date = $('input:radio[name=month]:checked').data('date');
                                        if ($('input:radio[name=type]:checked').val()) {
                                            type = $('input:radio[name=type]:checked').val();
                                        }
                                        if ($('input:radio[name=month]:checked').val()) {
                                            month = $('input:radio[name=month]:checked').val();
                                        }
                                        var postdata = {'type': type,
                                            'month': month
                                        };
                                        $.post("<?= site_url('search/getMoreEvents') ?>/<?= $id ?>", postdata, function (result) {
                                                        var resultdata = JSON.parse(result);
                                                        $("#eventslist").html(resultdata.data);
                                                        console.info(resultdata.status);
                                                        if (resultdata.status) {
                                                            $('.eventslistshowmore').show();
                                                        } else {
                                                            $('.eventslistshowmore').hide();
                                                        }
                                                        $(".search").html("Showing ");
                                                        if (choice_type) {
                                                            $(".search").append(choice_type);
                                                        }
                                                        $(".search").append(" retreats ");
                                                        if (date) {
                                                            $(".search").append("scheduled for " + date);
                                                        }
                                                    });
                                                });
                                            });

</script>


<!--./Header End-->