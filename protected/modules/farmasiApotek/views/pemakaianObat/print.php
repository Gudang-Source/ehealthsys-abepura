<style>
    .table {
        box-shadow: none;
        border: 1px solid black;
    }
    .table th, .table td {
        border: 1px solid black;
    }
</style>

<?php if (isset($judulLaporan)){
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      
}
?>

<table class='table'>
    <tr>
        <td>
             <b><?php echo CHtml::encode($model->getAttributeLabel('nopemakaian_obat')); ?>:</b>
            <?php echo CHtml::encode($model->nopemakaian_obat); ?>
            <br />
             <b><?php echo CHtml::encode($model->getAttributeLabel('tglpemakaianobat')); ?>:</b>
            <?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($model->tglpemakaianobat)); ?>
             <br/>
             
        </td>
    </tr>   
</table>

<table id="tableObatAlkes" class="table">
    <thead>
        <tr>
			<th>Kode / Nama Obat</th>
			<th hidden>Satuan Kecil</th>
			<th>Jumlah</th>
			<th hidden>Stok</th>
			<th>Harga Satuan</th>
			<th>Sub Total</th>
		</tr>
    </thead>
    <tbody>
		<?php
		if(count($modDetails) > 0){
			foreach($modDetails AS $i=> $modDetail){
				$modDetail->jmlstok = StokobatalkesT::getJumlahStokOaPemakaianTersimpan($modDetail->pemakaianobatdetail_id);
				$modDetail->subtotal = $modDetail->qty_satuanpakai*$modDetail->harga_satuanpakai;
				echo $this->renderPartial($this->path_view.'_rowDetail',array('modPemakaianObatDetail'=> $modDetail));
			}
		}
		?>
	</tbody>
</table>

<table width="100%" style="margin-top:20px;">
	<tr>
		<td width="100%" align="left" align="top">
			<table width="100%">
				<tr>
					<td width="35%" align="center">
						<div>Mengetahui<br>Instalasi <?php echo Yii::app()->user->getState('instalasi_nama'); ?></div>
						<div style="margin-top:60px;"><?php echo isset($modPesan->pegpemesan_id) ? $modPesan->pegawaipemesan->NamaLengkap : "-" ?></div>
					</td>
					<td width="35%" align="center">
					</td>
					<td width="35%" align="center">
						<div>Dibuat Oleh :</div>
						<div style="margin-top:60px;"><?php echo isset($modPesan->pegmengetahui_id) ? $modPesan->pegawaimengetahui->NamaLengkap : "-" ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php if(isset($caraPrint)){
    
}else{ ?>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
            array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; ?>
<?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print&id='.$modPesan->pesanbarang_id);
        $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gupesanbarang-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php } ?>