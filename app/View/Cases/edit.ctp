<?php

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
}
?>
<div id="getDefaultOpenTab"><?php echo $defaultCollapseIn; ?></div>
<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>

		<div class="col-sm-12 col-xs-12" id="accordion" role="tablist" aria-multiselectable="true">
			<div class="widget-box panel-group">
				<div class="widget-header">
					<a data-toggle="collapse" href="#basicDetails">
						<h4 class="col-sm-12 widget-title">
							<i class="more-less pull-right icon-plus"></i>
							Basic Details
						</h4>
					</a>
				</div>
				<div class="widget-body panel-collapse collapse" id="basicDetails">
					<div class="widget-main">
						<?php echo $this->Form->create('ClientCase', array('url' => '/cases/edit/', 'class' => 'form-horizontal', 'name' => 'edit', 'id' => 'edit', 'novalidate' => true)); ?>
							<?php echo $this->element('Cases/add');?>
						<?php echo $this->Form->end(); ?>
					</div>
				</div>

				<div class="widget-header">
					<a data-toggle="collapse" href="#clientInformation">
						<h4 class="col-sm-12 widget-title">
							<i class="more-less pull-right icon-plus"></i>
							Client Information
						</h4>
					</a>
				</div>
				<div class="widget-body panel-collapse collapse" id="clientInformation">
					<div class="widget-main">

					</div>
				</div>


				<div class="widget-header">
					<a data-toggle="collapse" href="#feesInformation">
						<h4 class="col-sm-12 widget-title">
							<i class="more-less pull-right icon-plus"></i>
							Fees Information
						</h4>
					</a>
				</div>
				<div class="widget-body panel-collapse collapse" id="feesInformation">
					<div class="widget-main">

					</div>
				</div>

				<div class="widget-header">
					<a data-toggle="collapse" href="#remarks">
						<h4 class="col-sm-12 widget-title">
							<i class="more-less pull-right icon-plus"></i>
							Remarks
						</h4>
					</a>
				</div>
				<div class="widget-body panel-collapse collapse" id="remarks">
					<div class="widget-main">

					</div>
				</div>
			</div>
		</div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->
<?php echo $this->Html->script('pages/add_case.js'); ?>
<?php echo $this->Html->script('pages/edit_case.js'); ?>