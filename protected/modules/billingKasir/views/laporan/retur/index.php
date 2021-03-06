<div class="white-container">
    <legend class="rim2">Laporan <b>Retur</b></legend>
    <?php

    $url = Yii::app()->createUrl('billingKasir/laporan/FrameGrafikLaporanRetur&id=1');
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
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="box search-form">
        <?php $this->renderPartial('retur/_search',array(
            'model'=>$model,
        )); ?>
    </div><!-- search-form --> 
    <div class="block-tabel"> 
        <h6>Tabel <b>Retur</b></h6>
        <?php $this->renderPartial('retur/_table', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>    
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanRetur');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));?>
</div>