<!DOCTYPE html>
<html  itemscope itemtype="http://schema.org/WebSite" lang="en">

    <?php echo $template['partials']['head']; ?>

    <body class="<?=(isset($body_class) && $body_class)?$body_class:''?>">

        <?php echo $template['partials']['header']; ?>
        <?php echo $template['body']; ?>
        <?php echo $template['partials']['footerbanner']; ?>
        <?php echo $template['partials']['footer']; ?>

    </body>

</html>
