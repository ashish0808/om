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
<div class="row"><div class="col-md-12">&nbsp;</div></div>
<div class="row">
	<div class="col-md-12">
		<?php echo $this->Form->create('CaseProceedings',array('url' => '/CaseProceedings/print_daily_diary','id'=>'printProceedings','name'=>'printProceedings','target'=>'_blank', 'novalidate' => true)); ?>
		<?php echo $this->Form->input('CaseProceeding.date_of_hearing', array('label' => false, 'required' => false, 'value' => $date, 'div' => false, 'type' => 'hidden', 'autocomplete' => 'off')); ?>
		<div class="form-group pull-right">
			<div class="col-sm-12 col-xs-12">
			<?php echo $this->Form->button("Print Proceedings", array("name" => "submitBtn", "class"=>"btn btn-purple btn-sm","escape"=>false, "type"=>"submit", "div" => false, 'value' => 'proceedings')); ?>
			<?php echo $this->Form->button("Print Todos", array("name" => "submitBtn", "class"=>"btn btn-purple btn-sm","escape"=>false, "type"=>"submit", "div" => false, 'value' => 'todos')); ?>
			<?php echo $this->Form->button("Print Both", array("name" => "submitBtn", "class"=>"btn btn-purple btn-sm","escape"=>false, "type"=>"submit", "div" => false, 'value' => 'both')); ?>
			</div>
		</div>
        <?php echo $this->Form->end(); ?>
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
<?php
echo $this->element('Cases/case_history');
?>

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
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Case Number
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Case Title
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Title
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Completion Date
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Priority
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Status
						</th>
						<th class="col-xs-3" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Action
						</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php $i = 1;
				if (isset($Todos) && !empty($Todos)) {
					foreach ($Todos as $record){ ?>
					<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
						<td>
							<?php echo $record['ClientCase']['id'] ? $this->Html->link($record['ClientCase']['complete_case_number'], array('controller' => 'Cases', 'action' => 'view', $record['ClientCase']['id'])) : "<span class='red'>Miscellaneous</span>";
							?>
						</td>
						<td class=" "><?php echo $record['ClientCase']['case_title'] ? $record['ClientCase']['case_title']: "<span class='red'>Miscellaneous</span>";?></td>
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
						<td class=" ">
							<?php
							if ($record['Todo']['status'] == 'pending') {
								echo $this->Html->link('<i class="icon-ok bigger-110"></i> Start', array('controller'=>'Todos','action'=>'changeStatus',$record['Todo']['id'], 'in_progress'), array('escape' => false, 'class' => 'btn btn-xs btn-primary'));
								?>
								<?php
								echo $this->Html->link('<i class="icon-ok bigger-110"></i> Complete', array('controller'=>'Todos','action'=>'changeStatus',$record['Todo']['id'], 'completed'), array('escape' => false, 'class' => 'btn btn-xs btn-primary'));
							} else if ($record['Todo']['status'] == 'in_progress') {
								echo $this->Html->link('<i class="icon-ok bigger-110"></i> Complete', array('controller'=>'Todos','action'=>'changeStatus',$record['Todo']['id'], 'completed'), array('escape' => false, 'class' => 'btn btn-xs btn-primary'));
							} else {
								echo $this->Html->link('<i class="icon-ok bigger-110"></i> Reopen', array('controller'=>'Todos','action'=>'changeStatus',$record['Todo']['id'], 'pending'), array('escape' => false, 'class' => 'btn btn-xs btn-primary'));
							}
							?>
							<?php
							echo $this->Html->link('<i class="icon-ok bigger-110"></i> Postpone', array('controller'=>'Todos','action'=>'edit',$record['Todo']['id']), array('escape' => false, 'class' => 'btn btn-xs btn-primary'));
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