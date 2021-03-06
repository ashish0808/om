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
					<h4 class="widget-title">Dispatch Details</h4>
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
											echo !empty($Dispatch['ClientCase']['case_title']) ? strtoupper($Dispatch['ClientCase']['case_title']) : 'Not Available';
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
											echo !empty($Dispatch['ClientCase']['computer_file_no']) ? $Dispatch['ClientCase']['computer_file_no'] : 'Not Available';
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
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Case Number:</b> </label>
										<div class="col-sm-8">
											<?php
											echo !empty($Dispatch['ClientCase']['complete_case_number']) ? $Dispatch['ClientCase']['complete_case_number'] : 'Not Available';
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Dispatch Title:</b> </label>
										<div class="col-sm-8">
											<?php
											echo strtoupper($Dispatch['Dispatch']['title']);
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
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Mode of Dispatch:</b> </label>
										<div class="col-sm-8">
											<?php 
											if ($Dispatch['Dispatch']['mode_of_dispatch'] == 'by_hand') {
												echo "By Hand";
											} else if ($Dispatch['Dispatch']['mode_of_dispatch'] == 'courier') {
												echo "Courier";
											} else if ($Dispatch['Dispatch']['mode_of_dispatch'] == 'post') {
												echo "Post";
											} else if ($Dispatch['Dispatch']['mode_of_dispatch'] == 'email') {
												echo "Email";
											} else {
												echo "Fax";
											}
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Date of Dispatch:</b> </label>
										<div class="col-sm-8">
											<?php
											echo $this->Time->format('D, M jS, Y', $Dispatch['Dispatch']['date_of_dispatch']);
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
											if (!empty($Dispatch['Dispatch']['attachment'])) {
											?>
											<a href="<?php echo $Dispatch['Dispatch']['attachment'];?>" target="_blank" 'class'='col-sm-12 col-xs-12'>Application Copy</a>
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
											echo $Dispatch['Dispatch']['remarks'];
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="clearfix pull-right">
									<?php echo $this->Html->link("Edit", array('controller' => 'Dispatches', 'action' => 'edit/'.$Dispatch['Dispatch']['id']), array('class' => 'btn btn-primary'));?>
									<?php
									if ($action == 'caseDispatches') {
										echo $this->Html->link("Back", array('controller' => 'Dispatches', 'action' => 'caseDispatches', $caseId), array('class' => 'btn btn-info'));
									} else {
										echo $this->Html->link("Back", array('controller' => 'Dispatches', 'action' => 'index'), array('class' => 'btn btn-info'));
									}
									?>
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