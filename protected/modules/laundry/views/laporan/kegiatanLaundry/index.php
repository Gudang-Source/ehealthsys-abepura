<div class="white-container">
    <legend class="rim2">Laporan <b>Kegiatan Laundry</b></legend>
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
        <?php $this->renderPartial($this->path_view.'kegiatanLaundry/_searchKegiatanLaundry',array(
            'model'=>$model,'format'=>$format
        )); ?>
    </div><!-- search-form --> 
    <div class="block-tabel">
        <h6>Tabel <b>Laporan Kegiatan Laundry</b></h6>
        <?php $this->renderPartial($this->path_view.'kegiatanLaundry/_tableKegiatanLaundry', array('model'=>$model)); ?>
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKegiatanLaundry');
    $this->renderPartial($this->path_view.'kegiatanLaundry/_footer', array('urlPrint'=>$urlPrint)); ?>
    <?php $this->renderPartial($this->path_view.'kegiatanLaundry/_jsFunctions', array('model'=>$model));?>
</div>