<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<div class="col-sm-12 col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Case History Details</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<?php echo $this->Form->create('CaseProceeding', array('class' => 'form-horizontal', 'name' => 'addCaseProceedingForm', 'id' => 'addCaseProceedingForm', 'novalidate' => true));
						?>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-12 control-label no-padding-right" for="form-field-dob"> <span style="color: red;">Note: </span> This will be added as history of the case and will not have any impact on the case itself. For ongoing case please use <strong><i>Daily Diary</i></strong> function of the software. </label>
									</div>
								</div>
							</div>
						</div>
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
												echo $clientCase['ClientCase']['complete_case_number'];
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
												echo $clientCase['ClientCase']['party_name'];
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
												echo $clientCase['Court']['name'];
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
												echo $this->Form->input('ClientCase.brief_status', array('options' => $briefStatus, 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
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
												$caseStatus = array('4' => 'Pending', '5' => 'Admitted');
												echo $this->Form->input('ClientCase.case_status', array('options' => $caseStatus, 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
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
												echo $this->Form->checkbox('ClientCase.referred_to_lok_adalat');
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
												echo $this->Form->input('CaseProceeding.next_date_of_hearing', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'placeholder' => 'Next Date', 'data-date-format' => 'yyyy-mm-dd', 'autocomplete' => 'off'));
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
									<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save", array("class" => "btn btn-primary addCaseProceeding", "escape" => false, "type" => "submit"));?>
								</div>
							</div>
						</div>
						<?php echo $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>
        <?php echo $this->Form->end(); ?>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->