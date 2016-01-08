<div class="white-container">
    <legend class="rim2">Laporan Pasien <b>Masuk Penunjang</b></legend>
    <?php
    $url = Yii::app()->createUrl('rawatJalan/laporan/frameGrafikLaporanKepenunjang&id=1');
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
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <fieldset class="search-form box">
        <?php $this->renderPartial($this->path_view.'kepenunjang/_searchKepenunjang',array(
            'model'=>$model,
        )); ?>
    </fieldset><!-- search-form --> 
    <div class="row-fluid block-tabel">
        <h6>Tabel <b>Kepenunjangan</b></h6>
        <?php $this->renderPartial($this->path_view.'kepenunjang/_tableKepenunjang', array('model'=>$model)); ?>
    </div>
    <div class="row-fluid block-tabel">
        <h6><b>Grafik</b></h6>
        <?php $this->renderPartial($this->path_view.'_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>     
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKepenunjang');
    $this->renderPartial($this->path_view.'_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>