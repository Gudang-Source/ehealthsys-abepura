<div class="white-container">
    <legend class="rim2">Laporan <b>Keseluruhan</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('tableLaporanKeseluruhan', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <fieldset class="box search-form">
        <?php
            $this->renderPartial('billingKasir.views.laporan.keseluruhan/_searchKeseluruhan',
                array(
                    'model'=>$model,
                )
            ); 
        ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Laporan Keseluruhan</b></h6>
        <?php
            $this->renderPartial('billingKasir.views.laporan.keseluruhan/_tableKeseluruhan',
                array(
                    'model'=>$model
                )
            );
        ?>
    </div>
    <div style="float:left;margin-right:6px;">
        <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKeseluruhan');

//                $this->widget('bootstrap.widgets.BootButtonGroup', array(
//                    'type'=>'primary',
//                    'buttons'=>array(
//                        array('label'=>'Print', 'icon'=>'icon-print icon-white', 'url'=>$urlPrint, 'htmlOptions'=>array('onclick'=>'print(\'PRINT\');return false;')),
//                        array('label'=>'',
//                            'items'=>array(
//                                array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'PDF\');return false;')),
//                                array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'EXCEL\');return false;')),
//                            )
//                        ),
//                    ),
//                ));
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
//                echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'))."&nbsp&nbsp";
         ?>
    </div>
    <div>
        <?php
//                $this->widget('bootstrap.widgets.BootButtonGroup', array(
//                    'type'=>'primary',
//                    'buttons'=>array(
//                        array('label'=>'Print Detail', 'icon'=>'icon-print icon-white', 'url'=>$urlPrint, 'htmlOptions'=>array('onclick'=>'printDetail(\'PRINT\');return false;')),
//                        array('label'=>'',
//                            'items'=>array(
////                                array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'printDetail(\'PDF\');return false;')),
//                                array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'printDetail(\'EXCEL\');return false;')),
//                            )
//                        ),
//                    ),
//                ));
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printDetail(\'PRINT\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} PDF Detail',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printDetail(\'PDF\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Excel Detail',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printDetail(\'EXCEL\')'))."&nbsp&nbsp"; 
//                echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik Detail',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printDetail(\'GRAFIK\')'))."&nbsp&nbsp";
         ?>
    </div>
    <div style="clear:both;">
        <?php 
            $content = $this->renderPartial('billingKasir.views.laporan.keseluruhan.tips/tipsLaporanKeseluruhan',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
        ?>
    </div>
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
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKeseluruhan');
$urlPrintDetail= Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printDetailLaporanKeseluruhan');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

function printDetail(caraPrint)
{
    window.open("${urlPrintDetail}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>