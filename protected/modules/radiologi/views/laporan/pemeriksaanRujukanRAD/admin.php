<div class="white-container">
    <legend class="rim2">Laporan <b>Pemeriksaan Rujukan Radiologi</b></legend>
    <?php
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js/bootstrap-multiselect/css/bootstrap-multiselect.css', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END);

        $url = Yii::app()->createUrl('radiologi/laporan/FrameLaporanPemeriksaanRujukanRAD&id=1');
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
    <fieldset class="box">
        <?php $this->renderPartial('pemeriksaanRujukanRAD/_search',array(
            'model'=>$model, 'format'=>$format
        )); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Pemeriksaan Rujukan Radiologi</b></h6>
        <?php $this->renderPartial('pemeriksaanRujukanRAD/_table', array('model'=>$model)); ?>        
    </div>
	<div class="block-tabel">
		<?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>           
	</div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintLaporanPemeriksaanRujukanRAD');
        $this->renderPartial('_footer_pisah', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
    <?php $this->renderPartial('gizi.views.laporan/_jsFunctions', array('model'=>$model));?>
</div>