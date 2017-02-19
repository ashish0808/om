<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<?php echo $this->Form->create('CaseCivilMisc', array('type'=>'file', 'url' => '/CaseCivilMiscs/edit/'.$id, 'class' => 'form-horizontal', 'name' => 'edit', 'id' => 'edit')); ?>
		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Case Details</h4>
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
											echo $this->Form->input('CaseCivilMisc.cm_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'required' => 'required'));
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
											echo $this->Form->input('ClientCase.computer_file_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'required' => 'required'));
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
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Attachment: </label>
										<div class="col-sm-8">
											<?php
											echo $this->Form->file('CaseCivilMisc.attachment', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12'));
											?>
										</div>
									</div>
								</div>
							</div>
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
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Remarks: </label>
										<div class="col-sm-8">
											<?php
											echo $this->Form->textarea('CaseCivilMisc.remarks', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12'));
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="clearfix pull-right custom-form-actions">
									<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class" => "btn btn-info", "escape" => false, "type" => "submit", "name" => "data[CaseCivilMiscs][submit]", "value" => "submit"));
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