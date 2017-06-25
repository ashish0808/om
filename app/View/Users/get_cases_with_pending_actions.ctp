<div id="cases_with_pending_actions">
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
					<i class="icon-caret-right blue"></i>Pending Actions
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($cases_with_pending_actions)) {
				foreach ($cases_with_pending_actions as $record) {
			?>
			<tr>
				<td>
					<?php echo $this->Html->link($record['ClientCase']['complete_case_number'], array('controller' => 'Cases', 'action' => 'view', $record['ClientCase']['id']));
					?>
				</td>
				<td class="hidden-480"><?php echo $record['ClientCase']['case_title']; ?></td>
				<td class="">
					<?php
						$str =  (!$record['ClientCase']['is_ememo_filed']) ? 'E-memo Filing,' : '';
						$str .= (!$record['ClientCase']['is_paper_book']) ? ' Paper Book,' : '';
						$str .= (!$record['ClientCase']['is_diary_entry']) ? ' Diary Entry,' : '';
						$str .= (!$record['ClientCase']['is_letter_communication']) ? ' Letter Communication,' : '';
						$str .= (!$record['ClientCase']['is_lcr']) ? ' LCR,' : '';
						echo rtrim($str, ",");
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
<div id="cases_with_pending_actions_count"><?php echo $cases_with_pending_actions_count; ?></div>