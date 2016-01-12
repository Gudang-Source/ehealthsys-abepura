<div class="white-container">
    <legend class="rim2">Laporan <b>Laboratorium</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('tableTrans', {
            data: $(this).serialize()
        });
        $.fn.yiiGridView.update('tableRekap', {
            data: $(this).serialize()
        });
        $.fn.yiiGridView.update('tableDetail', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <fieldset class="box search-form">
        <?php
            $this->renderPartial('billingKasir.views.laporan.laboratoirum/_search',
                array(
                    'model'=>$model,'format'=>$format
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
                    array('label'=>'Transaksi Laboratorium','url'=>'javascript:tab(0);', 'itemOptions'=>array("index"=>0),'active'=>true,),
                    array('label'=>'Rekap / Pasien','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
                    array('label'=>'Laboratorium Per-Registrasi','url'=>'javascript:tab(2);', 'itemOptions'=>array("index"=>2)),
                ),
            ))
        ?>
        <div class="biru" id="div_reportTranasksi">
            <!--<legend class="rim">Tabel Laporan Laboratorium</legend>-->
            <div class="white">
                <?php
                    $this->renderPartial('billingKasir.views.laporan.laboratoirum/_tableTransaksi',
                        array(
                            'model'=>$model
                        )
                    );
                ?>
            </div>
        </div>
        <div class="biru" id="div_rekap">
            <!--<legend class="rim">Rekap / Pasien</legend>-->
            <div class="white">
                <?php
                    $this->renderPartial('billingKasir.views.laporan.laboratoirum/_tableRekap',
                        array(
                            'model'=>$model
                        )
                    );
                ?>
            </div>
        </div>
        <div class="biru" id="div_per_registrasi">
            <!--<legend class="rim">Laboratoium Per-Registrasi</legend>-->
            <div class="white">
                <?php
                    $this->renderPartial('billingKasir.views.laporan.laboratoirum/_tablePerRegistrasi',
                        array(
                            'model'=>$model
                        )
                    );
                ?>
            </div>
        </div>
    </div>
<?php

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanLab');

$js = <<< JSCRIPT
$(document).ready(function() {
    $("#tabmenu").children("li").children("a").click(function() {
        $("#tabmenu").children("li").attr('class','');
        $(this).parents("li").attr('class','active');
        $(".icon-pencil").remove();
        $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
    });
    $("#div_reportTranasksi").show();
    $("#div_rekap").hide();
    $("#div_per_registrasi").hide();
    $("#BKLaporanpendapatanpenunjangV_filter_tab").val("trans");
});

function tab(index){
    $(this).hide();
    $(".btn-group").show();
    if (index==0){
        $("#BKLaporanpendapatanpenunjangV_filter_tab").val("trans");
        $("#div_reportTranasksi").show();
        $("#div_rekap").hide();
        $("#div_per_registrasi").hide();
    }else if(index==1){
        $("#BKLaporanpendapatanpenunjangV_filter_tab").val("rekap");
        $("#div_reportTranasksi").hide();
        $("#div_rekap").show();
        $("#div_per_registrasi").hide();
    }else if(index==2){
        $(".btn-group").hide();
        $("#BKLaporanpendapatanpenunjangV_filter_tab").val("per_reg");
        $("#div_reportTranasksi").hide();
        $("#div_rekap").hide();
        $("#div_per_registrasi").show();
    }
}

function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

function onReset(){
    setTimeout(
        function(){
            $.fn.yiiGridView.update('tableTrans', {
                data: $("#searchLaporan").serialize()
            });
            $.fn.yiiGridView.update('tableRekap', {
                data: $("#searchLaporan").serialize()
            });
            $.fn.yiiGridView.update('tableDetail', {
                data: $("#searchLaporan").serialize()
            });
        }, 1000
    );
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>
<?php
echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','url'=>$urlPrint,'onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','url'=>$urlPrint,'onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','url'=>$urlPrint,'onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
//            $this->widget('bootstrap.widgets.BootButtonGroup', array(
//                'type'=>'primary',
//                'buttons'=>array(
//                    array(
//                        'label'=>'Print',
//                        'icon'=>'icon-print icon-white',
//                        'url'=>$urlPrint,
//                        'htmlOptions'=>
//                            array(
//                                'onclick'=>'print(\'PRINT\');return false;'
//                            )
//                   ),
//                    array(
//                        'label'=>'',
//                        'items'=>array(
//                            array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'PDF\');return false;')),
//                            array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'EXCEL\');return false;')),
//                        )
//                    ),
//                ),
//            )); 
?>
<?php
    $content = $this->renderPartial('../tips/tips_laporan',array(),true); 
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
</div>