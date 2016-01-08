<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        //DIPISAH DARI RAWAT JALAN KARENA ADA PERBEDAAN DI CONTROLLER TAB NYA
        array('label'=>'Anamnesis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesaTRD/index')),
        array('label'=>'Periksa Fisik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemeriksaanFisikTRD/index')),
        array('label'=>'Laboratorium', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/laboratoriumTRD/index')),
        array('label'=>'Radiologi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/radiologiTRD/index')),
        array('label'=>'Rehab Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/rehabMedisTRD/index')),
        array('label'=>'Konsultasi Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulGiziTRD/index')),
        array('label'=>'Konsultasi Poliklinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulPoliTRD/index')),
        array('label'=>'Konsultasi MCU', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulMCURD/index')),
        array('label'=>'Diagnosis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/diagnosaTRD/index')),
        array('label'=>'Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/tindakanTRD/index')),
        array('label'=>'Bedah Sentral', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/bedahSentralTRD/index')),
        array('label'=>'Rujukan Ke Luar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/rujukanKeluarTRD/index')),
        array('label'=>'Reseptur', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/resepturTRD/index')),
        array('label'=>'Pemakaian Bahan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemakaianBahanTRD/index')),
    ),
));
?>