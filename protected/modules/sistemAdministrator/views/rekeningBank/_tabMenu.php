<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
//        array('label'=>'Bank', 'url'=>$this->createUrl('/akuntansi/bankM/create'),),
        array('label'=>'Bank', 'url'=>Yii::app()->createUrl($this->module->id.'/bankM/create'),),
        array('label'=>'Rekening', 'url'=>Yii::app()->createUrl($this->module->id.'/rekeningBank/create'),'active'=>true),
            ),
)); 
?>