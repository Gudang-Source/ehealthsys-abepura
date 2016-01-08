<div class="white-container">
    <legend class="rim2">Laporan <b>Jasa Services</b></legend>
    <?php
    $url = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/frameGrafikLaporanJasaServices&id=1');
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
            $this->renderPartial('jasaServices/_search',array(
                'model'=>$model,
            )); 
        ?>
    </fieldset><!-- search-form --> 
    <div class="block-tabel"> 
        <h6>Tabel <b>Jasa Services</b></h6>
        <?php $this->renderPartial('jasaServices/_table', array('model'=>$model)); ?>
        <?php // $this->renderPartial('_tab'); ?>
        <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printLaporanJasaServices');
    $this->renderPartial('_footer2', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
</div>