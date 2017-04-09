<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<?php echo $this->Form->create('Dispatch', array('type'=>'file', 'url' => '/Dispatches/add/', 'class' => 'form-horizontal', 'name' => 'add', 'id' => 'add')); ?>
		<?php
		echo $this->Form->hidden('Dispatch.case_id', array('value' => $caseId));
		echo $this->Form->hidden('Dispatch.referer', array('value' => $action));
		?>
		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Dispatch Details</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<?php echo $this->element('Dispatches/add_edit');?>
					</div>
				</div>
			</div>
		</div>
        <?php echo $this->Form->end(); ?>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->