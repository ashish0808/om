<div class="page-content">
	<div class="row">
		<div class="page-header" align="center">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<div class="col-sm-12">
			<div class="invoice-box">
				<?php if(isset($CaseProceedings)){ ?>
				<table class="borderedTable">
					<tr>
						<th colspan="10" style="text-align: center;">
							Case Proceedings
						</th>
					</tr>
					<tr>
						<th>Case No.</th>
						<th>Case Title</th>
						<th>Cr. No.</th>
						<th>Sr. No.</th>
						<th>Court</th>
						<th>Remarks</th>
						<th>Next Date</th>
					</tr>
					<?php if (!empty($CaseProceedings)) {
						foreach ($CaseProceedings as $record) { ?>
						<tr>
							<td>
								<?php echo $record['ClientCase']['complete_case_number']; ?>
							</td>
							<td><?php echo $record['ClientCase']['case_title'] ? $record['ClientCase']['case_title']: "<span class='red'>Miscellaneous</span>";?></td>
							<td><?php echo $record['CaseProceeding']['court_room_no']; ?></td>
							<td><?php echo $record['CaseProceeding']['court_serial_no']; ?></td>
							<td><?php echo $record['ClientCase']['Court']['name']; ?></td>
							<td><?php echo $record['CaseProceeding']['remarks']; ?></td>
							<td>
							<?php
								echo $this->Time->format('D, M jS, Y', $record['CaseProceeding']['next_date_of_hearing']);
							?>
							</td>
						</tr>
					<?php } } else { ?>
						<tr>
							<td style="text-align: center;" colspan="10">
								<?php echo NO_RECORD;?>
							</td>
						</tr>
					<?php } ?>
				</table>
				<?php } ?>

				<?php if(isset($Todos)){ ?>
				<table class="borderedTable">
					<tr>
						<th colspan="10" style="text-align: center;">
							Todos
						</th>
					</tr>
					<tr>
						<th>Case No.</th>
						<th>Case Title</th>
						<th>Title</th>
						<th>Completion Date</th>
						<th>Priority</th>
						<th>Status</th>
					</tr>
					<?php if (!empty($Todos)) {
						foreach ($Todos as $record) { ?>
						<tr>
							<td>
								<?php echo $record['ClientCase']['complete_case_number']; ?>
							</td>
							<td><?php echo $record['ClientCase']['case_title'] ? $record['ClientCase']['case_title']: "<span class='red'>Miscellaneous</span>";?></td>
							<td><?php echo $record['Todo']['title'];?></td>
							<td><?php echo $this->Time->format('D, M jS, Y', $record['Todo']['completion_date']); ?>
							</td>
							<td>
								<?php
								if ($record['Todo']['priority'] == 'normal') { ?>
									<div class="label label-lg label-yellow arrowed arrowed-right">
									<?php
								} else if ($record['Todo']['priority'] == 'high') {
								?>
									<div class="label label-lg label-danger arrowed arrowed-right">
								<?php
								} else if ($record['Todo']['priority'] == 'urgent') {
								?>
									<div class="label label-lg label-inverse arrowed arrowed-right">
								<?php
								} else {
								?>
									<div class="label label-lg arrowed arrowed-right">
								<?php
								}
								echo strtoupper($record['Todo']['priority']);
								?>
							</td>
							<td>
								<?php
								if ($record['Todo']['status'] == 'pending') { ?>
									<div class="label label-lg label-yellow arrowed-in arrowed-in-right">
									<?php
								} else if ($record['Todo']['status'] == 'in_progress') {
								?>
									<div class="label label-lg label-primary arrowed-in arrowed-in-right">
								<?php
								} else {
								?>
									<div class="label label-lg label-success arrowed-in arrowed-in-right">
								<?php
								}
								if ($record['Todo']['status'] == 'in_progress') {
									echo strtoupper('In Progress');
								} else {
									echo strtoupper($record['Todo']['status']);
								}
								?>
							</td>
						</tr>
					<?php } } else { ?>
						<tr>
							<td style="text-align: center;" colspan="10">
								<?php echo NO_RECORD;?>
							</td>
						</tr>
					<?php } ?>
				</table>
				<?php } ?>
			</div>
		</div>
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->
<?php echo $this->Html->css('print'); ?>
<script type="text/javascript">
	window.print();
	window.close();
</script>