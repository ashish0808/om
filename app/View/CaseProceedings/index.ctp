<div class="page-header position-relative">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
</div>

<?php
$data = $this->Js->get('#CaseProceedingSearchForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#CaseProceedingSearchForm')->event(
    'submit',
    $this->Js->request(
        array(
        	'action' => 'index',
        ),
        array(
            'update' => '#content',
            'before'   => '$("#overlay_img").fadeIn()',
            'complete' => '$("#overlay_img").fadeOut()',
            'data' => $data,
            'async' => true,
            'dataExpression' => true,
            'method' => 'POST'
        )
    )
);
$this->Js->get('#CaseProceedingSearchForm')->event(
    'reset',
    $this->Js->request(
        array('action' => 'index'),
        array(
            'update' => '#content',
            'before'   => '$("#overlay_img").fadeIn()',
            'complete' => '$("#overlay_img").fadeOut()',
            'async' => true,
            'dataExpression' => true,
            'method' => 'POST'
        )
    )
);

/*$updateData = $this->Js->get('#CaseProceedingUpdateForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#CaseProceedingUpdateForm')->event(
    'submit',
    $this->Js->request(
        array(
        	'action' => 'index',
        ),
        array(
            'update' => '#content',
            'before'   => '$("#overlay_img").fadeIn()',
            'complete' => '$("#overlay_img").fadeOut()',
            'data' => $updateData,
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);*/

echo $this->Form->create('CaseProceedings',array('url' => '/CaseProceedings/','id'=>'CaseProceedingSearchForm','name'=>'CaseProceedingSearchForm'));?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-header widget-header-small">
                    <h5 class="lighter">Search Form</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <?php
                        echo $this->Form->input('CaseProceeding.date_of_hearing', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'input-medium search-query date-picker', 'placeholder' => 'Proceeding Date', 'data-date-format' => 'yyyy-mm-dd', 'autocomplete' => 'off', 'value' => $date));
                        ?>
                        <?php
                        echo $this->Form->button("<i class='icon-search icon-on-right bigger-110'></i>Search",
                            array("class"=>"btn btn-purple btn-sm","escape"=>false,
                                "type"=>"submit", "div" => false));
                        ?>
                        <?php
                        echo $this->Form->button("<i class='icon-on-right bigger-110'></i>Today",
                            array("class"=>"btn btn-sm","escape"=>false,
                                "type"=>"reset", "div" => false));
                        echo $this->Form->end();
                        echo $this->Js->writeBuffer();
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
	<div class="span12">
        
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
	  <b><h4 class="lighter">Case Proceedings</h4></b>
        <hr>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
        <div class="row-fluid">
			<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
			<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
				   aria-describedby="sample-table-2_info">
				<thead>
					<tr role="row">
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Proceeding Date
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Cr. No.
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Sr. No.
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1">
							Case No.
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Party Name
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Court
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Case Brief
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Case Status
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Referred to Lok Adalat
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
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
						$this->request->data = $record;
						?>
					<?php echo $this->Form->create('CaseProceeding', array('url' => '/CaseProceedings/', 'id'=>'CaseProceedingUpdateForm','name'=>'CaseProceedingUpdateForm', 'class' => 'form-horizontal', 'name' => 'edit', 'id' => 'edit')); 
						echo $this->Form->hidden('CaseProceeding.id');
						echo $this->Form->hidden('CaseProceeding.client_case_id');
						echo $this->Form->hidden('CaseProceeding.search_date', array('value' => $date));
					?>
					<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
						<td class=" ">
						<?php 
						echo $this->Form->input('CaseProceeding.date_of_hearing', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'placeholder' => 'Proceeding Date', 'data-date-format' => 'yyyy-mm-dd', 'autocomplete' => 'off'));
						?>
						</td>
						<td class=" ">
						<?php
						echo $this->Form->input('CaseProceeding.court_room_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
						// echo $record['CaseProceeding']['court_room_no'];
						?>
						</td>
						<td class=" ">
						<?php
						echo $this->Form->input('CaseProceeding.court_serial_no', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
						// echo $record['CaseProceeding']['court_serial_no'];
						?>
						</td>
						<td class=" "><?php echo $record['ClientCase']['case_number']; ?></td>
						<td class=" "><?php echo $record['ClientCase']['party_name'];?></td>
						<td class=" "><?php echo $record['ClientCase']['Court']['name']; ?></td>
						<td class=" ">
						<?php
						$briefStatus = array('in_office' => 'In Office', 'out_of_office' => 'Out of Office');
						if ($record['CaseProceeding']['proceeding_status'] == 'pending') {
							echo $this->Form->input('ClientCase.brief_status', array('options' => $briefStatus, 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
						} else {
							if ($record['CaseProceeding']['brief_status'] == 'in_office') {
								echo 'In Office';
							} else {
								echo 'Out of Office';
							}
						}
						?>
						</td>
						<td class=" ">
						<?php
						$caseStatus = array('pending' => 'Pending', 'decided' => 'Decided', 'admitted' => 'Admitted', 'reserved' => 'Reserved');
						if ($record['CaseProceeding']['proceeding_status'] == 'pending') {
							echo $this->Form->input('ClientCase.case_status', array('options' => $caseStatus, 'label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
						} else {
							echo strtoupper($record['CaseProceeding']['case_status']);
						}
						?>
						</td>
						<td class=" " style="text-align: center;">
						<?php
						if ($record['CaseProceeding']['proceeding_status'] == 'pending') {
							echo $this->Form->checkbox('ClientCase.referred_to_lok_adalat');
						} else {
							if ($record['CaseProceeding']['referred_to_lok_adalat']) {
								echo 'Yes';
							} else {
								echo 'No';
							}
						}
						?>
						</td>
						<td class=" ">
						<?php
						echo $this->Form->textarea('CaseProceeding.remarks', array('label' => false, 'div' => false, 'class' => 'col-sm-12 col-xs-12', 'autocomplete' => 'off'));
						?>
						</td>
						<td>
						<?php
						if ($record['CaseProceeding']['proceeding_status'] == 'pending') {
							echo $this->Form->input('CaseProceeding.next_date_of_hearing', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-sm-12 col-xs-12 date-picker', 'placeholder' => 'Next Date', 'data-date-format' => 'yyyy-mm-dd', 'autocomplete' => 'off'));
						} else {
							echo $record['CaseProceeding']['next_date_of_hearing'];
						}
						?>
						</td>
						<td class=" ">
							<div class="hidden-phone visible-desktop action-buttons">
								<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Update", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[CaseProceeding][submit]", "value" => "submit"));
								?>
							</div>
							<div class="hidden-desktop visible-phone">
								<div class="inline position-relative">
									<button data-toggle="dropdown" class="btn btn-minier btn-yellow dropdown-toggle">
										<i class="icon-caret-down icon-only bigger-120"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
										<li>
											<?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Update", array("class" => "btn btn-primary", "escape" => false, "type" => "submit", "name" => "data[CaseProceeding][submit]", "value" => "submit"));
											?>
										</li>
									</ul>
								</div>
							</div>
						</td>
					</tr>
					<?php echo $this->Form->end(); ?>
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

<div class="row-fluid">
	<div class="span12">
        
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
        <b><h4 class="lighter">Todos</h4></b>
        <hr>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
        <div class="row-fluid">
			<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
			<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
				   aria-describedby="sample-table-2_info">
				<thead>
					<tr role="row">
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Case Title
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Title
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Completion Date
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Priority
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Status
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Action
						</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php $i = 1;
				if (isset($Todos) && !empty($Todos)) {
					foreach ($Todos as $record){ ?>
					<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
						<td class=" "><?php echo $record['ClientCase']['case_title'] ? $record['ClientCase']['case_title']: "<span class='red'>Miscellaneous</span>";?></td>
						<td class=" "><?php echo $record['Todo']['title'];?></td>
						<td class=""><?php echo $this->Time->format('F j, Y',$record['Todo']['completion_date']); ?>
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
							if ($record['Todo']['status'] == 'pending') {
							?>
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
							<?php
							if ($record['Todo']['status'] == 'pending') {
								echo $this->Html->link('<i class="icon-ok bigger-110"></i> Mark Complete', array('controller'=>'Todos','action'=>'changeStatus',$record['Todo']['id']), array('escape' => false, 'class' => 'btn btn-primary'));
							} else {
								echo $this->Html->link('<i class="icon-ok bigger-110"></i> Reopen', array('controller'=>'Todos','action'=>'changeStatus',$record['Todo']['id']), array('escape' => false, 'class' => 'btn btn-primary'));
							}
							?>
						</td>
					</tr>
					<?php
						$i++;
					}
					?>
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
<div class="row-fluid">
	<div class="span12">
        
	</div>
</div>
<script type="text/javascript">
	$('[data-rel=tooltip]').tooltip();
</script>
<?php echo $this->Form->end(); ?>