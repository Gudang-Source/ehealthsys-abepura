<div class="white-container">
    <legend class="rim2">Laporan <b>Tindak Lanjut</b></legend>
    <?php
    //$this->breadcrumbs=array(
    //    'Ppinfo Kunjungan Rjvs'=>array('index'),
    //    'Manage',
    //);

    $url = Yii::app()->createUrl('rawatJalan/laporan/frameGrafikLaporanTindakLanjut&id=1');
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
        <?php $this->renderPartial($this->path_view.'tindakLanjut/_searchTindakLanjut',array(
            'model'=>$model,
        )); ?>
    </fieldset><!-- search-form --> 
    <div class="row-fluid block-tabel">
        <h6>Tabel <b>Tindak Lanjut</b></h6>
        <?php $this->renderPartial($this->path_view.'tindakLanjut/_tableTindakLanjut', array('model'=>$model)); ?>
    </div>
    <div class="row-fluid block-tabel">
        <h6><b>Grafik</b></h6>
        <?php $this->renderPartial($this->path_view.'_tab'); ?>
        <iframe CLASS="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>
    </div>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanTindakLanjut');
    $this->renderPartial('rawatJalan.views.laporan._footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>