<?php $editPaymentLink = $this->Html->url(array('controller' => 'Cases', 'action' => 'addPayment')); ?>
<?php $viewPaymentLink = $this->Html->url(array('controller' => 'Cases', 'action' => 'addPayment')); ?>
<div class="row" style="margin-left: -10px !important;">
	<div class="payment_form_cnt col-xs-12" style="overflow-x: scroll;">
		<table id="simple-table" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Date</th>
					<th>Amount</th>
					<th>Mode</th>
					<th>Is Verified</th>
					<th>Created</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php

				$case_payments = $caseDetails['CasePayment'];
				$case_settled_fee = (!empty($caseDetails['ClientCase']['fee_settled'])) ? $caseDetails['ClientCase']['fee_settled'] : '0.00';
				$amount_paid = 0;
				if(!empty($case_payments)){
					foreach($case_payments as $case_payment){
						$amount_paid = $amount_paid+$case_payment['amount'];
						?>
						<tr>
							<td><?php echo $case_payment['date_of_payment'];?></td>
							<td><?php echo number_format((float)$case_payment['amount'], 2, '.', '');?></td>
							<td><?php echo $case_payment['PaymentMethod']['method'];?></td>
							<td><?php echo (!empty($case_payment['is_verified'])) ? 'Yes' : 'No'; ?></td>
							<td><?php echo date('Y-m-d', strtotime($case_payment['created']));?></td>
							<td>
								<?php echo $this->Html->link('<i class="icon-zoom-in bigger-130"></i>', "javascript:void(0)", array('escape' => false, 'class' => 'blue', 'pageTitle' => 'View Payment Details', 'pageName' => $viewPaymentLink.'/'.$case_payment['client_case_id'].'/'.$case_payment['id'])); ?>
								<?php echo $this->Html->link('<i class="icon-edit bigger-130"></i>', "javascript:void(0)", array('escape' => false, 'class' => 'blue', 'pageTitle' => 'Edit Payment Details', 'pageName' => $editPaymentLink.'/'.$case_payment['client_case_id'].'/'.$case_payment['id'])); ?>
								<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'Cases','action'=>'deletePayment',$case_payment['id'],$case_payment['client_case_id']), array('escape' => false, 'class' => 'blue'),"Are you sure you want to delete this payment?")?>
							</td>
						</tr>
				<?php } } ?>
			</tbody>
		</table>
	</div>
</div>

<?php echo $this->Form->create('ClientCase', array('url' => '/cases/casePayments/'.$caseId, 'class' => 'form-horizontal', 'name' => 'casePayments', 'id' => 'casePayments', 'novalidate' => true)); ?>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Fee Settled: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.fee_settled', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_fee_settled"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="paymentRequired required">*</span> Amount Paid: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.amount', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_amount"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row paymentRequiredField">
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
</div>

<div class="row paymentRequiredField">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required paymentRequired">*</span> Is Verified: </label>
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

<input type="hidden" name="data[ClientCase][submit]" value="" id ="casePaymentsHiddenSubmit">
<div class="row">
	<div class="col-sm-12">
		<div class="clearfix pull-right custom-form-actions">
			<?php echo $this->Form->button("<i class='icon-arrow-right bigger-110'></i>Next", array("class" => "btn btn-success btn-next saveCasePayments", "escape" => false, "type" => "submit", "value" => "next"));?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save Incomplete Info", array("class" => "btn btn-info saveCasePayments", "escape" => false, "type" => "submit", "value" => "saveIncomplete"));?>
		</div>
	</div>
</div>
<?php echo $this->Form->end(); ?>