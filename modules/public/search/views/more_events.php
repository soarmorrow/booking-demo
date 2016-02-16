
     <?php
     foreach ($events as $event) {
        ?>    

        <div class="col-md-12 col-sm-12 nopadding" style="background-color: white;margin-bottom:5px;">
            <div class="col-sm-3 col-md-3 nopadding">
                  <div class="card">
                      <!-- <div class="card-height-indicator"></div> -->
                      <div class="card-content">
                          <div class="card-image">
                              <img src="<?=base_url($event->image)?>" alt="Loading image..." style="height:185px;">
                          </div>
                      </div>
                  </div>
            </div>
            <div class="col-sm-9 col-md-9" style="padding-top:15px;">
                <h4 class="centre-info"><?=$event->name?></h4>
                <h5>All are welcome</h5>
                <div class="clearfix"></div>
                <input class="btn btn-default" type="button" value="<?= date('d', strtotime($event->start_date)) ?>  <?= (date('M', strtotime($event->start_date))!=date('M', strtotime($event->end_date)))?date('M', strtotime($event->start_date)):''?>&nbsp;<?= (date('Y', strtotime($event->start_date))!=date('Y', strtotime($event->end_date)))?date('Y', strtotime($event->start_date)):''?>&nbsp;-&nbsp;<?= date('d', strtotime($event->end_date)) ?>&nbsp;<?= date('M', strtotime($event->end_date)) ?>&nbsp;<?= date('Y', strtotime($event->end_date)) ?>" style="background-color:#999999;color:#fff;border-radius: 5px;"/>
                <div class="clearfix"></div>
                <div class="col-sm-12 col-md-12 nopadding">
                  <p class="col-sm-8 col-md-8 nopadding blue"><?=substr($event->description,0,100)?>...</p>
                  <a href="<?= site_url('event_public/single_event') ?>/<?= $event->id ?>" class="col-sm-3 col-md-3"><input class="btn btn-primary" type="button" value="book now" style="background-color:#106fa4;padding:5px 15px;"/></a>
                </div>
            </div>
      </div>
      <?php
  }
  ?>
