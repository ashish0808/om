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
					<h4 class="widget-title">Expense Details</h4>
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
											echo !empty($CasePayment['ClientCase']['case_title']) ? strtoupper($CasePayment['ClientCase']['case_title']) : 'Not Available';
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
											echo !empty($CasePayment['ClientCase']['computer_file_no']) ? $CasePayment['ClientCase']['computer_file_no'] : 'Not Available';
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
											echo !empty($CasePayment['ClientCase']['complete_case_number']) ? strtoupper($CasePayment['ClientCase']['complete_case_number']) : 'Not Available';
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Amount:</b> </label>
										<div class="col-sm-8">
											<?php
											echo number_format((float)$CasePayment['CasePayment']['amount'], 2, '.', '');
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
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Date of Payment:</b> </label>
										<div class="col-sm-8">
											<?php
											echo $this->Time->format('D, M jS, Y', $CasePayment['CasePayment']['date_of_payment']);
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Mode of Payment:</b> </label>
										<div class="col-sm-8">
											<?php
											echo $CasePayment['PaymentMethod']['method'];
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
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Remarks:</b> </label>
										<div class="col-sm-8">
											<?php
											echo $CasePayment['CasePayment']['notes'];
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="clearfix pull-right">
									<?php echo $this->Html->link("Edit", array('controller' => 'CasePayments', 'action' => 'edit/'.$CasePayment['CasePayment']['id']), array('class' => 'btn btn-primary'));?>
									<?php
									if ($action == 'caseExpenses') {
										echo $this->Html->link("Back", array('controller' => 'CasePayments', 'action' => 'caseExpenses', $caseId), array('class' => 'btn btn-info'));
									} else {
										echo $this->Html->link("Back", array('controller' => 'CasePayments', 'action' => 'index'), array('class' => 'btn btn-info'));
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