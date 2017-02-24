<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<?php echo $this->Form->create('Todo', array('type'=>'file', 'url' => '/Todos/checkList/', 'class' => 'form-horizontal', 'name' => 'add', 'id' => 'add')); ?>
		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Todo Details</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Attachment: </label>
										<div class="col-sm-8">
											<?php
											echo $this->Form->file('Todo.attachment', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12'));
											?>
											<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Update", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[Todo][submit]", "value" => "submit"));
			?>
										</div>
									</div>
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