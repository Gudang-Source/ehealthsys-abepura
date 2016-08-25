<div class="white-container">
    <legend class="rim2">Laporan <b>Closing Kasir</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Laporan Closing Kasir',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $.fn.yiiGridView.update('laporanclosingkasir-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <fieldset class="box search-form">
    <?php $this->renderPartial('closingKasir/_search', array('model'=>$model)); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Closing Kasir</b></h6>
        <?php $this->renderPartial('closingKasir/_table', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('billingKasir.views.laporan._tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe> 
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanClosingKasir');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/frameGrafikLaporanClosingKasir&id=1');
    $this->renderPartial('billingKasir.views.laporan._footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
    ?>
</div>