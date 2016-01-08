<?php
$url = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/frameGrafikLaporanMorbiditas&id=1');
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
<div class="white-container">
    <legend class="rim2">Laporan <b>Morbiditas Pasien</b></legend>
    <div class="search-form">
        <?php $this->renderPartial('morbiditas/_search',array(
            'model'=>$model,'format'=>$format
        )); ?>
    </div>
    <div class="block-tabel"> 
        <h6>Tabel Laporan <b>Morbiditas Pasien</b></h6>
        <?php $this->renderPartial('morbiditas/_table', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printLaporanMorbiditas');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
    <?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>
</div>