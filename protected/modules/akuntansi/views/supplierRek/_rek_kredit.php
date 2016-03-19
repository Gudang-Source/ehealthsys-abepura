<?php
    $debet = 'K';
//    $modRekSupplier = SupplierrekM::model()->findAllByAttributes(array('supplier_id'=>$supplier_id,'saldonormal'=>$debet));
    $modRekSupplier = SupplierrekM::model()->findAllBySql("SELECT * 
FROM supplierrek_m 
JOIN rekening5_m as rekeningdebit ON supplierrek_m.rekening5_id = rekeningdebit.rekening5_id AND rekeningdebit.rekening5_nb = 'K'
WHERE
supplierrek_m.supplier_id = $supplier_id");
    if(COUNT($modRekSupplier)>0)
    {   
        foreach($modRekSupplier as $i=>$data)
        {
            echo "<pre>";
            if(isset($_GET['caraPrint'])){
                echo $data->rekening5->nmrekening5;
            }else{
                echo $data->rekening5->nmrekening5.CHtml::Link("<i class=\"icon-form-ubah\"></i>",
                            Yii::app()->controller->createUrl("supplierRek/ubahRekeningKredit",array("id"=>$data->supplierrek_id)),
                            array("class"=>"", 
                                  "target"=>"iframeEditRekeningDebitKredit",
                                  "onclick"=>"$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk ubah Rekening Debit",
                            ));
            }
            echo "</pre>";
        }
    }
    else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>