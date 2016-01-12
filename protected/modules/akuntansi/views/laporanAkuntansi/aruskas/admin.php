<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
	$url = Yii::app()->createUrl('akuntansi/laporanAkuntansi/frameGrafikLaporanBukuBesar&id=1');
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
<div class="white-container">
    <legend class="rim2">Laporan <b>Arus Kas</b></legend>
    <div class="search-form">
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.aruskas/_search',array('model'=>$model)); 
        ?>
    </div><!-- search-form --> 
    <div class='block-tabel'> 
        <h6>Tabel <b>Arus Kas</b></h6>
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.aruskas/_table', array('model'=>$model)); ?>
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanArusKas');
        $this->renderPartial('akuntansi.views.laporanAkuntansi._footerNoGraph', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
    ?>
</div>