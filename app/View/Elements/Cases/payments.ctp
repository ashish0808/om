<?php $editPaymentLink = $this->Html->url(array('controller' => 'Cases', 'action' => 'editPayment')); ?>
<?php $viewPaymentLink = $this->Html->url(array('controller' => 'Cases', 'action' => 'addPayment')); ?>
<?php $deletePaymentLink = $this->Html->url(array('controller' => 'Cases', 'action' => 'deletePayment')); ?>
<div class="row" style="margin-left: -10px !important;">
	<div class="payment_form_cnt col-xs-12" style="overflow-x: scroll;">
		<table id="simple-table" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Date</th>
					<th>Amount</th>
					<th>Mode</th>
					<th>Is Verified</th>
					<th>Remarks</th>
					<th>Created</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

				$case_payments = $caseDetails['CasePayment'];
				$amount_paid = 0;
				if(!empty($case_payments)){
					foreach($case_payments as $case_payment){
						$amount_paid = $amount_paid+$case_payment['amount'];
						?>
						<tr>
							<td><?php echo $this->Time->format('D, M jS, Y', $case_payment['date_of_payment']);?></td>
							<td><?php echo number_format((float)$case_payment['amount'], 2, '.', '');?></td>
							<td><?php echo $case_payment['PaymentMethod']['method'];?></td>
							<td><?php echo (!empty($case_payment['is_verified'])) ? 'Yes' : 'No'; ?></td>
							<td><?php echo $case_payment['notes'];?></td>
							<td><?php echo $this->Time->format('D, M jS, Y', $case_payment['created']); ?></td>
							<td>
								<?php //echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i>', "javascript:void(0)", array('escape' => false, 'class' => 'blue', 'pageTitle' => 'View Payment Details', 'pageName' => $viewPaymentLink.'/'.$case_payment['client_case_id'].'/'.$case_payment['id'])); ?>
								<?php echo $this->Html->link('<i class="icon-edit bigger-130"></i>', "javascript:void(0)", array('escape' => false, 'class' => 'blue editCasePayment', 'pageTitle' => 'Edit Payment Details', 'pageName' => $editPaymentLink.'/'.$case_payment['client_case_id'].'/'.$case_payment['id'])); ?>
								<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', "javascript:void(0)", array('escape' => false, 'class' => 'blue deletePayment', 'id' => $deletePaymentLink.'/'.$case_payment['client_case_id'].'/'.$case_payment['id']))?>
							</td>
						</tr>
				<?php } } else { ?>
					<tr>
						<td colspan="6">No record found</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php echo $this->Form->create('CasePayment', array('url' => '/cases/addPayment/'.$caseId, 'class' => 'form-horizontal', 'name' => 'casePayments', 'id' => 'casePayments', 'novalidate' => true));

$fee_settled = '';
if(isset($caseDetails['ClientCase']['fee_settled'])) {

	$fee_settled = $caseDetails['ClientCase']['fee_settled'];
}

$payment_status = 'nil';
if(isset($caseDetails['ClientCase']['payment_status'])) {

	$payment_status = $caseDetails['ClientCase']['payment_status'];
}
?>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Fee Settled: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('CasePayment.fee_settled', array('label' => false, 'div' => false, 'value' => $fee_settled, 'class' => 'col-sm-12 col-xs-12')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_fee_settled"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Fee Status: </label>
				<div class="col-sm-8">
					<input type="text" disabled="disabled" class="col-sm-12 col-xs-12" value="<?php echo $payment_status; ?>">
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Amount Paid: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('CasePayment.amount', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_amount"></div>
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
					<div class="error-message editBasicDetailsError clear" id="error_mode_of_payment"></div>
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
					<div class="error-message editBasicDetailsError clear" id="error_date_of_payment"></div>
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
					<div class="error-message editBasicDetailsError clear" id="error_mode_of_payment"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(!empty($fee_settled)){ ?>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-dob">Balance Amount: </label>
				<div class="col-sm-10">
					<label style="padding-top: 7px;">
						<?php $balanceAmt = $fee_settled - $amount_paid;
						echo number_format((float)$balanceAmt, 2, '.', '');?>
					</label>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-2 control-label no-padding-right" for="form-field-dob">Payment Notes: </label>
				<div class="col-sm-10">
					<?php echo $this->Form->input('CasePayment.notes', array('label' => false, 'div' => false, 'type' => 'textarea', 'error' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="data[CasePayment][submit]" value="" id ="casePaymentsHiddenSubmit">
<div class="row">
	<div class="col-sm-12">
		<div class="clearfix pull-right custom-form-actions">
			<?php echo $this->Form->button("<i class='icon-arrow-right bigger-110'></i>Next", array("class" => "btn btn-success btn-next saveCasePayments", "escape" => false, "type" => "submit", "value" => "next"));?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save Incomplete Info", array("class" => "btn btn-info saveCasePayments", "escape" => false, "type" => "submit", "value" => "saveIncomplete"));?>
		</div>
	</div>
</div>
<?php echo $this->Form->end(); ?>