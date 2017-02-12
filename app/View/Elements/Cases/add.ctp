<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Is Existing Case: </label>
				<div class="col-sm-8">
					<div>
						<?php
						$existingCase = '';
						$notExistingCase = 'checked="checked"';
						if(!empty($this->request->data['ClientCase']['is_existing'])) {
							$notExistingCase = '';
							$existingCase = 'checked="checked"';
						}
						?>
						<label>
							<input name="data[ClientCase][is_existing]" type="radio" <?php echo $notExistingCase; ?> class="ace isExistingCase" value="0" />
							<span class="lbl"> No</span>
						</label>&nbsp;
						<label>
							<input name="data[ClientCase][is_existing]" type="radio" <?php echo $existingCase; ?> class="ace isExistingCase" value="1" />
							<span class="lbl"> Yes</span>
						</label>&nbsp;
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12 hide fileNumber">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> File Number: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.file_number', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Client Type: </label>
				<div class="col-sm-8">
					<?php
					$clientTypes = array('petitioner' => 'Appellant/Petitioner', 'respondent' => 'Respondent');
					echo $this->Form->input('ClientCase.client_type', array('options' => $clientTypes, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="customRequired required">*</span> Case Type: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('ClientCase.case_type_id', array('options' => $caseTypes, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'select2 col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="customRequired required">*</span> Case Number: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.case_number', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="customRequired required">*</span> Case Year: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.case_year', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Party Name: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.party_name', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="customRequired required">*</span> Case Title: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.case_title', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="customRequired required">*</span> Court: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('ClientCase.court_id', array('options' => $courts, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob">Presiding Officer: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.presiding_officer', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob">Date Fixed: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.date_fixed', array('label' => false, 'div' => false, 'type' => 'text', 'class' => 'col-sm-12 col-xs-12 date-picker', 'placeholder' => 'dd-mm-yyyy', 'data-date-format' => 'dd-mm-yyyy', 'readonly' => true)); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="clearfix pull-right custom-form-actions">
			<?php echo $this->Form->button("<i class='icon-arrow-right bigger-110'></i>Next", array("class" => "btn btn-success btn-next", "escape" => false, "type" => "submit", "name" => "data[ClientCase][submit]", "value" => "next"));?>
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save Incomplete Info", array("class" => "btn btn-info", "escape" => false, "type" => "submit", "name" => "data[ClientCase][submit]", "value" => "saveIncomplete"));?>
		</div>
	</div>
</div>