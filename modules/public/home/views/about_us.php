 <section class="team" style="margin-top:50px;">
        

        <!--Preachers and Guides-->
        <div class="clearfix"></div><br><br>
            <section class="about_us">
                <div class="container">
                    <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 bhoechie-tab-menu">
                              <div class="list-group">
                                <a href="#" class="list-group-item active">
                                  About goRetreat
                                </a>
                                <a href="#" class="list-group-item">
                                  Mission
                                </a>
                                <a href="#" class="list-group-item">
                                  Team behind
                                </a>
                                <a href="#" class="list-group-item">
                                  Contact us
                                </a>
                              </div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8 bhoechie-tab">
                                <!-- flight section -->
                                <div class="col-sm-9 bhoechie-tab-content active">
                                      <h4 style="color:#4c93bb">About goRetreat</h4><br>
                                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat. Etiam egestas est a elit cursus, vitae dignissim leo pulvinar. Fusce neque enim, placerat quis massa sed, tincidunt bibendum ipsum. Donec interdum congue mauris quis lobortis. Fusce eget rutrum velit. Quisque quis ipsum blandit, semper libero id, vulputate est. Morbi id euismod risus. Integer nec velit malesuada, tincidunt ligula ac, consectetur arcu. Ut aliquam neque ex, ut eleifend neque mollis sed</p>
                                      <p>dignissim leo pulvinar. Fusce neque enim, placerat quis massa sed, tincidunt bibendum ipsum. Donec interdum congue mauris quis lobortis. Fusce eget rutrum velit. Quisque quis ipsum blandit, semper libero id, vulputate est. Morbi id euismod risus. Integer nec velit malesuada, tincidunt ligula ac, consectetur arcu. Ut aliquam neque ex, ut eleifend neque mollis sed..</p>
                                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat. Etiam egestas est a elit cursus, vitae dignissim leo pulvinar. Fusce neque enim, placerat quis massa sed, tincidunt bibendum ipsum. Donec interdum congue mauris quis lobortis. Fusce eget rutrum velit. Quisque quis ipsum blandit, semper libero id, vulputate est. Morbi id euismod risus. Integer nec velit malesuada, tincidunt ligula ac, consectetur arcu. Ut aliquam neque ex, ut eleifend neque mollis sed</p>
                                </div>
                                <!-- train section -->
                                <div class="col-sm-9 bhoechie-tab-content">
                                      <h4 style="color:#4c93bb">Mission</h4><br>
                                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat. Etiam egestas est a elit cursus, vitae dignissim leo pulvinar. Fusce neque enim, placerat quis massa sed, tincidunt bibendum ipsum. Donec interdum congue mauris quis lobortis. Fusce eget rutrum velit. Quisque quis ipsum blandit, semper libero id, vulputate est. Morbi id euismod risus. Integer nec velit malesuada, tincidunt ligula ac, consectetur arcu. Ut aliquam neque ex, ut eleifend neque mollis sed</p>
                                </div>
                    
                                <!-- hotel search -->
                                <div class="col-sm-9 bhoechie-tab-content">
                                      <h4 style="color:#4c93bb">Team</h4><br>
                                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat. Etiam egestas est a elit cursus, vitae dignissim leo pulvinar. Fusce neque enim, placerat quis massa sed, tincidunt bibendum ipsum. Donec interdum congue mauris quis lobortis. Fusce eget rutrum velit. Quisque quis ipsum blandit, semper libero id, vulputate est. Morbi id euismod risus. Integer nec velit malesuada, tincidunt ligula ac, consectetur arcu. Ut aliquam neque ex, ut eleifend neque mollis sed</p>
                                </div>
                                <div class="col-sm-9 bhoechie-tab-content">
                                      <h4 style="color:#4c93bb">Contact Us</h4><br>
                                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat. Etiam egestas est a elit cursus, vitae dignissim leo pulvinar. Fusce neque enim, placerat quis massa sed, tincidunt bibendum ipsum. Donec interdum congue mauris quis lobortis. Fusce eget rutrum velit. Quisque quis ipsum blandit, semper libero id, vulputate est. Morbi id euismod risus. Integer nec velit malesuada, tincidunt ligula ac, consectetur arcu. Ut aliquam neque ex, ut eleifend neque mollis sed</p>
                                </div>
                            </div>
                  </div>
                </div>
            </section></section>
            <!--./ Preachers and Guides-->
            <div class="clearfix"></div><br><br><br>

        <!--./Header End-->

  <script>
    $(document).ready(function () {
        $("div.bhoechie-tab-menu>div.list-group>.list-group-item").click(function (e) {
            e.preventDefault();
            $(this).siblings('.list-group-item.active').removeClass("active");
            $(this).addClass("active");
            var index = $(this).index();
            $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
            $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
        });
    });
</script>  
    