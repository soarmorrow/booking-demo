<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function debug($var, $label = 'Debug Data') {
    echo '<h1>' . $label . '</h1><pre>';
    print_r($var);
    echo '</pre>';
    exit();
}

function debug_continue($var, $label = 'Debug Data') {
    echo '<h1>' . $label . '</h1><pre>';
    print_r($var);
    echo '</pre>';
}

function debug_html($var, $label = 'Debug Data') {
    ?>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <!-- Viewport metatags -->
            <meta name="HandheldFriendly" content="true">
            <meta name="MobileOptimized" content="320">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

            <!-- iOS webapp metatags -->
            <meta name="apple-mobile-web-app-capable" content="yes">
            <meta name="apple-mobile-web-app-status-bar-style" content="black">
            <title>Staffs Portal</title>
            <meta http-equiv="Cache-Control" content="no-cache">
            <meta http-equiv="Pragma" content="no-cache">
            <meta http-equiv="Expires" content="0">
        </head>
        <body>
    <?php
    echo '<h1>' . $label . '</h1><pre>';
    print_r($var);
    echo '</pre>';
    ?>
        </body>
    </html>
    <?php
    exit();
}
