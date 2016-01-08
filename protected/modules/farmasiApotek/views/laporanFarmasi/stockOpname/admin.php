<div class="white-container">
    <legend class="rim2">Laporan <b>Stock Opname</b></legend>
    <?php
        $url = Yii::app()->createUrl('farmasiApotek/laporanFarmasi/frameGrafikStockOpname&id=1');
        Yii::app()->clientScript->registerScript('search', "

        $('#searchLaporan').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $.fn.yiiGridView.update('tableLaporan', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial('stockOpname/_search',array(
            'model'=>$model,
        )); ?>
    </fieldset><!-- search-form -->
    <div class="block-tabel">
        <h6>Tabel <b>Stock Opname</b></h6>
        <?php $this->renderPartial('stockOpname/_tableStockOpname', array('model'=>$model)); ?>
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