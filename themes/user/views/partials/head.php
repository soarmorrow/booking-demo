<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Vineeth N Krishnan">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<!-- made by www.metatags.org -->
<meta name="description"
      content="<?=(isset($meta) && $meta)?$meta->content:'GoRetreat.com - a retreat booking site, in the making. This will be a place where retreat centres can publish their retreats and you can search, find and book them. The main challenges are to create a'?>"/>
<meta name="keywords" content="goretreat, retreat, cathedral, event, booking, online, center, retreat centres"/>
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="6 month">



<title><?=(isset($meta) && $meta)?$meta->title :'GoRetreat :: Book Events on your Favorite retreat center'?></title>
<!-- goretreat, cathedral, retreat -->




<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="<?=(isset($meta) && $meta)?$meta->title :'GoRetreat :: Book Events on your Favorite retreat center'?>">
<meta itemprop="description" content="<?=(isset($meta) && $meta)? substr($meta->content, 0, 200) :'GoRetreat.com - a retreat booking site, in the making. This will be a place where retreat centres can publish their retreats and you can search, find and book them. The main challenges are to create a'?>">
<meta itemprop="image" content="<?=(isset($meta) && $meta)?base_url($meta->path) :base_url('themes/user/resources/assets/images/logo.png') ?>">

<!-- Twitter Card data -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@way2vineeth">
<meta name="twitter:title" content="<?=(isset($meta) && $meta)?$meta->title :'GoRetreat :: Book Events on your Favorite retreat center'?>">
<meta name="twitter:description" content="<?=(isset($meta) && $meta)? substr($meta->content, 0, 200) :'GoRetreat.com - a retreat booking site, in the making. This will be a place where retreat centres can publish their retreats and you can search, find and book them. The main challenges are to create a'?>">
<meta name="twitter:creator" content="@way2vineeth">
<!-- Twitter summary card with large image must be at least 280x150px -->
<meta name="twitter:image:src" content="<?=(isset($meta) && $meta)?base_url($meta->path) :base_url('themes/user/resources/assets/images/logo.png') ?>">

<!-- Open Graph data -->
<meta property="og:title" content="<?=(isset($meta) && $meta)?$meta->title :'GoRetreat :: Book Events on your Favorite retreat center'?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="<?=site_url()?>" />
<meta property="og:image" content="<?=(isset($meta) && $meta)?base_url($meta->path) :base_url('themes/user/resources/assets/images/logo.png') ?>" />
<meta property="og:description" content="<?=(isset($meta) && $meta)? substr($meta->content, 0, 200) :'GoRetreat.com - a retreat booking site, in the making. This will be a place where retreat centres can publish their retreats and you can search, find and book them. The main challenges are to create a'?>" />
<meta property="og:site_name" content="GoRetreat" />
<meta property="article:published_time" content="<?=(isset($meta) && $meta)?$meta->timestamp:''?>" />
<meta property="article:modified_time" content="" />
<meta property="article:section" content="Article Section" />
<meta property="article:tag" content="GoRetreat" />
<meta property="fb:admins" content="1731064127129378" /> 


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="<?= base_url($theme_path . 'resources/assets/js/plugins/html5shiv.js') ?>"></script>
<script src="<?= base_url($theme_path . 'resources/assets/js/plugins/respond.min.js') ?>"></script>
<![endif]-->

<?php
echo css_tag(array_merge(array(
    $theme_path . 'resources/bootstrap/css/bootstrap.min.css',
    $theme_path . 'resources/assets/css/plugins/animate.min.css',
    $theme_path . 'resources/assets/selectize/selectize.css',
    $theme_path . 'resources/assets/fontawesome/css/font-awesome.min.css',
    'https://fonts.googleapis.com/icon?family=Material+Icons',
    $theme_path . 'resources/material/dist/css/material-fullpalette.min.css',
    $theme_path . 'resources/material/dist/css/ripples.min.css',
    $theme_path . 'resources/material/dist/css/roboto.min.css',
    $theme_path . 'resources/material_timepicker/css/bootstrap-material-datetimepicker.css',
    $theme_path . 'resources/assets/css/common.css',
    $theme_path . 'resources/assets/css/custom.css'
                ), $stylesheets));
?>

<?php
echo js_tag(array_merge(array(
$theme_path . 'resources/jquery/jquery.min.js',
$theme_path . 'resources/assets/js/countries.js'
 ), $javascripts));
?>
<!--favicon-->
<link rel="shortcut icon" href="<?= base_url($theme_path . 'resources/assets/images/fav.png') ?>" type="image/x-icon"/>

<link href="http://vjs.zencdn.net/5.3.0/video-js.css" rel="stylesheet">
