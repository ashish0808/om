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
								<div class="widget-box panel-group">
                                	<div class="widget-body" >
                                		<div class="widget-main">


                                			<div class="invoice-box" id="viewCaseDetails">
												<table cellpadding="0" cellspacing="0">
													<!--<tr class="top">
														<td colspan="2">
															<table>
																<tr>
																	<td class="title">
																		Company Name or LOGO
																	</td>

																	<td>
																		Invoice #: 123<br>
																		Created: January 1, 2015<br>
																		Due: February 1, 2015
																	</td>
																</tr>
															</table>
														</td>
													</tr> -->
													<tr class="information">
														<td>
															<table>
																<tr>
																	<td class="details-field">
																		<span class="view-label">Case Title: </span> <?php echo $caseDetails['ClientCase']['case_title']; ?>
																	</td>
																	<td></td>
																	<td class="details-field">
																		<span class="view-label">Case Number: </span> <?php echo $caseDetails['ClientCase']['complete_case_number']; ?>
																	</td>
																</tr>
																<tr>
																	<td class="details-field">
																		<span class="view-label">Party Name: </span>
																		<?php echo $caseDetails['ClientCase']['party_name']; ?>
																	</td>
																	<td></td>
																	<td class="details-field">
																		<span class="view-label">Engaged On: </span>
																		 <?php if(!empty($caseDetails['ClientCase']['engaged_on'])) {
																		 	echo $this->Time->format('D, M jS, Y', $caseDetails['ClientCase']['engaged_on']);
																		 }
																		 ?>
																	</td>
																</tr>
																<tr>
																	<td class="details-field">
																		<span class="view-label">Court: </span>
																		 <?php if(!empty($caseDetails['Court']['name'])) {
																		 	echo $caseDetails['Court']['name'];
																		 }
																		 ?>
																	</td>
																	<td></td>
																	<td class="details-field">
																		<span class="view-label">Presiding Officer: </span> <?php echo $caseDetails['ClientCase']['presiding_officer']; ?>
																	</td>
																</tr>
																<tr>
																	<td class="details-field">
																		<span class="view-label">Reference Number: </span>
																		<?php echo $caseDetails['ClientCase']['reference_no']; ?>
																	</td>
																	<td></td>
																	<td class="details-field">
																		<span class="view-label">Client Type: </span>
																		<?php if($caseDetails['ClientCase']['client_type']=='petitioner') {
																			echo 'Appellant/Petitioner';
																		}else{
																			echo ucfirst($caseDetails['ClientCase']['client_type']);
																		} ?>
																	</td>
																</tr>
																<tr>
																	<td class="details-field">
																		<span class="view-label">Computer File No.: </span> <?php echo $caseDetails['ClientCase']['computer_file_no']; ?>
																	</td>
																	<td></td>
																	<td class="details-field">
																		<span class="view-label">Limitation Expires On: </span>
																		 <?php if(!empty($caseDetails['ClientCase']['limitation_expires_on'])) {
																		 	echo $this->Time->format('D, M jS, Y', $caseDetails['ClientCase']['limitation_expires_on']);
																		 }
																		 ?>
																	</td>
																</tr>
																<tr>
																	<td colspan="3" class="details-field">
																		<span class="view-label">Client Address: </span>
																		<?php echo $caseDetails['ClientCase']['client_address1'].' '.$caseDetails['ClientCase']['client_address2']; ?>
																	</td>
																</tr>
																<tr>
																	<td class="details-field">
																		<span class="view-label">Client Email: </span> <?php echo $caseDetails['ClientCase']['client_email']; ?>
																	</td>
																	<td></td>
																	<td class="details-field">
																		<span class="view-label">Client Phone: </span>
																		<?php echo $caseDetails['ClientCase']['client_phone'];
																		 if(!empty($caseDetails['ClientCase']['client_phone2'])) {
																		 	echo ', '.$caseDetails['ClientCase']['client_phone2'];
																		 } ?>
																	</td>
																</tr>
																<tr>
																	<td colspan="3" class="details-field">
																		<span class="view-label">Date Fixed: </span>
																		<?php $clientCaseHelper = $this->Helpers->load('ClientCase');
																		echo $clientCaseHelper->getLastHearing($pendingProceeding); ?>

																	</td>
																</tr>
																<tr>
																	<td colspan="3" class="details-field">
																		<span class="view-label">Remarks: </span>
																		<?php echo $caseDetails['ClientCase']['remarks']; ?>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>

												<table class="table table-striped table-bordered">
													<tr>
														<th colspan="5" style="text-align: center;">
															Essential Works
														</th>
													</tr>
													<tr>
														<?php foreach($essentialWorksArr as $essentialWork){ ?>
														<th><?php echo $essentialWork; ?></th>
														<?php } ?>
													</tr>
													<tr>
														<?php foreach($essentialWorksArr as $essentialWorkKey=>$essentialWork){ ?>
															<td>
																<?php
																if(isset($caseDetails['ClientCase'][$essentialWorkKey]) && !empty($caseDetails['ClientCase'][$essentialWorkKey])) {
																	echo 'Yes';
																} else {
																	echo 'No';
																} ?>
															</td>
														<?php } ?>
													</tr>
												</table>

												<table class="table table-striped table-bordered">
													<tr>
														<th colspan="5" style="text-align: center;">
															Memo Of Hearings
														</th>
													</tr>
													<tr>
														<th>Date</th>
														<th>Court Room No.</th>
														<th>Court Serial No.</th>
														<th>Status</th>
														<th>Remarks</th>
													</tr>
													<?php if(!empty($caseDetails['CaseProceeding'])){
													foreach($caseDetails['CaseProceeding'] as $caseProceeding){
													?>
													<tr>
														<td>
															<?php echo $caseProceeding['date_of_hearing'] ? $this->Time->format('D, M jS, Y', $caseProceeding['date_of_hearing']) : ''; ?>
														</td>
														<td><?php echo $caseProceeding['court_room_no']; ?></td>
														<td><?php echo $caseProceeding['court_serial_no']; ?></td>
														<td><?php echo ucfirst($caseProceeding['proceeding_status']); ?></td>
														<td width="40%"><?php echo $caseProceeding['remarks']; ?></td>
													</tr>
													<?php } }else{ ?>
													<tr>
														<td colspan="5" class="details-field" style="text-align: center;">
															No record found
														</td>
													</tr>
													<?php } ?>
												</table>

												<table class="table table-striped table-bordered">
													<tr>
														<th colspan="5" style="text-align: center;">
															Case Filings
														</th>
													</tr>
													<tr>
														<th>Date</th>
														<th>Number</th>
														<th>Type</th>
													</tr>
													<?php if(!empty($caseDetails['CaseFiling'])){
													foreach($caseDetails['CaseFiling'] as $caseFiling){
													?>
													<tr>
														<td>
															<?php echo $caseFiling['filing_date'] ? $this->Time->format('D, M jS, Y', $caseFiling['filing_date']) : ''; ?>
														</td>
														<td><?php echo $caseFiling['filing_no']; ?></td>
														<td><?php echo $caseFiling['filing_type']; ?></td>
													</tr>
													<?php } }else{ ?>
													<tr>
														<td colspan="5" class="details-field" style="text-align: center;">
															No record found
														</td>
													</tr>
													<?php } ?>
												</table>

												<table class="table table-striped table-bordered">
													<tr>
														<th colspan="5" style="text-align: center;">
															Case Dispatches
														</th>
													</tr>
													<tr>
														<th>Date</th>
														<th>Title</th>
														<th>Remarks</th>
													</tr>
													<?php if(!empty($caseDetails['Dispatch'])){
													foreach($caseDetails['Dispatch'] as $caseDispatch){
													?>
													<tr>
														<td>
															<?php echo $caseDispatch['date_of_dispatch'] ? $this->Time->format('D, M jS, Y', $caseDispatch['date_of_dispatch']) : ''; ?>
														</td>
														<td><?php echo $caseDispatch['title']; ?></td>
														<td width="40%"><?php echo $caseDispatch['remarks']; ?></td>
													</tr>
													<?php } }else{ ?>
													<tr>
														<td colspan="5" class="details-field" style="text-align: center;">
															No record found
														</td>
													</tr>
													<?php } ?>
												</table>

												<?php if(!empty($caseDetails['CaseStatus']['status']) && $caseDetails['CaseStatus']['status']=='decided') { ?>
												<table class="table table-striped table-bordered">
													<tr>
														<th colspan="5" style="text-align: center;">
															Case Decision
														</th>
													</tr>
													<tr>
														<td>
															<?php if($caseDetails['ClientCase']['certified_copy_required']==1){ ?>
																<b>Certified copy required:</b> Yes <br />

																<?php if(!empty($caseDetails['ClientCase']['certified_copy_applied_date'])) { ?>

																	<b>Applied On:</b> <?php echo $caseDetails['ClientCase']['certified_copy_applied_date'] ? $this->Time->format('D, M jS, Y', $caseDetails['ClientCase']['certified_copy_applied_date']) : ''; ?> <br />
																<?php }

																if(!empty($caseDetails['ClientCase']['certified_copy_received_date'])) { ?>

																	<b>Received On:</b> <?php echo $caseDetails['ClientCase']['certified_copy_received_date'] ? $this->Time->format('D, M jS, Y', $caseDetails['ClientCase']['certified_copy_received_date']) : ''; ?> <br />
																<?php }

																if(!empty($caseDetails['ClientCase']['order_supplied_date'])) { ?>

																	<b>Supplied On:</b> <?php echo $caseDetails['ClientCase']['order_supplied_date'] ? $this->Time->format('D, M jS, Y', $caseDetails['ClientCase']['order_supplied_date']) : ''; ?> <br />

																	<?php if(!empty($caseDetails['ClientCase']['supplied_via'])) {

																		echo '<b>Supplied Via:</b> '.$caseDetails['ClientCase']['supplied_via'];

																		if(!empty($caseDetails['ClientCase']['alongwith_lcr'])) {

																			echo ' (Supplied along with lcr)';
																		}
																	}
																}
															}else{
																echo '<b>Certified copy required:</b> No';
															} ?>
														</td>
													</tr>
												</table>
												<?php } ?>
                                            </div>
                                			<!--<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<div class="col-sm-12 col-xs-12">
															<label class="col-xs-12 control-label no-padding-right"> <b>Case Title: </b> <span class="viewPageValues">sadsdsdas</span> </label>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<div class="col-sm-12 col-xs-12">
															<label class="col-xs-12 control-label no-padding-right"> <b>Case Title: </b> <span class="viewPageValues">sadsdsdas</span> </label>
														</div>
													</div>
												</div>
											</div>-->

											<div class="row">
												<div class="col-sm-12">
													<div class="clearfix pull-right">
														<input type='button' class='btn btn-primary noprint' id='btn' value='Print' onclick='printDiv();'>
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
			</div>
		</div>
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->
<?php echo $this->Html->css('print'); ?>
<script type="text/javascript">
function printDiv() {

  var divToPrint = document.getElementById('viewCaseDetails');
  var newWin=window.open('','Print-Window');
  newWin.document.open();
  newWin.document.write('<html><head><link rel=\"stylesheet\" href=\"/om/css/print.css\" type=\"text/css\" media=\"all\"/></head><body onload="window.focus();window.print();" onbeforeunload="window.close();">'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},10);
}
</script>