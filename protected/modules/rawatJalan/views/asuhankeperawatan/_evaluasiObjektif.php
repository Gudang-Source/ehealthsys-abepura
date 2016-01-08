<?php
$modEvaluasiSubjektif = RJAsuhankeperawatanT::model()->findByAttributes(array('asuhankeperawatan_id'=>$asuhankeperawatan_id));
if(COUNT($modEvaluasiSubjektif)>0)
    {
        echo $modEvaluasiSubjektif->evaluasi_objektif;        
    }
else
    {
        echo "Tidak di Set";
    }   
?>

