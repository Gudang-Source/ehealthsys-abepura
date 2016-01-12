<div class="white-container">
    <legend class="rim2">Laporan <b>Farmasi</b></legend>

<?php
Yii::app()->clientScript->registerScript('search', "
$('#searchLaporan').submit(function(){
    $.fn.yiiGridView.update('tableLaporanTrans', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableLaporanReg', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableLaporanKelompok', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
	<fieldset class="box search-form">
		<legend class="rim"><i class="icon-white icon-search"></i> Pencarian Berdasarkan : </legend>
		<div class="search-form">
			<?php
				$this->renderPartial('billingKasir.views.laporan.farmasi/_search',
					array(
						'model'=>$model,'format'=>$format
					)
				); 
			?>
		</div>
	</fieldset>

<div class="tab">
    <?php
        $this->widget('bootstrap.widgets.BootMenu',array(
            'type'=>'tabs',
            'stacked'=>false,
            'htmlOptions'=>array('id'=>'tabmenu'),
            'items'=>array(
                array('label'=>'Transaksi Farmasi','url'=>'javascript:tab(0);', 'itemOptions'=>array("index"=>0),'active'=>true),
                array('label'=>'Rekap / Kelompok','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
                array('label'=>'Farmasi Per-Registrasi','url'=>'javascript:tab(2);', 'itemOptions'=>array("index"=>2)),
            ),
        ))
    ?>
	<div class="block-tabel">
		<div id="div_reportTranasksi">
			<fieldset>
				<h6>Tabel <b>Laporan Farmasi</b></h6>
				<?php
					$this->renderPartial('billingKasir.views.laporan.farmasi/_tableTransaksi',
						array(
							'model'=>$model,'format'=>$format,
						)
					);
				?>
			</fieldset>
		</div>
		<div id="div_rekap">
			<fieldset>
				<h6>Tabel <b>Laporan Rekap / Kelompok</b></h6>
				<?php
					$this->renderPartial('billingKasir.views.laporan.farmasi/_tableKelompok',
						array(
							'model'=>$model,'format'=>$format,
						)
					);
				?>
			</fieldset>
		</div>
		<div id="div_per_registrasi">
			<fieldset>
				<h6>Tabel <b>Farmasi Per-Registrasi</b></h6>
				<?php
					$this->renderPartial('billingKasir.views.laporan.farmasi/_tablePerRegistrasi',
						array(
							'model'=>$model,'format'=>$format,
						)
					);
				?>
			</fieldset>
		</div>
	</div>
    
</div>
<?php

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/LaporanFarmasi');
$urlPrintLap =  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKeseluruhan');

$js = <<< JSCRIPT
$(document).ready(function() {
    $("#tabmenu").children("li").children("a").click(function() {
        $("#tabmenu").children("li").attr('class','');
        $(this).parents("li").attr('class','active');
        $(".icon-pencil").remove();
        $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
    });
    $("#BKObatalkesPasienT_nama_pasien").attr("disabled",true);
    $("#BKObatalkesPasienT_carabayar_id").attr("disabled",true);
    $("#div_reportTranasksi").show();
    $("#div_rekap").hide();
    $("#div_per_registrasi").hide();
    $("#BKObatalkesPasienT_filter_tab").val("trans");
});

function tab(index){
    $(this).hide();
    $(".btn-group").hide();

    if (index==0){
        $(".btn-group").show();
        $("#BKObatalkesPasienT_filter_tab").val("trans");
        $("#BKObatalkesPasienT_nama_pasien").attr("disabled",true);
        $("#BKObatalkesPasienT_carabayar_id").attr("disabled",true);
        $("#div_reportTranasksi").show();
        $("#div_rekap").hide();
        $("#div_per_registrasi").hide();
    }else if(index==1){
        $(".btn-group").show();
        $("#BKObatalkesPasienT_filter_tab").val("rekap");
        $("#BKObatalkesPasienT_nama_pasien").attr("disabled",false);
        $("#BKObatalkesPasienT_carabayar_id").attr("disabled",false);
        $("#div_reportTranasksi").hide();
        $("#div_rekap").show();
        $("#div_per_registrasi").hide();
    }else if(index==2){
        $(".btn-group").hide();
        $("#BKObatalkesPasienT_filter_tab").val("per_reg");
        $("#BKObatalkesPasienT_nama_pasien").attr("disabled",false);
        $("#BKObatalkesPasienT_carabayar_id").attr("disabled",false);
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
            $.fn.yiiGridView.update('tableLaporanTrans', {
                data: $("#searchLaporan").serialize()
            });
            $.fn.yiiGridView.update('tableLaporanReg', {
                data: $("#searchLaporan").serialize()
            });
            $.fn.yiiGridView.update('tableLaporanKelompok', {
                data: $("#searchLaporan").serialize()
            });        
        }, 1000
    );
}
    
function printLap(caraPrint)
{
    window.open("${urlPrintLap}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
    
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>
<div class="form-actions">
<?php
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','url'=>$urlPrint,'onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','url'=>$urlPrint,'onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','url'=>$urlPrint,'onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	$content = $this->renderPartial('../tips/tips_laporan',array(),true); 
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
</div>
	
</div>