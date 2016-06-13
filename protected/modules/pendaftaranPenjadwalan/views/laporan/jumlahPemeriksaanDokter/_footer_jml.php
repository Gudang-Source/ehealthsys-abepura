<!--echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; -->

<style>
    #instruction_button{
        margin-left: 5px;
        margin-bottom: 10px;
        position: relative;
        margin-top:-11px;
        display:inline-block;
    }
</style>
<div class="form-actions">
  <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp";       
        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'))."&nbsp&nbsp"; 
   ?>
        <?php
            if (isset($tips)):
                if ($tips == 'rekapitulasi'):
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporanRekapitulasiPerUnitpelayanan',array(),true); 
                elseif ($tips == 'bukuregister'):
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporanBukuRegister',array(),true); 
                else:
                     $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporan10BesarPenyakit',array(),true);    
                endif;
            else:
                $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporan10BesarPenyakit',array(),true); 
            endif;		
            
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>


</div>
<?php 

$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchInfoKunjungan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
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
    $("#Grafik").attr("src","'.$url.'"+$("#searchInfoKunjungan").serialize());
    return false;
}
', CClientScript::POS_HEAD);

?>
