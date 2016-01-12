<?php
//Yii::app()->clientScript->registerScript('search', "
//$('.search-form form').submit(function(){
//    $.fn.yiiGridView.update('tableLaporanJmlPasienHarian', {
//        data: $(this).serialize()
//    });
//    $.fn.yiiGridView.update('tableRekapJmlPasienHarian', {
//        data: $(this).serialize()
//    });
//    return false;
//});
//");
?>
<div class="white-container">
    <legend class="rim2">Laporan Jumlah <b>Pasien Harian</b></legend>
    <fieldset class="box search-form">
        <?php
            $this->renderPartial('gizi.views.laporan.jumlahPasienHarian/_searchJmlPasienHarian',
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
                    array('label'=>'Laporan Jumlah Harian','url'=>'javascript:tab(0);', 'itemOptions'=>array("index"=>1),'active'=>true),
                    array('label'=>'Rekap Jumlah','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
                ),
            ))
        ?>
        <div class="biru" id="tables">
            <div class="white">
                <?php
                    $this->renderPartial('gizi.views.laporan.jumlahPasienHarian/_tables',
                        array(
                            'model'=>$model,
                            'models'=>$models,
                            'modRekaps'=>$modRekaps,
                        )
                    );
                ?>
            </div>
        </div>
    </div>

    <div class="form-actions" style="margin-top:10px;">
		<?php
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";     
			echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
			echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp";   
			
			$content = $this->renderPartial('tips/tips',array(),true); 
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
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintLaporanJumlahPasienHarian');

$js = <<< JSCRIPT
$(document).ready(function() {
    $("#tabmenu").children("li").children("a").click(function() {
        $("#tabmenu").children("li").attr('class','');
        $(this).parents("li").attr('class','active');
        $(".icon-pencil").remove();
        $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
    });

    $("#div_reportJmlPasienHarian").show();
    $("#div_rekapJmlPasienHarian").hide();
});

function tab(index){
    $(this).hide();
    if (index==0){
        $("#GZLaporanjmlpasienhariangiziV_pilihan_tab").val("report");
        $("#div_reportJmlPasienHarian").show();
        $("#div_rekapJmlPasienHarian").hide();
    }else if(index==1){
        $("#GZLaporanjmlpasienhariangiziV_pilihan_tab").val("rekap");
        $("#div_reportJmlPasienHarian").hide();
        $("#div_rekapJmlPasienHarian").show();
    }
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>