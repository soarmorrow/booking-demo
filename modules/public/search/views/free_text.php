<div  style="padding-top: 150px;padding-bottom: 50px;" class="container">
    <div class="col-md-12">   
        <div class="col-md-2" style="margin: 20px auto;">
            <select class="form-control" id="perpage" style="max-width:80px;">
                <?php
                if (isset($perpages)) {
                    foreach ($perpages as $perpage) {
                        if ($perpage === $per_page) {
                            echo '<option value="' . $perpage . '" selected>' . $perpage . '</option>';
                        } else {
                            echo '<option value="' . $perpage . '">' . $perpage . '</option>';
                        }
                    }
                }
//            debug($pagination);
                ?>                                            
            </select>
        </div>
        <div class="col-md-10 text-right">
            <?= $pagination ?>
        </div>
    </div>
    <div class="col-md-12">
        <?php
        $i=0;
        foreach ($result as $value) {
            if($i%4==0){
                echo '<div class="clearfix"></div>';
            }
            ?>     
            <div class="col-md-3">   
                <div class="thumbnail tile tile-medium tile-teal">
                    <h4 align="center"><?= $value->event_name ?></h4>
                    <p>
                        Center Name: <?= $value->center_name ?><br/>
                        Location :  <?= $value->city ?><br/>
                        Timing : <?= $value->e_start_time ?>  <?= $value->e_end_time ?><br/>
                        <div align="right">
                            <form action="<?= site_url('payment'); ?>" method="get">
                                <input name="event" type="hidden" value="<?= $value->event_id ?>"/>
                                Seats:<input name="amount" type="number" value="1" required=""/>
                                <button type="submit" class="btn btn-primary">
                                    Book Now
                                </button>
                            </form>
                        </div>
                    </p>
                    <a href="#" >
                    </a>
                </div>
            </div>
            <?php
            $i++;
        }
        ?>
    </div>
</div>