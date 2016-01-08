<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status menyetujui berhasil disimpan !");
}
$this->widget('bootstrap.widgets.BootAlert'); 
echo "No. Rencana : <b>".$model->renkebbarang_no."</b>";
?>
<table class="items table table-striped table-condensed" id="table-rencanaanggaranpenerimaan">
	<thead>
		<tr>
			<th>No.</th>
			<th>Asal Barang</th>
			<th>Nama Barang</th>
			<th>Satuan</th>
			<th>Jumlah Permintaan</th>
			<th>Harga</th>
			<th>Stok Akhir</th>
			<th>Minimal Stok</th>
			<th>Maksimal Stok</th>
			<th>Sub Total</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
		$total = 0;
        $subtotal = 0;
		foreach($modDetails as $i => $modDetail){
		?>
		<tr>
				<td><?php echo $i+1; echo ". "; ?></td>
				<td><?php echo $modDetail->asal_barang; ?></td>
				<td><?php echo (!empty($modDetail->barang_id)) ? $modDetail->barang_id : ""; ?></td>
				<td><?php echo $modDetail->satuanbarangdet; ?></td>
				<td><?php echo $modDetail->jmlpermintaanbarangdet; ?></td>
				<td><?php echo $format->formatUang($modDetail->harga_barangdet); ?></td>
				<td><?php echo $modDetail->stokakhir_barangdet; ?></td>
				<td><?php echo $modDetail->minstok_barangdet; ?></td>
				<td><?php echo $modDetail->makstok_barangdet; ?></td>
				<td>
					<?php 
                    $subtotal = ($modDetail->harga_barangdet * $modDetail->jmlpermintaanbarangdet);
                    $total += $subtotal;
                    echo $format->formatUang($subtotal); ?>
				</td>
		</tr>
		<?php } ?>
		<tfoot>
			<tr>
				<td colspan="8" style="text-align:right;">Total</td>
				<td><b>
					<?php echo $format->formatUang($total) ?>
					</b>
				</td>
			</tr>
		</tfoot>
	</tbody>
</table>



<div class="row-fluid">
	<div class="span6" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
		Mengetahui,
		</div>
		<div class="control-group">
			( <?php echo isset($modHead->pegmengetahui_id) ? $modHead->pegawaimengetahui->NamaLengkap : "" ?> )
		</div>	
	</div>
	<div class="span6" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
			Menyetujui
		</div>
		<div class="control-group">
			( <?php echo isset($modHead->pegmenyetujui_id) ? $modHead->pegawaimenyetujui->NamaLengkap : "" ?> )
		</div>
	</div>
</div>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    $urlPrint= $this->createUrl('print',array('renkebbarang_id'=>$model->renkebbarang_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+$('#inforencanapen-form').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>



