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
						<div class="error-message editBasicDetailsError clear" id="error_is_existing"></div>
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
					<?php echo $this->Form->input('ClientCase.computer_file_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_computer_file_no"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<?php
				$clientTypes = array('petitioner' => 'Appellant/Petitioner', 'respondent' => 'Respondent');
				if(isset($caseDetails['ClientCase']['completed_step']) && $caseDetails['ClientCase']['completed_step']>=2 &&
				isset($clientTypes[$caseDetails['ClientCase']['client_type']])) { ?>
					<label class="col-sm-4 control-label no-padding-right"> Client Type: </label>
					<label class="col-sm-8" style="padding-top: 7px !important;"><?php echo $clientTypes[$caseDetails['ClientCase']['client_type']]; ?></label>
				<?php }else{ ?>
					<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Client Type: </label>
					<div class="col-sm-8">
						<?php
						echo $this->Form->input('ClientCase.client_type', array('options' => $clientTypes, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
						<div class="error-message editBasicDetailsError clear" id="error_client_type"></div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Case Type: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('ClientCase.case_type_id', array('options' => $caseTypes, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'select2 col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_case_type_id"></div>
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
					<div class="error-message editBasicDetailsError clear" id="error_case_number"></div>
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
					<div class="error-message editBasicDetailsError clear" id="error_case_year"></div>
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
					<div class="error-message editBasicDetailsError clear" id="error_party_name"></div>
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
					<div class="error-message editBasicDetailsError clear" id="error_case_title"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="customRequired required">*</span> Date Fixed: </label>
				<div class="col-sm-8">
					<?php if(empty($caseDetails['CaseProceeding'])) { ?>
					<?php echo $this->Form->input('ClientCase.date_fixed', array('label' => false, 'div' => false, 'type' => 'text', 'class' => 'col-sm-12 col-xs-12 date-picker', 'readonly' => true, 'data-date-format' => 'yyyy-mm-dd')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_date_fixed"></div>
					<?php } else {
					$lastHearing = 'NA';
					if(isset($pendingProceeding['CaseProceeding']) && !empty($pendingProceeding['CaseProceeding'])) {

						$lastHearing = $pendingProceeding['CaseProceeding']['date_of_hearing'];
					}
					?>
						<input class="col-sm-12 col-xs-12" disabled="disabled" value="<?php echo $lastHearing; ?>" type="text">
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Engaged On: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.engaged_on', array('label' => false, 'div' => false, 'type' => 'text', 'class' => 'col-sm-12 col-xs-12 date-picker', 'readonly' => true, 'data-date-format' => 'yyyy-mm-dd')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Court: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('ClientCase.court_id', array('options' => $courts, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_court_id"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Presiding Officer: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.presiding_officer', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_presiding_officer"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row fieldForAppellant">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="customRequiredAppellant required">*</span> Limitation Expires On: </label>
				<div class="col-sm-8">
					<?php
					if(empty($this->request->data['ClientCase']['limitation_expires_on'])) {

						$this->request->data['ClientCase']['limitation_expires_on'] = date('Y-m-d', strtotime(' + 40 days'));
					}
					echo $this->Form->input('ClientCase.limitation_expires_on', array('label' => false, 'div' => false, 'type' => 'text', 'class' => 'col-sm-12 col-xs-12 date-picker', 'readonly' => true, 'data-date-format' => 'yyyy-mm-dd')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_limitation_expires_on"></div>
				</div>
			</div>
		</div>
	</div>
</div>