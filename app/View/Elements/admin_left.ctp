<script type="text/javascript">
    try {
        // ace.settings.check('sidebar', 'fixed')
    } catch (e) {
    }
</script>

<div class="sidebar-shortcuts" id="sidebar-shortcuts">
    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
        <button class="btn btn-success">
            <i class="icon-signal"></i>
        </button>

        <button class="btn btn-info">
            <i class="icon-pencil"></i>
        </button>

        <button class="btn btn-warning">
            <i class="icon-group"></i>
        </button>

        <button class="btn btn-danger">
            <i class="icon-cogs"></i>
        </button>
    </div>

    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
        <span class="btn btn-success"></span>

        <span class="btn btn-info"></span>

        <span class="btn btn-warning"></span>

        <span class="btn btn-danger"></span>
    </div>
</div>
<!-- #sidebar-shortcuts -->

<ul class="nav nav-list">
    
    <?php
    $dashBoardStatus = '';
    $singleMenuClass = '';

    if ($this->params['controller'] == 'users' && $this->params['action'] == 'dashboard') {
        $singleMenuClass = 'active';
    } else {
        $singleMenuClass = '';
    }
    ?>
    <li class="<?php echo $singleMenuClass; ?>">
        <?php echo $this->Html->link('<i class="icon-dashboard"></i><span class="menu-text"> Dashboard </span>', array('controller'=>'users','action'=>'dashboard'), array('escape' => false))?>
    </li>
    <?php
    $userMain = '';
    $userSub = '';
    if ($this->params['controller'] == 'admins') {
        $userMain = 'open';
        $userSub = 'style="display:block;"';
    }
    ?>
    <li class="<?php echo $userMain; ?>">
        <a href="#" class="dropdown-toggle">
            <i class="icon-user"></i>
            <span class="menu-text"> Lawyers </span>
            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu" <?php echo $userSub; ?>>
            <li>
                <?php echo $this->Html->link('<i class="icon-double-angle-right"></i> List ', array('controller'=>'admins','action'=>'manageLawyers', 'admin' => false), array('escape' => false))?>
            </li>
            <li>
                <?php echo $this->Html->link('<i class="icon-double-angle-right"></i> Add ', array('controller'=>'admins','action'=>'addLawyer', 'admin' => false), array('escape' => false))?>
            </li>
        </ul>
    </li>
    <li>
        <?php echo $this->Html->link('<i class="icon-off"></i> Logout ', array('controller'=>'users','action'=>'logout', 'admin' => false), array('escape' => false))?>
    </li>
</ul>
<!-- /.nav-list -->

<div class="sidebar-collapse" id="sidebar-collapse">
    <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
</div>

<script type="text/javascript">
    try {
        ace.settings.check('sidebar', 'collapsed')
    } catch (e) {
    }
</script>