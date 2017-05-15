<?php
if ($pageType == 'case_history') {
	$redirectUrl = $this->Html->url(array('controller' => 'CaseProceedings', 'action' => 'caseHistory', $caseId));
?>
<div class="row-fluid">
	<?php echo $this->Html->link('Add Case History', array('controller'=>'CaseProceedings','action'=>'add',$caseDetails['ClientCase']['id']), array('escape' => false, 'class' => 'tooltip-info btn btn-primary', 'data-rel' => 'tooltip', 'data-original-title'=>'Add new CM/CRM'));
	?>
</div>
<?php
} else {
	$redirectUrl = $this->Html->url(array('controller' => 'CaseProceedings', 'action' => 'index'));
}
?>
<div class="row-fluid">
	<div class="span12">
        <div class="row-fluid">
			<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
			<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
				   aria-describedby="sample-table-2_info">
				<thead>
					<tr role="row">
						<?php 
						if ($pageType == 'case_history') {
							?>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1">
							Proceeding Date
						</th>
						<?php
						} else {
						?>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1">
							Case No
						</th>
						<?php
						}
						?>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Case Title
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Cr. No.
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Sr. No.
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Court
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Remarks
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Next Date
						</th>
						<th class="col-xs-1" role="columnheader" rowspan="1" colspan="1" aria-label="">Action</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php $i = 1;
				if (!empty($CaseProceedings)) {
					foreach ($CaseProceedings as $record) {
					?>
					<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
						<?php 
						if ($pageType == 'case_history') {
							?>
						<td class=" "><?php echo $this->Time->format('D, M jS, Y', $record['CaseProceeding']['date_of_hearing']);?></td>
						<?php
						} else {
						?>
						<td>
							<?php echo $this->Html->link($record['ClientCase']['complete_case_number'], array('controller' => 'Cases', 'action' => 'view', $record['ClientCase']['id']));
							?>
						</td>
						<?php
						}
						?>
						<td class=" "><?php echo $record['ClientCase']['case_title'];?></td>
						<td class=" "><?php echo $record['CaseProceeding']['court_room_no']; ?></td>
						<td class=" "><?php echo $record['CaseProceeding']['court_serial_no']; ?></td>
						<td class=" "><?php echo $record['ClientCase']['Court']['name']; ?></td>
						<td class=" "><?php echo $record['CaseProceeding']['remarks']; ?></td>
						<td>
						<?php
							echo $this->Time->format('D, M jS, Y', $record['CaseProceeding']['next_date_of_hearing']);
						?>
						</td>
						<td class=" ">
							<div class="hidden-phone visible-desktop action-buttons">
								<?php echo $this->Html->link('View/Edit', "javascript:void(0)", array('escape' => false, 'class' => 'btn btn-primary editCaseProceeding', 'pageTitle' => 'Edit Case Proceeding', 'pageName' => $this->Html->url(array('controller' => 'CaseProceedings', 'action' => 'editCaseProceeding')).'/'.$record['CaseProceeding']['id'].'/'.$date.'/'.$pageType, 'redirectUrl' => $redirectUrl)); ?>
							</div>
							<div class="hidden-desktop visible-phone">
								<div class="inline position-relative">
									<button data-toggle="dropdown" class="btn btn-minier btn-yellow dropdown-toggle">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<?php echo $this->Html->link('View/Edit', "javascript:void(0)", array('escape' => false, 'class' => 'btn btn-primary editCaseProceeding', 'pageTitle' => 'Edit Case Proceeding', 'pageName' => $this->Html->url(array('controller' => 'CaseProceedings', 'action' => 'editCaseProceeding')).'/'.$record['CaseProceeding']['id'].'/'.$date.'/'.$pageType)); ?>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>
					<?php echo $this->Js->writeBuffer(); ?>
					<?php
						$i++;
					}
					?>
				<?php } else {
					?>
						<tr>
							<td class="center" colspan="12">
								<label>
									<span class="notify_message"><?php echo NO_RECORD;?></span>
								</label>
							</td>
						</tr>
					<?php
				}?>
				</tbody>
			</table>
			</div>
        </div>
    </div>
</div>