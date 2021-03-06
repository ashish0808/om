<div class="page-content">
	<div class="row">
		<div class="page-header" align="center">
			<h1>
				<?php echo $caseDetails['ClientCase']['case_title']; ?>
			</h1>
		</div>
		<div class="col-sm-12">
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
									<td class="details-field">
										<span class="view-label">Date Fixed: </span>
										<?php $clientCaseHelper = $this->Helpers->load('ClientCase');
										echo $clientCaseHelper->getLastHearing($pendingProceeding); ?>
									</td>
									<td></td>
									<td class="details-field">
										<span class="view-label">Status: </span>
										<?php
										 if(!empty($caseDetails['CaseStatus']['status'])) {
											echo ucfirst(str_replace('_', ' ', $caseDetails['CaseStatus']['status']));
										 } else{
											echo 'NA';
										 } ?>
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

				<table class="borderedTable">
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

				<table class="borderedTable">
					<tr>
						<th colspan="5" style="text-align: center;">
							Memo Of Hearings
						</th>
					</tr>
					<tr>
						<th>Date</th>
						<th>Cr. No.</th>
						<th>Sr. No.</th>
						<th>Next Hearing</th>
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
						<td><?php echo $caseProceeding['next_date_of_hearing'] ? $this->Time->format('D, M jS, Y', $caseProceeding['next_date_of_hearing']) : ''; ?></td>
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

				<table class="borderedTable">
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

				<table class="borderedTable">
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
				<table class="borderedTable">
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

				<?php if(isset($connectedCases) && !empty($connectedCases)){ ?>
					<div class="pagebreak"> </div>
					<div class="page-header">
						<h1>
							&nbsp;
						</h1>
					</div>
					<table class="borderedTable">
						<tr>
							<th colspan="5" style="text-align: center;">
								<?php if(isset($connectedCases['is_parent_case'])){
									echo 'Connected Cases';
								} else {
									echo 'Main Case';
								}
								?>
							</th>
						</tr>
						<tr>
							<th>Case Number</th>
							<th>Case Title</th>
							<th>Client Name</th>
						</tr>
						<?php if(!empty($connectedCases['child_cases'])){
							foreach($connectedCases['child_cases'] as $childCase){ ?>
							<tr>
								<td><?php echo $childCase['ClientCase']['complete_case_number']; ?></td>
								<td><?php echo $childCase['ClientCase']['case_title']; ?></td>
								<td><?php echo $childCase['ClientCase']['party_name']; ?></td>
							</tr>
							<?php }
						}elseif(!empty($connectedCases['parent_case'])) { ?>
							<tr>
								<td><?php echo $connectedCases['parent_case']['ClientCase']['complete_case_number']; ?></td>
								<td><?php echo $connectedCases['parent_case']['ClientCase']['case_title']; ?></td>
								<td><?php echo $connectedCases['parent_case']['ClientCase']['party_name']; ?></td>
							</tr>
						<?php }else{ ?>
							<tr>
								<td colspan="5" class="details-field" style="text-align: center;">
									No record found
								</td>
							</tr>
						<?php } ?>
					</table>

					<?php if(!empty($connectedCases['parent_case']) && !empty($connectedCases['other_connected_cases'])){ ?>
						<table class="borderedTable">
							<tr>
								<th colspan="5" style="text-align: center;">
									Other Connected Cases
								</th>
							</tr>
							<tr>
								<th>Case Number</th>
								<th>Case Title</th>
								<th>Client Name</th>
							</tr>
							<?php foreach($connectedCases['other_connected_cases'] as $otherConnectedCase){  ?>
							<tr>
								<td>
									<?php echo $otherConnectedCase['ClientCase']['complete_case_number']; ?>
								</td>
								<td><?php echo $otherConnectedCase['ClientCase']['case_title']; ?></td>
								<td><?php echo $otherConnectedCase['ClientCase']['party_name']; ?></td>
							</tr>
							<?php } ?>
						</table>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->
<?php echo $this->Html->css('print'); ?>
<script type="text/javascript">
	window.print();
	window.close();
</script>