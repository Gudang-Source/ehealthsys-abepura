
<?php
//$modJenispengeluaranRek = AKJnsPengeluaranRekM::model()->findAllByAttributes(array('jenispengeluaran_id'=>$jenispengeluaran_id, 'saldonormal'=>$saldonormal));
$modJenispengeluaranRek = AKJnsPengeluaranRekM::model()->findAllBySql("SELECT * 
FROM jnspengeluaranrek_m 
JOIN rekening5_m as rekeningkredit ON jnspengeluaranrek_m.rekening5_id = rekeningkredit.rekening5_id
WHERE
jnspengeluaranrek_m.jenispengeluaran_id = $jenispengeluaran_id AND jnspengeluaranrek_m.debitkredit = 'K'"
);
if(COUNT($modJenispengeluaranRek)>0)
    {   
        echo "<ul>"; 
        foreach($modJenispengeluaranRek as $i=>$data)
        {
            echo "<li>".$data->rekeningkredit->nmrekening5.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
