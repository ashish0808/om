<?php echo $this->Form->create('CasePayment', array('url' => '/cases/editPayment/'.$caseId.'/'.$casePaymentId, 'class' => 'form-horizontal', 'name' => 'editCasePayments', 'id' => 'editCasePayments', 'novalidate' => true)); ?>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Amount Paid: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('CasePayment.id', array('label' => false, 'div' => false, 'type' => 'hidden')); ?>
					<?php echo $this->Form->input('CasePayment.amount', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_amount"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required paymentRequired">*</span> Mode of Payment: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('CasePayment.mode_of_payment', array('options' => $paymentMethods, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_mode_of_payment"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="paymentRequired required">*</span> Date of Payment: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('CasePayment.date_of_payment', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'data-date-format' => 'yyyy-mm-dd')); ?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_date_of_payment"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Is Verified: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('CasePayment.is_verified', array('options' => array(0 => 'No', 1 => 'Yes'), 'empty' => false, 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_mode_of_payment"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-dob">Remarks: </label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('CasePayment.notes', array('label' => false, 'div' => false, 'type' => 'textarea', 'error' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="clearfix pull-right custom-form-actions">
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save", array("class" => "btn btn-info updateCasePayment", "escape" => false, "type" => "submit"));?>
		</div>
	</div>
</div>
<?php echo $this->Form->end(); ?>