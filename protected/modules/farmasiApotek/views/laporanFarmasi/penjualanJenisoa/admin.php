<div class="white-container">
    <legend class="rim2">Laporan Penjualan <b>Jenis Obat dan Alkes</b></legend>
    <?php
    $url = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/frameGrafikLaporanPenjualanJenisoa&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="box search-form">
        <?php $this->renderPartial('penjualanJenisoa/_search',array(
            'model'=>$model,
        )); ?>
    </div><!-- search-form --> 
    <div class="block-tabel"> 
        <h6>Tabel Penjualan <b>Jenis Obat dan Alkes</b></h6>
        <?php $this->renderPartial('penjualanJenisoa/_table', array('model'=>$model)); ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printLaporanPenjualanJenisoa');
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'))."&nbsp&nbsp";
    //$this->renderPartial('penjualanJenisoa/_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
    <?php
        $content = $this->renderPartial('../tips/tipsLaporan',array(),true); 
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
    $("#Grafik").attr("src","'.$url.'"+$("#search-laporan").serialize()+"&type="+index);
    return false;
}
', CClientScript::POS_HEAD);

?>
