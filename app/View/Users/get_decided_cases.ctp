<div id="decided_cases">
	<table class="table table-bordered table-striped">
		<thead class="thin-border-bottom">
			<tr>
				<th>
					<i class="icon-caret-right blue"></i>Case No
				</th>

				<th class="hidden-480">
					<i class="icon-caret-right blue"></i>Case Title
				</th>

				<th>
					<i class="icon-caret-right blue"></i>Alert
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($decided_cases)) {
				foreach ($decided_cases as $record) {
			?>
			<tr>
				<td>
					<?php echo $this->Html->link($record['ClientCase']['complete_case_number'], array('controller' => 'Cases', 'action' => 'view', $record['ClientCase']['id']));
					?>
				</td>
				<td class="hidden-480"><?php echo $record['ClientCase']['case_title']; ?></td>
				<td class="">
					<?php
						echo $record['ClientCase']['message'];
					?>
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
<div id="decided_cases_count"><?php echo $decided_cases_count; ?></div>