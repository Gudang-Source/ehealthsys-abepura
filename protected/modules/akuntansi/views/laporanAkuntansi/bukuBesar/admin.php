<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
	$url = Yii::app()->createUrl('akuntansi/laporanAkuntansi/frameGrafikLaporanBukuBesar&id=1');
	Yii::app()->clientScript->registerScript('search', "
		$('#searchLaporan').submit(function(){
			$('#Grafik').attr('src','').css('height','0px');
			$.fn.yiiGridView.update('tableLaporan', {
					data: $(this).serialize()
			});
			return false;
		});
	");
?>
<div class='white-container'>
    <legend class="rim2">Laporan <b>Buku Besar</b></legend>
    <div class="search-form">
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.bukuBesar/_search',array('model'=>$model,'modelLaporan'=>$modelLaporan)); 
        ?>
    </div>
    <div class='block-tabel'> 
        <h6>Tabel <b>Buku Besar</b></h6>
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.bukuBesar/_table', array('model'=>$model, 'jmlrekening'=>$jmlrekening)); ?>
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanBukuBesar');
        //$this->renderPartial('akuntansi.views.laporanAkuntansi._footerNoGraph', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
    ?>
    <div class="form-actions">
	<?php 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 

	$content = $this->renderPartial('akuntansi.views.tips/tips',array(),true);
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
