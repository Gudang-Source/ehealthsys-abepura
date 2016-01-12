
<?php
//$modBankRek = AKBankRekM::model()->findAllByAttributes(array('bank_id'=>$bank_id));
$modBankRek = SABankRekM::model()->findAllBySql("SELECT * 
FROM bankrek_m 
JOIN rekening5_m as rekeningdebit ON bankrek_m.rekening5_id = rekeningdebit.rekening5_id 
WHERE
bankrek_m.bank_id = $bank_id AND bankrek_m.debitkredit = 'D'");

if(COUNT($modBankRek)>0)
    {   
        echo "<ul>"; 
        foreach($modBankRek as $i=>$data)
        {
            echo "<li>".$data->rekeningdebit->nmrekening5.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
