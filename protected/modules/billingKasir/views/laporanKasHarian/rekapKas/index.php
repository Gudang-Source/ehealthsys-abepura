<div class="white-container">
    <legend class="rim2">Laporan <b>Kas Harian</b></legend>
    <?php
        $url = Yii::app()->createUrl(Yii::app()->controller->module->id.'/laporan/frameGrafikKasHarian&id=1');
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('#searchLaporan').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $.fn.yiiGridView.update('laporankasharianlab-grid', {
                    data: $(this).serialize()
            });
            $.fn.yiiGridView.update('detaillaporankasharianlab-grid', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <fieldset class="box search-form">
        <?php 
            $this->renderPartial('rekapKas/_search',array(
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
                    array('label'=>'Rekap Kas Harian','url'=>'javascript:tab(0);','active'=>true),
                    array('label'=>'Detail Kas Harian','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
                ),
            ))
        ?>
    </div>

    <fieldset> 
        <?php $this->renderPartial('rekapKas/_table', array('model'=>$model)); ?>
        <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </fieldset>

    <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKasHarian');
        //$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
         echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
                        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
//                        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'))."&nbsp&nbsp"; 

        $content = $this->renderPartial('billingKasir.views.laporanKasHarian.tips.tips2',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
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
        
        $("#rekapKas").show();
        $("#detailKas").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('rekap');
            $("#rekapKas").show();
            $("#detailKas").hide();  
        } else if (index==1){
            $("#filter_tab").val('detail');
            $("#rekapKas").hide();
            $("#detailKas").show();
        } 
   }
   function onReset()
   {
        setTimeout(
            function(){
                $.fn.yiiGridView.update('laporankasharianlab-grid', {
                    data: $("#caripasien-form").serialize()
                });
                $.fn.yiiGridView.update('detaillaporankasharianlab-grid', {
                    data: $("#caripasien-form").serialize()
                });      
            }, 2000
        );
        return false;
   }   
JS;
Yii::app()->clientScript->registerScript('laporankasharian',$js,CClientScript::POS_HEAD);
?>