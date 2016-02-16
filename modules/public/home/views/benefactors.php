
<!DOCTYPE html>
<html  lang="en">

    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Vineeth N Krishnan">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<!-- made by www.metatags.org -->
<meta name="description"
      content="GoRetreat.com - a retreat booking site, in the making. This will be a place where retreat centres can publish their retreats and you can search, find and book them. The main challenges are to create a"/>
<meta name="keywords" content="goretreat, retreat, cathedral, event, booking, online, center, retreat centres"/>
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="6 month">

<title>GoRetreat :: Book Events on your Favorite retreat center</title>
<!-- goretreat, cathedral, retreat -->


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->


<link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="resources/assets/css/plugins/animate.min.css" rel="stylesheet" />
<link href="resources/assets/selectize/selectize.css" rel="stylesheet" />
<link href="resources/assets/fontawesome/css/font-awesome.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
<link href="resources/material/dist/css/material-fullpalette.min.css" rel="stylesheet" />
<link href="resources/material/dist/css/ripples.min.css" rel="stylesheet" />
<link href="resources/material/dist/css/roboto.min.css" rel="stylesheet" />
<link href="resources/material_timepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link href="resources/assets/css/common.css" rel="stylesheet" />
<!--favicon-->
<link rel="shortcut icon" href="resources/assets/images/fav.png" type="image/x-icon"/>


<script src="resources/jquery/jquery.min.js" type="text/javascript"></script>
<script src="resources/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="resources/material/dist/js/material.min.js" type="text/javascript"></script>
<script src="resources/material/dist/js/ripples.min.js" type="text/javascript"></script>
<script src="resources/assets/js/plugins/jquery.ddslick.min.js" type="text/javascript"></script>
<script src="resources/assets/js/plugins/jquery.sticky.js" type="text/javascript"></script>
<script src="resources/assets/selectize/selectize.min.js" type="text/javascript"></script>
<script src="resources/assets/js/plugins/moment.js" type="text/javascript"></script>
<script src="resources/material_timepicker/js/bootstrap-material-datetimepicker.js" type="text/javascript"></script>
<script src="resources/assets/js/common.js" type="text/javascript"></script>
<script src="resources/assets/js/plugins/angular.min.js" type="text/javascript"></script>

    <body>

        <header>
    <div class="navbar navbar-default navbar-fixed-top">
        <div id="fb-root"></div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><img src="http://localhost/goretreat/themes/user/resources/assets/images/logo.png" alt="GoRetreat"
                                                          class="img-responsive" draggable="false"/></a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <a href="javascript:void(0);" class="btn btn-default btn-list listyourcenter"><i class="fa fa-plus"></i>List<span class="listtext"> Your Centre</span></a>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <select name="language" id="language">
                        <option value="hindi"
                                data-imagesrc="http://www.virology.path.cam.ac.uk/Division_of_Virology/People_files/india_flag.png"></option>
                        <option value="english"
                                data-imagesrc="http://www.earthcarefilms.com/images/flag/Australia.png"></option>
                        <option value="austia"
                                data-imagesrc="http://www.houseofproctor.org/genealogy/hop_state_icons/us_flag.png"></option>
                        <option value="brazillian"
                                data-imagesrc="http://www.earthcarefilms.com/images/flag/Brazil.png"></option>
                    </select>
                </li>
                <li class="dropdown hidden">
                    <a href="#" data-target="#" class="dropdown-toggle pull-left" data-toggle="dropdown">Hello  <b
                            class="caret"></b></a>

                    <div class="divider-vertical pull-right">

                    </div><div class="clearfix"></div>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="http://localhost/goretreat/index.php/customer/logout ">
                                Sign Out
                            </a>
                        </li>
                    </ul>

                </li>


                <li class="dropdown ">
                    <a href="#" data-target="#" class="dropdown-toggle pull-left" data-toggle="dropdown">Sign in <b
                            class="caret"></b></a>

                    <div class="divider-vertical pull-right">

                    </div><div class="clearfix"></div>
                    <ul class="dropdown-menu">
                        <img src="http://localhost/goretreat/themes/user/resources/assets/images/topbanner.png" alt="Top banner" class="top_banner hidden-sm hidden-xs">
                        <li>
                            <div class="g-auth" onclick="window.location.href = 'http://localhost/goretreat/index.php/google'">
                                <a href="#">
                                    <img src="http://localhost/goretreat/themes/user/resources/assets/images/social_buttons/gplus.png" alt="Google+"/>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="facebook-auth"  onclick="fb_login()" style="cursor: pointer">
                                    <img src="http://localhost/goretreat/themes/user/resources/assets/images/social_buttons/fb.png" alt="Facebook"/>
                                
                            </div>
                        </li>
                        <li class="divider"></li>
                        <span class="or-signin">Or signin with your e-mail</span>
                        <li>
                            <div class="signin-auth">
                                <a href="#">
                                    <img src="http://localhost/goretreat/themes/user/resources/assets/images/social_buttons/sign-in.png" alt="Sign in"/>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="signup-auth">
                                <a href="#">
                                    <img src="http://localhost/goretreat/themes/user/resources/assets/images/social_buttons/signup.png" alt="Signup"/>
                                </a>
                            </div>
                        </li>
                    </ul>

                </li>
                <li>
                    <a href="#" data-toggle="dropdown" data-target="#" class="dropdown-toggle pull-left">Manage Booking <b class="caret"></b></a>

                    <div class="divider-vertical pull-right"></div>
                    <div class="clearfix"></div>

                    <ul class="dropdown-menu">
                        <img src="http://localhost/goretreat/themes/user/resources/assets/images/topbanner.png" alt="Top banner" class="top_banner hidden-sm hidden-xs">
                        <li>
                            <form class="form form-booking" action="#">
                                <div class="form-group">
                                    <input type="text" class="" name="booking_id" placeholder="Booking ID" required="required" />
                                </div>

                                <div class="form-group">
                                    <input type="text" class="" name="mobile_number" placeholder="Mobile Number" required="required" />
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-booking">Submit</button>
                                </div>
                            </form>
                        </li>
                        <li class="divider"></li>

                        <span class="or-signin booking-divider">Or signin with your e-mail</span>
                        <li>
                            <div class="signin-auth">
                                <a href="#">
                                    <img src="http://localhost/goretreat/themes/user/resources/assets/images/social_buttons/sign-in.png" alt="Sign in"/>
                                </a>
                            </div>
                            <br />
                        </li>
                    </ul>

                </li>
                <li><a href="javascript:void(0)">Help</a></li>
            </ul>
        </div>
    </div>
    <script>
        var ROOT_PATH='http://localhost/goretreat/';
        var SITE_PATH='http://localhost/goretreat/index.php';
        var THEME_PATH="http://localhost/goretreat/themes/user";
        window.fbAsyncInit = function () {
            FB.init({
                appId: '861005110615945',
                cookie: true,
                xfbml: true,
                oauth: true
            });
        };

        (function () {
            var e = document.createElement('script');
            e.async = true;
            e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
            document.getElementById('fb-root').appendChild(e);
        }());
        function fb_login() {

            $.ajax({
                url: "http://localhost/goretreat/index.php/customer/setLoginFb/true",
                data: {},
                success: function (data) {
                    FB.Event.subscribe('auth.login', function (response) {
                        window.location.reload();
                    });
                    FB.Event.subscribe('auth.logout', function (response) {
                        window.location.reload();
                    });
                    FB.login(function (response) {
                        if (response.authResponse) {
                            FB.api('/me', function (response) {
//                    console.error('test')
                                location.reload();
//                                if (response.status == "connected") {
//                                    location.reload();
//                                }
                            });
                        }
                    }, {scope: 'email'});
                }
            });

        }
    </script>
</header>

        


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
                                <a href="#" class="list-group-item active">
                                    Platinum
                                </a>
                                <a href="#" class="list-group-item">
                                    Gold
                                </a>
                                <a href="#" class="list-group-item">
                                    Silver
                                </a>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12 bhoechie-tab">
                        <!-- flight section -->
                        <div class="col-sm-12 bhoechie-tab-content active platinum">
                        	<div class="col-sm-10 nopadding border_bottom">
                               <h3>Platinum Benefactors</h3>
                               <div class="clearfix"></div>
                               <div class="col-md-12">
                               		<p style="padding-left:0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat.</p>	
                               </div>
                           	</div>
                            <div class="col-sm-10 nopadding border_bottom padding-top-30">
                               	<div class="col-sm-5 col-md-4">
                               		<img src="resources/assets/images/preachers/2.jpg">
                               	</div>
                               	<div class="col-sm-7 col-md-8">
                               		<h3>Fr. Jaison</h3>
                               		<span>Australia</span>
                               		<div class="clearfix"></div><br>
                               		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat.</p>	
                               	</div>
                            </div>
                            <div class="clearfix"></div><br>
                            <div class="col-sm-10 nopadding border_bottom padding-top-30">
                               	<div class="col-sm-5 col-md-4">
                               		<img src="resources/assets/images/preachers/2.jpg">
                               	</div>
                               	<div class="col-sm-7 col-md-8">
                               		<h3>Fr. Jaison</h3>
                               		<span>Australia</span>
                               		<div class="clearfix"></div><br>
                               		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat.</p>	
                               	</div>
                            </div>
                            <div class="clearfix"></div><br>
                            <div class="col-sm-10 nopadding border_bottom padding-top-30" style="border-bottom:0;">
                               	<div class="col-sm-5 col-md-4">
                               		<img src="resources/assets/images/preachers/2.jpg">
                               	</div>
                               	<div class="col-sm-7 col-md-8">
                               		<h3>Fr. Jaison</h3>
                               		<span>Australia</span>
                               		<div class="clearfix"></div><br>
                               		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat.</p>	
                               	</div>
                            </div>
                            <div class="clearfix"></div><br>
                        </div>
                        <!-- train section -->
                         	<div class="col-sm-12 bhoechie-tab-content platinum">
	                        	<div class="col-sm-10 nopadding border_bottom">
	                               <h3>Gold Benefactors</h3>
	                               <div class="clearfix"></div>
	                               <div class="col-md-12">
	                               		<p style="padding-left:0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat.</p>	
	                               </div>
	                           	</div> 
	                           	<div class="clearfix"></div><br>
	                            <div class="col-sm-10 nopadding border_bottom padding-top-15">
	                               	<div class="col-sm-5 col-md-4 nopadding">
	                               		<h3>Fr. Jaison</h3>
	                               		<span>Australia</span>
	                               	</div>
	                               	<div class="col-sm-7 col-md-8">	                               		
	                               		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat.</p>	
	                               	</div>
	                            </div>
	                            <div class="col-sm-10 nopadding border_bottom padding-top-20">
	                               	<div class="col-sm-5 col-md-4 nopadding">
	                               		<h3>Fr. Jaison</h3>
	                               		<span>Australia</span>
	                               	</div>
	                               	<div class="col-sm-7 col-md-8">	                               		
	                               		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat.</p>	
	                               	</div>
	                            </div>
	                            <div class="col-sm-10 nopadding border_bottom padding-top-20" style="border-bottom:0;">
	                               	<div class="col-sm-5 col-md-4 nopadding">
	                               		<h3>Fr. Jaison</h3>
	                               		<span>Australia</span>
	                               	</div>
	                               	<div class="col-sm-7 col-md-8">	                               		
	                               		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat.</p>	
	                               	</div>
	                            </div>
	                        </div>

                        <!-- hotel search -->
                        <div class="col-sm-12 bhoechie-tab-content">
                            <h4 style="color:#4c93bb">Team</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus congue ut quam a vestibulum. Ut hendrerit turpis sit amet sollicitudin porta. Proin feugiat mollis euismod. Sed egestas vitae turpis quis placerat. Etiam egestas est a elit cursus, vitae dignissim leo pulvinar. Fusce neque enim, placerat quis massa sed, tincidunt bibendum ipsum. Donec interdum congue mauris quis lobortis. Fusce eget rutrum velit. Quisque quis ipsum blandit, semper libero id, vulputate est. Morbi id euismod risus. Integer nec velit malesuada, tincidunt ligula ac, consectetur arcu. Ut aliquam neque ex, ut eleifend neque mollis sed</p>
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


<!--Footer Banner-->
<section class="footer-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 nopadding">
            <div class="col-xs-3 col-sm-3 col-md-3 ">
                <img src="http://localhost/goretreat/themes/user/resources/assets/images/logo-white.png" class="img-responsive" alt="Logo" />
            </div>
            <div class="col-xs-7 col-sm-7 col-md-7 nopadding">
                <div class="footer-banner-line"></div>
                <i class="fa fa-chevron-right"></i>
            </div>

            <div class="col-xs-2 col-sm-2 col-md-2 nopadding">
                <span class="know-more pull-right" style="padding-right: 5px;">Know More</span>
            </div>
            </div>
        </div>
    </div>
</section>
<!--./ Footer banner-->        <!--Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            
            <div class="col-md-10 col-md-offset-1 nopadding">
            <div class="col-sm-2 col-md-2">
                <h5>About GoRetreat</h5>
                <div class="footer-border-bottom"></div>
                <ul>
                    <li>
                        <a href="#">
                            About
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Careers
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Press
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Blog
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Help
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Policies
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Terms & Privacy
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-2 col-md-2">
                <h5>Services</h5>
                <div class="footer-border-bottom"></div>
                <ul>
                    <li>
                        <a href="#">
                            Retreat Search
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Booking
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Travel Assistance
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Remainders
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Newsletters
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Updates and News
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Lives Changed
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-2 col-md-2">
                <h5>Support</h5>
                <div class="footer-border-bottom"></div>
                <ul>
                    <li>
                        <a href="#">
                            Chat With Us
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Send an Enquiry 
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Email Us
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Call Us
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-2 col-md-2">
                <h5>Legal</h5>
                <div class="footer-border-bottom"></div>
                <ul>
                    <li>
                        <a href="#">
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Terms & Conditions
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-4 col-md-4 nopadding">
                <div class="social pull-right padding-right-5">
                    <span>Follow us on</span>
                    <a href="#">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-facebook fa-stack-1x"></i>
                        </span>
                    </a>

                    <a href="#">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-twitter fa-stack-1x"></i>
                        </span>
                    </a>

                    <a href="#">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-youtube-play fa-stack-1x"></i>
                        </span>
                    </a>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="container-fluid copyright">
        <div class="col-md-12">
            <div class="col-md-10 col-md-offset-1 ">
            <div class="col-md-12">
            <div class="col-md-12">
                <div class="col-md-12" style="padding-right: 0px;">
                <p class="pull-right">Copyright &copy; 2015-2016  goretreat.com. All rights reserved</p>
            </div>
            </div>
            </div>
            </div>
        </div>
    </div>
</footer>
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
