<div class="row-fluid">
	<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
	<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
		   aria-describedby="sample-table-2_info">
		<thead>
			<tr role="row">
				<th class="col-xs-3" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					Case No
				</th>
				<th class="col-xs-3" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					Title
				</th>
				<th class="col-xs-3" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('Dispatch.date_of_dispatch', 'Date of Dispatch', array());?>
				</th>
				<th class="col-xs-3" role="columnheader" rowspan="1" colspan="1" aria-label="">Action</th>
			</tr>
		</thead>
		<tbody role="alert" aria-live="polite" aria-relevant="all">
		<?php $i = ($this->params['paging']['Dispatch']['page']-1) * LIMIT + 1;
		if (isset($Dispatches) && !empty($Dispatches)) {
			foreach ($Dispatches as $record){ ?>
			<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
				<td class=" "><?php echo $record['ClientCase']['case_number'] ? $record['ClientCase']['case_number']: "<span class='red'>Miscellaneous</span>"; ?></td>
				<td class=" "><?php echo $record['Dispatch']['title'];?></td>
				<td class=""><?php echo $this->Time->format('D, M jS, Y', $record['Dispatch']['date_of_dispatch']); ?>
				</td>
				<td class=" ">
					<div class="hidden-phone visible-desktop action-buttons">
						<?php echo $this->Html->link('<i class="icon-tasks bigger-130"></i>', array('controller'=>'Dispatches','action'=>'view',$record['Dispatch']['id']), array('escape' => false, 'class' => 'green tooltip-success', 'data-rel' => 'tooltip', 'data-original-title'=>'View Dispatch'))?>
						<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'Dispatches','action'=>'edit',$record['Dispatch']['id']), array('escape' => false, 'class' => 'blue tooltip-info', 'data-rel' => 'tooltip', 'data-original-title'=>'Edit Dispatch'))?>
						<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'Dispatches','action'=>'delete',$record['Dispatch']['id']), array('escape' => false, 'class' => 'red tooltip-error', 'data-rel' => 'tooltip', 'data-original-title'=>'Delete Dispatch'),"Are you sure you want to delete this Dispatch?")?>

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
									<?php echo $this->Html->link('<i class="icon-tasks bigger-130"></i>', array('controller'=>'Dispatches','action'=>'view',$record['Dispatch']['id']), array('escape' => false, 'class' => 'green tooltip-success', 'data-rel' => 'tooltip', 'data-original-title'=>'View Dispatch'))?>
								</li>
								<li>
									<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'Dispatches','action'=>'edit',$record['Dispatch']['id']), array('escape' => false, 'class' => 'blue tooltip-info', 'data-rel' => 'tooltip', 'data-original-title'=>'Edit Dispatch'))?>
								</li>

								<li>
									<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'Dispatches','action'=>'delete',$record['Dispatch']['id']), array('escape' => false, 'class' => 'red tooltip-error', 'data-rel' => 'tooltip', 'data-original-title'=>'Delete Dispatch'),"Are you sure you want to delete this application?")?>
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
						if ($this->params['paging']['Dispatch']['count'] > 1) {
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