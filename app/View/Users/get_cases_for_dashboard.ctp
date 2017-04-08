<div id="pending_for_filing">
	<table class="table table-bordered table-striped">
		<thead class="thin-border-bottom">
			<tr>
				<th>
					<i class="icon-caret-right blue"></i>Case No
				</th>

				<th class="hidden-480">
					<i class="icon-caret-right blue"></i>Party Name
				</th>

				<th>
					<i class="icon-caret-right blue"></i>Limitation Expiry
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($pending_for_filing_data)) {
				foreach ($pending_for_filing_data as $record) {
			?>
			<tr>
				<td>
					<?php echo $this->Html->link($record['ClientCase']['complete_case_number'], array('controller' => 'Cases', 'action' => 'view', $record['ClientCase']['id']));
					?>
				</td>
				<td class="hidden-480"><?php echo $record['ClientCase']['party_name']; ?></td>
				<td class=""><?php echo (!empty($record['ClientCase']['limitation_expires_on'])) ? $this->Time->format('D, M jS, Y', $record['ClientCase']['limitation_expires_on']) : "Not Available"; ?></td>
			</tr>
			<?php
				}
			} else { ?>
				<tr>
					<td class="center" colspan="4">
						<label>
							<span class="notify_message"><?php echo NO_RECORD;?></span>
						</label>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div id="pending_for_filing_count"><?php echo $pending_for_filing_count; ?></div>
<div id="pending_for_refiling">
	<table class="table table-bordered table-striped">
		<thead class="thin-border-bottom">
			<tr>
				<th>
					<i class="icon-caret-right blue"></i>Case No
				</th>

				<th class="hidden-480">
					<i class="icon-caret-right blue"></i>Party Name
				</th>

				<th>
					<i class="icon-caret-right blue"></i>Limitation Expiry
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($pending_for_refiling_data)) {
				foreach ($pending_for_refiling_data as $record) {
			?>
			<tr>
				<td>
					<?php echo $this->Html->link($record['ClientCase']['complete_case_number'], array('controller' => 'Cases', 'action' => 'view', $record['ClientCase']['id']));
					?>
				</td>
				<td class="hidden-480"><?php echo $record['ClientCase']['party_name']; ?></td>
				<td class=""><?php echo (!empty($record['ClientCase']['limitation_expires_on'])) ? $this->Time->format('D, M jS, Y', $record['ClientCase']['limitation_expires_on']) : "Not Available"; ?></td>
			</tr>
			<?php
				}
			} else { ?>
				<tr>
					<td class="center" colspan="4">
						<label>
							<span class="notify_message"><?php echo NO_RECORD;?></span>
						</label>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div id="pending_for_refiling_count"><?php echo $pending_for_refiling_count; ?></div>

<div id="pending_for_registration">
	<table class="table table-bordered table-striped">
		<thead class="thin-border-bottom">
			<tr>
				<th>
					<i class="icon-caret-right blue"></i>Case No
				</th>

				<th class="hidden-480">
					<i class="icon-caret-right blue"></i>Party Name
				</th>

				<th>
					<i class="icon-caret-right blue"></i>Limitation Expiry
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($pending_for_registration_data)) {
				foreach ($pending_for_registration_data as $record) {
			?>
			<tr>
				<td>
					<?php echo $this->Html->link($record['ClientCase']['complete_case_number'], array('controller' => 'Cases', 'action' => 'view', $record['ClientCase']['id']));
					?>
				</td>
				<td class="hidden-480"><?php echo $record['ClientCase']['party_name']; ?></td>
				<td class=""><?php echo (!empty($record['ClientCase']['limitation_expires_on'])) ? $this->Time->format('D, M jS, Y', $record['ClientCase']['limitation_expires_on']) : "Not Available"; ?></td>
			</tr>
			<?php
				}
			} else { ?>
				<tr>
					<td class="center" colspan="4">
						<label>
							<span class="notify_message"><?php echo NO_RECORD;?></span>
						</label>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div id="pending_for_registration_count"><?php echo $pending_for_registration_count; ?></div>