<?php
App::uses('Helper', 'View');

class ClientCaseHelper extends AppHelper {

	public function getLastHearing($pendingProceeding) {

		$lastHearing = 'NA';
		if(isset($pendingProceeding['CaseProceeding']) && !empty($pendingProceeding['CaseProceeding'])) {

			$lastHearing = $pendingProceeding['CaseProceeding']['date_of_hearing'];

			if(strtotime($lastHearing) < strtotime(date('Y-m-d'))) {

				$lastHearing = 'NA';
			}
		}

		return $lastHearing;
	}
}
