<?php
//$this->breadcrumbs=array(
//    'Ppinfo Kunjungan Rjvs'=>array('index'),
//    'Manage',
//);

$url = Yii::app()->createUrl('pendaftaranPenjadwalan/laporan/frameGrafikKunjunganDokter&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('tableLaporan', {
            data: $(this).serialize()
    });
    return false;
});
");
?>
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="white-container">
    <legend class="rim2">Laporan <b>Kunjungan Dokter</b></legend>
    <fieldset class="box search-form">
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.kunjunganDokter/_searchKunjunganDokter',array(
            'model'=>$model,'format'=>$format
        )); ?>
    </fieldset><!-- search-form --> 
    <div class="block-tabel">
        <h6>Tabel <b>Kunjungan Dokter</b></h6>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.kunjunganDokter/_tableKunjunganDokter', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
      //echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan Grafik',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'$("#Grafik")[0].contentWindow.test();
    //'))."&nbsp&nbsp"; 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKunjunganDokter');
    $this->renderPartial('pendaftaranPenjadwalan.views.laporan._footer', array('urlPrint'=>$urlPrint, 'url'=>$url, 'tips'=>'rekapitulasi')); ?>
    <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.rawatJalan/_jsFunctions', array('model'=>$model));?>
</div>