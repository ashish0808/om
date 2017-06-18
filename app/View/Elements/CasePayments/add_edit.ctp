<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Amount: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('CasePayment.amount', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'required' => 'required', 'autocomplete' => 'off'));
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <span class="required">*</span>Date of Expense: </label>
				<div class="col-sm-8">
					<?php 
					echo $this->Form->input('CasePayment.date_of_payment', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'placeholder' => 'Date of Expense', 'data-date-format' => 'yyyy-mm-dd', 'required' => 'required', 'autocomplete' => 'off'));
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
					echo $this->Form->input('CasePayment.computer_file_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'value' => $computer_file_no, 'autocomplete' => 'off'));
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Mode of Payment: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('CasePayment.mode_of_payment', array('options' => $PaymentMethods, 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
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
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Expense Notes: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->textarea('CasePayment.notes', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="clearfix pull-right">
			<?php
			if ($this->action == 'add') {
			?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[CasePayment][submit]", "value" => "submit"));
			?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Reset", array("class" => "btn btn-info", "escape" => false, "type" => "reset", "name" => "data[CasePayment][reset]", "value" => "reset"));
			?>
			<?php
			} else {
			?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Update", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[CasePayment][submit]", "value" => "submit"));
			?>
			<?php
			if ($action == 'caseExpenses') {
				echo $this->Html->link("Back", array('controller' => 'CasePayments', 'action' => 'caseExpenses', $caseId), array('class' => 'btn btn-info'));
			} else {
				echo $this->Html->link("Back", array('controller' => 'CasePayments', 'action' => 'index'), array('class' => 'btn btn-info'));
			}
			?>
			<?php
			}
			?>
		</div>
	</div>
</div>