<div class="white-container">
    <?php
    $url = Yii::app()->createUrl('asuransi/lapVerifikasiKlaim/FrameGrafikLapVerifikasiKlaim&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('#searchLaporan').submit(function(){
            $.fn.yiiGridView.update('tableLaporan', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <legend class="rim2">Laporan Verifikasi <b>Klaim BPJS</b></legend>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <?php $this->renderPartial($this->path_view.'_search',array('model'=>$model,'format'=>$format)); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel Verifikasi <b>Klaim</b></h6>
        <?php $this->renderPartial($this->path_view.'_table',array('model'=>$model)); ?>
        <iframe src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
    </fieldset>
    <?php        
		$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
		$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
		$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
		$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>