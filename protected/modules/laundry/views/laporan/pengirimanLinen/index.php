<div class="white-container">
    <legend class="rim2">Laporan <b>Pengiriman Linen</b></legend>
    <?php
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
    <div class="search-form">
        <?php $this->renderPartial($this->path_view.'pengirimanLinen/_searchPengirimanLinen',array(
            'model'=>$model,'format'=>$format
        )); ?>
    </div><!-- search-form --> 
    <div class="block-tabel">
        <h6>Tabel <b>Laporan Pengiriman Linen</b></h6>
        <?php $this->renderPartial($this->path_view.'pengirimanLinen/_tablePengirimanLinen', array('model'=>$model)); ?>
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPengirimanLinen');
    $this->renderPartial($this->path_view.'pengirimanLinen/_footer', array('urlPrint'=>$urlPrint)); ?>
    <?php $this->renderPartial($this->path_view.'pengirimanLinen/_jsFunctions', array('model'=>$model));?>
</div>