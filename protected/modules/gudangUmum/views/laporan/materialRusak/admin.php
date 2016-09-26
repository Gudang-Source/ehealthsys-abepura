<div class="white-container">
    <legend class="rim2">Laporan <b>Material Rusak</b></legend>
    <?php
        $url = Yii::app()->createUrl('gudangUmum/laporan/FrameMaterialRusak&id=1');
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
        <?php $this->renderPartial('materialRusak/_search',array(
            'model'=>$model, 'format'=>$format,'searchdata'=>$searchdata,
        )); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Material Rusak</b></h6>
        <?php $this->renderPartial('materialRusak/_table', array('model'=>$model,'searchdata'=>$searchdata,)); ?>
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>           
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintMaterialRusak');
        $this->renderPartial('_footer_pisah', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
    <?php $this->renderPartial('gizi.views.laporan/_jsFunctions', array('model'=>$model,'searchdata'=>$searchdata,));?>
</div>