<?php
if ($show_add) {
?>
<div class="row-fluid">
	<?php echo $this->Html->link('Add', array('controller'=>'Todos','action'=>'add',trim(Inflector::slug($caseDetails['ClientCase']['computer_file_no']))), array('escape' => false, 'class' => 'tooltip-info btn btn-primary', 'data-rel' => 'tooltip', 'data-original-title'=>'Add new Todo'));
	?>
</div>
<?php
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
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Case No
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Title
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							<?php echo $this->Paginator->sort('Todo.completion_date', 'Completion Date', array());?>
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Priority
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							status
						</th>
						<th class="col-xs-2" role="columnheader" rowspan="1" colspan="1" aria-label="">Action</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php $i = ($this->params['paging']['Todo']['page']-1) * LIMIT + 1;
				if (isset($Todos) && !empty($Todos)) {
					foreach ($Todos as $record) { ?>
					<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
						<td class=" "><?php echo $record['ClientCase']['case_number'] ? $this->Html->link($record['ClientCase']['complete_case_number'], array('controller' => 'Cases', 'action' => 'view', $record['ClientCase']['id'])): "<span class='red'>Miscellaneous</span>"; ?></td>
						<td class=" "><?php echo $record['Todo']['title'];?></td>
						<td class=""><?php echo $this->Time->format('D, M jS, Y', $record['Todo']['completion_date']); ?>
						</td>
						<td class=" ">
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
						<td class=" ">
							<?php
							if ($record['Todo']['status'] == 'pending') { ?>
								<div class="label label-lg label-yellow arrowed-in arrowed-in-right">
								<?php
							} else {
							?>
								<div class="label label-lg label-success arrowed-in arrowed-in-right">
							<?php
							}
							echo strtoupper($record['Todo']['status']);
							?>
						</td>
						<td class=" ">
							<div class="hidden-phone visible-desktop action-buttons">
								<?php echo $this->Html->link('<i class="icon-tasks bigger-130"></i>', array('controller'=>'Todos','action'=>'view',$record['Todo']['id']), array('escape' => false, 'class' => 'green tooltip-success', 'data-rel' => 'tooltip', 'data-original-title'=>'View Todo'))?>
								<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'Todos','action'=>'edit',$record['Todo']['id']), array('escape' => false, 'class' => 'blue tooltip-info', 'data-rel' => 'tooltip', 'data-original-title'=>'Edit Todo'))?>
								<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'Todos','action'=>'delete',$record['Todo']['id']), array('escape' => false, 'class' => 'red tooltip-error', 'data-rel' => 'tooltip', 'data-original-title'=>'Delete Todo'),"Are you sure you want to delete this Todo?")?>

							</div>
							<div class="hidden-desktop visible-phone">
								<div class="inline position-relative">
									<button data-toggle="dropdown" class="btn btn-minier btn-yellow dropdown-toggle">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<a title="" data-rel="tooltip" class="tooltip-info" href="#" data-original-title="View">
												<span class="blue">
													<i class="icon-tasks bigger-120"></i>
												</span>
											</a>
										</li>

										<li>
											<?php echo $this->Html->link('<i class="icon-tasks bigger-130"></i>', array('controller'=>'Todos','action'=>'view',$record['Todo']['id']), array('escape' => false, 'class' => 'green tooltip-success', 'data-rel' => 'tooltip', 'data-original-title'=>'View Todo'))?>
										</li>
										<li>
											<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'Todos','action'=>'edit',$record['Todo']['id']), array('escape' => false, 'class' => 'blue tooltip-info', 'data-rel' => 'tooltip', 'data-original-title'=>'Edit Todo'))?>
										</li>
										<li>
											<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'Todos','action'=>'delete',$record['Todo']['id']), array('escape' => false, 'class' => 'red tooltip-error', 'data-rel' => 'tooltip', 'data-original-title'=>'Delete Todo'),"Are you sure you want to delete this Todo?")?>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>
					<?php
						$i++;
					}
					?>
					<tFoot>
						<tr role="row">
							<th role="columnheader" colspan="8" style="border-left: none !important;">
								<?php 
								if ($this->params['paging']['Todo']['count'] > 1) {
									echo $this->Element('pagination');
								}
								?>
							</th>
						</tr>
					</tFoot>
				<?php } else {
					?>
						<tr>
							<td class="center" colspan="7">
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