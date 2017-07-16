<div class="row-fluid">
	<?php echo $this->Html->link('Add User', array('controller'=>'Users','action'=>'add', 'admin' => true), array('escape' => false, 'class' => 'tooltip-info btn btn-primary pull-right', 'data-rel' => 'tooltip', 'data-original-title'=>'Add User')); ?>
</div>
<br />
<div class="row-fluid">
	<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
	<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
		   aria-describedby="sample-table-2_info">
		<thead>
		  <?php if(isset($Users) && count($Users) > 1){ ?>
			<tr role="row">
				<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('User.first_name', 'First Name', array());?>
				</th>
				<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('User.last_name', 'Last Name', array());?>
				</th>
				<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('User.email', 'Email', array());?>
				</th>
				<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
				  <?php echo $this->Paginator->sort('User.last_login', 'Last Login', array());?>
				</th>
				<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('User.created', 'Created', array());?>
				</th>
				<th class="col-xs-2" role="columnheader" rowspan="1" colspan="1" aria-label="">Action</th>
			</tr>
			<?php }else{ ?>
			<tr role="row">
				<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					First Name
				</th>
				<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					Last Name
				</th>
				<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					Email
				</th>
				<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					Last Login
				</th>
				<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					Created
				</th>
				<th class="col-xs-2" role="columnheader" rowspan="1" colspan="1" aria-label="">Action</th>
			</tr>
			<?php } ?>
		</thead>
		<tbody role="alert" aria-live="polite" aria-relevant="all">
		<?php $i = ($this->params['paging']['User']['page']-1) * LIMIT + 1;
		if (isset($Users) && !empty($Users)) {
			foreach ($Users as $record){ ?>
			<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
				<td class=" "><?php echo $record['User']['first_name'];?></td>
				<td class=" "><?php echo $record['User']['last_name'];?></td>
				<td class=" "><?php echo $record['User']['email'];?></td>
				<td class=""><?php echo $this->Time->format('D, M jS, Y', $record['User']['last_login']); ?>
				</td>
				<td class=""><?php echo $this->Time->format('D, M jS, Y', $record['User']['created']); ?>
				</td>
				<td class=" ">
					<div class="hidden-phone visible-desktop action-buttons">
						<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'Users','action'=>'edit', $record['User']['id'], 'admin' => true), array('escape' => false, 'class' => 'blue tooltip-info', 'data-rel' => 'tooltip', 'data-original-title'=>'Edit User'))?>
						<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'Users','action'=>'delete',$record['User']['id'], 'admin' => true), array('escape' => false, 'class' => 'red tooltip-error', 'data-rel' => 'tooltip', 'data-original-title'=>'Delete User'),"Are you sure you want to delete this User?")?>
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
									<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'Users','action'=>'edit',$record['User']['id'], 'admin' => true), array('escape' => false, 'class' => 'blue tooltip-info', 'data-rel' => 'tooltip', 'data-original-title'=>'Edit User'))?>
								</li>

								<li>
									<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'Users','action'=>'delete',$record['User']['id']), array('escape' => false, 'class' => 'red tooltip-error', 'data-rel' => 'tooltip', 'data-original-title'=>'Delete User'),"Are you sure you want to delete this user?")?>
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
						if ($this->params['paging']['User']['count'] > 1) {
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
<script type="text/javascript">
	$('[data-rel=tooltip]').tooltip();
</script>