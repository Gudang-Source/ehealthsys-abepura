<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Anamnesis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesaTPS/index')),
        array('label'=>'Periksa Fisik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemeriksaanFisikTPS/index')),
        array('label'=>'Laboratorium', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/laboratoriumTPS/index')),
        array('label'=>'Radiologi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/radiologiTPS/index')),
        array('label'=>'Rehab Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/rehabMedisTPS/index')),
        array('label'=>'Konsultasi Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulGiziTPS/index')),
        array('label'=>'Konsultasi Poliklinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulPoliTPS/index')),
        array('label'=>'Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/tindakanTPS/index')),
        array('label'=>'Diagnosis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/diagnosaTPS/index')),
        array('label'=>'Bedah Sentral', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/bedahSentralTPS/index')),
        array('label'=>'Rujukan Ke Luar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/rujukanKeluarTPS/index')),
        array('label'=>'Reseptur', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/resepturTPS/index')),
        array('label'=>'Pemakaian Bahan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemakaianBahanTPS/index&frame=TRUE')),
    ),
));
?>