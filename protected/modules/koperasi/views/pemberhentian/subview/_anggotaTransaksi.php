<div class="panel panel-primary col-sm-12">
	<div class="panel-heading panel-heading2">
		<div class="panel-title">Data Anggota</div>
	</div>
	<div class="panel-body col-sm-9">
		<div class="form-group">
			<?php echo $form->label($anggota, 'nokeanggotaan', array('class'=>'control-label col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($anggota, 'nokeanggotaan', array('class'=>'form-control', 'readonly'=>true));?>
				<?php echo $form->hiddenField($anggota, 'keanggotaan_id');?>
			</div>
		</div>
		<div class="form-group">
			<?php echo $form->label($anggota, 'nama_anggota', array('class'=>'control-label col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($anggota,'nama_pegawai', array('readonly'=>true, 'class'=>'form-control')); ?>
				<?php echo $form->hiddenField($anggota,'alamat_pegawai'); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo $form->label($anggota, 'unit_kerja', array('class'=>'control-label col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($anggota,'unit_id', array('readonly'=>true, 'class'=>'form-control')); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo $form->label($anggota, 'tgl_lahirpegawai', array('class'=>'control-label col-sm-3')); ?>
			<div class="col-sm-4">
				<?php echo $form->textField($anggota,'tgl_lahirpegawai', array('readonly'=>true, 'class'=>'form-control')); ?>
			</div>
			<?php echo $form->label($anggota, 'umur', array('class'=>'control-label col-sm-1')); ?>
			<div class="col-sm-4">
				<?php echo CHtml::textField('umur', $anggota->umur, array('readonly'=>true, 'class'=>'form-control')); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo $form->label($anggota, 'tglkeanggotaaan', array('class'=>'control-label col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($anggota,'tglkeanggotaaan', array('readonly'=>true, 'class'=>'form-control')); ?>
			</div>
		</div> <?php /*
		<div class="form-group">
			<?php echo $form->label($anggota, 'jml angsuran', array('class'=>'control-label col-sm-3')); ?>
			<div class="col-sm-4">
				<?php echo CHtml::textField('jml_angsuran', $berhenti->jmltunggakan_berhenti, array('readonly'=>true, 'class'=>'form-control num')); ?>
			</div>
		</div> */ ?>
	</div>
	<div class="panel-body col-sm-3">
		<img src="<?php echo $anggota->photopegawai; ?>" width="150" height="200" id="photo_pegawai">
	</div>
</div>
