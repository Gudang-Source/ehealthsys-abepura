<style>
    .uang {
        text-align: right !important;
    }
</style>

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
echo "No. Rencana : <b>".$model->noperencnaan."</b>";
?>
<table class="items table table-striped table-condensed" id="table-rencanaanggaranpenerimaan">
	<thead>
		<tr>
			<th>No.</th>
			<th>Asal Barang</th>
			<th>Kategori / Nama Obat</th>
			<th>Jumlah Kemasan (Satuan)</th>
			<th>Jumlah Permintaan</th>
			<th>Harga Netto</th>
			<th>Stok Akhir</th>
			<th>Minimal Stok</th>
			<th>Sub Total</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
		$total = 0;
        $subtotal = 0;
		foreach($modDetails as $i => $modDetail){
                    $oa = ObatalkesM::model()->findByPk($modDetail->obatalkes_id);
                    $sat = !empty($modDetail->satuankecil_id)?$modDetail->satuankecil->satuankecil_nama:$modDetail->satuanbesar->satuanbesar_nama;
                    $kecil = $oa->satuankecil->satuankecil_nama;
		?>
		<tr>
				<td><?php echo $i+1; echo ". "; ?></td>
				<td><?php echo $modDetail->sumberdana->sumberdana_nama; ?></td>
				<td><?php echo (!empty($modDetail->obatalkes->obatalkes_kategori) ? $modDetail->obatalkes->obatalkes_kategori."/ " : "") ."". $modDetail->obatalkes->obatalkes_nama; ?></td>
				<td class="uang"><?php echo $modDetail->kemasanbesar." ".$kecil; ?></td>
				<td class="uang"><?php echo $modDetail->jmlpermintaan." ".$sat; ?></td>
				<td class="uang"><?php echo $format->formatUang($modDetail->harganettorenc); ?></td>
				<td class="uang"><?php echo $modDetail->stokakhir." ".$kecil; ?></td>
				<td class="uang"><?php echo $modDetail->minimalstok." ".$kecil; ?></td>
				<td class="uang">
					<?php 
                    if (!empty($modDetail->satuankecil_id)) {
                        $subtotal = $modDetail->harganettorenc * $modDetail->jmlpermintaan;
                    } else {
                        $subtotal = $modDetail->harganettorenc * $modDetail->jmlpermintaan * $modDetail->kemasanbesar;
                    }
                    // $subtotal = ($modDetail->harganettorenc * $modDetail->jmlpermintaan);
                    $total += $subtotal;
                    echo $format->formatUang($subtotal); ?>
				</td>
		</tr>
		<?php } ?>
		<tfoot>
			<tr>
				<td colspan="8" style="text-align:right;">Total Anggaran</td>
				<td class="uang"><b>
					<?php echo $format->formatUang($total) ?>
					</b>
				</td>
			</tr>
		</tfoot>
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
				echo isset($_GET['ditolak'])? "Ditolak," : "Menyetujui, ";
			}else{
				echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
				echo CHtml::link(Yii::t('mds',' Menyetujui'), 
				$this->createUrl($this->id.'/index'), 
				array('class'=>'btn btn-primary',
					'onclick'=>'myConfirm("Apakah anda yakin ?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('Menyetujui',array('rencanakebfarmasi_id'=>$model->rencanakebfarmasi_id,'approve'=>true)).'";} ); return false;'));  
				echo "&nbsp";
				echo CHtml::link(Yii::t('mds',' Menolak'), 
				$this->createUrl($this->id.'/index'), 
				array('class'=>'btn btn-default',
					'onclick'=>'myConfirm("Apakah anda yakin ?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('Menyetujui',array('rencanakebfarmasi_id'=>$model->rencanakebfarmasi_id,'tolak'=>true)).'";} ); return false;'));  
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
    $urlPrint= $this->createUrl('printMenyetujui',array('rencanakebfarmasi_id'=>$model->rencanakebfarmasi_id));
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