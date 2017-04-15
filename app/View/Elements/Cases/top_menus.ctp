<div class="">
	<div class="widget-toolbars no-border">
		<ul class="nav nav-tabs" id="myTab2">

			<?php
			$viewCaseTab = $editCaseTab = $manageCaseFilesTab = $manageCaseConnectsTab = $manageCaseHistoryTab = $manageCaseDispatchTab = $manageCaseCivilMiscTab = $manageTodoTab = '';
			$viewCaseAE = $editCaseAE = $manageCaseFilesAE = $manageCaseConnectsAE = $manageCaseHistoryAE = $manageCaseDispatchAE = $manageCaseCivilMiscAE = $manageTodoAE = 'false';

			if (lcfirst($this->params['controller']) == 'cases' && $this->params['action'] == 'view') {
				$viewCaseTab = 'active';
				$viewCaseAE = 'true';
			} elseif (lcfirst($this->params['controller']) == 'cases') {
				$editCaseTab = 'active';
				$editCaseAE = 'true';
			}

			if ($this->params['controller'] == 'CaseFiles') {
				$manageCaseFilesTab = 'active';
				$manageCaseFilesAE = 'true';
			}

			if ($this->params['controller'] == 'ConnectCases') {
				$manageCaseConnectsTab = 'active';
				$manageCaseConnectsAE = 'true';
			}

			if ($this->params['controller'] == 'CaseProceedings') {
				$manageCaseHistoryTab = 'active';
				$manageCaseHistoryAE = 'true';
			}

			if ($this->params['controller'] == 'Dispatches') {
				$manageCaseDispatchTab = 'active';
				$manageCaseDispatchAE = 'true';
			}

			if ($this->params['controller'] == 'CaseCivilMiscs') {
				$manageCaseCivilMiscTab = 'active';
				$manageCaseCivilMiscAE = 'true';
			}

			if ($this->params['controller'] == 'Todos') {
				$manageTodoTab = 'active';
				$manageTodoAE = 'true';
			}

			?>
			<li class="<?php echo $viewCaseTab; ?>">
				<?php echo $this->Html->link('View Case ', array('controller'=>'cases','action'=>'view', $caseId), array('escape' => false, 'aria-expanded' => $viewCaseAE))?>
			</li>

			<li class="<?php echo $editCaseTab; ?>">
				<?php echo $this->Html->link('Edit Case ', array('controller'=>'cases','action'=>'edit', $caseId), array('escape' => false, 'aria-expanded' => $editCaseAE))?>
			</li>

			<?php
			$emptyCaseNumberField = 'hide';
			if (!empty($caseDetails['ClientCase']['case_number'])) {
				$emptyCaseNumberField = '';
			}
			?>

			<li class="caseNumberRelatedFields <?php echo $emptyCaseNumberField; ?> <?php echo $manageCaseFilesTab; ?>">
				<?php echo $this->Html->link('Attachments ', array('controller'=>'CaseFiles','action'=>'manage', $caseId), array('escape' => false, 'aria-expanded' => $manageCaseFilesAE))?>
			</li>

			<li class="caseNumberRelatedFields <?php echo $emptyCaseNumberField; ?> <?php echo $manageCaseConnectsTab; ?>">
				<?php echo $this->Html->link('Connect Cases ', array('controller'=>'ConnectCases','action'=>'manage', $caseId), array('escape' => false, 'aria-expanded' => $manageCaseConnectsAE))?>
			</li>

			<li class="caseNumberRelatedFields <?php echo $emptyCaseNumberField; ?> <?php echo $manageCaseHistoryTab; ?>">
				<?php echo $this->Html->link('Case History ', array('controller'=>'CaseProceedings','action'=>'caseHistory', $caseId), array('escape' => false, 'aria-expanded' => $manageCaseHistoryAE))?>
			</li>

			<li class="caseNumberRelatedFields <?php echo $emptyCaseNumberField; ?> <?php echo $manageCaseCivilMiscTab; ?>">
				<?php echo $this->Html->link('CM/CRM ', array('controller'=>'CaseCivilMiscs','action'=>'caseCivilMisc', $caseId), array('escape' => false, 'aria-expanded' => $manageCaseCivilMiscAE))?>
			</li>

			<li class="caseNumberRelatedFields <?php echo $emptyCaseNumberField; ?> <?php echo $manageCaseDispatchTab; ?>">
				<?php echo $this->Html->link('Case Dispatches ', array('controller'=>'Dispatches','action'=>'caseDispatches', $caseId), array('escape' => false, 'aria-expanded' => $manageCaseDispatchAE))?>
			</li>

			<li class="caseNumberRelatedFields <?php echo $emptyCaseNumberField; ?> <?php echo $manageTodoTab; ?>">
				<?php echo $this->Html->link('Case Todos ', array('controller'=>'Todos','action'=>'caseTodos', $caseId), array('escape' => false, 'aria-expanded' => $manageTodoAE))?>
			</li>

		</ul>
	</div>
</div>