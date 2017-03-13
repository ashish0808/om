<?php echo $this->Form->create('CaseProceeding', array('url' => '/CaseProceedings/editCaseProceeding/'.$caseProceedingId.'/'.$date, 'class' => 'form-horizontal', 'name' => 'editCaseProceedingForm', 'id' => 'editCaseProceedingForm', 'novalidate' => true));
echo $this->Form->hidden('CaseProceeding.id');
echo $this->Form->hidden('CaseProceeding.client_case_id');
echo $this->Form->hidden('CaseProceeding.search_date', array('value' => $date));
?>
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Proceeding Date: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('CaseProceeding.date_of_hearing', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'placeholder' => 'Proceeding Date', 'data-date-format' => 'yyyy-mm-dd', 'autocomplete' => 'off'));
					?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_filing_date"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Cr. No.: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('CaseProceeding.court_room_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_filing_type"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Sr. No.: </label>
				<div class="col-sm-8">
					<?php
					echo $this->Form->input('CaseProceeding.court_serial_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
					?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_filing_no"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right"> Case No.: </label>
				<div class="col-sm-8">
					<label class="control-label no-padding-right">
					<?php
						echo $caseProceeding['ClientCase']['case_number'];
					?>
					</label>
					<div class="error-message editBasicDetailsError clear" id="edit_error_filing_no"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Party Name: </label>
				<div class="col-sm-8">
					<label class="control-label no-padding-right">
					<?php
						echo $caseProceeding['ClientCase']['party_name'];
					?>
					</label>
					<div class="error-message editBasicDetailsError clear" id="edit_error_filing_no"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Court: </label>
				<div class="col-sm-8">
					<label class="control-label no-padding-right">
					<?php
						echo $caseProceeding['ClientCase']['Court']['name'];
					?>
					</label>
					<div class="error-message editBasicDetailsError clear" id="edit_error_filing_no"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Case Brief: </label>
				<div class="col-sm-8">
					<?php
						$briefStatus = array('in_office' => 'In Office', 'out_of_office' => 'Out of Office');
						if ($caseProceeding['CaseProceeding']['proceeding_status'] == 'pending') {
							echo $this->Form->input('ClientCase.brief_status', array('options' => $briefStatus, 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
						} else {
							?>
							<label class="control-label no-padding-right">
							<?php
							if ($caseProceeding['CaseProceeding']['brief_status'] == 'in_office') {
								echo 'In Office';
							} else {
								echo 'Out of Office';
							}
							?>
							</label>
							<?php
						}
					?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_filing_no"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Case Status: </label>
				<div class="col-sm-8">
					<?php
						$caseStatus = array('4' => 'Pending', '6' => 'Decided', '5' => 'Admitted', '8' => 'Reserved', '7' => 'Not with Us');
						if ($caseProceeding['CaseProceeding']['proceeding_status'] == 'pending') {
							echo $this->Form->input('ClientCase.case_status', array('options' => $caseStatus, 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
						} else {
						?>
						<label class="control-label no-padding-right">
						<?php
							echo strtoupper($caseProceeding['CaseProceeding']['case_status']);
						?>
						</label>
						<?php
						}
					?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_filing_no"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Referred to Lok Adalat: </label>
				<div class="col-sm-8">
					<?php
						if ($caseProceeding['CaseProceeding']['proceeding_status'] == 'pending') {
							echo $this->Form->checkbox('ClientCase.referred_to_lok_adalat');
						} else {
						?>
						<label class="control-label no-padding-right">
						<?php
							if ($caseProceeding['CaseProceeding']['referred_to_lok_adalat']) {
								echo 'Yes';
							} else {
								echo 'No';
							}
						?>
						</label>
						<?php
						}
					?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_filing_no"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Remarks: </label>
				<div class="col-sm-8">
					<?php
						echo $this->Form->textarea('CaseProceeding.remarks', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
					?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_filing_no"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> Next Date: </label>
				<div class="col-sm-8">
					<?php
						if ($caseProceeding['CaseProceeding']['proceeding_status'] == 'pending') {
							echo $this->Form->input('CaseProceeding.next_date_of_hearing', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'placeholder' => 'Next Date', 'data-date-format' => 'yyyy-mm-dd', 'autocomplete' => 'off'));
						} else {
						?>
						<label class="control-label no-padding-right">
						<?php
							echo $this->Time->format('D, M jS, Y', $caseProceeding['CaseProceeding']['next_date_of_hearing']);
						?>
						</label>
						<?php
						}
					?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_filing_no"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="clearfix pull-right">
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Update", array("class" => "btn btn-primary updateCaseProceeding", "escape" => false, "type" => "submit"));?>
		</div>
	</div>
</div>
<?php echo $this->Form->end(); ?>