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
echo "No. Rencana : <b>".$model->norenpengembalian."</b>";
?>
<table class="items table table-striped table-condensed" id="table-rencanaanggaranpenerimaan">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nama Obat</th>
			<th>Supplier</th>
			<th>Satuan Kecil</th>
			<th>Jumlah</th>
			<th>Tanggal Kadaluarsa</th>

		</tr>
	</thead>
	<tbody>
		<?php 
		foreach($modDetails as $i => $modDetail){
		?>
		<tr>
			<td><?php echo $i+1; echo ". "; ?></td>
			<td><?php echo $modDetail->obatalkes_nama; ?></td>
			<td><?php echo $modDetail->supplier_nama; ?></td>
			<td><?php echo $modDetail->satuankecil_nama; ?></td>
			<td><?php echo $modDetail->qty_renpenged; ?></td>
			<td><?php echo $format->formatDateTimeForUser($modDetail->tglkadaluarsa_renpeng); ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<div class="row-fluid">
	<div class="span6" style="text-align:center;">
		&nbsp;
	</div>
	<div class="span6" style="text-align:center;">
		<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
			<?php 
			if(isset($_GET['sukses'])){
				echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
				echo "Menyetujui, ";
			}else{
				echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
				echo CHtml::link(Yii::t('mds',' Menyetujui'), 
				$this->createUrl($this->id.'/index'), 
				array('class'=>'btn btn-primary',
					'onclick'=>'myConfirm("Apakah anda yakin ?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('Menyetujui',array('renpengembalianed_id'=>$model->renpengembalianed_id,'approve'=>true)).'";} ); return false;'));  
				echo "&nbsp";
				/*echo CHtml::link(Yii::t('mds',' Menolak'), 
				$this->createUrl($this->id.'/index'), 
				array('class'=>'btn btn-default',
					'onclick'=>'myConfirm("Apakah anda yakin ?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('Menyetujui',array('rencanakebfarmasi_id'=>$model->rencanakebfarmasi_id,'tolak'=>true)).'";} ); return false;'));  
				 * 
				 */
			}
			?>
		</div>
	</div>
		<div class="control-group">
			( <?php echo $model->PegawaimenyetujuiLengkap;?> )
		</div>
	</div>
</div>
<?php 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	$urlPrint= $this->createUrl('printMenyetujui',array('renpengembalianed_id'=>$model->renpengembalianed_id));
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