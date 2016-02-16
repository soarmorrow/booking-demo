<!--Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">

            <div class="col-md-10 col-md-offset-1 nopadding">
                <div class="col-sm-2 col-md-2">
                    <h5>About GoRetreat</h5>
                    <div class="footer-border-bottom"></div>
                    <ul>
                        <li>
                            <a href="<?= site_url('home/about_us') ?>">
                                About
                            </a>
                        </li>
                        <!-- <li>
                            <a href="#">
                                Careers
                            </a>
                        </li> -->
                        <li>
                            <a href="#">
                                Press
                            </a>
                        </li>
                        <li>
                            <a href="<?=site_url('blogs')?>">
                                Blog
                            </a>
                        </li>
                        <!-- <li>
                            <a href="<?=site_url('home/help')?>">
                                Help
                            </a>
                        </li> -->
                    </ul>
                </div>
                <div class="col-sm-2 col-md-2">
                    <h5>Services</h5>
                    <div class="footer-border-bottom"></div>
                    <ul>
                        <li>
                            <a href="<?=site_url('search/clearsearch')?>">
                                Retreat Search
                            </a>
                        </li>
                        <li>
                            <a href="<?=($this->gr_auth->logged_in()) ? site_url('user_dashboard/mybookings') : site_url('home/sign_in')?>">
                                Booking
                            </a>
                        </li>
                        <!-- <li>
                            <a href="#">
                                Travel Assistance
                            </a>
                        </li> -->
                        <!-- <li>
                            <a href="#">
                                Reminders
                            </a>
                        </li> -->
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
                            <a href="https://goretreat.freshdesk.com/support/home">
                                Help
                            </a>
                        </li>
                        <!-- <li>
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
                        </li> -->
                    </ul>
                </div>

                <div class="col-sm-2 col-md-2">
                    <h5>Legal</h5>
                    <div class="footer-border-bottom"></div>
                    <ul>
                        <li>
                            <a href="<?=site_url('home/privacy')?>">
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="<?=site_url('home/terms')?>">
                                Terms & Conditions
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-4 col-md-4 nopadding">
                    <div class="social pull-right padding-right-5">
                        <span>Follow us on</span>
                        <a href="https://www.facebook.com/goretreatmedia" target="_blank">
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-facebook fa-stack-1x"></i>
                            </span>
                        </a>

                        <a href="https://twitter.com/goretreatmedia" target="_blank">
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-twitter fa-stack-1x"></i>
                            </span>
                        </a>

                        <a href="https://www.youtube.com/goretreat" target="_blank">
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
                            <p class="text-center">Copyright &copy; 2015-2016  goretreat.com. All rights reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php
echo js_tag(array_merge(array(
    $theme_path . 'resources/jquery/jquery.min.js',
    $theme_path . 'resources/bootstrap/js/bootstrap.min.js',
    $theme_path . 'resources/material/dist/js/material.min.js',
    $theme_path . 'resources/material/dist/js/ripples.min.js',
    $theme_path . 'resources/assets/js/plugins/jquery.ddslick.min.js',
    $theme_path . 'resources/assets/js/plugins/jquery.sticky.js',
    $theme_path . 'resources/assets/selectize/selectize.min.js',
    $theme_path . 'resources/assets/js/plugins/moment.js',
    $theme_path . 'resources/material_timepicker/js/bootstrap-material-datetimepicker.js',
    $theme_path . 'resources/assets/js/common.js',
    $theme_path . 'resources/assets/js/plugins/angular.min.js'
                ), $javascripts));
?>

    <?php
    $country_selected=$this->session->userdata('country_selected');
    if(!$country_selected){
        $country_selected=98;
    }
    ?>
<script>

    //sector design
//    $('select[name="language"]').ddslick({
//        width: 80,
//        background: '#fff',
//        defaultSelectedIndex:1
//    });
    $(document).ready(function () {
        $('.dd-option').click(function () {
            var id = $(this).find('.dd-option-value').val();
            $.ajax({
                url: "<?= site_url('home/selectLanguage') ?>",
                type: 'POST',
                data: {country: id},
                dataType: 'JSON',
                success: function (data) {
                    location.reload();
//                    console.log(data);
                }
            });
        });
        var searchBy = '<?= $country_selected ?>';
        $('#language li').each(function (index) {
            //traverse all the options and get the value of current item
            var curValue = $(this).find('.dd-option-value').val();
            //check if the value is matching with the searching value
            if (curValue == searchBy)
            {
                //if found then use the current index number to make selected    
                $('#language').ddslick('select', {index: $(this).index()});
            }
        });
    });
</script>