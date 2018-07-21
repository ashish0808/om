<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<div class="col-sm-12 widget-container-col ui-sortable">
			<div class="widget-box transparent ui-sortable-handle">
				<?php echo $this->element('Cases/top_menus');?>

				<div class="widget-body edit-case-cnt">
					<div class="widget-main padding-12">
						<div class="tab-content padding-4">
							<div class="tab-pane active">
								<?php echo $this->Form->create('ClientCase', array('type'=>'file', 'url' => '/CaseFiles/addMainCaseFile/'.$caseId, 'class' => 'form-horizontal', 'name' => 'add', 'id' => 'add')); ?>
									<?php echo $this->Form->hidden('ClientCase.id', array('value' => $caseId)); ?>
									<div class="row">
										<div class="col-sm-12">
											<label class="col-sm-2 control-label no-padding-right" for="form-field-dob"><span class="required">*</span> Case File: </label>
											<div class="col-sm-10">
												<input name="file" class="col-sm-12 col-xs-12" id="ClientCaseFile" type="file">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<div class="clearfix pull-right custom-form-actions">
												<?php echo $this->Html->link('<i class="icon-arrow-left bigger-110"></i> Back To List ', array('controller'=>'CaseFiles','action'=>'manage', $caseId), array('escape' => false, 'class' => 'btn btn-next'))?>
												<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Save", array("class" => "btn btn-info", "escape" => false, "type" => "submit"));?>
											</div>
										</div>
									</div>
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->