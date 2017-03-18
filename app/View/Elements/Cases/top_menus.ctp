<div class="">
	<div class="widget-toolbars no-border">
		<ul class="nav nav-tabs" id="myTab2">

			<?php
			$editCaseTab = $manageCaseFilesTab = $manageCaseConnectsTab = $manageCaseHistoryTab = $manageCaseDispatchTab = $manageCaseCivilMiscTab = '';
			$editCaseAE = $manageCaseFilesAE = $manageCaseConnectsAE = $manageCaseHistoryAE = $manageCaseDispatchAE = $manageCaseCivilMiscAE = 'false';
			if (lcfirst($this->params['controller']) == 'cases') {
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

			?>

			<li class="<?php echo $editCaseTab; ?>">
				<?php echo $this->Html->link('Edit Case ', array('controller'=>'cases','action'=>'edit', $caseId), array('escape' => false, 'aria-expanded' => $editCaseTab))?>
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

		</ul>
	</div>
</div>