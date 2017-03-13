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
$data = $this->Js->get('#CaseSearchForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#CaseSearchForm')->event(
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
$this->Js->get('#CaseSearchForm')->event(
    'reset',
    $this->Js->request(
        array('action' => 'manage'),
        array(
            'update' => '#content',
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
echo $this->Form->create('ClientCase',array('url' => '/Cases/manage','id'=>'CaseSearchForm','name'=>'CaseSearchForm'));?>
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
                        echo $this->Form->input('ClientCase.case_number', array('label' => false, 'div' => false, 'type' => 'text', 'error' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Case Number', 'data-date-format' => 'yyyy-mm-dd', 'autocomplete' => 'off'));
                        ?>
                        <?php
                        echo $this->Form->input('ClientCase.computer_file_no', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Computer File No', 'autocomplete' => 'off'));
                        ?>
                        <?php
                        echo $this->Form->button("<i class='icon-search icon-on-right bigger-110'></i>Search",
                            array("class"=>"btn btn-purple btn-sm","escape"=>false,
                                "type"=>"submit", "div" => false));
                                ?>
                        <?php
                        echo $this->Form->button("<i class='icon-on-right bigger-110'></i>Reset",
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
        <div class="row-fluid">
			<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
			<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
				   aria-describedby="sample-table-2_info">
				<thead>
					<tr role="row">
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							<?php echo $this->Paginator->sort('ClientCase.case_number', 'Case Number', array());?>
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							<?php echo $this->Paginator->sort('ClientCase.computer_file_no', 'Computer File No', array());?>
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							<?php echo $this->Paginator->sort('ClientCase.case_title', 'Case Title', array());?>
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Attachment
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							<?php echo $this->Paginator->sort('ClientCase.created', 'Created', array());?>
						</th>
						<th class="col-xs-2" role="columnheader" rowspan="1" colspan="1" aria-label="">Action</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php $i = ($this->params['paging']['ClientCase']['page']-1) * LIMIT + 1;
				if (isset($records) && !empty($records)) {
					foreach ($records as $record){ ?>
					<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
						<td class=" "><?php echo $record['ClientCase']['case_number'];?></td>
						<td class=" "><?php echo $record['ClientCase']['computer_file_no'];?></td>
						<td class=" "><?php echo $record['ClientCase']['case_title'] ? $record['ClientCase']['case_title']: "<span class='red'>Miscellaneous</span>"; ?></td>
						<td class=" ">
							<?php 
							if (!empty($record['ClientCase']['case_file'])) {
							?>
							<a href="<?php echo $record['ClientCase']['case_file'];?>" target="_blank" 'class'='col-sm-12 col-xs-12'>Application Copy</a>
							<?php
							} else {
								echo "Not Available";
							}
							?>
						</td>
						<td class=""><?php echo $this->Time->format('F j, Y',$record['ClientCase']['created']); ?></td>
						<td class=" ">
							<div class="hidden-phone visible-desktop action-buttons">
								<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'cases','action'=>'edit',$record['ClientCase']['id']), array('escape' => false, 'class' => 'blue tooltip-info', 'data-rel' => 'tooltip', 'data-original-title'=>'Edit Case'))?>

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
<script type="text/javascript">
	$('[data-rel=tooltip]').tooltip();
</script>
<?php echo $this->Form->end(); ?>