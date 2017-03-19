<div class="widget-main">
	<?php echo $this->Form->create('ClientCase', array('url' => '/cases/addDecision/'.$caseId, 'class' => 'form-horizontal', 'name' => 'addDecision', 'id' => 'addDecision', 'novalidate' => true)); ?>
		<?php echo $this->Form->input('ClientCase.id', array('label' => false, 'div' => false, 'type' => 'hidden')); ?>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<div class="col-sm-12 col-xs-12">
						<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Certified copy required: </label>
						<div class="col-sm-8">
							<?php
							echo $this->Form->input('ClientCase.certified_copy_required', array('options' => array(1 => 'Yes', 0 => 'No'), 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12 certifiedCopyRequired', 'autocomplete' => 'off')); ?>
							<div class="error-message editBasicDetailsError clear" id="error_certified_copy_required"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<div class="col-sm-12 col-xs-12 requiredCertifiedCopy">
						<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Applied On: </label>
						<div class="col-sm-8">
							<?php echo $this->Form->input('ClientCase.certified_copy_applied_date', array('label' => false, 'div' => false, 'type' => 'text', 'class' => 'col-sm-12 col-xs-12 date-picker', 'readonly' => true, 'data-date-format' => 'yyyy-mm-dd')); ?>
							<div class="error-message editBasicDetailsError clear" id="error_certified_copy_applied_date"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row requiredCertifiedCopy">
			<div class="col-sm-6">
				<div class="form-group">
					<div class="col-sm-12 col-xs-12">
						<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Received On: </label>
						<div class="col-sm-8">
							<?php echo $this->Form->input('ClientCase.certified_copy_received_date', array('label' => false, 'div' => false, 'type' => 'text', 'class' => 'col-sm-12 col-xs-12 date-picker', 'readonly' => true, 'data-date-format' => 'yyyy-mm-dd')); ?>
							<div class="error-message editBasicDetailsError clear" id="error_certified_copy_received_date"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<div class="col-sm-12 col-xs-12">
						<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Supplied On: </label>
						<div class="col-sm-8">
							<?php echo $this->Form->input('ClientCase.order_supplied_date', array('label' => false, 'div' => false, 'type' => 'text', 'class' => 'col-sm-12 col-xs-12 date-picker', 'readonly' => true, 'data-date-format' => 'yyyy-mm-dd')); ?>
							<div class="error-message editBasicDetailsError clear" id="error_order_supplied_date"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row requiredCertifiedCopy">
			<div class="col-sm-6">
				<div class="form-group">
					<div class="col-sm-12 col-xs-12">
						<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Supplied Via: </label>
						<div class="col-sm-8">
							<?php echo $this->Form->input('ClientCase.supplied_via', array('label' => false, 'div' => false, 'type' => 'text', 'class' => 'col-sm-12 col-xs-12')); ?>
							<div class="error-message editBasicDetailsError clear" id="error_supplied_via"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row requiredCertifiedCopy">
			<div class="col-sm-6">
				<div class="form-group">
					<div class="col-sm-12 col-xs-12">
						<label class="col-sm-4 control-label no-padding-right" for="form-field-dob">&nbsp;</label>
						<div class="col-sm-8">
							<label class="control-label no-padding-right">
							<?php echo $this->Form->input('ClientCase.alongwith_lcr', array('type'=>'checkbox', 'label' => false, 'div' => false)); ?>
							 <b>Supplied along with lcr</b></label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="clearfix pull-right custom-form-actions">
					<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class" => "btn btn-info addDecision", "escape" => false, "type" => "button"));?>
				</div>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>