<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Tabular List', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->getUrlTabularList())),
    	array('label'=>'Kelompok Diagnosa', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlKelompokDiagnosa())),
        array('label'=>'DTD', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlDTD())),
    	array('label'=>'Klasifikasi Diagnosa', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlKlasifikasiDiagnosa())),
    	array('label'=>'Diagnosa ICD X', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlDiagnosa())),
    	array('label'=>'Diagnosa ICD IX', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlDiagnosaIX())),
    		
    ),
));
?>