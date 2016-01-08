<div class="white-container">
    <legend class="rim2">Laporan <b>Rekap Piutang</b></legend>
    <?php
        $url = Yii::app()->createUrl(Yii::app()->controller->module->id.'/laporan/frameGrafikLaporanRekapPiutang&id=1');
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('#searchLaporan').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $('#laporanrekapiutangpenjamin-grid').addClass('animation-loading');
            $('#laporanrekapiutangumum-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('laporanrekapiutangpenjamin-grid', {
                    data: $(this).serialize()
            });
            $.fn.yiiGridView.update('laporanrekapiutangumum-grid', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <fieldset class="box search-form">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian </legend>
        <?php 
            $this->renderPartial('piutangPenjamin/_search',array(
                'model'=>$model,
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
                    array('label'=>'P3 / Penjamin','url'=>'javascript:tab(0);','active'=>true),
                    array('label'=>'Umum','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
                ),
            ))
        ?>
    </div>
    <fieldset> 
        <?php $this->renderPartial('piutangPenjamin/_table', array('model'=>$model)); ?>
        <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </fieldset>
    <?php   $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanRekapPiutang');
            $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));  ?>
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
        
        $("#div_penjamin").show();
        $("#div_umum").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('penjamin');
            $("#div_penjamin").show();
            $("#div_umum").hide();       
        } else if (index==1){
            $("#filter_tab").val('umum');
            $("#div_penjamin").hide();
            $("#div_umum").show();
        } 
   }
function onReset()
{
    setTimeout(
        function(){
            $.fn.yiiGridView.update('laporanrekapiutangpenjamin-grid', {
                data: $("#searchLaporan").serialize()
            });
            $.fn.yiiGridView.update('laporanrekapiutangumum-grid', {
                data: $("#searchLaporan").serialize()
            });      
        }, 2000
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat',$js,CClientScript::POS_HEAD);
?>