<div class="white-container">
    <legend class="rim2">Laporan <b>Rekap Pendapatan</b></legend>
    <?php
    $url = Yii::app()->createUrl(Yii::app()->controller->module->id.'/laporan/frameGrafikLaporanRekapPendapatan&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $('#tableLaporan').addClass('animation-loading');
        $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial('rekapPendapatan/_search',array(
            'model'=>$model,'format'=>$format
        )); ?>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Rekap Pendapatan</b></h6>
        <?php $this->renderPartial('rekapPendapatan/_table', array('model'=>$model)); ?>
        
    </div>
    <div class="block-tabel">        
        <?php $this->renderPartial('_tab', array('model'=>$model)); ?>
        <iframe class = "biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanRekapPendapatan');
   // $this->renderPartial('_footer2', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
 
    <div class="form-actions">
	<?php 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'))."&nbsp&nbsp"; 

        $tips = array(
            '0' => 'tanggal', 
            '1' => 'bootaccordion',
            '2' => 'cari',
            '3' => 'ulang2',
            '4' => 'masterPDF',
            '5' => 'masterEXCEL',
            '6' => 'masterPRINT',
            '7' => 'grafik',
        );
	$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
	$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
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