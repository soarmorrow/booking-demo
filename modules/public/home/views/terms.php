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
    .bhoechie-tab-content h3{
        margin: 0 !important;
        padding: 0 !important;
    }
</style>
<div class="clearfix"></div><br><br><br><br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="bhoechie-tab-content" style="padding-bottom:10px;">
                        <h3 style="color:#4c93bb">GoRetreat Terms of Service</h3><br>
                        <p style="font-size:16px;">
                            By using our Services, you are agreeing to these terms. Please read them carefully.
                        </p><br>
                        <h4 style="color:#4c93bb;">Using Our Services</h4>
                        <br>
                        <p style="font-size:16px;">You must follow any policies made available to you within the Services.</p>
                        <p style="font-size:16px;">Don’t misuse our Services. For example, don’t interfere with our Services or 
                            try to access them using a method other than the interface and the instructions 
                            that we provide. You may use our Services only as permitted by law, including 
                            applicable export and re-export control laws and regulations. We may suspend or 
                            stop providing our Services to you if you do not comply with our terms or policies 
                            or if we are investigating suspected misconduct.</p>
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
                        $(this).siblings('.list-group-item.active').removeClass("active");
                        $(this).addClass("active");
                        var index = $(this).index();
                        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
                    });
                });
            </script>
    </body>

</html>
