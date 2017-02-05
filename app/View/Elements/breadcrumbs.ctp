<script type="text/javascript">
    try {
        ace.settings.check('breadcrumbs', 'fixed')
    } catch (e) {
    }
</script>

<ul class="breadcrumb">
    <li>
        <i class="icon-home home-icon"></i>
        <?php echo $this->Html->link('Dashboard', array('controller'=>'users','action'=>'dashboard'), array('escape' => false))?>
    </li>
    <li class="active"><?php echo $pageTitle; ?></li>
</ul>
<!-- .breadcrumb -->