<div class="form-actions">
          <?php
            echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')')).""; 
            echo "&nbsp;";
            echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')')).""; 
            echo "&nbsp;";
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')')).""; 
            echo "&nbsp;";
            echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'))."&nbsp&nbsp";
          ?>
        <?php
             if (isset($tips)):
                if ($tips  == 'Pembebasan'):
                    $content = $this->renderPartial('rawatJalan.views.laporan.tips/PembebasanTarif',array(),true);
                elseif ($tips == '10besarpenyakit'):
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporan10BesarPenyakit',array(),true);    
                else:
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporanBukuRegister',array(),true);
                endif;
            else:
                $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporanBukuRegister',array(),true);
            endif;
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
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
function setType(obj, index){
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    $.fn.yiiGridView.update("laporan-grid", {
            data: $(this).serialize()
    });
    if (index==1) {
        index="batang";
    } else if (index==2) {
        index="pie";
    } else if (index==3) {
        index="garis";
    }
    $("#Grafik").attr("src","'.$url.'"+$("#searchLaporan").serialize());
    return false;
}
', CClientScript::POS_HEAD);

?>

