<?php

$modKonsulPoli = KonsulpoliT::model()->with('poliasal','politujuan')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
if (isset($modMasukPenunjang)){
    $jumlah = count($modMasukPenunjang);
}
$result = array();
foreach($modKonsulPoli as $row){
        $result[] = $row->politujuan->ruangan_nama;    
}
echo implode(', ',$result);
?>