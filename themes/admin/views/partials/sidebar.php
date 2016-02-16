
<!-- sidebar -->
<section class="sidebar">

    <ul class="sidebar-menu">

        <li <?php echo ( in_array($current_controller, array('dashboard'))) ? 'class="active treeview"' : 'treeview'; ?>>
            <a href="<?= site_url('dashboard') ?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
            </a>
        </li>

        <?php
        if (_can("User")) {
            ?>
            <li <?php echo ( in_array($current_controller, array('user'))) ? 'class="active treeview"' : 'treeview'; ?>>
                <a href="<?= site_url('user') ?>">
                    <i class="fa fa-group"></i>
                    <span>Admin</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php echo ( in_array($current_controller_method, array('index'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('user') ?>"><i class="fa fa-list"></i> List All</a></li>
                    <li <?php echo ( in_array($current_controller_method, array('adduser'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('user/adduser') ?>"><i class="fa fa-user-plus"></i> Add New</a></li>

                </ul>
            </li>
            <?php
        }
        if (_can("Customer")) {
            ?>
            <li <?php echo ( in_array($current_controller, array('customer'))) ? 'class="active treeview"' : 'treeview'; ?>>
                <a href="">
                    <i class="fa fa-group"></i>
                    <span>Customers</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php echo ( in_array($current_controller_method, array('index'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('customers') ?>"><i class="fa fa-list"></i> List All</a></li>
                </ul>
            </li>
            <?php
        }


        if (_can('Relation')) {
            ?>
            <li <?php echo ( in_array($current_controller, array('relation'))) ? 'class="active treeview"' : 'treeview'; ?>>
                <a href="">
                    <i class="fa fa-hdd-o"></i>
                    <span>Relations</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">                    
                    <li <?php echo ( in_array($current_controller_method, array('index'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('relation') ?>"><i class="fa fa-clipboard"></i> Role Module</a></li>
                    <li <?php echo ( in_array($current_controller_method, array('addrole'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('relation/addrole') ?>"><i class="fa fa-plus"></i> Roles</a></li>
                    <li <?php echo ( in_array($current_controller_method, array('usermodule'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('relation/usermodule') ?>"><i class="fa fa-user-plus"></i> User role</a></li>
                </ul>
            </li>
            <?php
        }
        ?>
        <?php
        if (_can('Center')) {
            ?>
            <li <?php echo ( in_array($current_controller, array('centre'))) ? 'class="active treeview"' : 'treeview'; ?>>
                <a href="<?= site_url('centre') ?>">
                    <i class="fa fa-building-o"></i>
                    <span>Center</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php echo ( in_array($current_controller_method, array('index'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('centre') ?>"><i class="fa fa-list"></i>
                            List All</a></li>
                    <li <?php echo ( in_array($current_controller_method, array('categories'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('centre/categories') ?>"><i class="fa fa-cog"></i> Categories</a></li>
                    <li <?php echo ( in_array($current_controller_method, array('rctypes'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('centre/rctypes') ?>"><i class="fa fa-cog"></i> Types</a></li>
                    <li <?php echo ( in_array($current_controller_method, array('testimonial'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('centre/testimonial') ?>"><i class="fa fa-pencil-square-o"></i>
                            Testimonial</a></li>
                </ul>
            </li>
            <?php
        }
        ?>
        <?php
        if (_can("Blog")) {
            ?>
            <li <?php echo ( in_array($current_controller, array('blog'))) ? 'class="active treeview"' : 'treeview'; ?>>
                <a href="">
                    <i class="fa fa-edit"></i>
                    <span>Blog</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php echo ( in_array($current_controller_method, array('index', 'view', 'update'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('blog') ?>"><i class="fa fa-list"></i> List All</a></li>

                    <li <?php echo ( in_array($current_controller_method, array('addnew'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('blog/addnew') ?>"><i class="fa fa-plus"></i> Add New</a></li>

                </ul>
            </li>
            <?php
        }
        if (_can("Preachers")) {
            ?>
            <li <?php echo ( in_array($current_controller, array('event')) && in_array($current_controller_method, array('preachers', 'preacher_edit', 'preacher_add', 'languages', 'preachers_status', 'area_of_expertise'))) ? 'class="active treeview"' : 'treeview'; ?>>
                <a href="">
                    <i class="fa fa-edit"></i>
                    <span>Preachers</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php echo ( in_array($current_controller_method, array('preachers', 'preacher_edit', 'preacher_add'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('event/preachers') ?>"><i class="fa fa-user"></i>Preachers</a></li>
                    <?php
                    if (_is("GR Admin")) {
                        ?>
                        <li <?php echo ( in_array($current_controller_method, array('languages'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('event/languages') ?>"><i class="fa fa-language"></i>Languages</a></li>
                        <li <?php echo ( in_array($current_controller_method, array('preachers_status'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('event/preachers_status') ?>"><i class="fa fa-user"></i>Preacher status</a></li>
                        <li <?php echo ( in_array($current_controller_method, array('area_of_expertise'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('event/area_of_expertise') ?>"><i class="fa fa-user"></i>Area of expertise</a></li>
                        <li <?php echo ( in_array($current_controller_method, array('area_of_expertise'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('event/approve_existing_preachers') ?>"><i class="fa fa-user"></i>Approve existing preachers</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </li>
            <?php
        }

        if (_can("Event")) {
            ?>
            <li <?php echo ( in_array($current_controller, array('event')) && !in_array($current_controller_method, array('preachers', 'preacher_edit', 'preacher_add', 'languages', 'preachers_status', 'area_of_expertise'))) ? 'class="active treeview"' : 'treeview'; ?>>
                <a href="">
                    <i class="fa fa-calendar"></i>
                    <span>Events</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php
                    if (_is("GR Admin")) {
                        ?>
                        <li <?php echo ( in_array($current_controller_method, array('eventtypes'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('event/eventtypes') ?>"><i class="fa fa-cog"></i>Event Types</a></li>

                        <?php
                    }
                    ?>

                    <li <?php echo ( in_array($current_controller_method, array('index', 'view', 'update'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('event') ?>"><i class="fa fa-list"></i> List All</a></li>
                    <li <?php echo ( in_array($current_controller_method, array('addnew'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('event/addnew') ?>"><i class="fa fa-plus"></i> Add New</a></li>
                    <li <?php echo ( in_array($current_controller_method, array('accomodation'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('event/accomodation') ?>"><i class="fa fa-plus"></i> Accomodation type</a></li>
                    <?php if (_can("Promo Code")) { ?>
                        <li <?php echo ( in_array($current_controller_method, array('promocode', 'promocrowd'))) ? 'class="active"' : 'treeview'; ?>><a href=""><i class="fa fa-volume-off"></i> Promo Code<i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li <?php echo ( in_array($current_controller_method, array('promocode'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('event/promocode') ?>"><i class="fa fa-plus"></i> Add</a></li>
                                <li><a href="<?= site_url('event/promocrowd') ?>"><i class="fa fa-circle-o"></i> Crowd funding</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li <?php echo ( in_array($current_controller_method, array('testimonial'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('event/testimonial') ?>"><i class="fa fa-pencil-square-o"></i>
                            Testimonial</a></li>
                </ul>
            </li>
            <?php
        }
        if (_can("News letter")) {
            ?>
            <li <?php echo ( in_array($current_controller, array('newsletter'))) ? 'class="active treeview"' : 'treeview'; ?>>
                <a href="">
                    <i class="fa fa-edit"></i>
                    <span>News letter</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php echo ( in_array($current_controller_method, array('sendnew', 'selecttheme'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('newsletter/selecttheme') ?>"><i class="fa fa-plus"></i> Send New</a></li>
                    <li <?php echo ( in_array($current_controller_method, array('groups'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('newsletter/groups') ?>"><i class="fa fa-plus"></i>Groups</a></li>
                    <li <?php echo ( in_array($current_controller_method, array('subscribers'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('newsletter/subscribers') ?>"><i class="fa fa-list"></i>Subscribers</a></li>
                    <li <?php echo ( in_array($current_controller_method, array('index', 'view', 'update'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('newsletter') ?>"><i class="fa fa-list"></i> History</a></li>
                </ul>
            </li>
            <?php
        }

        if (_can("Analytics")) {
            ?>
            <li <?php echo ( in_array($current_controller, array('analytics'))) ? 'class="active treeview"' : 'treeview'; ?>>
                <a href="">
                    <i class="fa fa-bar-chart"></i>
                    <span>Analytics</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php echo ( in_array($current_controller_method, array('index'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('analytics') ?>"><i class="fa fa-building-o"></i> Center </a></li>
                </ul>
            </li>
            <?php
        }
        if (_can("Home Slider")) {
            ?>
            <li <?php echo ( in_array($current_controller, array('home_slider'))) ? 'class="active treeview"' : 'treeview'; ?>>
                <a href="">
                    <i class="fa fa-picture-o"></i>
                    <span>Home Slider</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php echo ( in_array($current_controller_method, array('images'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('home_slider') ?>"><i class="fa fa-building-o"></i> List All </a></li>
                    <li <?php echo ( in_array($current_controller_method, array('index'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('home_slider/add_new_image') ?>"><i class="fa fa-plus"></i> Add New Image </a></li>
                </ul>
            </li>
            <?php
        }

        if (_can("Finance")) {
            ?>
            <li <?php echo ( in_array($current_controller, array('finance', 'booking'))) ? 'class="active treeview"' : 'treeview'; ?>>
                <a href="">
                    <i class="fa fa-money"></i>
                    <span>Finance</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <?php
                    if (_is('GR Admin')) {
                        ?>
                        <li <?php echo ( in_array($current_controller, array('finance'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('finance') ?>"><i class="fa fa-building"></i> Booking (Centers)</a></li>
                        <?php
                    }
                    ?>
                    <li <?php echo ( in_array($current_controller, array('booking'))) ? 'class="active"' : 'treeview'; ?>><a href="<?= site_url('booking') ?>"><i class="fa fa-cart-plus"></i> Booking (Events)</a></li>
                </ul>
            </li>
            <?php
        }

        if (_is("RC Admin")) {
            ?>
            <li <?php echo ( in_array($current_controller, array('center_profile'))) ? 'class="active treeview"' : 'treeview'; ?>>
                <a href="<?= site_url('center_profile') ?>">
                    <i class="fa fa-info"></i>
                    <span>Center Profile</span>
                </a>
            </li>
            <?php
        }
        ?>
    </ul>
</section>
<!-- /.sidebar -->
