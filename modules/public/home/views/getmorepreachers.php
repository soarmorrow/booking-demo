<?php
if (empty($preachers)) {
    echo false;
} else {
    foreach ($preachers as $value) {
        ?>
        <div class="col-sm-6 col-md-3 col-xs-12  col-centered padding-2 animated slideInDown"  style="text-align: left">
                                <div class="card preachers_card">
                                    <!-- <div class="card-height-indicator"></div> -->
                                    <div class="card-content">
                                        <div class="card-image">
                                            <img src="<?= base_url(($value->image)?$value->image:'uploads/images/eventslider/14520608113861.png') ?>" alt="Loading image...">
                                        </div>
                                        <div class="card-body">
                                            <div class="centre-info" style="margin-bottom: 0px;">
                                                <h4><a href="<?=site_url('preachers/preachers_profile')?>/<?=$value->id?>"> <?= $value->name ?></a></h4>
                                            </div>
                                            <p><?= closetags(sub_str($value->description, 0, 40)); 
                                            if(strlen($value->description) > 40){
                                                echo '...';
                                            }?></p>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

        <?php
    }
}
?>