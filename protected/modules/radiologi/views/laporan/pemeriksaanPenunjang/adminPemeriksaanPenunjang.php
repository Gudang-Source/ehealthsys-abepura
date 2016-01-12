<div class="white-container">
    <legend class="rim2"><?php echo $judulLaporan?></legend>
    <?php
    $url = Yii::app()->createUrl('radiologi/laporan/frameGrafikPemeriksaanPenunjang&id=1');
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
        <?php $this->renderPartial('radiologi.views.laporan.pemeriksaanPenunjang/_searchPemeriksaanPenunjang',
                array('model'=>$model)); ?>
    </div>
    <div class="block-tabel"> 
        <h6>Tabel <b>Jenis Pemeriksaan</b></h6>
        <?php $this->renderPartial('radiologi.views.laporan.pemeriksaanPenunjang/_tablePemeriksaanPenunjang', array('model'=>$model)); ?>
    </div>
	<div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php   
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPemeriksaanPenunjang');
        $this->renderPartial('_footer_pisah', array('urlPrint'=>$urlPrint, 'url'=>$url));
//        $this->renderPartial('_jsFunctions', array('model'=>$model));
    ?>
</div>
<script type="text/javascript">
    function refreshForm(){
        window.location.href = "<?php echo $url;?>";
    }
    function konfirmasiBatal(){
        myConfirm("Apakah anda akan membatalkan ini?","Perhatian!",function(r) {
            if(r){
                window.location.href = "<?php echo $module;?>&modul_id=39";
            }
        });
    }
    function ubahJnsPeriode(){
        var obj = $("#<?php echo CHtml::activeId($model, 'jns_periode')?>");
        if(obj.val() == 'hari'){
            $('.hari').show();
            $('.bulan').hide();
            $('.tahun').hide();
        }else if(obj.val() == 'bulan'){
            $('.hari').hide();
            $('.bulan').show();
            $('.tahun').hide();
        }else if(obj.val() == 'tahun'){
            $('.hari').hide();
            $('.bulan').hide();
            $('.tahun').show();
        }
    }
ubahJnsPeriode();
</script>