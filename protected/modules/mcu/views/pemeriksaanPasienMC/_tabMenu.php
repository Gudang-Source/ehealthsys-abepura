<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Anamnesis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesa/index')),
        array('label'=>'Periksa Fisik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemeriksaanFisik/index')),
        array('label'=>'Laboratorium', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/laboratorium/index')),
        array('label'=>'Radiologi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/radiologi/index')),
        array('label'=>'Treadmill', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/treadmillMcu/index')),
        array('label'=>'Kacamata', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemeriksaanMataMcu/index')),
        array('label'=>'Hearing Test', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/hearingTestMcu/index')),
        array('label'=>'Konsultasi Poliklinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulPoliMC/index')),
        array('label'=>'Diagnosis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/diagnosa/index')),
        array('label'=>'Kesimpulan dan Saran', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/kesimpulanSaran/index')),        
        array('label'=>'Jantung Koroner', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/jantungKoroner/index')),        
    ),
));
?>