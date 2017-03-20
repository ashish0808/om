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
																		<span class="view-label">Complete Case Number: </span> <?php echo $caseDetails['ClientCase']['complete_case_number']; ?>
																	</td>
																</tr>
																<tr>
																	<td class="details-field">
																		<span class="view-label">Case Number: </span> <?php echo $caseDetails['ClientCase']['case_number']; ?>
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
																		<span class="view-label">Case Type: </span>
																		 <?php if(!empty($caseDetails['CaseType']['name'])) {
																		 	echo $caseDetails['CaseType']['name'];
																		 }
																		 ?>
																	</td>
																	<td></td>
																	<td class="details-field">
																		<span class="view-label">Case Year: </span> <?php echo $caseDetails['ClientCase']['case_year']; ?>
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
																		<span class="view-label">Party Name: </span>
																		 <?php echo $caseDetails['ClientCase']['party_name']; ?>
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
															</table>
														</td>
													</tr>
												</table>
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