<?php
if (empty($events)) {
    echo false;
} else {

    foreach ($events as $value) {
        ?>
        <div class="col-sm-6 col-md-4 col-xs-12  col-centered padding-2 animated slideInDown"   style="text-align: left" >
            <a href="<?= site_url('event_public/single_event') ?>/<?= $value->id ?>">
                <div class="card events_card">
                    <!-- <div class="card-height-indicator"></div> -->
                    <div class="card-content">
                        <div class="card-header">
                            <h3 class="card-image-headline">
                                <?php
                                echo substr($value->name, 0, 25);
                                if (strlen($value->name) > 25) {
                                    echo '...';
                                }
                                ?>
                            </h3>
                        </div>
                        <div class="card-image">
                            <img src="<?= base_url(($value->image)?$value->image:'uploads/images/eventslider/14520608113861.png') ?>" alt="Loading image...">
                        </div>
                        <div class="card-body">
                            <div class="centre-info">
                                <h4>
                                    <?php
                                    echo substr($value->center_name, 0, 25);
                                    if (strlen($value->center_name) > 25) {
                                        echo '...';
                                    }
                                    ?></h4>
                                <span>
                                    <?php
                                    $address = $value->street_address1 . ', ' . $value->state;
                                    echo substr($address, 0, 30);
                                    if (strlen($address) > 30) {
                                        echo '...';
                                    }
                                    ?>
                                </span>
                            </div>
                            <p><?=
                                substr($value->description, 0, 80);
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
}
?>