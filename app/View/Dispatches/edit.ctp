<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<?php echo $this->Form->create('Dispatch', array('type'=>'file', 'url' => '/Dispatches/edit/'.$id, 'class' => 'form-horizontal', 'name' => 'edit', 'id' => 'edit')); ?>
		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Update Dispatch Details</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Title: </label>
										<div class="col-sm-8">
											<?php
											echo $this->Form->input('Dispatch.title', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'required' => 'required', 'autocomplete' => 'off'));
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Date of Dispatch: </label>
										<div class="col-sm-8">
											<?php
											echo $this->Form->input('Dispatch.date_of_dispatch', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'placeholder' => 'Date of Dispatch', 'data-date-format' => 'yyyy-mm-dd', 'required' => 'required', 'autocomplete' => 'off'));
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Compute File No: </label>
										<div class="col-sm-8">
											<?php
											echo $this->Form->input('ClientCase.computer_file_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off', 'required' => false));
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Attachment: </label>
										<div class="col-sm-8">
											<?php
											echo $this->Form->file('Dispatch.attachment', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12'));
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Previous Attachment: </label>
										<div class="col-sm-8">
											<?php 
											if (!empty($attachment)) { 
											?>
											<a href="<?php echo $attachment;?>" target="_blank" 'class'='col-sm-12 col-xs-12'>Application Copy</a>
											<?php 
											} else {
											?>
											<label class="col-sm-4 control-label"> Not Available </label>
											<?php
											}
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Remarks: </label>
										<div class="col-sm-8">
											<?php
											echo $this->Form->textarea('Dispatch.remarks', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12'));
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="clearfix pull-right">
									<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Update", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[Dispatch][submit]", "value" => "submit"));
									?>
									<?php echo $this->Html->link("Back", array('controller' => 'Dispatches', 'action' => 'index'), array('class' => 'btn btn-info'));?>
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