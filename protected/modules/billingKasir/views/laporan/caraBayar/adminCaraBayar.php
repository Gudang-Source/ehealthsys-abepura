<div class="white-container">
    <legend class="rim2">Laporan <b>Cara Bayar</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('tableLaporanCaraBayar', {
            data: $(this).serialize()
        });
        $.fn.yiiGridView.update('tableRekapCaraBayar', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <fieldset class="box search-form">
        <?php
            $this->renderPartial('billingKasir.views.laporan.caraBayar/_searchCaraBayar',
                array(
                    'model'=>$model,
                )
            ); 
        ?>
    </fieldset>
    <div class="tab">
        <?php
            $this->widget('bootstrap.widgets.BootMenu',array(
                'type'=>'tabs',
                'stacked'=>false,
                'htmlOptions'=>array('id'=>'tabmenu'),
                'items'=>array(
                    array('label'=>'Data Pasien P3','url'=>'javascript:tab(0);', 'itemOptions'=>array("index"=>1),'active'=>true),
                    array('label'=>'Rekap P3','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
                ),
            ))
        ?>
        <div class="biru" id="div_reportCaraBayar">
            <!--<legend class="rim">Laporan Cara Bayar</legend>-->
            <div class="white"> 
                <?php
                    $this->renderPartial('billingKasir.views.laporan.caraBayar/_tableCaraBayar',
                        array(
                            'model'=>$model
                        )
                    );
                ?>
            </div>
        </div>
        <div class="biru" id="div_rekapCaraBayar">
            <!--<legend class="rim">Rekap Cara Bayar</legend>-->
            <div class="white"> 
                <?php
                    $this->renderPartial('billingKasir.views.laporan.caraBayar/_tableRekapCaraBayar',
                        array(
                            'model'=>$model
                        )
                    );
                ?>
            </div>
        </div>
    </div>

    <?php
     echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
     echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
     echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
     echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'))."&nbsp&nbsp";
    $content = $this->renderPartial('billingKasir.views.laporan.caraBayar.tips',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 

    ?>
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
<?php

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/laporanCaraBayar');

$js = <<< JSCRIPT
$(document).ready(function() {
    $("#tabmenu").children("li").children("a").click(function() {
        $("#tabmenu").children("li").attr('class','');
        $(this).parents("li").attr('class','active');
        $(".icon-pencil").remove();
        $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
    });

    $("#div_reportCaraBayar").show();
    $("#div_rekapCaraBayar").hide();
});

function tab(index){
    $(this).hide();
    if (index==0){
        $("#BKLaporanCaraBayar_pilihan_tab").val("report");
        $("#div_reportCaraBayar").show();
        $("#div_rekapCaraBayar").hide();
    }else if(index==1){
        $("#BKLaporanCaraBayar_pilihan_tab").val("rekap");
        $("#div_reportCaraBayar").hide();
        $("#div_rekapCaraBayar").show();
    }
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>