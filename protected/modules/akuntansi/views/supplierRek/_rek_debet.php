<?php
	$saldonormal = isset($saldonormal) ? $saldonormal : "D";
    $debet = 'D';
//    $modRekSupplier = SupplierrekM::model()->findAllByAttributes(array('supplier_id'=>$supplier_id));
    $modRekSupplier = SupplierrekM::model()->findAllBySql("SELECT * 
FROM supplierrek_m 
JOIN rekening5_m as rekeningdebit ON supplierrek_m.rekening5_id = rekeningdebit.rekening5_id AND rekeningdebit.rekening5_nb = 'D'
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
                echo $data->rekening5->nmrekening5.CHtml::Link("<i class=\"icon-pencil\"></i>",
                            Yii::app()->controller->createUrl("supplierRek/ubahRekeningDebit",array("id"=>$data->supplierrek_id)),
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