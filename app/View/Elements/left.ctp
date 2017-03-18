<script type="text/javascript">
    try {
        ace.settings.check('sidebar', 'fixed')
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
$lawyersStatus = '';
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
    $caseMain = '';
    $caseSub = '';
    if ($this->params['controller'] == 'cases' || ($this->params['controller'] == 'CaseProceedings' && $this->params['action'] == 'caseHistory') || ($this->params['controller'] == 'Dispatches' && $this->params['action'] == 'caseDispatches') || ($this->params['controller'] == 'CaseCivilMiscs' && $this->params['action'] == 'caseCivilMisc') || ($this->params['controller'] == 'Todos' && $this->params['action'] == 'caseTodos')) {
  		$caseMain = 'open';
  		$caseSub = 'style="display:block;"';
    }
    ?>
    <li class="<?php echo $caseMain; ?>">
        <a href="#" class="dropdown-toggle">
            <i class="icon-book"></i>
            <span class="menu-text"> Cases </span>
            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu" <?php echo $caseSub; ?>>
            <li>
				<?php echo $this->Html->link('<i class="icon-double-angle-right"></i> Add ', array('controller'=>'cases','action'=>'add'), array('escape' => false))?>
			</li>
            <li>
                <?php echo $this->Html->link('<i class="icon-double-angle-right"></i> List ', array('controller'=>'cases','action'=>'manage'), array('escape' => false))?>
            </li>
            <li>
                <?php echo $this->Html->link('<i class="icon-double-angle-right"></i> Decided ', array('controller'=>'cases','action'=>'manage', 'decided'), array('escape' => false))?>
            </li>
            <li>
                <?php echo $this->Html->link('<i class="icon-double-angle-right"></i> Not With Us ', array('controller'=>'cases','action'=>'manage', 'notwithus'), array('escape' => false))?>
            </li>
        </ul>
    </li>
    <?php
    $caseCivilMiscMain = '';
    $caseCivilMiscSub = '';
    if($this->params['controller'] == 'CaseCivilMiscs' && $this->params['action'] != 'caseCivilMisc')
    {
        $caseCivilMiscMain = 'open';
        $caseCivilMiscSub = 'style="display:block;"';
    }
    ?>
    <li class="<?php echo $caseCivilMiscMain; ?>">
        <a href="#" class="dropdown-toggle">
            <i class="icon-legal"></i>
            <span class="menu-text"> Case CM/CRM </span>
            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu" <?php echo $caseCivilMiscSub; ?>>
            <li>
                <?php echo $this->Html->link('<i class="icon-double-angle-right"></i> Add ', array('controller'=>'CaseCivilMiscs','action'=>'add'), array('escape' => false))?>
            </li>
            <li>
                <?php echo $this->Html->link('<i class="icon-double-angle-right"></i>Pending List ', array('controller'=>'CaseCivilMiscs','action'=>'index'), array('escape' => false))?>
            </li>
            <li>
                <?php echo $this->Html->link('<i class="icon-double-angle-right"></i>Decided List ', array('controller'=>'CaseCivilMiscs','action'=>'index', 'decided'), array('escape' => false))?>
            </li>
        </ul>
    </li>
    <?php
    $caseDisptachMain = '';
    $caseDisptachSub = '';
    if($this->params['controller'] == 'Dispatches' && $this->params['action'] != 'caseDispatches')
    {
        $caseDisptachMain = 'open';
        $caseDisptachSub = 'style="display:block;"';
    }
    ?>
    <li class="<?php echo $caseDisptachMain; ?>">
        <a href="#" class="dropdown-toggle">
            <i class="icon-envelope"></i>
            <span class="menu-text"> Dispatches </span>
            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu" <?php echo $caseDisptachSub; ?>>
            <li>
                <?php echo $this->Html->link('<i class="icon-double-angle-right"></i> List ', array('controller'=>'Dispatches','action'=>'index'), array('escape' => false))?>
            </li>
            <li>
                <?php echo $this->Html->link('<i class="icon-double-angle-right"></i> Add ', array('controller'=>'Dispatches','action'=>'add'), array('escape' => false))?>
            </li>
        </ul>
    </li>
    <?php
    $todoMain = '';
    $todoSub = '';
    if($this->params['controller'] == 'Todos' && $this->params['action'] != 'caseTodos')
    {
        $todoMain = 'open';
        $todoSub = 'style="display:block;"';
    }
    ?>
    <li class="<?php echo $todoMain; ?>">
        <a href="#" class="dropdown-toggle">
            <i class="icon-bell"></i>
            <span class="menu-text"> Todos </span>
            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu" <?php echo $todoSub; ?>>
            <li>
                <?php echo $this->Html->link('<i class="icon-double-angle-right"></i> List ', array('controller'=>'Todos','action'=>'index'), array('escape' => false))?>
            </li>
            <li>
                <?php echo $this->Html->link('<i class="icon-double-angle-right"></i> Add ', array('controller'=>'Todos','action'=>'add'), array('escape' => false))?>
            </li>
        </ul>
    </li>
    <?php
    $caseProceedingMain = '';
    if($this->params['controller'] == 'CaseProceedings' && $this->params['action'] != 'caseHistory')
    {
        $caseProceedingMain = 'active';
    }
    ?>
    <li class="<?php echo $caseProceedingMain; ?>">
        <?php echo $this->Html->link('<i class="icon-calendar"></i> Daily Dairy ', array('controller'=>'CaseProceedings','action'=>'index'), array('escape' => false))?>
    </li>
    <!--li class="<?php echo $caseDisptachMain; ?>">
        <?php echo $this->Html->link('<i class="icon-desktop"></i> Change Password ', array('controller'=>'Todos','action'=>'index'), array('escape' => false))?>
    </li-->
    <li class="<?php echo $caseDisptachMain; ?>">
        <?php echo $this->Html->link('<i class="icon-off"></i> Logout ', array('controller'=>'users','action'=>'logout'), array('escape' => false))?>
    </li>
    <!--
    <li class="active">
        <a href="index.html">
            <i class="icon-dashboard"></i>
            <span class="menu-text"> Dashboard </span>
        </a>
    </li>
    <li>
        <a href="typography.html">
            <i class="icon-text-width"></i>
            <span class="menu-text"> Typography </span>
        </a>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-desktop"></i>
            <span class="menu-text"> UI Elements </span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="elements.html">
                    <i class="icon-double-angle-right"></i>
                    Elements
                </a>
            </li>

            <li>
                <a href="buttons.html">
                    <i class="icon-double-angle-right"></i>
                    Buttons &amp; Icons
                </a>
            </li>

            <li>
                <a href="treeview.html">
                    <i class="icon-double-angle-right"></i>
                    Treeview
                </a>
            </li>

            <li>
                <a href="jquery-ui.html">
                    <i class="icon-double-angle-right"></i>
                    jQuery UI
                </a>
            </li>

            <li>
                <a href="nestable-list.html">
                    <i class="icon-double-angle-right"></i>
                    Nestable Lists
                </a>
            </li>

            <li>
                <a href="#" class="dropdown-toggle">
                    <i class="icon-double-angle-right"></i>

                    Three Level Menu
                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li>
                        <a href="#">
                            <i class="icon-leaf"></i>
                            Item #1
                        </a>
                    </li>

                    <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-pencil"></i>

                            4th level
                            <b class="arrow icon-angle-down"></b>
                        </a>

                        <ul class="submenu">
                            <li>
                                <a href="#">
                                    <i class="icon-plus"></i>
                                    Add Product
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="icon-eye-open"></i>
                                    View Products
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-list"></i>
            <span class="menu-text"> Tables </span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="tables.html">
                    <i class="icon-double-angle-right"></i>
                    Simple &amp; Dynamic
                </a>
            </li>

            <li>
                <a href="jqgrid.html">
                    <i class="icon-double-angle-right"></i>
                    jqGrid plugin
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-edit"></i>
            <span class="menu-text"> Forms </span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="form-elements.html">
                    <i class="icon-double-angle-right"></i>
                    Form Elements
                </a>
            </li>

            <li>
                <a href="form-wizard.html">
                    <i class="icon-double-angle-right"></i>
                    Wizard &amp; Validation
                </a>
            </li>

            <li>
                <a href="wysiwyg.html">
                    <i class="icon-double-angle-right"></i>
                    Wysiwyg &amp; Markdown
                </a>
            </li>

            <li>
                <a href="dropzone.html">
                    <i class="icon-double-angle-right"></i>
                    Dropzone File Upload
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="widgets.html">
            <i class="icon-list-alt"></i>
            <span class="menu-text"> Widgets </span>
        </a>
    </li>

    <li>
        <a href="calendar.html">
            <i class="icon-calendar"></i>

                                            <span class="menu-text">
                                                Calendar
                                                <span class="badge badge-transparent tooltip-error"
                                                      title="2&nbsp;Important&nbsp;Events">
                                                    <i class="icon-warning-sign red bigger-130"></i>
                                                </span>
                                            </span>
        </a>
    </li>

    <li>
        <a href="gallery.html">
            <i class="icon-picture"></i>
            <span class="menu-text"> Gallery </span>
        </a>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-tag"></i>
            <span class="menu-text"> More Pages </span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="profile.html">
                    <i class="icon-double-angle-right"></i>
                    User Profile
                </a>
            </li>

            <li>
                <a href="inbox.html">
                    <i class="icon-double-angle-right"></i>
                    Inbox
                </a>
            </li>

            <li>
                <a href="pricing.html">
                    <i class="icon-double-angle-right"></i>
                    Pricing Tables
                </a>
            </li>

            <li>
                <a href="invoice.html">
                    <i class="icon-double-angle-right"></i>
                    Invoice
                </a>
            </li>

            <li>
                <a href="timeline.html">
                    <i class="icon-double-angle-right"></i>
                    Timeline
                </a>
            </li>

            <li>
                <a href="login.html">
                    <i class="icon-double-angle-right"></i>
                    Login &amp; Register
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-file-alt"></i>

                                            <span class="menu-text">
                                                Other Pages
                                                <span class="badge badge-primary ">5</span>
                                            </span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="faq.html">
                    <i class="icon-double-angle-right"></i>
                    FAQ
                </a>
            </li>

            <li>
                <a href="error-404.html">
                    <i class="icon-double-angle-right"></i>
                    Error 404
                </a>
            </li>

            <li>
                <a href="error-500.html">
                    <i class="icon-double-angle-right"></i>
                    Error 500
                </a>
            </li>

            <li>
                <a href="grid.html">
                    <i class="icon-double-angle-right"></i>
                    Grid
                </a>
            </li>

            <li>
                <a href="blank.html">
                    <i class="icon-double-angle-right"></i>
                    Blank Page
                </a>
            </li>
        </ul>
    </li>-->
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