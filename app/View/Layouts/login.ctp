<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $title_for_layout; ?>
    </title>
    <?php
    echo $this->Html->meta('icon');

    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('font-awesome.min'); ?>

    <!--[if IE 7]>
    <?php echo $this->Html->css('font-awesome-ie7.min'); ?>
    <![endif]-->

    <?php
    echo $this->Html->css('ace-fonts');
    echo $this->Html->css('ace.min');
    echo $this->Html->css('ace-rtl.min');
    echo $this->Html->css('style');
    ?>
    <!--[if lte IE 8]>
    <?php echo $this->Html->css('ace-ie.min'); ?>
    <![endif]-->

    <?php echo $this->Html->script('jquery.min');?>
    <?php
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
    <!-- inline styles related to this page -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <?php
    echo $this->Html->script('html5shiv');
    echo $this->Html->script('respond.min');
    ?>
    <![endif]-->


</head>
<body class="login-layout">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container" id="login-container">
                    <?php echo $content_for_layout; ?>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</div>
<!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->

<!--<script type="text/javascript">
    window.jQuery || document.write("<script src='js/jquery-2.0.3.min.js'>" + "<" + "/script>");
</script>-->
<?php echo $this->Html->script('jquery-2.0.3.min'); ?>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='js/jquery-1.10.2.min.js'>" + "<" + "/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if ("ontouchend" in document) document.write("<script src='js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>

<!-- inline scripts related to this page -->

<script type="text/javascript">
    function show_box(id) {
        jQuery('.widget-box.visible').removeClass('visible');
        jQuery('#' + id).addClass('visible');
    }
</script>
<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
