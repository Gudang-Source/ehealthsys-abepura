<?php
    $url = Yii::app()->createUrl('gudangFarmasi/laporan/frameGrafikStockOpname&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
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
    <legend class="rim2">Laporan <b>Stock Opname</b></legend>
    <fieldset class="box search-form">
        <?php $this->renderPartial('stockOpname/_search',array(
            'model'=>$model,'format'=>$format
        )); ?>
    </fieldset><!-- search-form -->
    <div class="block-tabel">
        <h6>Tabel <b>Stock Opname</b></h6>
        <?php //$model = new GFLaporanfarmasikopnameV; ?>
        <?php $this->renderPartial('stockOpname/_tableStockOpname', array('model'=>$model,'format'=>$format)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanStockOpname');
        $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
</div>