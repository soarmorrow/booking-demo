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
        <a class="navbar-brand" href="<?= site_url() ?>"><img src="<?= base_url($theme_path . 'resources/assets/images/logo.png') ?>" alt="GoRetreat"
          class="img-responsive" draggable="false"/></a>
      </div>
      <div class="navbar-collapse collapse navbar-responsive-collapse">
        <a href="<?=site_url('home/centre_list')?>" class="btn btn-default btn-list listyourcenter"><i class="fa fa-plus"></i>List<span class="listtext"> Your Centre</span></a>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <select name="language" id="language">
                    <option  value="98"
                    data-imagesrc="http://www.virology.path.cam.ac.uk/Division_of_Virology/People_files/india_flag.png"></option>
                    <option value="13" 
                    data-imagesrc="http://www.earthcarefilms.com/images/flag/Australia.png"></option>
                    <option value="227"
                    data-imagesrc="http://www.houseofproctor.org/genealogy/hop_state_icons/us_flag.png"></option>
                    <option value="30"
                    data-imagesrc="http://www.earthcarefilms.com/images/flag/Brazil.png"></option>
                </select>
            </li>
            <li class="dropdown <?php
            if (!isset($current_user->id)) {
                echo 'hidden';
            }
            ?>">
            <a href="#" data-target="#" class="dropdown-toggle pull-left" data-toggle="dropdown">Hello <?= isset($current_user->first_name) ? ucfirst(substr($current_user->first_name, 0, 11)) : ''; ?><b
                class="caret"></b></a>

                <div class="divider-vertical pull-right">

                </div><div class="clearfix"></div>
                <ul class="dropdown-menu">
                    <li>
                        <?php
                        if (isset($current_user->id)) {
                            ?>                
                            <a href="<?= site_url('home/profile') ?>/<?= $current_user->id ?> ">
                                Profile
                            </a>
                            <?php
                        }
                        ?>
                    </li>
                    <li>
                        <a href="<?= site_url('customer/logout') ?> ">
                            Sign Out
                        </a>
                    </li>
                </ul>
            </li>


            <li class="dropdown <?php
            if (isset($current_user->id)) {
                echo 'hidden';
            }
            ?>">
            <a href="#" data-target="#" class="dropdown-toggle pull-left" data-toggle="dropdown">Sign in <b
                class="caret"></b></a>

                <div class="divider-vertical pull-right">

                </div><div class="clearfix"></div>
                <ul class="dropdown-menu">
                    <img src="<?= base_url($theme_path . 'resources/assets/images/topbanner.png') ?>" alt="Top banner" class="top_banner hidden-sm hidden-xs">
                    <li>
                        <div class="g-auth" onclick="window.location.href = '<?= site_url('google') ?>'">
                            <a href="#">
                                <img src="<?= base_url($theme_path . 'resources/assets/images/social_buttons/gplus.png') ?>" alt="Google+"/>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="facebook-auth"  onclick="fb_login()" style="cursor: pointer">
                            <img src="<?= base_url($theme_path . 'resources/assets/images/social_buttons/fb.png') ?>" alt="Facebook"/>

                        </div>
                    </li>
                    <li class="divider"></li>
                    <span class="or-signin">Or signin with your e-mail</span>
                    <li>
                        <div class="signin-auth">
                            <a href="<?= site_url('home/sign_in') ?>">
                                <img src="<?= base_url($theme_path . 'resources/assets/images/social_buttons/sign-in.png') ?>" alt="Sign in"/>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="signup-auth">
                            <a href="<?= site_url('home/sign_up') ?>">
                                <img src="<?= base_url($theme_path . 'resources/assets/images/social_buttons/signup.png') ?>" alt="Signup"/>
                            </a>
                        </div>
                    </li>
                </ul>

            </li>
            <li>
                <?php
                if (isset($current_user->id)) {
                    ?> 
                    <a href="#" data-toggle="dropdown" data-target="#" class="dropdown-toggle pull-left">Manage Booking <b class="caret"></b></a>

                    <div class="divider-vertical pull-right"></div>
                    <div class="clearfix"></div>

                    <ul class="dropdown-menu">
                        <img src="<?= base_url($theme_path . 'resources/assets/images/topbanner.png') ?>" alt="Top banner" class="top_banner hidden-sm hidden-xs">

                        
                        <li>            
                            <a href="<?= site_url('user_dashboard') ?>">
                                View Bookings
                            </a>

                        </li>
                        
                    </ul>
                    <?php
                } 
                ?>
            </li>
            <li><a href="https://goretreat.freshdesk.com/support/home">Help</a></li>
        </ul>
    </div>
</div>
<script>
    var ROOT_PATH = '<?= base_url() ?>';
    var SITE_PATH = '<?= site_url() ?>';
    var THEME_PATH = "<?= base_url($theme_path) ?>";
    window.fbAsyncInit = function () {
        FB.init({
            appId: '<?php echo $this->facebook->getAppID() ?>',
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
            url: "<?= site_url("customer/setLoginFb/true") ?>",
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
    window.location = "<?= site_url('home') ?>";
    //location.reload();
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

