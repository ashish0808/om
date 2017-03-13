<?php
echo $this->Html->script('listing'); ?>
<?php $this->Paginator->options(array(
    'update' => '#content',
    'evalScripts' => true,
    'before' => $this->Js->get('#overlay_img')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#overlay_img')->effect('fadeOut', array('buffer' => false)),
)); ?>
<div class="page-header position-relative">
    <h1>
        Cases Management
    </h1>
</div>
<?php
$data = $this->Js->get('#casesListForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#casesListForm')->event(
    'submit',
    $this->Js->request(
        array('action' => 'manage'),
        array(
            'update' => '#content',
            'data' => $data,
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
echo $this->Form->create('ClientCase',array('url' => '/cases/manage','id'=>'casesListForm','name'=>'casesListForm')); ?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-header widget-header-small">
                    <h5 class="lighter">Search Form</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <?php echo $this->Form->input('ClientCase.client_name', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Client Name')); ?>
                        <?php echo $this->Form->input('ClientCase.client_email', array('label' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Client Email','required' => false)); ?>
                        <?php echo $this->Form->input('ClientCase.opponent_name', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Opponent Name')); ?>

                        <?php
                        echo $this->Form->button("<i class='icon-search icon-on-right bigger-110'></i>Search",
                            array("class"=>"btn btn-purple btn-small","escape"=>false,
                                "type"=>"submit"));
						echo $this->Js->writeBuffer(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row-fluid">
<div class="span12">
        <div class="row-fluid">
			<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
			<div class="row-fluid">
				<div class="span6">
					<div id="sample-table-2_length" class="dataTables_length">
						<label>
							Display
							<?php
							$pagingLimitOptions = array('10'=>'10','25'=>'25','50'=>'50','100'=>'100');
							echo $this->Form->input('ClientCase.paging_limit',array('id'=>'paging_limit','type' =>'select', 'options'=>$pagingLimitOptions,'label'=>'','readonly'=>'','div'=>false,'label'=>false,"onchange"=>"setPagingLimit('casesListForm');","value"=>$paginateLimit)); ?>
							 records
						</label>
					</div>
				</div>
			</div>
			<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
				   aria-describedby="sample-table-2_info">
			<thead>
			<tr role="row">
				<th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 51px;" aria-label="">
					<label>
						<input type="checkbox" class="ace" onclick="changeCheckboxStatus(casesListForm)" name="selectAll" id='checkall'>
						<span class="lbl"></span>
					</label>
				</th>
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('ClientCase.client_first_name', 'Client Name', array());?>
				</th>
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('ClientCase.client_email', 'Client Email', array());?>
				</th>
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('ClientCase.opponent_first_name', 'Opponent Name', array());?>
				</th>
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1">
					<?php echo $this->Paginator->sort('ClientCase.stage', 'Stage', array());?>
				</th>
				<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 146px; " aria-label=""></th>
			</tr>
			</thead>
			<tbody role="alert" aria-live="polite" aria-relevant="all">
			<?php $i=($this->params['paging']['ClientCase']['page']-1)*LIMIT+1;
			if(isset($records) && !empty($records)){
				foreach ($records as $record){ ?>
				<tr class="<?php echo ($i%2==1)?'odd':'even';?>"">
					<td class="center  sorting_1">
						<label>
							<input type="checkbox" class="ace">
							<input type="checkbox" class="ace" onclick="toggleCheck(casesListForm)" name="box[]" value="<?php echo $record['ClientCase']['id']; ?>" >
							<span class="lbl"></span>
						</label>
					</td>
					<td class=" ">
						<?php echo $record['ClientCase']['client_first_name'].' '.$record['ClientCase']['client_last_name'];?>
					</td>
					<td class=" "><?php echo $record['ClientCase']['client_email']; ?></td>
					<td class=" ">
						<?php echo $record['ClientCase']['opponent_first_name'].' '.$record['ClientCase']['opponent_last_name'];?>
					</td>
					<td>
						<?php echo $record['ClientCase']['stage']; ?>
					</td>
					<td class=" ">
						<div class="hidden-phone visible-desktop action-buttons">
							<?php echo $this->Html->link('<i class="icon-tasks bigger-130"></i>', array('controller'=>'cases','action'=>'manageHearings',$record['ClientCase']['id']), array('escape' => false, 'class' => 'green'))?>

							<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'cases','action'=>'add',$record['ClientCase']['id']), array('escape' => false, 'class' => 'green'))?>

							<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'cases','action'=>'delete',$record['ClientCase']['id']), array('escape' => false, 'class' => 'red'),"Are you sure you want to delete this case?")?>

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
										<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'cases','action'=>'add',$record['ClientCase']['id']), array('escape' => false, 'class' => 'green'))?>
									</li>

									<li>
										<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'cases','action'=>'delete',$record['ClientCase']['id']), array('escape' => false, 'class' => 'red'),"Are you sure you want to delete this case?")?>
									</li>
								</ul>
							</div>
						</div>
					</td>
				</tr>
				<?php
					$i++;
				} ?>
				<tFoot>
					<tr role="row">
						<th role="columnheader" style="border-right: none !important;">
							<?php
							$updateStatusOptions = array('Update Stage', 'Open' => 'Open', 'Close' => 'Close');
							echo $this->Form->input('ClientCase.stage',array('id'=>'paging_limit','type' =>'select', 'options'=>$updateStatusOptions,'label'=>'','readonly'=>'','div'=>false,'label'=>false,'id'=>'status',"onchange"=>"updateRecords(this.value,'casesListForm');")); ?>
						</th>
						<th role="columnheader" colspan="8" style="border-left: none !important;">
							<?php if($this->params['paging']['ClientCase']['count']>LIMIT){?>
								<?php echo $this->Element('pagination');?>
							<?php } ?>
						</th>
					</tr>
				</tFoot>
			<?php }else{
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
<?php echo $this->Form->end(); ?>