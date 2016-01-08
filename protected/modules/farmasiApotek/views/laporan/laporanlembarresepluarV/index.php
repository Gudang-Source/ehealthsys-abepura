<style>
    table{
        margin-bottom: 0px;
    }
    .form-actions{
        padding:4px;
        margin-top:5px;
    }
    .nav-tabs>li>a{display:block; cursor:pointer;}
    .nav-tabs > .active a:hover{cursor:pointer;}
</style>
<div class="white-container">
    <legend class="rim2">Laporan Lembar <b>Resep Luar</b></legend>
    <?php
    $url = Yii::app()->createUrl('farmasiApotek/laporan/frameGrafikLaporanLembarResepLuar&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('#laporan-search').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $.fn.yiiGridView.update('laporan-grid', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <fieldset class="box search-form">
        <?php // $this->renderPartial('_search',array('model'=>$model)); ?>
        <?php $this->renderPartial('laporanlembarresepluarV/_search',array('model'=>$model)); ?>
    </fieldset><!-- search-form -->
    <div class="block-tabel">
        <?php $this->renderPartial('laporanlembarresepluarV/_table',array('model'=>$model)); ?>       
    </div>
    <div class="block-tabel">
        <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintLaporanLembarResepLuar');
        $this->renderPartial('_tab');
        ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>  
        <?php
        $this->renderPartial('_footerLaporanlembar', array('urlPrint'=>$urlPrint, 'url'=>$url));
        ?>
    </div>
</div>