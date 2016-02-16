
<?php echo $template['partials']['homeslider']; ?>
<!--Upcoming Events-->
<style>
    .col-centered{
        margin: 0 auto;
        display: inline-block;
    }
    @media (min-width:992px){                    
        .col-md-4.col-centered{
            width: 33%
        }
        .col-md-3.col-centered{
            width: 24.635%!important;
        }
    }

    @media (min-width:768px){                    
        .col-sm-4.col-centered{
            width: 33%
        }
        .col-sm-3.col-centered{
            width: 24.635%;
        }

    }   
    @media (min-width:498px) and (max-width:768px){                    
        .col-xs-10.col-centered{
            width: 46%
        }
    }
    .preachers_card{
        height: 300px;
    }
    .events_card{
        height: 380px;
    }
    .article_card{
        height: 320px;
    }
    @media (max-width: 767px){
        .events_card{
            height: auto;
        }
        .article_card{
            height: auto;
        }
        .preachers_card{
            height: auto;
        }
    }
    @media (min-width: 768px) and (max-width:1199px){
        .article_card{
            height: 345px;
        }
        .preachers_card{
            height: 320px;
        }
    }
    @media (max-width:497px){
        .preachers_card{
            height: auto;
        }
        .article_card{
            height: auto;
        }
    }


    .margin-top-25 {
        margin-top: 25px!important;
    }
    @media (max-width: 420px){
        .dtp{
            position: absolute;
            z-index: 999999999;
        }
    }

</style>
<section class="upcoming-events">
    <h3 class="text-center title">Upcoming Events</h3>
    <div class="container">
        <div class="row">

            <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-md-10 col-md-offset-1">

                <div class="row"  style="text-align: center"  id="eventlist">
                    <?php
                    foreach ($events as $value) {
                        ?>
                        <div class="col-sm-6 col-md-4 col-xs-12  col-centered padding-2"   style="text-align: left" >
                            <a href="<?= site_url('event_public/single_event') ?>/<?= $value->id ?>">
                                <div class="card events_card">
                                    <!-- <div class="card-height-indicator"></div> -->
                                    <div class="card-content">
                                        <div class="card-header">
                                            <h3 class="card-image-headline">
                                                <?php
                                                echo sub_str($value->name, 0, 25);
                                                if (strlen($value->name) > 25) {
                                                    echo '...';
                                                }
                                                ?>
                                            </h3>
                                        </div>
                                        <div class="card-image">
                                            <img src="<?= base_url(($value->image) ? $value->image : 'uploads/images/eventslider/14520608113861.png') ?>" alt="Loading image...">
                                        </div>
                                        <div class="card-body">
                                            <div class="centre-info">
                                                <h4>
                                                    <?php
                                                    echo sub_str($value->center_name, 0, 25);
                                                    if (strlen($value->center_name) > 25) {
                                                        echo '...';
                                                    }
                                                    ?></h4>
                                                <span>
                                                    <?php
                                                    $address = $value->street_address1 . ', ' . $value->state;
                                                    echo sub_str($address, 0, 30);
                                                    if (strlen($address) > 30) {
                                                        echo '...';
                                                    }
                                                    ?>
                                                </span>

                                            </div>
                                            <p><?=
                                                sub_str($value->description, 0, 80);
                                                if (strlen($value->description) > 80) {
                                                    echo '...';
                                                }
                                                ?></p>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row border-bottom">
                    <div class="col-md-12">
                        <div class="center-block">
                            <a href="<?= site_url('event_public') ?>" class="show-more show-all hide " >Show All <img src="<?= base_url($theme_path . 'resources/assets/images/show_more.png') ?>" /></a><br />
                            <a href="#!/showmore" data-url="<?= site_url('home/getMoreEvents') ?>" data-target="eventlist" data-page="1" class="loadmore show-more">Show More <img src="<?= base_url($theme_path . 'resources/assets/images/show_more.png') ?>" /></a><br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Popular centres-->
<section class="popular-centres">
    <h3 class="text-center title">Popular Retreat Centres</h3>
    <div class="container">
        <div class="row" >
            <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-md-10 col-md-offset-1">

                <div class="row" style="text-align: center" id="centerlist">
                    <?php
                    foreach ($centers as $value) {
                        ?>
                        <div class="col-sm-6 col-md-4 col-xs-12 col-centered padding-2"   style="text-align: left" >
                            <a href="<?= site_url('centre_public/events') ?>/<?= $value->id ?>">
                                <div class="card events_card" >
                                    <div class="card-content">
                                        <div class="card-header">
                                            <h3 class="card-image-headline"><?php
                                                echo sub_str($value->name, 0, 25);
                                                if (strlen($value->name) > 25) {
                                                    echo '...';
                                                }
                                                ?></h3>
                                        </div>
                                        <div class="card-image">
                                            <img src="<?= base_url(($value->logo) ? $value->logo : 'uploads/images/eventslider/14520608113861.png') ?>" alt="Loading image...">
                                        </div>
                                        <div class="card-body">
                                            <div class="centre-info">
                                                <h4><?php
                                                    echo sub_str($value->name, 0, 25);
                                                    if (strlen($value->name) > 25) {
                                                        echo '...';
                                                    }
                                                    ?></h4>
                                                <span><?php
                                                    $address = $value->street_address1 . ', ' . $value->state;
                                                    echo sub_str($address, 0, 20);
                                                    if (strlen($address) > 20) {
                                                        echo '...';
                                                    }
                                                    ?></span>
                                            </div>
                                            <p>
                                                <?php
                                                echo sub_str($value->description, 0, 130);
                                                if (strlen($value->description) > 130) {
                                                    echo '...';
                                                }
                                                ?>
                                            </p>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div> 

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row border-bottom">
                    <div class="col-md-12">
                        <div class="center-block">
                            <a href="<?= site_url('centre_public') ?>" class="show-more show-all hide " >Show All <img src="<?= base_url($theme_path . 'resources/assets/images/show_more.png') ?>" /></a><br />
                            <a href="#!/showmore" data-url="<?= site_url('home/getMoreCenters') ?>" data-target="centerlist" data-page="1" class="loadmore show-more">Show More <img src="<?= base_url($theme_path . 'resources/assets/images/show_more.png') ?>" /></a><br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--./ Popular centres-->


<!--Preachers and Guides-->
<section class="preatures">
    <h3 class="text-center title">Preachers and Guides</h3>
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1">

                <div class="row"  style="text-align: center" id="preacherlist">
                    <?php
                    foreach ($preachers as $value) {
                        ?>
                        <div class="col-sm-6 col-md-3 col-xs-12  col-centered padding-2"  style="text-align: left">
                            <div class="card preachers_card">
                                <!-- <div class="card-height-indicator"></div> -->
                                <div class="card-content">
                                    <div class="card-image">
                                        <img src="<?= base_url(($value->image) ? $value->image : 'uploads/images/eventslider/14520608113861.png') ?>" alt="Loading image...">
                                    </div>
                                    <div class="card-body">
                                        <div class="centre-info" style="margin-bottom: 5px;">
                                            <h4><a href="<?= site_url('preachers/preachers_profile') ?>/<?= $value->id ?>"> <?= $value->name ?></a></h4>
                                        </div>
                                        <p><?=
                                            closetags(sub_str($value->description, 0, 50));
                                            if (strlen($value->description) > 50) {
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
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="center-block">
                            <a href="<?= site_url('preachers') ?>" class="show-more show-all hide">Show All <img src="<?= base_url($theme_path . 'resources/assets/images/show_more.png') ?>" /></a><br />
                            <a href="#!/showmore" data-url="<?= site_url('home/getMorePreachers') ?>" data-target="preacherlist" data-page="1" class="loadmore show-more">Show More <img src="<?= base_url($theme_path . 'resources/assets/images/show_more.png') ?>" /></a><br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--./ Preachers and Guides-->
</section>
<!--./Upcoming events-->


<!--Articles-->
<section class="articles">
    <h3 class="text-center blue title margin-top-25">Reflections</h3><br />
    <div class="container">
        <div class="row">
            <div class=" col-xs-10 col-xs-offset-1 col-sm-10 col-md-10 col-md-offset-1">

                <div class="row"  style="text-align: center" id="articleslist">
                    <?php
                    foreach ($articles as $value) {
                        ?>
                        <div class="col-sm-6 col-md-3 col-xs-12  col-centered padding-2"  style="text-align: justify">
                            <div class="card article_card">
                                <!-- <div class="card-height-indicator"></div> -->
                                <div class="card-content">
                                    <div class="card-image">
                                        <img src="<?= base_url(($value->event_image) ? $value->event_image : 'uploads/images/eventslider/14520608113861.png') ?>" alt="Loading image..." >
                                    </div>
                                    <div class="card-body">
                                        <div class="centre-info">
                                            <a href="<?= site_url('blogs/view') ?>/<?= $value->id ?>"> <h4>
                                                    <?php
                                                    echo sub_str(strip_tags($value->title), 0, 15);
                                                    if (strlen($value->title) > 24) {
                                                        echo '...';
                                                    }
                                                    ?></h4></a>
<!--                                                    <h4>
                                                    <?php
                                                    echo sub_str(strip_tags($value->author), 0, 15);
                                                    if (strlen($value->author) > 24) {
                                                        echo '...';
                                                    }
                                                    ?></h4>-->
                                        </div>
                                        <p><?=
                                            sub_str(strip_tags($value->content), 0, 50);
                                            if (strlen(strip_tags($value->content)) > 50) {
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
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="center-block">
                            <a href="<?= site_url('blogs') ?>" class="show-more show-all hide">Show All <img src="<?= base_url($theme_path . 'resources/assets/images/show_more.png') ?>" /></a><br />
                            <a href="#!/showmore" data-url="<?= site_url('home/getMoreArticles') ?>" data-target="articleslist" data-page="1" class="loadmore show-more">Show More <img src="<?= base_url($theme_path . 'resources/assets/images/show_more.png') ?>" /></a><br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $(".filter").sticky({topSpacing: 63, className: "sticky-filter"});
    });
    $(document).ready(function () {
//        var eventpage = 1, centerpage = 1;

        $('.loadmore').click(function (e) {
            e.preventDefault();
            var obj = $(this);
            var url = obj.data('url');
            var target = obj.data('target');
            var centerpage = parseInt(obj.data('page'));
            obj.children('img').attr('src', THEME_PATH + '/resources/assets/images/loading.gif');
            $.ajax({
                url: url + '/' + centerpage,
                type: 'POST',
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
                    $(obj).addClass('hide');
                    $(obj).parent('div').children('.show-all').removeClass('hide');
                }
            });
        });

    });
</script>
<!--./ Articles-->