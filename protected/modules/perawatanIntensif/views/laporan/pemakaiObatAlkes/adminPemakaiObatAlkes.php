<div class="white-container">
    <legend class="rim2">Laporan Pemakai <b>Obat Alkes</b></legend>
    <?php
    $url = Yii::app()->createUrl('perawatanIntensif/laporan/FrameGrafikLaporanPemakaiObatAlkes&id=1');
    Yii::app()->clientScript->registerScript('search',"
    $('.search-button').click(
        function(){
            $('.search-form').toggle();
            return false;
        }
    );
    $('.search-form form').submit(
        function() {
            $('#Grafik').attr('src','').css('height','0px');
            $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
            }
     );
     return false;
     });
    ")

    ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial('pemakaiObatAlkes/_searchPemakaiObatAlkes',array('model'=>$model,'format'=>$format)); ?>
    </fieldset><!-- search-form -->
    <div class="block-tabel">
        <h6>Tabel Pemakai <b>Obat Alkes</b></h6>
        <?php $this->renderPartial('pemakaiObatAlkes/_tablePemakaiObatAlkes', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPemakaiObatAlkes');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
</div>