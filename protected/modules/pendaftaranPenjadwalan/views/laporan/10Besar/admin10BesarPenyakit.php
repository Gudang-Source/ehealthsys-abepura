<div class='white-container'>
    <legend class="rim2">Laporan 10 <b>Besar Penyakit</b></legend>
    <?php
    $this->breadcrumbs=array(
        'Ppinfo Kunjungan Rjvs'=>array('index'),
        'Manage',
    );
    
    $url = Yii::app()->createUrl('pendaftaranPenjadwalan/laporan/frameGrafik10BesarPenyakit&id=1');
    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_REKAM_MEDIS){
        $url = Yii::app()->createUrl('rekamMedis/laporan/frameGrafik10BesarPenyakit&id=1');
    }
    
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="search-form">
    <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.10Besar/_search10Besar',array(
        'modPPInfoKunjunganV'=>$model,'format'=>$format
    )); ?>
    </div><!-- search-form --> 
    <div class='block-tabel'> 
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.10Besar/_table10Besar', array('model'=>$model)); ?>
    </div>
    <div class='block-tabel'>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._tab'); ?>
        <iframe class='biru' src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
        </iframe>  

    </div>
    <?php 

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print10BesarPenyakit');
    $this->renderPartial('pendaftaranPenjadwalan.views.laporan._footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
</div>