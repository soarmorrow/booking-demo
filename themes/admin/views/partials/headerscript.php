<?php
echo js_tag(array_merge(array(
    $theme_path . 'plugins/jQuery/jQuery-2.1.4.min.js',
    'http://code.jquery.com/ui/1.11.2/jquery-ui.min.js',
    $theme_path . 'bootstrap/js/bootstrap.min.js',
    'http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
    $theme_path . 'plugins/morris/morris.min.js',
    // $theme_path . 'jui/js/jquery-ui-timepicker-addon.js', //this is latest version timepicker
    $theme_path . 'plugins/sparkline/jquery.sparkline.min.js', //this is old version of timepicker
    $theme_path . 'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
    $theme_path . 'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
    $theme_path . 'plugins/knob/jquery.knob.js',
    'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js',
    $theme_path . 'plugins/daterangepicker/daterangepicker.js',
    $theme_path . 'plugins/datepicker/bootstrap-datepicker.js',
    $theme_path . 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
    $theme_path . 'plugins/slimScroll/jquery.slimscroll.min.js',
    $theme_path . 'plugins/fastclick/fastclick.min.js',
    $theme_path . 'dist/js/app.min.js',
    $theme_path . 'dist/js/pages/dashboard.js',
    $theme_path . 'dist/js/demo.js'
                ), $javascripts));
?>

<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
