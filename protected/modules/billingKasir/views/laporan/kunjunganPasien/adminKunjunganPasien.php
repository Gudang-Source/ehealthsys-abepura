<div class="white-container">
    <legend class="rim2">Laporan <b>Kunjungan</b></legend>
    <?php
    $url = Yii::app()->createUrl('billingKasir/laporan/frameGrafikKunjunganPasien&id=1');
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
        <?php $this->renderPartial('billingKasir.views.laporan.kunjunganPasien/_searchKunjunganPasien',array(
            'model'=>$model,
        )); ?>
    </fieldset>
    <div class="block-tabel"> 
        <h6>Tabel <b>Laporan Kunjungan</b></h6>
        <?php $this->renderPartial('billingKasir.views.laporan.kunjunganPasien/_tableKunjunganPasien', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('billingKasir.views.laporan._tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKunjunganPasien');
    $this->renderPartial('billingKasir.views.laporan.kunjunganPasien.footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
</div>
<script type="text/javascript">
    function checkAll()
    {
        if($("#checkAllRuangan").is(':checked')){
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", false);
        }        
        
    }
</script>