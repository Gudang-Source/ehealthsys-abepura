<div class="white-container">
    <legend class="rim2">Laporan <b>Pemakaian Ambulans</b></legend>
    <?php
        $url = Yii::app()->createUrl('ambulans/laporanAmbulans/frameGrafikPemakaianAmbulans&id=1');
        Yii::app()->clientScript->registerScript('search', "
        $('#laporan-search').submit(function(){
            $.fn.yiiGridView.update('laporan-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        "); 
    ?>
    <?php $this->renderPartial('pemakaianAmbulansT/_search',array('model'=>$model,'format'=>$format)); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pemakaian Ambulans</b></h6>
        <?php $this->renderPartial('pemakaianAmbulansT/_table',array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload='javascript:resizeIframe(this);'>
        </iframe>
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printPemakaianAmbulans');
        $this->renderPartial('_footer_pisah', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>
<script type="text/javascript">
function batalPakai(idPemakaian,idPemesanan)
{
    myConfirm("Anda yakin akan membatalkan pemakaian ambulans?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('batalPakai'); ?>', {idPemakaian:idPemakaian,idPemesanan:idPemesanan}, function(data){
                if(data.status == 'berhasil'){
                    $.fn.yiiGridView.update('pemakaianambulans-t-grid', {
                        data: $(this).serialize()
                    });
                    return false;
                }
            }, 'json');
        }
    });
}
</script>