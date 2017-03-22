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
								<?php echo $this->Form->create('ClientCase',array('url' => '/ConnectCases/addConnections/'.$caseId,'id'=>'searchCasesForm','name'=>'searchCasesForm')); ?>
								<div class="row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <div class="widget-box">
                                                <div class="widget-header widget-header-small">
                                                    <h5 class="lighter">Search Form</h5>
                                                </div>
                                                <div class="widget-body">
                                                    <div class="widget-main">
                                                        <?php echo $this->Form->input('ClientCase.party_name', array('label' => false, 'required' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Client Name')); ?>
                                                        <?php echo $this->Form->input('ClientCase.complete_case_number', array('label' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Case Number','required' => false)); ?>
                                                        <?php echo $this->Form->input('ClientCase.case_year', array('label' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Case Year','required' => false)); ?>
                                                        <?php echo $this->Form->input('ClientCase.client_phone', array('label' => false, 'div' => false, 'class' => 'input-medium search-query', 'placeholder' => 'Client Phone','required' => false)); ?>
                                                        <?php
                                                        echo $this->Form->button("<i class='icon-search icon-on-right bigger-110'></i>Search",
                                                            array("class"=>"btn btn-purple btn-small","escape"=>false,
                                                                "type"=>"submit")); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php echo $this->Form->end(); ?>

                                <?php echo $this->Form->create('ClientCase',array('url' => '/ConnectCases/addConnectionsProcess/'.$caseId,'id'=>'connectCasesForm','name'=>'connectCasesForm')); ?>
								<div class="row-fluid">
									<div class="span12">
										<div class="row-fluid">
											<div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
											<table class="table table-striped table-bordered table-hover dataTable" id="sample-table-2"
												   aria-describedby="sample-table-2_info">
											<thead>
											<?php if(isset($listCases) && !empty($listCases) &&
											($selectChild==false && $selectParent==false)){ ?>
											<tr role="row">
												<th colspan="10">
													<div>
														<label>
															<input name="connectionType" type="radio" checked="checked class="ace checkConnectionType" value="child" />
															<span class="lbl"> Add Child Cases</span>
														</label>&nbsp;
														<label>
															<input name="connectionType" type="radio" class="ace checkConnectionType" value="parent" />
															<span class="lbl"> Connect To Main Case</span>
														</label>
													</div>
												</th>
											</tr>
											<?php } ?>
											<tr role="row">
												<th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 51px;" aria-label="">
													<?php if($selectParent==false){ ?>
													<label class="selectChildCheckAll">
														<input type="checkbox" class="ace" onclick="changeCheckboxStatus(connectCasesForm)" name="selectAll" id='checkall'>
														<span class="lbl"></span>
													</label>
													<?php } ?>
												</th>
												<th>
													Case Number
												</th>
												<th>
													Client Name
												</th>
												<th>
													Case Year
												</th>
												<th>
													Phone
												</th>
											</tr>
											</thead>
											<tbody id="connectionsBody" role="alert" aria-live="polite" aria-relevant="all">
											<?php
											if(isset($listCases) && !empty($listCases)){
												foreach ($listCases as $i=>$currRecord){
												$record = $currRecord['cc1'];
												$i = $i+1; ?>
												<tr class="<?php echo ($i%2==1)?'odd':'even';?>"">
													<td class="center">
														<?php if($selectChild==true){ ?>
															<label>
																<input type="checkbox" class="ace">
																<input type="checkbox" class="ace" onclick="toggleCheck(connectCasesForm)" name="box[]" value="<?php echo $record['id']; ?>" >
																<span class="lbl"></span>
															</label>
														<?php }elseif($selectParent==true){ ?>
														<label>
															<input type="radio" class="ace" name="parentId" value="<?php echo $record['id']; ?>" >
															<span class="lbl"></span>
														</label>
														<?php }else{ ?>
															<label class="selectChildCheckbox">
																<input type="checkbox" class="ace">
																<input type="checkbox" class="ace" onclick="toggleCheck(connectCasesForm)" name="box[]" value="<?php echo $record['id']; ?>" >
																<span class="lbl"></span>
															</label>
															<label class="selectParentRadio">
																<input type="radio" class="ace" name="parentId" value="<?php echo $record['id']; ?>" >
																<span class="lbl"></span>
															</label>
														<?php } ?>
													</td>
													<td><?php echo $record['complete_case_number']; ?></td>
													<td>
														<?php echo $record['party_name']; ?>
													</td>
													<td>
														<?php echo $record['case_year']; ?>
													</td>
													<td>
														<?php echo $record['client_phone']; ?>
													</td>
												</tr>
												<?php $i++; } ?>
												<tFoot>
													<tr role="row">
														<th role="columnheader" colspan="10" style="border-right: none !important; text-align: right;">
															<?php echo $this->Html->link('<i class="icon-arrow-left bigger-110"></i> Back To List ', array('controller'=>'ConnectCases','action'=>'manage', $caseId), array('escape' => false, 'class' => 'btn btn-next'))?>
															<?php echo $this->Form->button("<i class='icon-trash bigger-110'></i> Add Connections", array("class" => "btn btn-info", "escape" => false, "type" => "button", "onclick"=>"updateConnections('update connections for','connectCasesForm');"));?>
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
													<tFoot>
														<tr role="row">
															<th role="columnheader" colspan="10" style="border-right: none !important; text-align: right;">
																<?php echo $this->Html->link('<i class="icon-arrow-left bigger-110"></i> Back To List ', array('controller'=>'ConnectCases','action'=>'manage', $caseId), array('escape' => false, 'class' => 'btn btn-next'))?>
															</th>
														</tr>
													</tFoot>
												<?php
											}?>
											</tbody>
											</table>
											</div>
										</div>
									</div>
								</div>
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
<?php echo $this->Html->script('pages/add_connections.js'); ?>