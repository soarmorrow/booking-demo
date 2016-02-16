

<!--Upcoming Events-->
<style>
  .col-centered{
    float: none;
    margin: 0 auto;
    display: inline-block;
  }
  @media (min-width:992px){                    
    .col-md-4.col-centered{
      width: 33%
    }
    .col-md-3.col-centered{
      width: 24.635%!important;
    }
  }

  @media (min-width:768px){                    
    .col-sm-4.col-centered{
      width: 33%
    }
    .col-sm-3.col-centered{
      width: 24.635%;
    }

        /*                    .col-sm-6.col-centered{
                                width: 47%
                              }*/
                            }   
                            @media (min-width:498px) and (max-width:768px){                    
                              .col-xs-10.col-centered{
                                width: 46%
                              }
                            }

                            .margin-top-25 {
                              margin-top: 25px!important;
                            }
                          </style>
                          <div class="clearfix"></div><br><br><br><br><br><br>
                          <section class="blog">
                            <div class="container">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-12 nopadding">
                                      <div class="bhoechie-tab-menu">
                                        <div class="list-group">
                                          <a href="#" id="1" class="list-group-item active">
                                            Platinum
                                          </a>
                                          <a href="#" id="2" class="list-group-item">
                                            Gold
                                          </a>
                                          <a href="#" id="3" class="list-group-item">
                                            Silver
                                          </a>
                                        </div>
                                      </div>

                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12 bhoechie-tab">
                                      <!-- flight section -->
                                      <div class="col-sm-12 bhoechie-tab-content active platinum">

                                       <div class="content" id="benefactorsContent">
                                       <div class="col-sm-10 nopadding border_bottom">
                                         <h3><font id="benType"><?= $benefactor_type->name?></font> Benefactors</h3>
                                         <div class="clearfix"></div>
                                         <div class="col-md-12">
                                           <p style="padding-left:0"><?= $benefactor_type->description?></p>	
                                         </div>
                                       </div>
                                        <?php
                                        foreach ($benefactors as $benefactor) {
                                          ?>
                                          <div class="col-sm-10 nopadding border_bottom padding-top-30">
                                            <div class="col-sm-6 col-md-4">
                                              <img src="<?=base_url($benefactor->avatar)?>">
                                            </div>
                                            <div class="col-sm-6 col-md-8">
                                              <h3><?=$benefactor->first_name?></h3>
                                              <span><?=$benefactor->country?></span>
                                              <div class="clearfix"></div><br>
                                              <p>Address : <?=$benefactor->address?></p> 
                                              <p>District : <?=$benefactor->district?></p> 
                                              <p>State : <?=$benefactor->state?></p>
                                              <p>Pincode : <?=$benefactor->pincode?></p>
                                              <p>Email : <?=$benefactor->email?></p>
                                              <p>Contact Number : <?=$benefactor->contact_number?></p>
                                            </div>
                                          </div>
                                          <div class="clearfix"></div><br>
                                          <?php
                                        }
                                        ?>


                                      </div>

                                    </div>

                                  </div>
                                  <div class="col-xs-12 col-sm-2 col-md-2 nopadding">
                                    <div class="yellow_bg"></div>
                                    <div class="clearfix"></div></br>
                                    <div class="blue_bg"></div>
                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </section> 
                        <br>

                        <script>
                          $(document).ready(function () {
                            $("div.bhoechie-tab-menu>div.list-group>.list-group-item").click(function (e) {
                              e.preventDefault();
                              var id = $(this).attr('id');
                              var benType = $(this).html();
                              $(this).siblings('.list-group-item.active').removeClass("active");
                              $(this).addClass("active");
                              var url="<?= site_url('benefactors/changeType') ?>/"+id;
                              console.log(url);
                              $.ajax({
                                url:url,
                                success:function(data){
                                  $("#benefactorsContent").html(data);
                                  // $("#benType").html(benType);
                                }
                              });
                            });
                          });
                        </script>
                      </body>

                      </html>
