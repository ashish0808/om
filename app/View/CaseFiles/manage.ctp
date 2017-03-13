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
								<div class="row">
                                	<div class="col-sm-12">
                                		<div class="clearfix pull-right custom-form-actions">
                                			<?php echo $this->Html->link('Add Case Files', array('controller'=>'CaseFiles','action'=>'add', $caseId), array('escape' => false, 'class' => 'btn btn-info'))?>
                                		</div>
                                	</div>
                                </div>

								<?php
								$this->Paginator->options(array(
									'update' => '#content',
									'evalScripts' => true,
									'before' => $this->Js->get('#overlay_img')->effect('fadeIn', array('buffer' => false)),
									'complete' => $this->Js->get('#overlay_img')->effect('fadeOut', array('buffer' => false)),
								));
								?>
								<?php
								$data = $this->Js->get('#CaseFileSearchForm')->serializeForm(array('isForm' => true, 'inline' => true));
								$this->Js->get('#CaseFileSearchForm')->event(
									'submit',
									$this->Js->request(
										array('action' => 'manage', $caseId),
										array(
											'update' => '#content',
											'data' => $data,
											'async' => true,
											'dataExpression'=>true,
											'method' => 'POST'
										)
									)
								);
								$this->Js->get('#CaseFileSearchForm')->event(
									'reset',
									$this->Js->request(
										array('action' => 'manage', $caseId),
										array(
											'update' => '#content',
											'async' => true,
											'dataExpression'=>true,
											'method' => 'POST'
										)
									)
								);
								echo $this->Form->create('CaseFile',array('url' => '/CaseFiles/manage','id'=>'CaseFileSearchForm','name'=>'CaseFileSearchForm'));?>
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
														echo $this->Form->input('CaseFile.name', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'File Name', 'autocomplete' => 'off'));
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
														<th class="col-xs-5" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
															<?php if(count($CaseFiles) > 1){ ?>
																<?php echo $this->Paginator->sort('CaseFile.name', 'File Name', array());?>
															<?php }else{ ?>
																File Name
															<?php } ?>
														</th>
														<th class="col-xs-4" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1">
															Attachment
														</th>
														<th class="col-xs-3" role="columnheader" rowspan="1" colspan="1" aria-label="">Action</th>
													</tr>
												</thead>
												<tbody role="alert" aria-live="polite" aria-relevant="all">
												<?php $i = ($this->params['paging']['CaseFile']['page']-1) * LIMIT + 1;
												if (isset($CaseFiles) && !empty($CaseFiles)) {
													foreach ($CaseFiles as $record){ ?>
													<tr class="<?php echo ($i%2==1)?'odd':'even';?>">
														<td class=" "><?php echo $record['CaseFile']['name'];?></td>
														<td class=" ">
															<?php
															if (!empty($record['CaseFile']['path'])) {
															?>
															<a href="<?php echo $record['CaseFile']['path'];?>" target="_blank" 'class'='col-sm-12 col-xs-12'>Case File</a>
															<?php
															} else {
																echo "Not Available";
															}
															?>
														</td>
														<td class=" ">
															<div class="action-buttons">
																<?php echo $this->Html->link('<i class="icon-trash bigger-130"></i>', array('controller'=>'CaseFiles','action'=>'delete',$record['CaseFile']['id'], $caseId), array('escape' => false, 'class' => 'red tooltip-error', 'data-rel' => 'tooltip', 'data-original-title'=>'Delete Case File'),"Are you sure you want to delete this Case File?")?>

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
																if ($this->params['paging']['CaseFile']['count'] > 1) {
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <!-- /.row -->
</div>