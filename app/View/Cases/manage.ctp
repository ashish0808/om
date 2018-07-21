<?php
$this->Paginator->options(array(
    'update' => '#content',
    'evalScripts' => true,
    'before' => $this->Js->get('#overlay_img')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#overlay_img')->effect('fadeOut', array('buffer' => false)),
)); 
?>
<div class="page-header position-relative">
    <h1>
        <?php echo $pageTitle; ?>
    </h1>
</div>

<?php
if (isset($listType) && $listType == 'deleted') {?>
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<span style="color: red">Note:</span> These cases will be here for 30 days. After that they will be deleted permanently. Till then you can restore them to their original state by clicking restore icon.
		</div>
	</div>
</div>
<?php
}
?>
<?php
if (isset($listType) && $listType != 'deleted') {
$data = $this->Js->get('#CaseSearchForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#CaseSearchForm')->event(
    'submit',
    $this->Js->request(
        array('action' => 'manage', $listType),
        array(
            'update' => '#content',
            'before'   => '$("#overlay_img").fadeIn()',
            'complete' => '$("#overlay_img").fadeOut()',
            'data' => $data,
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
$this->Js->get('#CaseSearchForm')->event(
    'reset',
    $this->Js->request(
        array('action' => 'manage', $listType),
        array(
            'update' => '#content',
            'before'   => '$("#overlay_img").fadeIn()',
            'complete' => '$("#overlay_img").fadeOut()',
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
echo $this->Form->create('ClientCase',array('url' => '/Cases/manage','id'=>'CaseSearchForm','name'=>'CaseSearchForm', 'novalidate' => true));?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-header widget-header-small">
                    <h5 class="lighter">Search Form</h5>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
						<div class="row">
							<div class="col-sm-3 col-xs-12">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-xs-12 control-label no-padding-right">Case Type: </label>
										<?php echo $this->Form->input('ClientCase.case_type_id', array('options' => $caseTypes, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'select2 col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-xs-12">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-xs-12 control-label no-padding-right">Case Number: </label>
										<?php echo $this->Form->input('ClientCase.complete_case_number', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-xs-12 search-query', 'autocomplete' => 'off')); ?>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-xs-12">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-xs-12 control-label no-padding-right">Case Year: </label>
										<?php echo $this->Form->input('ClientCase.case_year', array('label' => false, 'required' => false, 'div' => false, 'class' => 'col-xs-12 search-query', 'autocomplete' => 'off')); ?>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-xs-12">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-xs-12 control-label no-padding-right">Case Title: </label>
										<?php echo $this->Form->input('ClientCase.case_title', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'col-xs-12 search-query', 'autocomplete' => 'off')); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row m-t-10">
							<div class="col-sm-3 col-xs-12">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-xs-12 control-label no-padding-right">Client Type: </label>
										<?php
										$clientTypes = array('petitioner' => 'Appellant/Petitioner', 'respondent' => 'Respondent');
										echo $this->Form->input('ClientCase.client_type', array('options' => $clientTypes, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'select2 col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-xs-12">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-xs-12 control-label no-padding-right">Party Name: </label>
										<?php echo $this->Form->input('ClientCase.party_name', array('label' => false, 'required' => false, 'div' => false, 'class' => 'col-xs-12 search-query', 'autocomplete' => 'off')); ?>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-xs-12">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-xs-12 control-label no-padding-right">Computer File No: </label>
										<?php echo $this->Form->input('ClientCase.computer_file_no', array('label' => false, 'required' => false, 'div' => false, 'class' => 'col-xs-12 search-query', 'autocomplete' => 'off')); ?>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-xs-12">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-xs-12 control-label no-padding-right">Payment Paid: </label>
										<?php
										$paymentPaidTypes = array('nil' => 'Nil', 'part' => 'Part', 'half' => 'Half', 'full' => 'Full');
										echo $this->Form->input('ClientCase.payment_status', array('options' => $paymentPaidTypes, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'select2 col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row m-t-10">
							<div class="col-sm-3 col-xs-12">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-xs-12 control-label no-padding-right">Case Status: </label>
										<?php echo $this->Form->input('ClientCase.case_status', array('options' => $caseStatuses, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'select2 col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-xs-12">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-xs-12 control-label no-padding-right">Company: </label>
										<?php echo $this->Form->input('ClientCase.user_companies_id', array('options' => $userCompanies, 'empty' => '--Select--', 'label' => false, 'div' => false, 'class' => 'select2 col-sm-12 col-xs-12', 'autocomplete' => 'off')); ?>
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-xs-12">
								<div class="form-group">
									<div class="col-sm-12 col-xs-12">
										<label class="col-xs-12 control-label no-padding-right">&nbsp;</label>
										<label class="col-xs-12 control-label no-padding-right">

										<?php echo $this->Form->input('ClientCase.saved_incomplete', array('label' => false, 'value' => 1, 'required' => false, 'div' => false, 'class' => 'search-query', 'type' => 'checkbox', 'autocomplete' => 'off')); ?> Saved Incomplete </label>
									</div>
								</div>
							</div>
						</div>
						<div class="row"><div class="col-md-12">&nbsp;</div></div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group pull-right">
									<div class="col-sm-12 col-xs-12">
									<?php echo $this->Form->button("<i class='icon-search icon-on-right bigger-110'></i>Search",
										array("class"=>"btn btn-purple btn-sm caseSearchBtn","escape"=>false, "type"=>"submit", "div" => false)); ?>
									<?php echo $this->Form->button("<i class='icon-on-right bigger-110'></i>Reset",
										array("class"=>"btn btn-sm","escape"=>false, "type"=>"reset", "div" => false)); ?>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end();
echo $this->Js->writeBuffer();
}
?>
<?php if (empty($records) && isset($listType) && $listType == 'deleted') {?>
	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">
				<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
					<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2" aria-describedby="sample-table-2_info">
						<thead>
							<tr>
								<th>No records found</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php if(count($records) > 0) {?>
	<?php if(!empty($criteria)){ ?>
	<div class="row"><div class="col-md-12">&nbsp;</div></div>
	<div class="row">
		<div class="col-md-12">
			<?php echo $this->Form->create('ClientCase',array('url' => '/cases/exportExcel','id'=>'exportExcel','name'=>'exportExcel','target'=>'_blank', 'novalidate' => true)); ?>
			<?php foreach($criteria as $criteriaKey => $criteriaValue){
				echo $this->Form->input('ClientCase.'.$criteriaKey, array('label' => false, 'required' => false, 'value' => $criteriaValue, 'div' => false, 'type' => 'hidden', 'autocomplete' => 'off'));
			}
			?>
			<div class="form-group pull-right">
				<div class="col-sm-12 col-xs-12">
				<?php echo $this->Form->button("Export To Excel",
					array("class"=>"btn btn-purple btn-sm","escape"=>false, "type"=>"submit", "div" => false)); ?>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
	<?php } ?>
	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">
				<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
				<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
					   aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
							<?php if(count($records) > 1) {?>
								<th>
									<?php echo $this->Paginator->sort('ClientCase.complete_case_number', 'Case Number', array());?>
								</th>
								<th class="col-xs-2">
									<?php echo $this->Paginator->sort('ClientCase.computer_file_no', 'Computer File No', array());?>
								</th>
								<th class="col-xs-2">
									<?php echo $this->Paginator->sort('ClientCase.case_title', 'Case Title', array());?>
								</th>
								<th>
									<?php echo $this->Paginator->sort('ClientCase.case_year', 'Case Year', array());?>
								</th>
								<th>
									<?php echo $this->Paginator->sort('ClientCase.client_case_count', 'Connected Cases', array());?>
								</th>
								<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
									<?php echo $this->Paginator->sort('ClientCase.created', 'Created', array());?>
								</th>
								<th>Action</th>
							<?php }else{ ?>
								<th>Case Number</th>
								<th class="col-xs-2">Computer File No</th>
								<th class="col-xs-2">Case Title</th>
								<th>Case Year</th>
								<th>Connected Cases</th>
								<th class="col-xs-2">Created</th>
								<th>Action</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php $i = ($this->params['paging']['ClientCase']['page']-1) * LIMIT + 1;
					if (isset($records) && !empty($records)) {
						foreach ($records as $record){ ?>
						<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
							<td class=" "><?php echo $record['ClientCase']['complete_case_number'];?></td>
							<td class=" "><?php echo $record['ClientCase']['computer_file_no'];?></td>
								<td class=" "><?php echo $record['ClientCase']['case_title'] ? $record['ClientCase']['case_title']: "<span class='red'>Miscellaneous</span>"; ?></td>
							<td><?php echo $record['ClientCase']['case_year'];?></td>
							<td><?php echo $record['ClientCase']['client_case_count'] ? $record['ClientCase']['client_case_count']: 0; ?></td>
							<td class=""><?php echo $this->Time->format('D, M jS, Y', $record['ClientCase']['created']); ?></td>
							<td class=" ">
								<div class="hidden-phone visible-desktop action-buttons">
									<?php
									if(isset($listType) && $listType != 'deleted') {
										echo $this->Html->link('<i class="icon-tasks bigger-130"></i>', array('controller'=>'cases','action'=>'view',$record['ClientCase']['id']), array('escape' => false, 'class' => 'green tooltip-success', 'data-rel' => 'tooltip', 'data-original-title'=>'View Case'))?>
										<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'cases','action'=>'edit',$record['ClientCase']['id']), array('escape' => false, 'class' => 'green tooltip-success', 'data-rel' => 'tooltip', 'data-original-title'=>'Edit Case'))?>
										<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'cases','action'=>'delete',$record['ClientCase']['id']), array('escape' => false, 'class' => 'red tooltip-success', 'data-rel' => 'tooltip', 'data-original-title'=>'Delete Case'),"Are you sure you want to delete this Case?");
									} else {
										echo $this->Html->link('<i class="icon-refresh bigger-130"></i>', array('controller'=>'cases','action'=>'restore',$record['ClientCase']['id']), array('escape' => false, 'class' => 'red tooltip-success', 'data-rel' => 'tooltip', 'data-original-title'=>'Restore Case'),"Are you sure you want to restore this Case?");
									}
									?>
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
<span id="selectedCaseStatus" class="hide"><?php echo $selectedCaseStatus; ?></span>
<script type="text/javascript">
	$('[data-rel=tooltip]').tooltip();

	$(document).ready(function(){

		var selectedCaseStatus = $('#selectedCaseStatus').html();

		if(selectedCaseStatus!='') {

			$("#ClientCaseCaseStatus").val(selectedCaseStatus);

			$(".caseSearchBtn").click();
		}
	})
</script>
<?php echo $this->Form->end(); ?>