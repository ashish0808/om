<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<?php echo $this->Form->create('CaseCivilMisc', array('type'=>'file', 'url' => '/CaseCivilMiscs/add/', 'class' => 'form-horizontal', 'name' => 'add', 'id' => 'add')); ?>
		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">CM/CRM Details</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Application Type: </label>
										<div class="col-sm-8">
											<?php
											$applicationTypes = array('cm' => 'CM', 'crm' => 'CRM');
											echo $this->Form->input('CaseCivilMisc.cm_type', array('options' => $applicationTypes, 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Application No: </label>
										<div class="col-sm-8">
											<?php
											echo $this->Form->input('CaseCivilMisc.cm_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'required' => 'required', 'autocomplete' => 'off'));
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
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Remarks: </label>
										<div class="col-sm-8">
											<?php
											echo $this->Form->textarea('CaseCivilMisc.remarks', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Application Status: </label>
										<div class="col-sm-8">
											<?php
											$statuses = array('pending' => 'Pending', 'decided' => 'Decided');
											echo $this->Form->input('CaseCivilMisc.status', array('options' => $statuses, 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
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
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <span class="required">*</span>Compute File No: </label>
										<div class="col-sm-8">
											<?php
											echo $this->Form->input('CaseCivilMisc.computer_file_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'value' => $computer_file_no, 'required' => 'required', 'autocomplete' => 'off'));
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
											echo $this->Form->file('CaseCivilMisc.attachment', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12'));
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
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Application Date: </label>
										<div class="col-sm-8">
											<?php 
											echo $this->Form->input('CaseCivilMisc.application_date', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'placeholder' => 'Application Date', 'data-date-format' => 'yyyy-mm-dd', 'autocomplete' => 'off'));
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="clearfix pull-right">
									<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[CaseCivilMisc][submit]", "value" => "submit"));
									?>
									<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Reset", array("class" => "btn btn-info", "escape" => false, "type" => "reset", "name" => "data[CaseCivilMisc][reset]", "value" => "reset"));
									?>
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