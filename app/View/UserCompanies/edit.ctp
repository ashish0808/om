<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<?php echo $this->Form->create('UserCompany', array('type'=>'file', 'url' => '/UserCompanies/edit/'.$id, 'class' => 'form-horizontal', 'name' => 'edit', 'id' => 'edit')); ?>
		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Update Todo Details</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<?php echo $this->element('UserCompanies/add_edit');?>
					</div>
				</div>
			</div>
		</div>
        <?php echo $this->Form->end(); ?>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->