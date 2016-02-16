<?php
                    if(!empty($reviews)){
                        ?>
                        <div class="col-xs-12 col-md-12" style="height:200px;overflow-x:hidden;overflow-y:auto">
                            <?php
                            foreach ($reviews as $value) {
                                ?>
                                <div class="row">
                                    <img src="<?=base_url($value->avatar)?>" width="50px" height="50px" style="float:left">
                                    <p style="padding-left:60px;margin:0"><strong><?=ucwords(strtolower($value->first_name)).' '.ucwords(strtolower($value->last_name))?>&nbsp;&nbsp;</strong><br>
                                        <?=date('d M Y',strtotime($value->created_at))?></p>
                                        <div class="rating-input">
                                            <span class="<?= (round($value->rating) == 5) ? "active" : '' ?>">☆</span>
                                            <span class="<?= (round($value->rating) == 4) ? "active" : '' ?>">☆</span>
                                            <span class="<?= (round($value->rating) == 3) ? "active" : '' ?>">☆</span>
                                            <span class="<?= (round($value->rating) == 2) ? "active" : '' ?>">☆</span>
                                            <span class="<?= (round($value->rating) == 1) ? "active" : '' ?>">☆</span>
                                        </div>
                                        <div class="clearfix"></div>
                                        <p style="padding-left:60px;width: 500px;word-wrap: break-word;"><?=$value->comment?></p>

                                    </div>
                                    <hr>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>