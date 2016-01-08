<div class="white-container">
    <legend class="rim2">Laporan <b>Extra Fooding</b></legend>
    <?php
        $url = Yii::app()->createUrl('rawatJalan/laporan/frameGrafikLaporanExtraFooding&id=1');
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
    <fieldset class="box search-form">
        <?php $this->renderPartial('extraFooding/_search',array(
            'model'=>$model, 'format'=>$format
        )); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Extra Fooding</b></h6>
        <?php $this->renderPartial('extraFooding/_table', array('model'=>$model, 'format'=>$format)); ?>
        <?php //$this->renderPartial('_tab'); ?>
        <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanExtraFooding');
        $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
    <?php $this->renderPartial('gizi.views.laporan/_jsFunctions', array('model'=>$model));?>
</div>