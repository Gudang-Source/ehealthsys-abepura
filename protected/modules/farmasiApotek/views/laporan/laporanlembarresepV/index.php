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
    <legend class="rim2">Laporan <b>Lembar Resep</b></legend>
    <?php
    $url = Yii::app()->createUrl('farmasiApotek/laporan/frameGrafikLaporanLembarResep&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
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
        <?php $this->renderPartial('laporanlembarresepV/_search',array('model'=>$model)); ?>
    </fieldset><!-- search-form -->
    <div class="block-tabel">
        <h6>Tabel <b>Lembar Resep</b></h6>
        <?php $this->renderPartial('laporanlembarresepV/_table',array('tgl_awal'=>$tgl_awal,'tgl_akhir'=>$tgl_akhir)); ?>       
    </div>
    <div class="block-tabel">
        <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintLaporanLembarResep');
        $this->renderPartial('_tab');
        ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>
    </div>
    <?php 
    $this->renderPartial('_footerLaporanlembar', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
</div>