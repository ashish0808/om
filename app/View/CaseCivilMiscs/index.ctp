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
$data = $this->Js->get('#caseCivilMiscSearchForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#caseCivilMiscSearchForm')->event(
    'submit',
    $this->Js->request(
        array('action' => 'index'),
        array(
            'update' => '#content',
            'data' => $data,
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
$this->Js->get('#caseCivilMiscSearchForm')->event(
    'reset',
    $this->Js->request(
        array('action' => 'index'),
        array(
            'update' => '#content',
            'async' => true,
            'dataExpression'=>true,
            'method' => 'POST'
        )
    )
);
echo $this->Form->create('CaseCivilMiscs',array('url' => '/CaseCivilMiscs/index','id'=>'caseCivilMiscSearchForm','name'=>'caseCivilMiscSearchForm'));?>
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
                        echo $this->Form->input('CaseCivilMisc.cm_no', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Application No'));
                        ?>
                        <?php 
                        echo $this->Form->input('CaseCivilMisc.cm_type', array('label' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Application Type','required' => false));
                        ?>
                        <?php 
                        echo $this->Form->input('CaseCivilMisc.status', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Status'));
                        ?>
                        <?php
                        echo $this->Form->button("<i class='icon-search icon-on-right bigger-110'></i>Search",
                            array("class"=>"btn btn-purple btn-small","escape"=>false,
                                "type"=>"submit", "div" => false));
                                ?>
                        <?php
                        echo $this->Form->button("<i class='icon-on-right bigger-110'></i>Reset",
                            array("class"=>"btn btn-small","escape"=>false,
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
        <div class="row-fluid">
			<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
			<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
				   aria-describedby="sample-table-2_info">
			<thead>
			<tr role="row">
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('CaseCivilMisc.cm_no', 'Application No', array());?>
				</th>
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('CaseCivilMisc.cm_type', 'Application Type', array());?>
				</th>
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
					<?php echo $this->Paginator->sort('CaseCivilMisc.remarks', 'Remarks', array());?>
				</th>
				<th role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1">
					<?php echo $this->Paginator->sort('CaseCivilMisc.status', 'Status', array());?>
				</th>
				<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 146px; " aria-label=""></th>
			</tr>
			</thead>
			<tbody role="alert" aria-live="polite" aria-relevant="all">
			<?php $i = ($this->params['paging']['CaseCivilMisc']['page']-1) * LIMIT + 1;
			if (isset($caseCivilMiscs) && !empty($caseCivilMiscs)) {
				foreach ($caseCivilMiscs as $record){ ?>
				<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
					<td class=" ">
						<?php echo $record['CaseCivilMisc']['cm_no'];?>
					</td>
					<td class=" "><?php echo $record['CaseCivilMisc']['cm_type']; ?></td>
					<td class=" ">
						<?php echo $record['CaseCivilMisc']['remarks'];?>
					</td>
					<td class=" ">
						<?php echo $record['CaseCivilMisc']['status'];?>
					</td>
					<td class=" ">
						<div class="hidden-phone visible-desktop action-buttons">
							<?php echo $this->Html->link('<i class="icon-tasks bigger-130"></i>', array('controller'=>'CaseCivilMiscs','action'=>'edit',$record['CaseCivilMisc']['id']), array('escape' => false, 'class' => 'green'))?>
							<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'CaseCivilMiscs','action'=>'delete',$record['CaseCivilMisc']['id']), array('escape' => false, 'class' => 'red'),"Are you sure you want to delete this application?")?>

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
										<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'CaseCivilMiscs','action'=>'edit',$record['CaseCivilMisc']['id']), array('escape' => false, 'class' => 'green'))?>
									</li>

									<li>
										<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'CaseCivilMiscs','action'=>'delete',$record['CaseCivilMisc']['id']), array('escape' => false, 'class' => 'red'),"Are you sure you want to delete this application?")?>
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
							if ($this->params['paging']['CaseCivilMisc']['count'] > 1) {
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
<?php echo $this->Form->end(); ?>