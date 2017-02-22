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
						<div class="row">
                        	<div class="col-sm-12">
                        		<div class="clearfix pull-right custom-form-actions">
                        			<?php echo $this->Form->button("<i class='icon-arrow-right bigger-110'></i>Next", array("class" => "btn btn-success btn-next", "escape" => false, "type" => "submit", "name" => "data[ClientCase][submit]", "value" => "next"));?>
                        			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save Incomplete Info", array("class" => "btn btn-info", "escape" => false, "type" => "submit", "name" => "data[ClientCase][submit]", "value" => "saveIncomplete"));?>
                        		</div>
                        	</div>
                        </div>
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