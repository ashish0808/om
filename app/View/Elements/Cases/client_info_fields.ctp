<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Party Type: </label>
				<div class="col-sm-8">
					<?php
					$partyTypes = array('Private Client' => 'Private Client', 'Company' => 'Company');
					echo $this->Form->input('ClientCase.party_type', array('options' => $partyTypes, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_party_type"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12 hide companyField">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="customRequired required">*</span> Company: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('ClientCase.user_companies_id', array('options' => $userCompanies, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'select2 col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_user_companies_id"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row hide companyField">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Reference Number: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.reference_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_reference_no"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row hide clientField">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob">Address1: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.client_address1', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob">Address2: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.client_address2', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row hide clientField">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob">Email: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.client_email', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="customRequired required">*</span> Phone: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.client_phone', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
					<div class="error-message editBasicDetailsError clear" id="error_client_phone"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row hide clientField">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob">Phone2: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('ClientCase.client_phone2', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				</div>
			</div>
		</div>
	</div>
</div>