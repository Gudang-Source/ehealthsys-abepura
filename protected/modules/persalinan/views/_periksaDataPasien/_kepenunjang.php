<?php
$modMasukPenunjang = PSPasienMasukPenunjangT::model()->with('ruangan')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
$jumlah = count($modMasukPenunjang);
foreach($modMasukPenunjang as $row){
        $result = '<li>'.$row->ruangan->ruangan_nama.'</li>';
}
echo (isset($result)?$result:"");
?>