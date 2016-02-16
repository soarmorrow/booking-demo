<?php
if (empty($articles)) {
    echo false;
//    exit();
} else {
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
                                                    if (strlen($value->title) > 15) {
                                                        echo '...';
                                                    }
                                                    ?></h4></a>
<!--                                                    <h4>
                                                    <?php
                                                    echo sub_str(strip_tags($value->author), 0,15);
                                                    if (strlen($value->author) > 15) {
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
}
?>