<?php
$url = Yii::app()->createUrl('gudangFarmasi/laporan/FrameGrafikLaporanPermintaanPembelian&id=1');
Yii::app()->clientScript->registerScript('search', "
$('#search-laporan').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
	$.fn.yiiGridView.update('tableLaporan', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Laporan <b>Permintaan Pembelian</b></legend>
    <fieldset class="box">
        <?php $this->renderPartial('permintaanPembelian/_search',array('model'=>$model,'format'=>$format)); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Permintaan Pembelian</b></h6>
        <?php $this->renderPartial('permintaanPembelian/_table',array('model'=>$model,'format'=>$format)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
        </iframe>
    </div>
    <?php        
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPermintaanPembelian');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>