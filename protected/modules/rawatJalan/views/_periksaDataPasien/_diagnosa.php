<?php
$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
$morbid = PasienmorbiditasT::model()->findAllByAttributes(array(
    'pendaftaran_id'=>$pendaftaran_id,
    'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA,
));

if(count($modPendaftaran) > 0){
    if(count($morbid) > 0) {
        echo "Pemeriksaan : <br/><ul>";
        foreach ($morbid as $item) {
            echo "<li>".$item->diagnosa->diagnosa_kode." ".$item->diagnosa->diagnosa_nama."</li>";
        }
        echo "</ul>";
    } 
    if(!empty($modPendaftaran->rujukan_id)){
            echo "Rujukan : <br/>";
            $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
            echo isset($modRujukan->kddiagnosa_rujukan) ? $modRujukan->kddiagnosa_rujukan : ""." - ".isset($modRujukan->diagnosa_rujukan) ? $modRujukan->diagnosa_rujukan : "";
    }
}
?>