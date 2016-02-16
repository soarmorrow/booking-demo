<div class="col-xs-12 back-non eventlist" style="padding: 20px 0;">
                <div id="eventslist">
                    <?php
                        $i = 0;
                        foreach ($program_schedule as $schedule) {
                        $i++;
                        // if($event->start_date )

                    ?>    
                    <div class="col-md-12 col-sm-12" style="background-color: #efefef;margin-bottom:5px;margin-top:5px;border-radius:5px;">
                        <div class="col-sm-3 col-md-3 nopadding">
                            <div class="card">
                                <!-- <div class="card-height-indicator"></div> -->
                                <div class="card-content">
                                    <div class="card-image">
                                        <img src="<?= base_url($schedule->image) ?>" alt="Loading image...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9 col-md-9" style="padding-top:15px;">
                            <h4 class="centre-info"><?= $schedule->name ?></h4>
                            <div class="clearfix"></div>
                            <input class="btn btn-default" type="button" value="<?= date('d', strtotime($schedule->start_date)) ?>  <?= (date('M', strtotime($schedule->start_date))!=date('M', strtotime($schedule->end_date)))?date('M', strtotime($schedule->start_date)):''?>&nbsp;<?= (date('Y', strtotime($schedule->start_date))!=date('Y', strtotime($schedule->end_date)))?date('Y', strtotime($schedule->start_date)):''?>&nbsp;-&nbsp;<?= date('d', strtotime($schedule->end_date)) ?>&nbsp;<?= date('M', strtotime($schedule->end_date)) ?>&nbsp;<?= date('Y', strtotime($schedule->end_date)) ?>" style="background-color:#999999;color:#fff;border-radius: 5px;"/>
                            <div class="clearfix"></div>
                            <div class="col-sm-12 col-md-12">
                                <p class="col-sm-8 col-md-8 blue"><?= substr($schedule->description, 0, 100) ?>...</p>
                                <a href="<?= site_url('event_public/single_event') ?>/<?= $schedule->event_id ?>" class="col-sm-3 col-md-3"><input class="btn btn-primary" type="button" value="view event" style="background-color:#106fa4;padding:5px 15px;" /></a>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
                <?php
                    if ($i > 2) {
                ?>
                <div class="row expo">
                    <div class="col-md-10 col-sm-12 col-xs-12 col-md-offset-1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="center-block">
                                    <a href="#!/showmore" data-url="<?= site_url('centre_public/getMoreEvents') ?>/<?= $id ?>" data-target="eventslist" data-page="1"  class="loadmore show-more">Show More<img src="<?= base_url('themes/user/resources/assets/images/show_more.png') ?>"></a><br />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
                <?php
                    }
                ?>
                <?php
                    if($i==0) {
                        echo '<div class="col-md-12 nopadding nomatch"><h4>No Events Scheduled</h4></div>';
                    }
                ?>
            </div>
