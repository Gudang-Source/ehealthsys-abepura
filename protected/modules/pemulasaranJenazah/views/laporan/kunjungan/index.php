<?php
//$this->breadcrumbs=array(
//    'Ppinfo Kunjungan Rjvs'=>array('index'),
//    'Manage',
//);

$url = Yii::app()->createUrl(Yii::app()->controller->module->id.'/laporan/frameGrafikKunjungan&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('#searchLaporan').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('tableLaporan', {
            data: $(this).serialize()
    });
    return false;
});
");
?>
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class='white-container'>
    <legend class="rim2">Laporan <b>Daftar Jenazah</b></legend>
    <fieldset class="box search-form">
        <?php $this->renderPartial('kunjungan/_search',array(
            'model'=>$model,'format'=>$format
        )); ?>
    </fieldset><!-- search-form -->
    <div class='block-tabel'>
        <h6>Tabel <b>Daftar Jenazah</b></h6>
        <?php $this->renderPartial('kunjungan/_table', array('model'=>$model)); ?>
    </div>
    <div class='block-tabel'>
        <?php $this->renderPartial('_tab'); ?>
        <iframe class='biru' src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKunjungan');
    $this->renderPartial('_footer_pisah', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>

    <?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>
</div>