<!--echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; -->
<div class="form-actions">
<table border="0" >
  <tr>
   <!-- <td width="90"> --> <?php // $this->widget('bootstrap.widgets.BootButtonGroup', array(
//        'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
//        'buttons'=>array(
//            array('label'=>'Print', 'icon'=>'icon-print icon-white', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
//            array('label'=>'', 'items'=>array(
//                array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
//                array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
//                array('label'=>'Grafik','icon'=>'icon-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'GRAFIK\')')),
//            )),       
//        ),
//        'htmlOptions'=>array('class'=>'btn')
//    )); ?>	<!-- </td > -->
    <td style="padding-top:10px;">
        <?php
        
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        
        if (isset($grafik)){
            if ($grafik!='none'){            
                echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'))."&nbsp&nbsp";
                $grafik = '';
            }
        }else{
            echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'))."&nbsp&nbsp";
            $grafik='';
        }
        
        if (isset($tips)):
                if ($tips  == 'Pembebasan'):
                    $content = $this->renderPartial('rawatJalan.views.laporan.tips/PembebasanTarif',array(),true);
                elseif ($tips == '10besarpenyakit'):
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporan10BesarPenyakit',array('grafik'=>$grafik),true);    
                else:
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporanBukuRegister',array(),true);
                endif;
            else:
                $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporanBukuRegister',array('grafik'=>$grafik),true);
            endif;
		
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </td>

</tr>
</table>
</div>
<?php 

$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsx,CClientScript::POS_HEAD);                        
?> 
<?php 
Yii::app()->clientScript->registerScript('test','
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj){
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    $.fn.yiiGridView.update("tableLaporan", {
            data: $(this).serialize()
    });
    $("#Grafik").attr("src","'.$url.'"+$(".search-form form").serialize());
    return false;
}
', CClientScript::POS_HEAD);

?>

