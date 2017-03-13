<?php

if(empty($defaultCollapseIn)) {

	$defaultCollapseIn = 'basicDetails';
    if(!empty($caseDetails['ClientCase']['completed_step'])) {

    	if($caseDetails['ClientCase']['completed_step']==1) {

    		$defaultCollapseIn = 'clientInformation';
    	}

    	if($caseDetails['ClientCase']['completed_step']==2) {

    		$defaultCollapseIn = 'feesInformation';
        }

        if($caseDetails['ClientCase']['completed_step']==3) {

    		$defaultCollapseIn = 'remarks';
        }

        if($caseDetails['ClientCase']['completed_step']==4) {

        	$defaultCollapseIn = 'essentialWorks';
        	if($caseDetails['ClientCase']['client_type']=='petitioner') {

        		$defaultCollapseIn = 'caseFiling';
        	}
		}

		if(!empty($caseDetails['CaseStatus']['status']) && $caseDetails['CaseStatus']['status']=='decided') {

			$defaultCollapseIn = 'caseDecision';
		}
    }
}
?>
<div class="hide" id="getDefaultOpenTab"><?php echo $defaultCollapseIn; ?></div>
<div class="widget-box panel-group">
	<div class="widget-header">
		<a data-toggle="collapse" href="#basicDetails">
			<h4 class="col-sm-12 widget-title">
				<i class="more-less pull-right icon-plus"></i>
				Basic Details
			</h4>
		</a>
	</div>
	<div class="widget-body edit-case-cnt panel-collapse collapse" id="basicDetails">
		<div class="widget-main">
			<?php echo $this->Form->create('ClientCase', array('url' => '/cases/editBasicDetails/'.$caseId, 'class' => 'form-horizontal', 'name' => 'editBasicDetails', 'id' => 'editBasicDetails', 'novalidate' => true)); ?>
				<?php echo $this->element('Cases/add');?>
				<?php echo $this->Form->input('ClientCase.id', array('label' => false, 'div' => false, 'type' => 'hidden')); ?>
				<input type="hidden" name="data[ClientCase][submit]" value="" id ="basicDetailsHiddenSubmit">
				<div class="row">
                	<div class="col-sm-12">
                		<div class="clearfix pull-right custom-form-actions">
                			<?php echo $this->Form->button("<i class='icon-arrow-right bigger-110'></i>Next", array("class" => "btn btn-success btn-next saveBasicDetails", "escape" => false, "type" => "submit", "value" => "next"));?>
                			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save Incomplete Info", array("class" => "btn btn-info saveBasicDetails", "escape" => false, "type" => "submit", "value" => "saveIncomplete"));?>
                		</div>
                	</div>
                </div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>

	<?php if($caseDetails['ClientCase']['completed_step']>=1) { ?>
	<div class="widget-header">
		<a data-toggle="collapse" href="#clientInformation">
			<h4 class="col-sm-12 widget-title">
				<i class="more-less pull-right icon-plus"></i>
				Client Information
			</h4>
		</a>
	</div>
	<div class="widget-body edit-case-cnt panel-collapse collapse" id="clientInformation">
		<div class="widget-main">
			<?php echo $this->Form->create('ClientCase', array('url' => '/cases/editClientInfo/'.$caseId, 'class' => 'form-horizontal', 'name' => 'editClientInfo', 'id' => 'editClientInfo', 'novalidate' => true)); ?>
				<?php echo $this->element('Cases/client_info_fields');?>
				<?php echo $this->Form->input('ClientCase.id', array('label' => false, 'div' => false, 'type' => 'hidden')); ?>
				<input type="hidden" name="data[ClientCase][submit]" value="" id ="clientInfoHiddenSubmit">
				<div class="row">
                	<div class="col-sm-12">
                		<div class="clearfix pull-right custom-form-actions">
                			<?php echo $this->Form->button("<i class='icon-arrow-right bigger-110'></i>Next", array("class" => "btn btn-success btn-next saveClientInfo", "escape" => false, "type" => "submit", "value" => "next"));?>
                			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save Incomplete Info", array("class" => "btn btn-info saveClientInfo", "escape" => false, "type" => "submit", "value" => "saveIncomplete"));?>
                		</div>
                	</div>
                </div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
	<?php } ?>

	<?php if($caseDetails['ClientCase']['completed_step']>=2) { ?>
	<div class="widget-header">
		<a data-toggle="collapse" href="#feesInformation">
			<h4 class="col-sm-12 widget-title">
				<i class="more-less pull-right icon-plus"></i>
				Fees Information
			</h4>
		</a>
	</div>
	<div class="widget-body edit-case-cnt panel-collapse collapse" id="feesInformation">
		<div class="widget-main">
			<?php echo $this->element('Cases/payments');?>
		</div>
	</div>
	<?php } ?>

	<?php if($caseDetails['ClientCase']['completed_step']>=3) { ?>
	<div class="widget-header">
		<a data-toggle="collapse" href="#remarks">
			<h4 class="col-sm-12 widget-title">
				<i class="more-less pull-right icon-plus"></i>
				Remarks
			</h4>
		</a>
	</div>
	<div class="widget-body edit-case-cnt panel-collapse collapse" id="remarks">
		<div class="widget-main">
			<?php echo $this->Form->create('ClientCase', array('url' => '/cases/editRemarks/'.$caseId, 'class' => 'form-horizontal', 'name' => 'editRemarks', 'id' => 'editRemarks', 'novalidate' => true)); ?>
				<div class="col-xs-12">
					<div class="form-group">
						<div class="col-sm-12 col-xs-12">
							<?php echo $this->Form->input('ClientCase.remarks', array('label' => false, 'div' => false, 'type' => 'textarea', 'error' => false, 'class' => 'col-sm-12 col-xs-12')); ?>
						</div>
					</div>
				</div>
				<?php echo $this->Form->input('ClientCase.id', array('label' => false, 'div' => false, 'type' => 'hidden')); ?>
				<input type="hidden" name="data[ClientCase][submit]" value="" id ="remarksHiddenSubmit">
				<div class="row">
                	<div class="col-sm-12">
                		<div class="clearfix pull-right custom-form-actions">
                			<?php echo $this->Form->button("<i class='icon-arrow-right bigger-110'></i>Next", array("class" => "btn btn-success btn-next saveRemarks", "escape" => false, "type" => "submit", "value" => "next"));?>
                			<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save Incomplete Info", array("class" => "btn btn-info saveRemarks", "escape" => false, "type" => "submit", "value" => "saveIncomplete"));?>
                		</div>
                	</div>
                </div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
	<?php } ?>

	<?php if($caseDetails['ClientCase']['completed_step']>=4 && $caseDetails['ClientCase']['client_type']=='petitioner') { ?>
	<div class="widget-header">
		<a data-toggle="collapse" href="#caseFiling">
			<h4 class="col-sm-12 widget-title">
				<i class="more-less pull-right icon-plus"></i>
				Appellant Case Filing
			</h4>
		</a>
	</div>
	<div class="widget-body edit-case-cnt panel-collapse collapse" id="caseFiling">
		<div class="widget-main">
			<?php echo $this->element('Cases/filings');?>
		</div>
	</div>
	<?php } ?>

	<?php if($caseDetails['ClientCase']['completed_step']>=4 && !empty($caseDetails['ClientCase']['case_number'])) { ?>
		<div class="widget-header">
			<a data-toggle="collapse" href="#essentialWorks">
				<h4 class="col-sm-12 widget-title">
					<i class="more-less pull-right icon-plus"></i>
					Essential Works
				</h4>
			</a>
		</div>
		<div class="widget-body edit-case-cnt panel-collapse collapse" id="essentialWorks">
			<div class="widget-main">
				<?php echo $this->Session->flash();?>
				<?php echo $this->Form->create('ClientCase', array('url' => '/cases/updateEssentialWorks/'.$caseId, 'class' => 'form-horizontal', 'name' => 'formEssentialWorks', 'id' => 'formEssentialWorks', 'novalidate' => true)); ?>
					<?php echo $this->Form->input('ClientCase.id', array('label' => false, 'div' => false, 'type' => 'hidden')); ?>

					<?php foreach($essentialWorksArr as $essentialWorkKey=>$essentialWork){ ?>
					<div class="col-sm-12">
						<div class="form-group">
							<div class="col-sm-12">
								<span class="help-inline col-xs-12 col-sm-7">
									<label>
										<?php
										$workChecked = '';
										if(!empty($caseDetails['ClientCase'][$essentialWorkKey])){
											$workChecked = 'checked="checked"';
										} ?>

										<input class="ace" <?php echo $workChecked; ?> value=1 name="data[ClientCase][<?php echo $essentialWorkKey; ?>]" type="checkbox">
										<span class="lbl"> <?php echo $essentialWork; ?></span>
									</label>
								</span>
							</div>
						</div>
					</div>
					<?php } ?>

					<div class="row">
						<div class="col-sm-12">
							<div class="clearfix pull-right custom-form-actions">
								<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Update", array("class" => "btn btn-info updateCaseEssentials", "escape" => false, "type" => "button"));?>
							</div>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>

		<?php if(!empty($caseDetails['CaseStatus']['status']) && $caseDetails['CaseStatus']['status']=='decided') { ?>
			<div class="widget-header">
				<a data-toggle="collapse" href="#caseDecision">
					<h4 class="col-sm-12 widget-title">
						<i class="more-less pull-right icon-plus"></i>
						Case Decision
					</h4>
				</a>
			</div>
			<div class="widget-body edit-case-cnt panel-collapse collapse" id="caseDecision">
				<?php echo $this->element('Cases/decision');?>
			</div>
		<?php } ?>
	<?php } ?>

	<?php if($caseDetails['ClientCase']['client_type']=='petitioner'){ ?>
		<div class="hide" id="fifthStep">caseFiling</div>
	<?php } else { ?>
		<div class="hide" id="fifthStep">essentialWorks</div>
	<?php } ?>
</div>
<?php echo $this->Html->script('pages/ajax_edit_case.js'); ?>