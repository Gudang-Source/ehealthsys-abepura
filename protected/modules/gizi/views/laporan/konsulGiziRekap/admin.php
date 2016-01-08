<div class="white-container">
    <legend class="rim2">Laporan Konsultasi <b>Gizi Berdasarkan Ruangan</b></legend> 
    <?php
        $url = Yii::app()->createUrl('gizi/laporan/frameGrafikLaporanKonsulGiziRekap&id=1');
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
        <?php 
            $this->renderPartial('konsulGiziRekap/_search',array(
                'model'=>$model, 'format'=>$format
        )); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel Konsultasi <b>Gizi Berdasarkan Ruangan</b></h6>
        <div id='rekap'> 
            <?php $this->renderPartial('konsulGiziRekap/_table', array('model'=>$model, 'models'=>$models)); ?>
        </div>    
        <?php //$this->renderPartial('_tab'); ?>
        <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintLaporanKonsulGiziRekap');
        $this->renderPartial('konsulGiziRekap/_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
    <?php $this->renderPartial('gizi.views.laporan/_jsFunctions', array('model'=>$model));?>
</div>