<?php echo $this->Form->create('CaseFiling', array('type'=>'file', 'url' => '/cases/editCaseFiling/'.$caseId.'/'.$caseFilingId, 'class' => 'form-horizontal', 'name' => 'editCaseFilingForm', 'id' => 'editCaseFilingForm', 'novalidate' => true)); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Filing Date: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('CaseFiling.id', array('id' => 'EditCaseFilingId', 'label' => false, 'div' => false, 'type' => 'hidden')); ?>
					<?php echo $this->Form->input('CaseFiling.filing_date', array('id' => 'EditCaseFilingFilingDate', 'label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'data-date-format' => 'yyyy-mm-dd')); ?>
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
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Filing Type: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('CaseFiling.filing_type', array('options' => array('Urgent' => 'Urgent', 'Ordinary' => 'Ordinary'), 'empty' => '--Select--', 'id' => 'EditCaseFilingFilingType', 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
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
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Filing No.: </label>
				<div class="col-sm-8">
					<?php echo $this->Form->input('CaseFiling.filing_no', array('id' => 'EditCaseFilingFilingNo', 'label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
					<div class="error-message editBasicDetailsError clear" id="edit_error_filing_no"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if (!empty($mainCaseFile)) { ?>
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<div class="col-sm-12 col-xs-12">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dob">&nbsp;</label>
				<div class="col-sm-8">
					<a href="<?php echo $mainCaseFile;?>" target="_blank" 'class'='col-sm-12 col-xs-12'>Main Case File</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<div class="row">
	<div class="col-sm-12">
		<div class="clearfix pull-right custom-form-actions">
			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save", array("class" => "btn btn-info updateCaseFiling", "escape" => false, "type" => "submit"));?>
		</div>
	</div>
</div>
<?php echo $this->Form->end(); ?>