<div class="page-header position-relative">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
</div>

<?php if (count($records) > 0) {?>
<div class="row-fluid">
	<div class="span12">
        <div class="row-fluid">
			<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
			<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
				   aria-describedby="sample-table-2_info">
				<thead>
					<tr role="row">
						<th>Case Number</th>
						<th>Computer File No</th>
						<th>Case Title</th>
						<th>Alert</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php $i = 1;
				if (isset($records) && !empty($records)) {
					foreach ($records as $record){ ?>
					<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
						<td class=" "><?php echo $record['ClientCase']['complete_case_number'];?></td>
						<td class=" "><?php echo $record['ClientCase']['computer_file_no'];?></td>
							<td class=" "><?php echo $record['ClientCase']['case_title'] ? $record['ClientCase']['case_title']: "<span class='red'>Miscellaneous</span>"; ?></td>
						<td>
						<?php
							echo $record['ClientCase']['message'];
						?>
						</td>
						<td class=" ">
							<div class="hidden-phone visible-desktop action-buttons">
								<?php echo $this->Html->link('<i class="icon-tasks bigger-130"></i>', array('controller'=>'cases','action'=>'view',$record['ClientCase']['id']), array('escape' => false, 'class' => 'green tooltip-success', 'data-rel' => 'tooltip', 'data-original-title'=>'View Case'))?>
								<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'cases','action'=>'edit',$record['ClientCase']['id']), array('escape' => false, 'class' => 'green tooltip-success', 'data-rel' => 'tooltip', 'data-original-title'=>'Edit Case'))?>

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
											<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'cases','action'=>'edit',$record['ClientCase']['id']), array('escape' => false, 'class' => 'blue tooltip-info', 'data-rel' => 'tooltip', 'data-original-title'=>'Edit Case'))?>
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
								if ($this->params['paging']['ClientCase']['count'] > 1) {
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
<?php } ?>
<script type="text/javascript">
	$('[data-rel=tooltip]').tooltip();
</script>
<?php echo $this->Form->end(); ?>