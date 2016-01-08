<?php
$url = Yii::app()->createUrl('gudangFarmasi/laporan/FrameGrafikLaporanMutasiObatAlkes&id=1');
Yii::app()->clientScript->registerScript('search', "
$('#search-laporan').submit(function(){
	$.fn.yiiGridView.update('laporan-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Laporan Mutasi <b>Obat Alkes Intern</b></legend>
    <fieldset class="box">
        <?php $this->renderPartial('mutasiIntern/_search',array('model'=>$model,'format'=>$format)); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel Mutasi <b>Obat Alkes Intern</b></h6>
        <?php $this->renderPartial('mutasiIntern/_table',array('model'=>$model,'format'=>$format)); ?>
        <?php // $this->renderPartial('_tab'); ?>
        <iframe src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
    </div>
    <?php        
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanMutasiIntern');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>