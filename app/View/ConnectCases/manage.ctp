<?php echo $this->Html->script('listing'); ?>
<div class="page-content">
	<div class="row">
		<div class="page-header">
			<h1>
				<?php echo $pageTitle; ?>
			</h1>
		</div>
		<div class="col-sm-12 widget-container-col ui-sortable">
			<div class="widget-box transparent ui-sortable-handle">
				<?php echo $this->element('Cases/top_menus');?>

				<div class="widget-body edit-case-cnt">
					<div class="widget-main padding-12">
						<div class="tab-content padding-4">
							<div class="tab-pane active">
								<?php if(isset($parentCase)) { ?>
								<div class="row">
                                	<div class="col-sm-12">
                                		<div class="clearfix pull-right custom-form-actions">
                                			<?php echo $this->Html->link('Change Connected Case', array('controller'=>'ConnectCases','action'=>'addConnections', $caseId), array('escape' => false, 'class' => 'btn btn-info'))?>
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
												<th>
													Case Number
												</th>
												<th>
													Client Name
												</th>
												<th>
													Case Type
												</th>
												<th>
													Case Year
												</th>
												<th>
													Phone
												</th>
											</tr>
											</thead>
											<tbody role="alert" aria-live="polite" aria-relevant="all">
											<?php if(!empty($parentCase)) { ?>
												<?php $record = $parentCase; ?>
												<tr class="even">
													<td><?php echo $record['ClientCase']['case_number']; ?></td>
													<td>
														<?php echo $record['ClientCase']['party_name']; ?>
													</td>
													<td>
														<?php
														if(!empty($record['CaseType']['name'])) {
															echo $record['CaseType']['name'];
														} ?>
													</td>
													<td>
														<?php echo $record['ClientCase']['case_year']; ?>
													</td>
													<td>
														<?php echo $record['ClientCase']['client_phone']; ?>
													</td>
												</tr>
												<tFoot>
													<tr role="row">
														<th role="columnheader" colspan="10" style="border-right: none !important; text-align: right;">
															<?php echo $this->Html->link("<i class='icon-trash bigger-110'></i> Remove Connection", array('controller'=>'ConnectCases','action'=>'detachCase', $caseId), array('escape' => false, 'class' => 'btn btn-next'),"Are you sure you want to delete this connection?")?>
														</th>
													</tr>
												</tFoot>
											<?php }else{ ?>
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
								<?php }else{ ?>
								<div class="row">
                                	<div class="col-sm-12">
                                		<div class="clearfix pull-right custom-form-actions">
                                			<?php echo $this->Html->link('Connect Cases', array('controller'=>'ConnectCases','action'=>'addConnections', $caseId), array('escape' => false, 'class' => 'btn btn-info'))?>
                                		</div>
                                	</div>
                                </div>
								<?php echo $this->Form->create('ClientCase',array('url' => '/ConnectCases/manage/'.$caseId,'id'=>'connectCasesForm','name'=>'connectCasesForm')); ?>
								<div class="row-fluid">
									<div class="span12">
										<div class="row-fluid">
											<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
											<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
												   aria-describedby="sample-table-2_info">
											<thead>
											<tr role="row">
												<th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 51px;" aria-label="">
													<label>
														<input type="checkbox" class="ace" onclick="changeCheckboxStatus(connectCasesForm)" name="selectAll" id='checkall'>
														<span class="lbl"></span>
													</label>
												</th>
												<th>
													Case Number
												</th>
												<th>
													Client Name
												</th>
												<th>
													Case Type
												</th>
												<th>
													Case Year
												</th>
												<th>
													Phone
												</th>
												<th></th>
											</tr>
											</thead>
											<tbody role="alert" aria-live="polite" aria-relevant="all">
											<?php
											if(isset($childCases) && !empty($childCases)){
												foreach ($childCases as $i=>$record){
												$i = $i+1; ?>
												<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
													<td class="center">
														<label>
															<input type="checkbox" class="ace">
															<input type="checkbox" class="ace" onclick="toggleCheck(connectCasesForm)" name="box[]" value="<?php echo $record['ClientCase']['id']; ?>" >
															<span class="lbl"></span>
														</label>
													</td>
													<td><?php echo $record['ClientCase']['case_number']; ?></td>
													<td>
														<?php echo $record['ClientCase']['party_name']; ?>
													</td>
													<td>
														<?php
														if(!empty($record['CaseType']['name'])) {
															echo $record['CaseType']['name'];
														} ?>
													</td>
													<td>
														<?php echo $record['ClientCase']['case_year']; ?>
													</td>
													<td>
														<?php echo $record['ClientCase']['client_phone']; ?>
													</td>
													<td class=" ">
														<div class="hidden-phone visible-desktop action-buttons">
															<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'ConnectCases','action'=>'detachCase', $record['ClientCase']['id']), array('escape' => false, 'class' => 'red'),"Are you sure you want to delete this connection?")?>
														</div>
													</td>
												</tr>
												<?php $i++; } ?>
												<tFoot>
													<tr role="row">
														<th role="columnheader" colspan="10" style="border-right: none !important; text-align: right;">
															<?php echo $this->Form->button("<i class='icon-trash bigger-110'></i> Remove Connections", array("class" => "btn btn-next removeConnections", "escape" => false, "type" => "button", "onclick"=>"updateRecords('remove connections for','connectCasesForm');"));?>
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
								<?php } ?>
                           	</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <!-- /.row -->
</div>