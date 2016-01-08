<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
	$url = Yii::app()->createUrl('akuntansi/laporanAkuntansi/frameGrafikLaporanBukuBesar&id=1');
	Yii::app()->clientScript->registerScript('search', "
		$('.search-form form').submit(function(){
			$('#Grafik').attr('src','').css('height','0px');
			$.fn.yiiGridView.update('tableLaporan', {
					data: $(this).serialize()
			});
			return false;
		});
	");
?>
<div class='white-container'>
    <legend class="rim2">Laporan <b>Buku Besar</b></legend>
    <div class="search-form">
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.bukuBesar/_search',array('model'=>$model,'modelLaporan'=>$modelLaporan)); 
        ?>
    </div>
    <div class='block-tabel'> 
        <h6>Tabel <b>Buku Besar</b></h6>
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.bukuBesar/_table', array('model'=>$model, 'jmlrekening'=>$jmlrekening)); ?>
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanBukuBesar');
        $this->renderPartial('akuntansi.views.laporanAkuntansi._footerNoGraph', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
    ?>
</div>