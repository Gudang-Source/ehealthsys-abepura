<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	//'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'form-groups-bordered'),
	'id'=>'pencarian-pinjaman',
));

$model2 = clone $model;
$model2->tglAwal = date('d/m/Y', strtotime($model->tglAwal));
$model2->tglAkhir = date('d/m/Y', strtotime($model->tglAkhir));

?>
		<div class="form-group">
			<?php echo $form->label($model, 'tglAwal', array('class'=>'control-label col-sm-3')); ?>
			<div class="col-sm-5">
				<div class="input-group">
				<?php
				$this->widget('bootstrap.widgets.TbDatePicker', array(
					'model'=>$model2, 'attribute'=>'tglAwal', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
				));
				?>
				<div class='input-group-addon'  onclick="$('#InformasipermohonanpinjamanV_tglAwal').focus()">
					<a><i class='entypo-calendar'></i></a>
				</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<?php echo $form->label($model, 'tglAkhir', array('class'=>'control-label col-sm-3')); ?>
			<div class="col-sm-5">
				<div class="input-group">
				<?php
				$this->widget('bootstrap.widgets.TbDatePicker', array(
					'model'=>$model2, 'attribute'=>'tglAkhir', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
				));
				?>
				<div class='input-group-addon' onclick="$('#InformasipermohonanpinjamanV_tglAkhir').focus()">
					<a><i class='entypo-calendar'></i></a>
				</div>
				</div>
			</div>
		</div>
                <?php echo $form->textFieldRow($model,'nopermohonan',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nopermohonan'),)); ?>
		<?php echo $form->textFieldRow($model,'nokeanggotaan',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nokeanggotaan'),)); ?>
		<div class="form-group">
			<?php echo $form->label($model, 'nama_anggota', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-5">
					<?php echo $form->textField($model,'nama_pegawai',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nama_anggota'),)); ?>
				</div>
		</div>


		<?php //echo $form->textFieldRow($model,'namaunit',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('namaunit'),)); ?>
		<div class="form-group">
                    <?php echo $form->labelEx($model, 'Golongan',array('class'=>'control-label col-sm-3')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('condition'=>'golonganpegawai_aktif = true', 'order'=>'golonganpegawai_nama asc')), 'golonganpegawai_id', 'golonganpegawai_nama'), array('empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
                    </div>
                </div>
		<?php //echo $form->textFieldRow($model,'jenispinjaman_permohonan',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('jenispinjaman_permohonan'),)); ?>
		<?php echo $form->dropDownListRow($model,'jenispinjaman_permohonan',Params::jenisPinjaman(),array('empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
		<div class="form-group">
            <?php echo $form->labelEx($model, 'Status Persetujuan',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-5">
				<?php echo $form->dropDownList($model,'status_disetujui',array(3=>'Menunggu Persetujuan', 1=>'Disetujui', 2=>'Tidak Disetujui'),array('empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
			</div>
		</div>
		<div class="form-group">
            <?php echo $form->labelEx($model, 'Status Pencairan',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-5">
				<?php echo $form->dropDownList($model,'cair',array(1=>'Sudah Dicairkan', 2=>'Belum Dicairkan'),array('empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
			</div>
		</div>
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-5">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Cari',
			'htmlOptions'=>array('class'=>'btn-primary'),
		)); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>
