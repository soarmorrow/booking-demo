<?php
if (empty($centers)) {
    echo false;
} else {
    foreach ($centers as $value) {
        ?>
        <div class="col-sm-6 col-md-4 col-xs-12 col-centered padding-2 animated slideInDown"   style="text-align: left" >
            <a href="<?= site_url('centre_public/events') ?>/<?= $value->id ?>"> 
                <div class="card events_card">
                    <div class="card-content">
                        <div class="card-header">
                            <h3 class="card-image-headline"><?= $value->name ?></h3>
                        </div>
                        <div class="card-image">
                            <img src="<?= base_url(($value->logo)?$value->logo:'uploads/images/eventslider/14520608113861.png') ?>" alt="Loading image...">
                        </div>
                        <div class="card-body">
                            <div class="centre-info">
                                <h4>
                                    <?php
                                    echo substr($value->name, 0, 25);
                                    if (strlen($value->name) > 25) {
                                        echo '...';
                                    }
                                    ?></h4>
                                <span><?php
                                    $address = $value->street_address1 . ', ' . $value->state;
                                    echo substr($address, 0, 20);
                                    if (strlen($address) > 20) {
                                        echo '...';
                                    }
                                    ?></span>
                            </div>
                            <p>
                                <?php
                                echo substr($value->description, 0, 130);
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
}
?>