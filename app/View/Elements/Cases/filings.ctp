<?php $editFilingLink = $this->Html->url(array('controller' => 'Cases', 'action' => 'editCaseFiling')); ?>
<div class="row" style="margin-left: -10px !important;">
	<div class="case_filing_form_cnt col-xs-12" style="overflow-x: scroll;">
		<table id="simple-table" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Filing Date</th>
					<th>Filing Type</th>
					<th>Filing Number</th>
					<th>Created</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

				$case_filings = $caseDetails['CaseFiling'];
				$amount_paid = 0;
				if(!empty($case_filings)){
					foreach($case_filings as $case_filing){ ?>
						<tr>
							<td><?php echo date('Y-m-d', strtotime($case_filing['filing_date']));?></td>
							<td><?php echo $case_filing['filing_type'];?></td>
							<td><?php echo $case_filing['filing_no'];?></td>
							<td><?php echo date('Y-m-d', strtotime($case_filing['created']));?></td>
							<td>
								<?php echo $this->Html->link('<i class="icon-edit bigger-130"></i>', "javascript:void(0)", array('escape' => false, 'class' => 'blue editCaseFiling', 'pageTitle' => 'Edit Filing Details', 'pageName' => $editFilingLink.'/'.$case_filing['client_case_id'].'/'.$case_filing['id'])); ?>
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

<?php

if(empty($caseDetails['CaseStatus']['status']) ||
(!empty($caseDetails['CaseStatus']['status']) && in_array($caseDetails['CaseStatus']['status'], array('pending_for_filing', 'pending_for_refiling')))) { ?>
<?php echo $this->Form->create('CaseFiling', array('type'=>'file', 'url' => '/cases/addCaseFiling/'.$caseId, 'class' => 'form-horizontal', 'name' => 'caseFilingForm', 'id' => 'caseFilingForm', 'novalidate' => true)); ?>

<div class="">
	<div class="col-sm-4">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Filing Date: </label>
				<?php echo $this->Form->input('CaseFiling.filing_date', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'data-date-format' => 'yyyy-mm-dd')); ?>
				<div class="error-message editBasicDetailsError clear" id="error_filing_date"></div>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Filing Type: </label>
				<?php echo $this->Form->input('CaseFiling.filing_type', array('options' => array('Urgent' => 'Urgent', 'Ordinary' => 'Ordinary'), 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
				<div class="error-message editBasicDetailsError clear" id="error_filing_type"></div>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Filing No.: </label>
				<?php echo $this->Form->input('CaseFiling.filing_no', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				<div class="error-message editBasicDetailsError clear" id="error_filing_no"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12" style="padding-left:40px;">
				<label class="control-label no-padding-right" for="form-field-dob"> Upload File.: </label>
				<?php echo $this->Form->input('ClientCase.main_file', array('label' => false, 'div' => false, 'type' => 'file', 'error' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
				<div class="error-message editBasicDetailsError clear" id="error_main_file"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="clearfix pull-right custom-form-actions">
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save", array("class" => "btn btn-info saveCaseFiling", "escape" => false, "type" => "button"));?>
		</div>
	</div>
</div>
<?php echo $this->Form->end(); ?>
<?php }elseif(!empty($caseDetails['CaseStatus']['status']) && $caseDetails['CaseStatus']['status']=='pending_for_registration'){ ?>
<?php echo $this->Form->create('CaseFiling', array('type'=>'file', 'url' => '/cases/caseRegistration/'.$caseId, 'class' => 'form-horizontal', 'name' => 'caseFilingForm', 'id' => 'caseFilingForm', 'novalidate' => true)); ?>



<?php echo $this->Form->end(); ?>
<?php } ?>