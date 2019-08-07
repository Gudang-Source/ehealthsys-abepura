<div class="white-container">
    <legend class="rim2">Laporan <b>Formulir Opname Obat Alkes</b></legend>
    <?php
        $url = Yii::app()->createUrl('gudangFarmasi/laporan/FrameGrafikFormulirOpnameObatAlkes&id=1');
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
        <?php $this->renderPartial('formulirOpnameObatAlkes/_search',array(
            'model'=>$model, 'format'=>$format
        )); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Formulir Opname Obat Alkes</b></h6>
        <?php $this->renderPartial('formulirOpnameObatAlkes/_table', array('model'=>$model)); ?>
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>           
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintLaporanFormulirOpnameObatAlkes');
        $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url, 'tips'=>'10besar')); ?>
    <?php $this->renderPartial('gizi.views.laporan/_jsFunctions', array('model'=>$model));?>
</div>