<style>
    i.fa{
        height: 10px;
    }
</style>
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url('/dashboard'); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="<?php echo base_url($theme_path); ?>/images/logo.png" class="img-responsive"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="<?php echo base_url($theme_path); ?>/images/logo.png" class="img-responsive"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php  if (isset($current_user->avatar) && !empty($current_user->avatar) ) { ?>
                            <img class="user-image" src="<?php echo $current_user->avatar; ?>">
                        <?php } else { ?>
                            <img class="user-image" src="<?php echo base_url($theme_path . 'images/pp.jpg'); ?>" alt="" />
                        <?php } ?>
                        <span class="hidden-xs"><?= $current_user->first_name.' '.$current_user->last_name ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php  if (isset($current_user->avatar) && !empty($current_user->avatar) ) { ?>
                            <img src="<?php echo $current_user->avatar; ?>" class="img-circle" alt="User Image" />
                        <?php } else { ?>
                            <img  src="<?php echo base_url($theme_path . 'images/pp.jpg'); ?>" class="img-circle" alt="User Image" />
                        <?php } ?>
                            
                            <p>
                                <?= $current_user->first_name.' '.$current_user->last_name ?>
                                <small><strong><?= $this->session->userdata('current_centre_role')->role ?></strong></small>
                                <small>Member since <?= date("M. Y",  strtotime($current_user->activated_at)) ?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <!--                    -->
                            <div class="col-xs-4 text-center">
                                <a href="#">Settings</a>
                            </div>
                            <div class="col-xs-4 text-center">
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Profile</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Lock Screen</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?=  site_url('logout')?>" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </div>
    </nav>
</header>
