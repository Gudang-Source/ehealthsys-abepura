<?php
//    $modRekPenjamin = PenjaminrekM::model()->findAllByAttributes(array('penjamin_id'=>$penjamin_id,'saldonormal'=>$saldonormal));
    $modRekPenjamin = PenjaminrekM::model()->findAllBySql("SELECT * 
FROM penjaminrek_m 
JOIN rekening5_m as rekeningdebit ON penjaminrek_m.rekening5_id = rekeningdebit.rekening5_id AND rekeningdebit.rekening5_nb = 'K'
WHERE
penjaminrek_m.penjamin_id = $penjamin_id");
    if(COUNT($modRekPenjamin)>0)
    {   
        foreach($modRekPenjamin as $i=>$data)
        {
            if(isset($_GET['caraPrint'])){
                //echo "<pre>";
                echo !empty($data->rekening5_id)?$data->rekeningdebit->nmrekening5:" - ";
                //echo "</pre>";
            }else{
            
                //echo "<pre>";
                echo $data->rekeningdebit->nmrekening5; /*.CHtml::Link("<i class=\"icon-form-ubah\"></i>",
                                Yii::app()->controller->createUrl("jurnalRekPenjamin/ubahRekeningKredit",array("id"=>$data->penjaminrek_id)),
                                array("class"=>"", 
                                      "target"=>"iframeEditRekeningDebitKredit",
                                      "onclick"=>"$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk ubah Rekening Debit",
                                ));
                echo "</pre>"; */
            }
        }
    }
    else
    {
        echo Yii::t('zii','-'); 
    }   
?>