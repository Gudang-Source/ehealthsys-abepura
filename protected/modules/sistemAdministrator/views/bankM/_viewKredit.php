
<?php
//$modBankRek = AKBankRekM::model()->findAllByAttributes(array('bank_id'=>$bank_id,'saldonormal'=>$saldonormal));
$modBankRek = SABankRekM::model()->findAllBySql("SELECT * 
FROM bankrek_m 
JOIN rekening5_m as rekeningkredit ON bankrek_m.rekening5_id = rekeningkredit.rekening5_id
WHERE
bankrek_m.bank_id = $bank_id AND bankrek_m.debitkredit = 'K'");
if(COUNT($modBankRek)>0)
    {   
        echo "<ul>"; 
        foreach($modBankRek as $i=>$data)
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
