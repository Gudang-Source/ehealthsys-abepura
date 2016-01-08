<div class="white-container">
    <legend class="rim2">Laporan <b>Setoran Harian</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
     $('#searchLaporan').submit(function(){
    +         $('#tableLaporan').addClass('animation-loading');
            $.fn.yiiGridView.update('tableLaporan', {
                    data: $(this).serialize()
            });

    ");
    $url = Yii::app()->createUrl('billingKasir/laporan/FrameGrafikLaporanSetoranHarian&id=1');
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
        $.fn.yiiGridView.update('tableLaporanDP', {
                data: $(this).serialize()
        });
        $.fn.yiiGridView.update('tableLaporanJumlah', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <div class="box search-form">
            <?php 
                $this->renderPartial('setoranHarian/_search',array(
                    'model'=>$model,'format'=>$format,
                )); 
            ?>
    </div><!-- search-form --> 
    <?php $this->renderPartial('setoranHarian/_table', array('model'=>$model)); ?>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanSetoranHarian');
    $this->renderPartial('_footer2', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>