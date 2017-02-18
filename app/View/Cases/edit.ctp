<div class="hide" id="ajaxEdit"><?php echo $this->Html->url(array('controller' => 'Cases', 'action' => 'ajaxEdit', $caseId));?></div>
<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>

		<div class="col-sm-12 col-xs-12" id="editPage-cnt">
		</div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->
<?php echo $this->Html->script('pages/add_case.js'); ?>
<?php echo $this->Html->script('pages/edit_case.js'); ?>