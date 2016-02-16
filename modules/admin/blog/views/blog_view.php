<section class="content-header">
    <h1>
        Add Blog
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Blog</a></li>
        <li class="active">Add blog</li>
    </ol>
</section>
<style>
    .thumbnail{
        height: 130px;
    }
</style>	
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box  box-success">
                
                    <div class="box-header">
                    </div><!-- /.box-header -->
                    <div class="box-body" style="padding-top: 0px">

                    <!--<form name="createblog" method="post" action="" id="createBLOG" >-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class='box-body pad'>
                                    <h3><?= $blog->title; ?></h3>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class='box-header'>
                                    <!-- tools box -->
                                </div><!-- /.box-header -->
                                <div class='box-body pad'>
                                    <?= $blog->content; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="thumbnails">
                            <?php
                            foreach ($images as $value) {
                                if ($value->attachment_type == 0) {
                                    echo '<a href="' . base_url($value->path) . '" rel="prettyPhoto[gallery2]"><img class="col-md-2 thumbnail"  src="' . base_url($value->path) . '" alt="" ></a>';
                                } else if ($value->attachment_type == 1) {
                                    echo '<a href="' . base_url($value->path) . '?iframe=true"  rel="prettyPhoto[flash]"><img  class="col-md-2 thumbnail"  src="' . base_url($theme_path . 'images/video_icon.jpg') . '" alt=""></a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="box-footer">  
                        <a onclick="history.go(-1);" class="btn-default btn">
                            Back
                        </a>
                        <a href="<?=  site_url("blog/update/$blog->id"); ?>" class="btn btn-primary" onclick="">Edit</a>
                    </div>

                    <!--</form>-->
                </div><!-- /.box-body --> 
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div><!-- /.row -->

    <script>
        $(window).load(function () {
            $("#thumbnails:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000,social_tools: false});
            $("#thumbnails:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true,social_tools: false});
        });
        $(document).ready(function(){				
        });
    </script>
</section>

<!--<script type="text/javascript">
    
</script>-->