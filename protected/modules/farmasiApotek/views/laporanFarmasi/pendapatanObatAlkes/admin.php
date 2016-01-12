<div class="white-container">
    <legend class="rim2">Laporan Pendapatan <b>Obat Alkes</b></legend>
    <?php
    $url = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/FrameGrafikLaporanPendapatanObatAlkes&id=1');
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
    <div class="box search-form">
        <?php 
            $this->renderPartial('pendapatanObatAlkes/_search',array(
                'model'=>$model,
            )); 
        ?>
    </div><!-- search-form --> 
    <div class="block-tabel"> 
        <h6>Tabel Transaksi <b>Obat Alkes</b></h6>
        <?php $this->renderPartial('pendapatanObatAlkes/_table', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printLaporanPendapatanObatAlkes');
    $this->renderPartial('pendapatanObatAlkes/_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
</div>