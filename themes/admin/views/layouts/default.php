<!DOCTYPE html>
<html>

    <?php echo $template['partials']['head']; ?>
        <?php // echo $template['partials']['headerscript']; ?>
    
    <body  class="skin-blue sidebar-mini wysihtml5-supported">
        <div id="wrapper" class="fluid" style="background-color: #1C5B80">

            <?php echo $template['partials']['header']; ?>

            <aside class="main-sidebar">
                <?php echo $template['partials']['sidebar']; ?>
            </aside>
            
            <div class="content-wrapper">
                <?php echo $template['body']; ?>
            </div>

            <?php echo $template['partials']['footer']; ?>
            <!--<?php echo $template['partials']['footer_notify']; ?>-->
            
        </div>

    </body>

</html>
