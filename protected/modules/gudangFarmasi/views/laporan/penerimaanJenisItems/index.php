<?php
$url = Yii::app()->createUrl('gudangFarmasi/laporan/FrameGrafikLaporanPenerimaanJenisItems&id=1');
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
    <legend class="rim2">Laporan Penerimaan <b>Items - Berdasarkan Jenis</b></legend>
    <fieldset class="box">
        <?php $this->renderPartial('penerimaanJenisItems/_search',array('model'=>$model,'format'=>$format)); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel Penerimaan <b>Items Berdasarkan Jenis</b></h6>
        <?php $this->renderPartial('penerimaanJenisItems/_table',array('model'=>$model,'tgl_awal'=>$model->tgl_awal,'tgl_akhir'=>$model->tgl_akhir,'format'=>$format)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
        </iframe>
    </div>
    <?php        
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPenerimaanJenisItems');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>