<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title><?php echo $template['title']; ?></title>
    <link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url('themes/parent/images/favicon.ico') ?> '/>
    <?php
    echo css_tag(array_merge(array(
        $theme_path . 'bootstrap/css/bootstrap.min.css',
        $theme_path.'dist/css/AdminLTE.min.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        $theme_path . 'plugins/iCheck/square/blue.css'
                    ), $stylesheets));
    echo js_tag(array(
    $theme_path . 'plugins/jQuery/jQuery-2.1.4.min.js',
    $theme_path . 'bootstrap/js/bootstrap.min.js',
    $theme_path . 'plugins/iCheck/icheck.min.js'
));
    ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>