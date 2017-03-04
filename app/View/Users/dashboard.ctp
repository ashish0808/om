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

<div class="row-fluid">
	<div class="span12">
        <div class="row-fluid">
        <!-- #section:pages/dashboard.infobox.dark -->
		<div class="infobox infobox-green infobox-small infobox-dark">
			<div class="infobox-progress">
				<!-- #section:pages/dashboard.infobox.easypiechart -->
				<div class="easy-pie-chart percentage" data-percent="61" data-size="39">
					<span class="percent">61</span>%
				</div>

				<!-- /section:pages/dashboard.infobox.easypiechart -->
			</div>

			<div class="infobox-data">
				<div class="infobox-content">Pending Task</div>
			</div>
		</div>
		<div class="hr hr32 hr-dotted"></div>

		<div class="row-fluid">
			<div class="col-sm-5">
				<div class="widget-box transparent">
					<div class="widget-header widget-header-flat">
						<h4 class="widget-title lighter">
							<i class="ace-icon fa fa-star orange"></i>
							Popular Domains
						</h4>

						<div class="widget-toolbar">
							<a href="#" data-action="collapse">
								<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="widget-body">
						<div class="widget-main no-padding">
							<table class="table table-bordered table-striped">
								<thead class="thin-border-bottom">
									<tr>
										<th>
											<i class="ace-icon fa fa-caret-right blue"></i>name
										</th>

										<th>
											<i class="ace-icon fa fa-caret-right blue"></i>price
										</th>

										<th class="hidden-480">
											<i class="ace-icon fa fa-caret-right blue"></i>status
										</th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td>internet.com</td>

										<td>
											<small>
												<s class="red">$29.99</s>
											</small>
											<b class="green">$19.99</b>
										</td>

										<td class="hidden-480">
											<span class="label label-info arrowed-right arrowed-in">on sale</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div><!-- /.widget-main -->
					</div><!-- /.widget-body -->
				</div><!-- /.widget-box -->
			</div><!-- /.col -->

		<div class="vspace-12-sm"></div>
			<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
			<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
				   aria-describedby="sample-table-2_info">
				<thead>
					<tr role="row">
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Case Title
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							CM/CRM No
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							<?php echo $this->Paginator->sort('CaseCivilMisc.cm_type', 'Type', array());?>
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							<?php echo $this->Paginator->sort('CaseCivilMisc.application_date', 'Date', array());?>
						</th>
						<th class="col-xs-1" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1">
							<?php echo $this->Paginator->sort('CaseCivilMisc.status', 'Status', array());?>
						</th>
						<th class="col-xs-2" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
							Attachment
						</th>
						<th class="col-xs-2" role="columnheader" rowspan="1" colspan="1" aria-label="">Action</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php $i = ($this->params['paging']['CaseCivilMisc']['page']-1) * LIMIT + 1;
				if (isset($caseCivilMiscs) && !empty($caseCivilMiscs)) {
					foreach ($caseCivilMiscs as $record){ ?>
					<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
						<td class=" "><?php echo $record['ClientCase']['case_title']; ?></td>
						<td class=" "><?php echo $record['CaseCivilMisc']['cm_no'];?></td>
						<td class=" "><?php echo $record['CaseCivilMisc']['cm_type']; ?></td>
						<td class=""><?php echo $this->Time->format('F j, Y',$record['CaseCivilMisc']['application_date']); ?></td>
						<td class=" ">
						<?php
						if ($record['CaseCivilMisc']['status'] == 'pending') { ?>
							<div class="label label-lg label-yellow arrowed-in arrowed-in-right">
							<?php
						} else {
						?>
							<div class="label label-lg label-success arrowed-in arrowed-in-right">
						<?php
						}
						echo strtoupper($record['CaseCivilMisc']['status']);
						?>
						</td>
						<td class=" ">
							<?php 
							if (!empty($record['CaseCivilMisc']['attachment'])) {
							?>
							<a href="<?php echo $record['CaseCivilMisc']['attachment'];?>" target="_blank" 'class'='col-sm-12 col-xs-12'>Application Copy</a>
							<?php 
							} else {
								echo "Not Available";
							}
							?>
						</td>
						<td class=" ">
							<div class="hidden-phone visible-desktop action-buttons">
								<?php echo $this->Html->link('<i class="icon-tasks bigger-130"></i>', array('controller'=>'CaseCivilMiscs','action'=>'view',$record['CaseCivilMisc']['id']), array('escape' => false, 'class' => 'green tooltip-success', 'data-rel' => 'tooltip', 'data-original-title'=>'View CM/CRM'))?>
								<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'CaseCivilMiscs','action'=>'edit',$record['CaseCivilMisc']['id']), array('escape' => false, 'class' => 'blue tooltip-info', 'data-rel' => 'tooltip', 'data-original-title'=>'Edit CM/CRM'))?>
								<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'CaseCivilMiscs','action'=>'delete',$record['CaseCivilMisc']['id']), array('escape' => false, 'class' => 'red tooltip-error', 'data-rel' => 'tooltip', 'data-original-title'=>'Delete CM/CRM'),"Are you sure you want to delete this application?")?>

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
											<?php echo $this->Html->link('<i class="icon-tasks bigger-130"></i>', array('controller'=>'CaseCivilMiscs','action'=>'view',$record['CaseCivilMisc']['id']), array('escape' => false, 'class' => 'green tooltip-success', 'data-rel' => 'tooltip', 'data-original-title'=>'View CM/CRM'))?>
										</li>
										<li>
											<?php echo $this->Html->link('<i class="icon-pencil bigger-130"></i>', array('controller'=>'CaseCivilMiscs','action'=>'edit',$record['CaseCivilMisc']['id']), array('escape' => false, 'class' => 'blue tooltip-info', 'data-rel' => 'tooltip', 'data-original-title'=>'Edit CM/CRM'))?>
										</li>

										<li>
											<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'CaseCivilMiscs','action'=>'delete',$record['CaseCivilMisc']['id']), array('escape' => false, 'class' => 'red tooltip-error', 'data-rel' => 'tooltip', 'data-original-title'=>'Delete CM/CRM'),"Are you sure you want to delete this application?")?>
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
<script type="text/javascript">
	$('[data-rel=tooltip]').tooltip();
	jQuery(function($) {
		$('.easy-pie-chart.percentage').each(function() {
			var $box = $(this).closest('.infobox');
			var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
			var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
			var size = parseInt($(this).data('size')) || 50;
			$(this).easyPieChart({
				barColor: barColor,
				trackColor: trackColor,
				scaleColor: false,
				lineCap: 'butt',
				lineWidth: parseInt(size/10),
				animate: 1000,
				size: size
			});
		});
	});
</script>
<?php echo $this->Form->end(); ?>