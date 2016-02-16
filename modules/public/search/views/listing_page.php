<style type="text/css">
    .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
        padding-right: 3px;
        padding-left: 3px;
    }
    #showMore{
        cursor: pointer;
    }
    #showMore img{        
        width: 18px;
    }
    .nomatch{
        background-color: #fff;
        text-align: center;
        padding: 50px 0 50px 0;
        border-radius: 5px;
        margin-top: 5px;
    }
    .search-query{
        border: 0 !important;
        background: none !important;
    }
    #custom-search-input div{
        border-bottom: 1px solid #ddd;
    }
    .table tr td{
        border-top: 0 !important;
        border-bottom: 1px solid #ddd;
    }
    .head-blue{
        padding-bottom: 15px;
    }
    .row{
        margin-left: -3px;
        margin-right: -3px;
    }
    @media (max-width: 365px){
        .addrs{
            font-size: 12px;
        }
    }
</style>
<div class="clearfix">

</div>
<br>
<br>
<br><br>
<div class="container ">
    <?php
    if ($total) {
        ?>
        <div class="row">
            <div class="col-md-7 col-md-offset-3 hide-25 nopadding">Showing <span id="idCount"><?= ($total > $loaded) ? $loaded : $total ?> </span> of <?= $total ?> <?= ($total > 1) ? 'centers' : 'center' ?> that matches your search. </div>
        </div>
        <?php
    }
    ?>
    <div class="row">

        <div class="col-md-12">

            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12 widget-item pull-left box-round" style="background-color: white;">
                    <label class="head-blue text-centre">Search</label>

                    <form id="custom-search-form" class="form-search form-horizontal pull-right">
                        <div id="custom-search-input">
                            <div class="input-group col-md-12">
                                <input type="text" value="<?= $filters['inner_key'] ?>" name="search_keyword" class="search-query form-control" placeholder="Keywords" />
                                <span class="input-group-btn" id="addInnerSearch">
                                    <button class="btn btn" type="button">
                                        <span class=" glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>                                 
                </div> 

                <div class="col-md-12 col-sm-12 col-xs-12 pull-left widget-item box-round" style="background-color: white;">
                    <label class="head-blue text-centre">Type of Retreat Preferred</label>
                    <table class=" table table-responsive">
                        <?php
                        $i = 0;
                        foreach ($searchtype as $val) {
                            ?>
                            <tr>
                                <td><?= $val->name ?></td><td><input class="pull-right optionlist" type="radio" name="type" value="<?= $val->id ?>" <?= ($val->id == $filters['centre']) ? 'checked' : '' ?>/></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </table>   
                </div> 

                <div class="col-md-12 col-sm-12 col-xs-12 pull-left widget-item box-round" style="background-color: white;">
                    <label class="head-blue text-centre">Language Preferred</label>
                    <table class=" table table-responsive" style="text-transform: capitalize">
                        <?php
                        foreach ($searchlanguage as $val) {
                            if($val->id==''){
                                continue;
                            }
                            ?>
                            <tr>
                                <td><?= $val->language ?></td><td><input class="pull-right optionlist" type="radio" name="lang" value="<?= $val->id ?>" <?= ($val->id == $filters['centre_lang']) ? 'checked' : '' ?>/></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>   
                </div>

            </div>   
            <!--./side blue End-->
            <?php
            if ($total) {
                ?>
                <div class="col-md-7 col-xs-12 nopadding">    
                    <input type="hidden" value="0" id="pagenum"/>
                    <div class="raw">
                        <span id="searchList">
                            <?php
                            foreach ($results as $result) {
                                ?>
                                <div class="col-md-12 col-sm-12 widget-item box-round" style="background-color: white;padding-top: 10px;">
                                    <div class="col-sm-3 col-md-3" >
                                        <div class="raw">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-image">
                                                        <img src="<?= base_url($result->center_image) ?>" alt="Loading image...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-md-9">
                                        <div class="row">
                                            <div class="col-sm-7 col-md-7">
                                                <h4 class="centre-info"><?= $result->center_name ?></h4>
                                                <h5 class="addrs"><?= $result->street_address1 . "," . $result->city . "," . $result->state ?></h5>
                                                <h6><?= ucfirst($filters['centre_lang']) ?> Retreats Scheduled <?= $result->month_name ?>(<?= $result->count ?>)</h6>
                                                <!--                                            <input class="btn btn-default" type="button" value="19-25 Nov 15" />
                                                <input class="btn btn-default" type="button" value="20-28 Nov 15" />-->
                                                <!--<div class="col-xs-12"><p class="blue x-small">Led by Fr. Mathew Naikamparambil, Booking Open</p> </div>-->                                    
                                            </div>
                                            <div class="col-sm-5 col-md-5">
                                                <div class="row pad-top-10">
                                                    <div class="col-xs-6 col-md-6">
                                                        <i class="fa fa-check-circle-o head-red">&nbsp;</i>verified
                                                    </div>
                                                    <div class="col-xs-6 col-md-6">
                                                        <div class="rating-input">
                                                            <span class="<?= (round($result->rate->average) == 5) ? "active" : '' ?>">☆</span>
                                                            <span class="<?= (round($result->rate->average) == 4) ? "active" : '' ?>">☆</span>
                                                            <span class="<?= (round($result->rate->average) == 3) ? "active" : '' ?>">☆</span>
                                                            <span class="<?= (round($result->rate->average) == 2) ? "active" : '' ?>">☆</span>
                                                            <span class="<?= (round($result->rate->average) == 1) ? "active" : '' ?>">☆</span>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-md-6">
                                                        <i class="fa blue x-small <?= (empty($result->liked)) ? "fa-heart-o":"fa-heart"?>"> <?=$result->likes?></i>
                                                    </div>
                                                    <div class="col-xs-6 col-md-6">
                                                        <i class="fa fa-pencil-square-o x-small blue">&nbsp;&nbsp;<?=$result->reviews?>Testimonial</i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-12">
                                                <a href="<?= site_url('search/events/' . $result->center_id) ?>"><input class="btn btn-primary view-details" type="button" value="View Details" /></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </span>
                        <?php
                        if ($total > 4) {
                            ?>
                            <div class="row">
                                <div class="col-md-10 col-sm-12 col-xs-12 col-md-offset-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="center-block">
                                                <a  class="show-more" id="showMore">Show More <img src="<?= base_url('themes/user/resources/assets/images/show_more.png') ?>" /></a><br />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="col-md-7 col-xs-12 nopadding nomatch"><h3>No matches to your search. </h3></div>
                <?php
            }
            ?>
            <!--.side blue-->
            <div class="col-md-2 col-sm-12 col-xs-12 back-non pull-right">    
                <div class="raw">
                    <div class="col-sm-12 col-md-12 col-xs-12 widget-red"> 
                        <a href="#" style="width: 100%" >
                            <img style="width: 100%" src="<?= base_url('themes/user/resources/assets/images/emirates_icn.png') ?>" class="img-responsive"> 
                        </a>
                    </div>
                </div>
                <div class="raw">
                    <div class="col-sm-12 col-md-12 col-xs-12 widget-yellow" style="height: 550px; margin-top:8px;">                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var page = 0;
            var urldata = "<?= site_url('search/loadmore') ?>";
            var clickable = true;
            $("#showMore").click(function () {
                var obj = $(this);
                if (clickable) {
                    obj.children('img').attr('src', THEME_PATH + '/resources/assets/images/loading.gif');
    //                    var page = parseInt($('#pagenum').val()) + 1;
    //                    $('#pagenum').val(page);
                    page++;
                    clickable = false;
                    $.ajax({
                        url: urldata + '/' + page,
                        dataType: 'json',
                        success: function (data) {
                            clickable = true;
                            obj.children('img').attr('src', THEME_PATH + '/resources/assets/images/show_more.png');
                            $("#searchList").append(data['view']);
                            $("#idCount").html(data['count']);
                            if (data['more'] != 'true') {
                                $("#showMore").addClass('hide');
                            }
                        }
                    });
                }
            });
            
            $("#addInnerSearch").click(function () {
                var search_keyword = $('input[name="search_keyword"]').val();
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('search/setFilterInnerKey') ?>",
                    data: {inner_key: search_keyword},
                    success: function (data) {
                        Redirect();
                    }
                });
            })
            $('.optionlist').change(function () {
                var type = $('input[name="type"]:checked').val();
                var language = $('input[name="lang"]:checked').val();
    //                var formdata = new FormData();
    //                formdata.append('lang', language);
    //                formdata.append('type', type);
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('search/setFilter') ?>",
                    data: {lang: language, type: type},
                    success: function (data) {
                        Redirect();
                    }
                });
            });
            function Redirect() {
                window.location = "<?= site_url('search') ?>";
            }
        }
        );
    </script>
</div>