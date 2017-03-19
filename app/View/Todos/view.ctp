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
					<h4 class="widget-title">Todo Details</h4>
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
											echo !empty($Todo['ClientCase']['case_title']) ? strtoupper($Todo['ClientCase']['case_title']) : 'Not Available';
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
											echo !empty($Todo['ClientCase']['computer_file_no']) ? $Todo['ClientCase']['computer_file_no'] : 'Not Available';
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
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Title:</b> </label>
										<div class="col-sm-8">
											<?php
											echo strtoupper($Todo['Todo']['title']);
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Completion Date:</b> </label>
										<div class="col-sm-8">
											<?php
											echo $this->Time->format('D, M jS, Y', $Todo['Todo']['completion_date']);
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
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Priority:</b> </label>
										<?php 
										if ($Todo['Todo']['priority'] == 'normal') { ?>
											<div class="col-sm-2 label label-lg label-yellow arrowed arrowed-right">
										<?php
										} else if ($Todo['Todo']['priority'] == 'high') {
										?>
											<div class="col-sm-2 label label-lg label-danger arrowed arrowed-right">
										<?php
										} else if ($Todo['Todo']['priority'] == 'urgent') {
										?>
											<div class="col-sm-2 label label-lg label-inverse arrowed arrowed-right">
										<?php
										} else {
										?>
											<div class="col-sm-2 label label-lg arrowed arrowed-right">
										<?php
										}
										echo strtoupper($Todo['Todo']['priority']);
										?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Status:</b> </label>
										<?php if ($Todo['Todo']['status'] == 'pending') { ?>
										<div class="col-sm-2 label label-lg label-yellow arrowed-in arrowed-in-right">
										<?php
										} else {
										?>
										<div class="col-sm-2 label label-lg label-success arrowed-in arrowed-in-right">
										<?php
										}
										echo strtoupper($Todo['Todo']['status']);
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
										<label class="col-sm-4 control-label no-padding-right" for="form-field-dob"> <b>Description:</b> </label>
										<div class="col-sm-8">
											<?php
											echo $Todo['Todo']['description'];
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="clearfix pull-right">
									<?php echo $this->Html->link("Edit", array('controller' => 'Todos', 'action' => 'edit/'.$Todo['Todo']['id']), array('class' => 'btn btn-primary'));?>
									<?php
									if ($action == 'caseTodos') {
										echo $this->Html->link("Back", array('controller' => 'Todos', 'action' => 'caseTodos', $caseId), array('class' => 'btn btn-info'));
									} else {
										echo $this->Html->link("Back", array('controller' => 'Todos', 'action' => 'index'), array('class' => 'btn btn-info'));
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