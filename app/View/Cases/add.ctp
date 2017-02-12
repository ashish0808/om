<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<?php echo $this->Form->create('ClientCase', array('url' => '/cases/add/', 'class' => 'form-horizontal dropzone', 'name' => 'add', 'id' => 'add', 'novalidate' => true)); ?>
		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Case Details</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<?php echo $this->element('Cases/add');?>
					</div>
				</div>
			</div>
		</div>
        <?php echo $this->Form->end(); ?>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->
<?php echo $this->Html->script('pages/add_case.js'); ?>