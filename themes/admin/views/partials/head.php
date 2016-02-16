<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title><?php echo $template['title']; ?></title>
    <link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url('themes/admin/images/favicon.png') ?> '/>
    <?php
    echo css_tag(array_merge(array(
        $theme_path . 'bootstrap/css/bootstrap.min.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        // 'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        $theme_path . 'dist/css/AdminLTE.min.css',
        $theme_path . 'dist/css/skins/_all-skins.css',
        $theme_path . 'plugins/iCheck/flat/blue.css',
        $theme_path . 'plugins/morris/morris.css',
        $theme_path . 'plugins/jvectormap/jquery-jvectormap-1.2.2.css',
        $theme_path . 'plugins/datepicker/datepicker3.css',
        $theme_path . 'plugins/daterangepicker/daterangepicker-bs3.css',
        $theme_path . 'plugins/timepicker/bootstrap-timepicker.css',
        $theme_path . 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
                    ), $stylesheets));
    echo js_tag(array_merge(array(
        $theme_path . 'plugins/jQuery/jQuery-2.1.4.min.js',
        'http://code.jquery.com/ui/1.11.2/jquery-ui.min.js',
        $theme_path . 'bootstrap/js/bootstrap.min.js',
        'http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
        $theme_path . 'plugins/morris/morris.min.js',
//         $theme_path . 'jui/js/jquery-ui-timepicker-addon.js', //this is latest version timepicker
        $theme_path . 'plugins/sparkline/jquery.sparkline.min.js', //this is old version of timepicker
        $theme_path . 'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        $theme_path . 'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        $theme_path . 'plugins/knob/jquery.knob.js',
        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js',
        $theme_path . 'plugins/daterangepicker/daterangepicker.js',
        $theme_path . 'plugins/datepicker/bootstrap-datepicker.js',
        $theme_path . 'plugins/sweetalert/sweetalert.min.js',
        'https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js',
        $theme_path . 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        $theme_path . 'plugins/timepicker/bootstrap-timepicker.js',
        $theme_path . 'plugins/slimScroll/jquery.slimscroll.min.js',
        $theme_path . 'plugins/fastclick/fastclick.min.js',
        $theme_path . 'plugins/iCheck/icheck.min.js',
        $theme_path . 'dist/js/app.min.js',
        $theme_path . 'dist/js/pages/dashboard.js',
        $theme_path . 'dist/js/demo.js',
//         $theme_path . 'plugins/jQuery/jQuery-2.1.4.min.js'
                    ), $javascripts));
    ?>

    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
