<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
	$url = Yii::app()->createUrl('asuransi/laporanSEP/frameGrafikLaporanSEP&id=1');
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
    <legend class="rim2">Laporan <b>SEP Peserta (BPJS)</b></legend>
	<fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <div class="search-form">
			<?php $this->renderPartial($this->path_view.'_search',array('model'=>$model,'format'=>$format)); 
			?>
		</div><!-- search-form --> 
    </fieldset>    
    <div class='block-tabel'> 
        <h6>Tabel <b>SEP Peserta (BPJS)</b></h6>
        <?php $this->renderPartial($this->path_view.'_table', array('model'=>$model)); ?>
    </div>
	<div class="block-tabel">
        <?php $this->renderPartial($this->path_view.'_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanSEP');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model));?>
</div>