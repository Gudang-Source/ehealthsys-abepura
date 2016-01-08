<div class="white-container">
    <legend class="rim2">Laporan <b>Batal Periksa</b></legend>
    <?php
    $this->breadcrumbs=array(
        'Ppinfo Kunjungan Rjvs'=>array('index'),
        'Manage',
    );

    $url = Yii::app()->createUrl('pendaftaranPenjadwalan/laporan/frameGrafikBatalPeriksa&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('#searchInfoKunjungan').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial('_search',array(
            'modPPInfoKunjunganV'=>$model,'format'=>$format
        )); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Batal Periksa</b></h6>
        <?php $this->renderPartial('batalPeriksa/_tableBatalPeriksa', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printBatalPeriksa');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));

    ?>
    <?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>
</div>