<style type="text/css">
.table tr td{
    border-top: 0 !important;
    border-bottom: 1px solid #ddd;
}
.preatures{
    box-shadow: none !important;
}
.img-description.explore{
    height: 285px;
    display: none;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 99999;
    border-radius: 5px;
}
.card-content:hover .img-description.explore{
    display: block;
}
span.explore{
    padding: 5px 10px;
    border: 2px solid #fff;
    margin-top: 55%;
    margin-left: 15%;
    position: absolute;
    color: #fff;
}
.card{
    height: 285px;
}
</style>
<div class="container">
    <div class="row">        
        <section class="preatures">
            <div class="col-md-12"><br>
                <h3 class="text-center title">Preachers and Guides</h3>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 nopadding">
                            <div class="col-md-12 widget-item nopadding">

                                <!-- Blog Categories Well -->
                                <div class="panel panel-default">

                                    <div class="panel-heading">
                                        <label class="head-blue">Role/Status</label>
                                    </div>
                                    <div class="panel-body">
                                        <table class=" table table-responsive">
                                            <?php
                                            foreach ($status as $value) {
                                                ?>
                                                <tr>
                                                    <td><?=$value->status?></td><td><input class="option pull-right" value="<?=$value->id?>" name="status" type="radio"/></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                        <!-- <tr>
                                            <td>Priests</td><td><input class="option pull-right" value="priests" name="status" type="radio"/></td>
                                        </tr>
                                        <tr>
                                            <td>Religious</td><td><input class="option pull-right" value="religious" name="status" type="radio"/></td>
                                        </tr> -->
                                    </table>
                                    <!-- /.col-lg-6 -->
                                </div>
                                <!-- /.col-lg-6 -->
                            </div>
                            <!-- /.row -->
                        </div>                          

                        <div class="col-md-12 widget-item nopadding">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <label class="head-blue">Languages Preached</label>
                                </div>
                                <div class="panel-body">
                                    <table class=" table table-responsive">
                                        <?php
                                        foreach ($languages as $value) {
                                         ?>
                                         <tr>
                                            <td><?=$value->language?></td><td><input class="option  pull-right" value="<?=$value->id?>" name="language" type="radio"/></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                        <!-- <tr>
                                            <td>Malayalam</td><td><input class="option  pull-right" value="malayalam" name="language" type="radio"/></td>
                                        </tr>
                                        <tr>
                                            <td>Tamil</td><td><input class="option  pull-right" value="tamil" name="language" type="radio"/></td>
                                        </tr> -->
                                    </table>                            
                                </div>
                            </div>                  
                        </div>
                        <div class="col-md-12 widget-item nopadding">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <label class="head-blue">Areas of Expertise</label>
                                </div>
                                <div class="panel-body">
                                    <table class=" table table-responsive">
                                        <?php
                                        foreach ($expertise as $value) {
                                            ?>
                                            <tr>
                                            <td><?=$value->area_of_expertise?></td><td><input class="option pull-right" value="<?=$value->id?>" name="field" type="radio"/></td>
                                        </tr>
                                            <?php
                                        }
                                        ?>
                                        
                                        <!-- <tr>
                                            <td>Youth Topics</td><td><input class="option pull-right" value="Youth Topics" name="field" type="radio"/></td>
                                        </tr>
                                        <tr>
                                            <td>Teenagers</td><td><input class="option pull-right" value="Teenagers" name="field" type="radio"/></td>
                                        </tr> -->
                                    </table>                            
                                </div>
                            </div>                  
                        </div>
                    </div>
                    <div class="col-md-9 nopadding" id="preacherslist">
                        <div class="row">

                            <?php
                            $i=0;
                            foreach ($preachers as $preacher) {
                                $i++;
                                ?>
                                <div class="col-sm-3 col-md-3">
                                    <div class="card">
                                        <!-- <div class="card-height-indicator"></div> -->
                                        <div class="card-content">
                                            <div class="img-description explore"><a href="<?=site_url('preachers/preachers_profile')?>/<?=$preacher->id?>"><span class="explore">- VIEW PROFILE -</span></a></div>
                                            <div class="card-image">
                                                <img src="<?=base_url($preacher->image)?>" alt="Loading image...">
                                            </div>
                                            <div class="card-body">
                                                <div class="centre-info" style="margin-bottom: 0px;">
                                                    <h4> <?= $preacher->name ?></h4>
                                                </div>
                                                <p><?php echo substr($preacher->address, 0, 20);
                                                if(strlen($preacher->address) > 20){
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
                    <?php
                    if($i>7){
                        ?>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="center-block">
                                            <a href="#!/showmore" data-url="<?= site_url('preachers/getMorePreachers') ?>" data-target="preacherslist" data-page="1"  class="loadmore show-more">Show More<img src="<?=base_url('themes/user/resources/assets/images/show_more.png')?>"></a><br />
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
        </div>
    </section> 
</div>
</div>
<!--contact-->

<!--./Header End-->

<!--./Upcoming events-->
<script>

    // $(document).ready(function() {
    //     $(".filter").sticky({topSpacing: 63,className:"sticky-filter"});
    // });
$(document).ready(function() {
//        var eventpage = 1, centerpage = 1;

$('.loadmore').click(function(e) {
    e.preventDefault();
    var obj = $(this);
    var url = obj.data('url');
    var target = obj.data('target');
    var preacherpage = parseInt(obj.data('page'));
    var role = $('input:radio[name=status]:checked').val();
    var language = $('input:radio[name=language]:checked').val();
    var field = $('input:radio[name=field]:checked').val();
    var postdata = {'role' : role,
    'language' : language,
    'field' : field
};
obj.children('img').attr('src', THEME_PATH + '/resources/assets/images/loading.gif');
$.ajax({
    url: url + '/' + preacherpage,
    type: 'POST',
    data:postdata,
    dataType: 'JSON',
    success: function(data) {
        console.log(data);
        if (data['status'] == false) {
            obj.hide();
        } else {
            preacherpage++;
            obj.data("page", preacherpage);
        }
        $('#' + target).append(data['data']);
        obj.children('img').attr('src', THEME_PATH + '/resources/assets/images/show_more.png');

    }
});
});
$('.option').on('change',function(){
    var role = $('input:radio[name=status]:checked').val();
    var language = $('input:radio[name=language]:checked').val();
    var field = $('input:radio[name=field]:checked').val();
    var postdata = {'role' : role,
    'language' : language,
    'field' : field
};
$.post("<?= site_url('preachers/getMorePreachers') ?>", postdata, function(result){
    var resultdata = JSON.parse(result);
    $("#preacherslist").html(resultdata.data);
});

});

});

</script>
