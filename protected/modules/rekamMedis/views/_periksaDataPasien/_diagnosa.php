<?php

$modMorbiditas = PasienmorbiditasT::model()->with('diagnosa')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
$jumlahMorbiditas = count($modMorbiditas);
$result = array();
foreach($modMorbiditas as $row){
        $result[] = $row->diagnosa->diagnosa_nama;
}
echo implode(', ',$result);
?>