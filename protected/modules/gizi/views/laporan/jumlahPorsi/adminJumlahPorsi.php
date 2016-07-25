<div class="white-container">
    <legend class="rim2">Laporan <b>Jumlah Porsi</b></legend>
    <?php
        $url = Yii::app()->createUrl('rawatJalan/laporan/frameGrafikLaporanJasaInstalasi&id=1');
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
    <fieldset class="box search-form">
        <?php
         $this->renderPartial('jumlahPorsi/_searchJumlahPorsi',array(
            'model'=>$model,
        )); ?>
    </fieldset><!-- search-form -->
    <div class="block-tabel">
        <h6>Tabel Jumlah Porsi Berdasarkan <b><span id = "ruangan"></span></b></h6> 
        <?php $this->renderPartial('jumlahPorsi/_tableJumlahPorsi', array('model'=>$model)); ?>
        <?php //$this->renderPartial('_tab'); ?>
        <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan Grafik',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'$("#Grafik")[0].contentWindow.test();
    //'))."&nbsp&nbsp"; 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanJumlahPorsiGizi');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url, 'grafik'=>'none'));?>
        <?php $this->renderPartial('gizi.views.laporan/_jsFunctions', array('model'=>$model));?>
</div>
<script>
function changeRuangan(){
        	
        var ru = "Ruangan "+$("#GZLaporanJumlahPorsiV_ruangan_id option:selected").html();
       
	setTimeout(function(){
            if (ru == "Ruangan -- Pilih --"){
                ru = "Semua Ruangan";
            }
                $("#ruangan").html(ru);		
	},500);
}
</script>