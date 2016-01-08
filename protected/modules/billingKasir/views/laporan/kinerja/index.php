<div class="white-container">
    <legend class="rim2">Laporan <b>Kinerja</b></legend>
    <?php
    $url = Yii::app()->createUrl(Yii::app()->controller->module->id.'/laporan/frameGrafikLaporanKinerja&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $('#tableKinerjaKelas').addClass('animation-loading');
        $('#tableKinerjaBangsal').addClass('animation-loading');
        $.fn.yiiGridView.update('tableKinerjaKelas', {
                data: $(this).serialize()
        });
        $.fn.yiiGridView.update('tableKinerjaBangsal', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <fieldset class="box search-form">
        <?php 
            $this->renderPartial('kinerja/_search',array(
                'model'=>$model, 'filter'=>$filter,'format'=>$format
            )); 
        ?>
    </fieldset>
    <div>
        <?php
            $this->widget('bootstrap.widgets.BootMenu',array(
                'type'=>'tabs',
                'stacked'=>false,
                'htmlOptions'=>array('id'=>'tabmenu'),
                'items'=>array(
                    array('label'=>'Kinerja Per Kelas','url'=>'javascript:tab(0);','active'=>true),
                    array('label'=>'Kinerja Per Bangsal','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
                ),
            ))
        ?>
    </div>

    <fieldset> 
        <?php $this->renderPartial('kinerja/_table', array('model'=>$model,'tgl_awal'=>$tgl_awal,'tgl_akhir'=>$tgl_akhir)); ?>
        <?php //$this->renderPartial('_tab'); ?>
        <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </fieldset>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKinerja');
        $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
</div>
<?php
$js= <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        
        $("#div_kelas").show();
        $("#search_kelas").show();
        $("#div_bangsal").hide();
        $("#search_bangsal").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('kelas');
            $("#div_kelas").show();
            $("#div_bangsal").hide();        
            $("#search_kelas").show();        
            $("#search_bangsal").hide();
            $("#BKLaporankinerjapenunjangV_ruanganpenunj_id").val('');
            $("#searchLaporan").submit();
        } else if (index==1){
           $("#filter_tab").val('bangsal');
            $("#div_kelas").hide();
            $("#div_bangsal").show();  
            $("#search_kelas").hide();         
            $("#search_bangsal").show();
            $("#BKLaporankinerjapenunjangV_kelaspelayanan_id").val('');
            $("#searchLaporan").submit();
        }
   }
function onReset()
{
    setTimeout(
        function(){
            $.fn.yiiGridView.update('tableKinerjaKelas-grid', {
                data: $("#searchLaporan").serialize()
            });
            $.fn.yiiGridView.update('tableKinerjaBangsal-grid', {
                data: $("#searchLaporan").serialize()
            });      
        }, 2000
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat',$js,CClientScript::POS_HEAD);
?>