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
					<h4 class="widget-title">CM/CRM Details</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Case Title:</b> </label>
										<div class="col-sm-8">
											<?php
											echo strtoupper($CaseCivilMisc['ClientCase']['case_title']);
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Computer File No:</b> </label>
										<div class="col-sm-8">
											<?php
											echo $CaseCivilMisc['ClientCase']['computer_file_no'];
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Application Type:</b> </label>
										<div class="col-sm-8">
											<?php
											echo strtoupper($CaseCivilMisc['CaseCivilMisc']['cm_type']);
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Application No:</b> </label>
										<div class="col-sm-8">
											<?php
											echo $CaseCivilMisc['CaseCivilMisc']['cm_no'];
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Application Date:</b> </label>
										<div class="col-sm-8">
											<?php 
											echo $this->Time->format('F j, Y',$CaseCivilMisc['CaseCivilMisc']['application_date']);
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Application Status:</b> </label>
										<?php if ($CaseCivilMisc['CaseCivilMisc']['status'] == 'pending') { ?>
										<div class="col-sm-2 label label-warning arrowed-in arrowed-in-right">
										<?php
										} else {
										?>
										<div class="col-sm-2 label label-success arrowed-in arrowed-in-right">
										<?php
										}
										echo strtoupper($CaseCivilMisc['CaseCivilMisc']['status']);
										?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Attachment:</b> </label>
										<div class="col-sm-8">
											<?php 
											if (!empty($CaseCivilMisc['CaseCivilMisc']['attachment'])) {
											?>
											<a href="<?php echo $CaseCivilMisc['CaseCivilMisc']['attachment'];?>" target="_blank" 'class'='col-sm-12 col-xs-12'>Application Copy</a>
											<?php 
											} else {
												echo "Not Available";
											}
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Remarks:</b> </label>
										<div class="col-sm-8">
											<?php
											echo $CaseCivilMisc['CaseCivilMisc']['remarks'];
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="clearfix pull-right">
									<?php echo $this->Html->link("Edit", array('controller' => 'CaseCivilMiscs', 'action' => 'edit/'.$CaseCivilMisc['CaseCivilMisc']['id']), array('class' => 'btn btn-primary'));?>
									<?php echo $this->Html->link("Back", array('controller' => 'CaseCivilMiscs', 'action' => 'index'), array('class' => 'btn btn-info'));?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <?php echo $this->Form->end(); ?>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->