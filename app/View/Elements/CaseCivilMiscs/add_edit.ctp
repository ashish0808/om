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
	<?php
	if ($this->action == 'edit') {
	?>
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
	<?php
	}
	?>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="clearfix pull-right">
			<?php
			if($this->action == 'add') {
			?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[CaseCivilMisc][submit]", "value" => "submit"));
			?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Reset", array("class" => "btn btn-info", "escape" => false, "type" => "reset", "name" => "data[CaseCivilMisc][reset]", "value" => "reset"));
			?>
			<?php
			} else {
			?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Update", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[CaseCivilMiscs][submit]", "value" => "submit"));
			?>
			<?php echo $this->Html->link("Back", array('controller' => 'CaseCivilMiscs', 'action' => 'index/'.$this->request->data['CaseCivilMisc']['status']), array('class' => 'btn btn-info'));?>
			<?php
			}
			?>
		</div>
	</div>
</div>