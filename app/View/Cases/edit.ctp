<div class="hide" id="ajaxEdit"><?php echo $this->Html->url(array('controller' => 'Cases', 'action' => 'ajaxEdit', $caseId));?></div>
<div class="hide" id="redirectIncompleteForm"><?php echo $this->Html->url(array('controller' => 'users', 'action' => 'dashboard'));?></div>
<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<div class="col-sm-12 widget-container-col ui-sortable">
			<div class="widget-box transparent ui-sortable-handle">
				<?php echo $this->element('Cases/top_menus');?>

				<div class="widget-body edit-case-cnt">
					<div class="widget-main padding-12">
						<div class="tab-content padding-4">
							<div class="tab-pane active" id="editPage-cnt">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->
<?php echo $this->Html->script('pages/add_case.js'); ?>
<?php echo $this->Html->script('pages/edit_case.js'); ?>