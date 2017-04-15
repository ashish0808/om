<div id="todos">
	<table class="table table-bordered table-striped">
		<thead class="thin-border-bottom">
			<tr>
				<th>
					<i class="icon-caret-right blue"></i>Case No
				</th>

				<th class="hidden-480">
					<i class="icon-caret-right blue"></i>Title
				</th>

				<th>
					<i class="icon-caret-right blue"></i>Due Date
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($todos)) {
				foreach ($todos as $record) {
			?>
			<tr>
				<td>
					<?php echo $record['ClientCase']['complete_case_number'] ? $this->Html->link($record['ClientCase']['complete_case_number'], array('controller' => 'Todos', 'action' => 'caseTodos', $record['ClientCase']['id'])): "<span class='red'>Miscellaneous</span>"; ?>
				</td>
				<td class="hidden-480"><?php echo $record['Todo']['title']; ?></td>
				<td class="">
					<?php echo $record['Todo']['completion_date']; ?>
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
<div id="todos_count"><?php echo $todos_count; ?></div>