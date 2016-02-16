<style>
.centre-language{
    text-transform: capitalize;
}
.selectize-control.single .selectize-input::after, .selectize-control.multi .selectize-input::after,
.selectize-control.single .selectize-input.input-active::after,
.selectize-control.multi .selectize-input.input-active::after{
    content: none;
}
@media (max-width: 580px){
    .centre-language, .centre{
        border-radius: 0;
        background-color: #fff;
    }
}
@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
    .sticky-wrapper{
        height: 104px !important;
    }
    .filter{
        position: absolute !important;
        padding: 30px 0 !important;
        margin-top: -60px;
    }
}
@media screen and (min-width:0\0) {
    .sticky-wrapper{
        height: 104px !important;
    }
    .filter{
        position: absolute !important;
        padding: 30px 0 !important;
    }
}
</style>
<!--[if gte IE 10]>
<style type="text/css">
    .filter{
        position: absolute !important;
    }
</style>
<![endif]-->
<!--Slider Begin-->
<section class="go-slider">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            for ($i=0; $i <$count ; $i++) { 
                ?>
                <li data-target="#carousel-example-generic" data-slide-to="<?=$i?>" class="<?=$i==0?'active':''?>"></li>
                <?php
            }
            ?>   
        </ol>

        <!-- Indicators -->
        <!-- <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol> -->

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <?php
            $i=0;
            foreach ($images as $image) {
                $i++;
                ?>
                <!-- First slide -->
                <div class="item <?=$i==1?'active':''?>">
                    <img src="<?= base_url($image->avatar) ?>" alt="" class="img-responsive" />
                    <div class="carousel-caption">
                    <!--                            <div class="icon-container" data-animation="animated fadeInDownBig">
                                                    <i class="fa fa-building-o"></i>
                                                </div>-->
                                                <h1 data-animation="animated bounceInRight">
                                                 <?=$image->title?>
                                             </h1>
                                             <h4 data-animation="animated bounceInLeft">
                                                 <?=$image->description?>
                                             </h4>
                                         </div>
                                     </div>
                                     <!-- /.item -->
                                     <?php
                                 }
                                 ?>
                                 

                                 <!-- Second slide -->
            <!-- <div class="item">
                <img src="<?= base_url($theme_path . 'resources/assets/images/slider/2.jpg') ?>" alt="" class="img-responsive" />
                <div class="carousel-caption"> -->
                    <!--                            <div class="icon-container" data-animation='animated bounceInRight'>
                                                    <i class="fa fa-building-o"></i>
                                                </div>-->
                    <!-- <h1 data-animation="animated bounceInLeft">
                        Reach out to your inner self
                    </h1>
                    <h4 data-animation="animated bounceInUp">
                        Consectetur adipiscing elit. Nunc vulputate malesuada nulla, eget pretium quam aliquet sit amet. 
                        Nulla sagittis at nulla a mattis. In velit dolor.
                    </h4>
                </div>
            </div> -->
            <!-- /.item -->

            <!-- Third slide -->
            <!-- <div class="item">
                <img src="<?= base_url($theme_path . 'resources/assets/images/slider/3.jpg') ?>" alt="" class="img-responsive" />
                <div class="carousel-caption"> -->
                    <!--                            <div class="icon-container" data-animation='animated rollIn'>
                                                    <i class="fa fa-building-o"></i>
                                                </div>-->
                   <!--  <h1 data-animation="animated flipInX">
                        Reach out to your inner self
                    </h1>
                    <h4 data-animation="animated lightSpeedIn">
                        Consectetur adipiscing elit. Nunc vulputate malesuada nulla, eget pretium quam aliquet sit amet. 
                        Nulla sagittis at nulla a mattis. In velit dolor.
                    </h4>

                </div>
            </div> -->
            <!-- /.item -->

        </div>
        <!-- /.carousel-inner -->


    </div>
    <!-- /.carousel -->
    <section class="filter">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">

                    <form action="<?= site_url('search') ?>" class="form-inline filter-form" method="POST">
                        <div class="row">
                            <div class="form-group col-xs-3 col-sm-3">
                                <input type="text" name="query" placeholder="Enter centre name, preacher or place">
                            </div>
                            <div class="form-group col-xs-3 col-sm-3">
                                <a href="#info" class="btn-exclamation" data-toggle="tooltip" data-placement="top" title="Sample info for a user to understand what it means.">
                                    <span class="fa fa-stack fa-lg">
                                        <i class="fa fa-exclamation fa-stack-1x"></i>
                                        <i class="fa fa-circle-thin fa-stack-2x"></i>

                                    </span>
                                </a>
                                <select name="centre" class="centre">
                                    <option value="">Type of retreat</option>
                                    <?php
                                    foreach ($searchtype as $val) {
                                        ?>

                                        <option value="<?= $val->id ?>"><?= $val->name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-xs-2 col-sm-2">
                                <select name="centre_lang" class="centre-language">
                                    <option value="">Language</option>
                                    <?php
                                    foreach ($searchlanguage as $val) {
                                        ?>

                                        <option value="<?= $val->id ?>"><?= $val->language ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-xs-2 col-sm-2">
                                <input type="text" name="startdate" class="start-date" placeholder="Start Date" />
                            </div>
                            <div class="form-group col-xs-2 col-sm-2">
                                <input type="text" name="enddate" class="end-date" placeholder="End Date" />
                            </div>
                            <div class="form-group col-xs-1 col-sm-1 search-button">
                                <button type="submit" class="btn btn-primary btn-search"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
<!--Slider End-->
