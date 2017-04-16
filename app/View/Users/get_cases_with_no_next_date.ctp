<div id="cases_with_no_next_date">
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
					<i class="icon-caret-right blue"></i>Last Hearing Date
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($cases_with_no_next_date)) {
				foreach ($cases_with_no_next_date as $record) {
			?>
			<tr>
				<td>
					<?php echo $this->Html->link($record['ClientCase']['complete_case_number'], array('controller' => 'Cases', 'action' => 'view', $record['ClientCase']['id']));
					?>
				</td>
				<td class="hidden-480"><?php echo $record['ClientCase']['party_name']; ?></td>
				<td class="">
					<?php echo $record['CaseProceeding']['date_of_hearing']; ?>
				</td>
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
<div id="cases_with_no_next_date_count"><?php echo $cases_with_no_next_date_count; ?></div>