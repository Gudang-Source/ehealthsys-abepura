<fieldset>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Tanggal Asuhan Keperawatan</td>
            <td>:</td>
            <td><?php echo isset($model->tglaskep) ? MyFormatter::formatDateTimeForUser($model->tglaskep) : ""; ?></td>
        </tr>
        <tr>
            <td>No. Pendaftaran</td>
            <td>:</td>
            <td><?php echo (isset($model->pendaftaran->no_pendaftaran) ? $model->pendaftaran->no_pendaftaran : ""); ?></td>
        </tr>
        <tr>
            <td>No. Rekam Medik</td>
            <td>:</td>
            <td><?php echo (isset($model->pasien->no_rekam_medik) ? $model->pasien->no_rekam_medik : ""); ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo (isset($model->pasien->nama_pasien) ? $model->pasien->nama_pasien : ""); ?></td>
        </tr>
    </table><br/>
</fieldset>
<fieldset>
	<div class="block-tabel">
		<h6>Tabel Rencana dan <b>Implementasi Keperawatan</b></h6>
		<table width="100%" class="table table-striped table-condensed" id='asuhankeperawatan'>
			<thead>
				<tr>
					<th>Diagnosa </th>
					<th width="200">Intervensi</th>
					<th width="200">Implementasi</th>
				</tr>
			</thead>
			<tbody>
				<?php if(count($model) > 0){ 
					$disabled = false;
				?>
				<tr>
					<td><?php echo isset($model->diagnosakeperawatan_id) ? $model->diagnosakeperawatan->diagnosakeperawatan_kode : ""; ?><br/>
						<?php echo isset($model->diagnosakeperawatan->diagnosa_id) ? $model->diagnosakeperawatan->diagnosa->diagnosa_kode." - ".$model->diagnosakeperawatan->diagnosa->diagnosa_nama : ""; ?>
					</td>
					<td><?php $this->renderPartial('_intervensilanjutan',array('asuhankeperawatan_id'=>$model->asuhankeperawatan_id)); ?></td>
					<td><?php $this->renderPartial('_rencanaKeperawatan',array('asuhankeperawatan_id'=>$model->asuhankeperawatan_id)); ?></td>
				</tr>
				<?php }else{$disabled = true; ?>
				<tr>
					<td colspan="3"><i>Data tidak ditemukan.</i>
				</tr>
			<?php } ?>
			</tbody>              
		</table>
	</div>

	<div class="block-tabel">
		<h6>Tabel <b>Planning Keperawatan</b></h6>
		<table class="table table-striped table-condensed" id="asuhankeperawatan3">
			<thead>
				<tr>
					<th>Diagnosa</th>
					<th colspan='2'>Planning</th>
				</tr>
			</thead>
			<tbody>
				<?php if(count($model) > 0){ 
					$disabled = false;
				?>
				<tr>
					<td><?php echo isset($model->diagnosakeperawatan_id) ? $model->diagnosakeperawatan->diagnosakeperawatan_kode : ""; ?><br/>
						<?php echo isset($model->diagnosakeperawatan->diagnosa_id) ? $model->diagnosakeperawatan->diagnosa->diagnosa_kode." - ".$model->diagnosakeperawatan->diagnosa->diagnosa_nama : ""; ?>
					</td>
					<td><?php $this->renderPartial('_intervensilanjutan',array('asuhankeperawatan_id'=>$model->asuhankeperawatan_id)); ?></td>
				</tr>
				<?php }else{$disabled = true; ?>
				<tr>
					<td colspan="3"><i>Data tidak ditemukan.</i>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</fieldset>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disabled, 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'disabled'=>$disabled, 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'disabled'=>$disabled, 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
?>
<script type="text/javascript">
function print(caraPrint)
{
    var asuhankeperawatan_id = '<?php echo isset($_GET['asuhankeperawatan_id']) ? $_GET['asuhankeperawatan_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('printDetail'); ?>&asuhankeperawatan_id='+asuhankeperawatan_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>