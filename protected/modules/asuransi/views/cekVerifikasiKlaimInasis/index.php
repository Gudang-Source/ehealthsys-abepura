<div class="white-container">
	<legend  class="rim2">Transaksi Cek <b>Verifikasi Klaim</b></legend>
	<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'verifikasi-klaim-inasis-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    ));
    ?>
	<?php 
		if(isset($_GET['sukses'])){ 
			Yii::app()->user->setFlash('success', "Data Verifikasi Klaim berhasil dibuat !");
		}
	?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>	
	<fieldset class="box">
		<legend class="rim">Form Verifikasi Klaim</legend>
		<?php echo $this->renderPartial($this->path_view.'_formVerifikasiKlaim',array('form'=>$form,'modVerifikasiInasis'=>$modVerifikasiInasis,'modVerifikasiKlaimInasis'=>$modVerifikasiKlaimInasis)); ?>
	</fieldset>
	
	<div class="block-tabel">
		<h6>Tabel Hasil Pencarian</h6>
        <table class="items table table-striped table-condensed" id="table-hasil-verifikasi">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tanggal Masuk (SEP)</th>
					<th>Tanggal Pulang</th>
					<th>Jenis Pelayanan</th>
					<th>Kelas Pelayanan</th>
					<th>Status</th>
					<th>No. RM</th>
					<th>No. Peserta</th>
					<th>Nama Pasien</th>
					<th>No. SEP</th>
					<th>Kode INA-CBG</th>
					<th>Nama INA-CBG</th>
					<th>Total Tagihan</th>
					<th>Total Gruper</th>
					<th>Tagihan Pelayanan RS</th>
					<th>Top Upton</th>
				</tr>
			</thead>
			<tbody>
				<?php echo $this->renderPartial($this->path_view.'_rowHasilPencarian',array('form'=>$form,'modVerifikasiInasis'=>$modVerifikasiInasis,'modVerifikasiKlaimInasis'=>$modVerifikasiKlaimInasis)); ?>
			</tbody>
		</table>
	</div>
	
	<div class="form-actions">
		<?php 
			$disabledSave = isset($_GET['sukses']) ? true : false;
			echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('disabled'=>$disabledSave,'class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
			echo "&nbsp;";
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('index'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);'));
			echo "&nbsp;";
			if(!isset($_GET['sukses'])){
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
				echo "&nbsp;";
			}else{
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>'print(\'PRINT\');return false'));
				echo "&nbsp;";
			}
		?> 
		<?php $this->widget('UserTips',array('content'=>''));?>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view.'_jsFunctions',array(
	'modVerifikasiInasis'=>$modVerifikasiInasis,
	'modVerifikasiKlaimInasisi'=>$modVerifikasiKlaimInasis
)); ?>