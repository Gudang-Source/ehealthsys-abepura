<?php

//    $modRekBank = BankrekM::model()->findAllByAttributes(array('bank_id'=>$bank_id));

$modRekBank = BankrekM::model()->findAllBySql("SELECT * 
FROM bankrek_m 
JOIN rekening5_m as rekeningdebit ON bankrek_m.rekening5_id = rekeningdebit.rekening5_id 
JOIN bank_m as bank ON bankrek_m.bank_id = bank.bank_id
WHERE
bankrek_m.bank_id = $bank_id AND bankrek_m.debitkredit = 'D'");
if (COUNT($modRekBank) > 0) {
	foreach ($modRekBank as $i => $data) {
		if (isset($_GET['caraPrint'])) {
			echo "<pre>";
			echo $data->rekeningdebit->nmrekening5;
			echo "</pre>";
		} else {
			echo "<pre>";
			echo $data->rekeningdebit->nmrekening5 . CHtml::Link("<i class=\"icon-pencil\"></i>", Yii::app()->controller->createUrl(Yii::app()->controller->id ."/ubahRekeningDebit", array("id" => $data->bankrek_id)), array("class" => "",
				"target" => "iframeEditRekeningDebitKredit",
				"onclick" => "$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
				"rel" => "tooltip",
				"title" => "Klik untuk ubah Rekening Debit",
			));
			echo "</pre>";
		}
	}
} else {
	echo Yii::t('zii', 'Not set');
}
?>