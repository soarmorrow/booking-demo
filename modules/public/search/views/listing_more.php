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
                                                        <i class="fa fa-pencil-square-o x-small blue">&nbsp;&nbsp;<?=$result->reviews?> reviews</i>
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