<div class="white-container">
    <legend class="rim2">Laporan Total <b>Pendapatan Farmasi</b></legend>
    <?php

    $url = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/frameGrafikLaporanJasaServices&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $('#tableLaporan').addClass('animation-loading');
        $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <fieldset class="box search-form">
        <?php 
            $this->renderPartial('totalPendapatanFarmasi/_search',array(
                'model'=>$model,
            )); 
        ?>
    </fieldset><!-- search-form --> 
    <div class="block-tabel"> 
        <h6>Tabel Total <b>Pendapatan Farmasi</b></h6>
        <?php $this->renderPartial('totalPendapatanFarmasi/_table', array('model'=>$model)); ?>
        <?php //$this->renderPartial('_tab'); ?>        
    </div>
    <div class="block-tabel">
        <h6><b>Grafik</b></h6>
        <?php $this->renderPartial('rawatJalan.views.laporan._tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>
<!--            <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>-->
    </div>
    <?php 

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/PrintLaporanPendapatanTotalFarmasi');
    $this->renderPartial('totalPendapatanFarmasi/_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
</div>