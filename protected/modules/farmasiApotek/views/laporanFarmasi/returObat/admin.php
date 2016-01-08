<div class="white-container">
    <legend class="rim2">Laporan <b>Retur Obat</b></legend>
    <?php
    //$this->breadcrumbs=array(
    //    'Ppinfo Kunjungan Rjvs'=>array('index'),
    //    'Manage',
    //);

    Yii::app()->clientScript->registerScript('searchTable', "
    $('#searchLaporan').submit(function(){
             $('#tableLaporan').addClass('animation-loading');
            $.fn.yiiGridView.update('tableLaporan', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");


    $url = Yii::app()->createUrl('farmasiApotek/laporanFarmasi/frameGrafikReturObat&id=1');
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
    <fieldset class="box search-form">
        <?php $this->renderPartial('returObat/_search',array(
            'model'=>$model,
        )); ?>
    </fieldset><!-- search-form -->
    <div class="block-tabel">
        <h6>Tabel <b>Retur</b></h6>
        <?php $this->renderPartial('returObat/_tableReturObat', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanReturObat');
    $this->renderPartial('_footer2', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
</div>