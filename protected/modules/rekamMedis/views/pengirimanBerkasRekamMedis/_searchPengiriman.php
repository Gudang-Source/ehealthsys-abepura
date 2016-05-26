<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'search',
    'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($modPengiriman, 'tgl pendaftaran', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$modPengiriman->tgl_rekam_medik = MyFormatter::formatDateTimeForUser($modPengiriman->tgl_rekam_medik);					
				$this->widget('MyDateTimePicker', array(
					'model' => $modPengiriman,
					'attribute' => 'tgl_rekam_medik',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
					),
					'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
				));
				$modPengiriman->tgl_rekam_medik = MyFormatter::formatDateTimeForDb($modPengiriman->tgl_rekam_medik);	

				?>
			</div>
		</div>

		<div class="control-group ">
			<?php echo CHtml::label('Sampai dengan','', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$modPengiriman->tgl_rekam_medik_akhir = MyFormatter::formatDateTimeForUser($modPengiriman->tgl_rekam_medik_akhir);
				$this->widget('MyDateTimePicker', array(
					'model' => $modPengiriman,
					'attribute' => 'tgl_rekam_medik_akhir',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
					),
					'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
				));
				$modPengiriman->tgl_rekam_medik_akhir = MyFormatter::formatDateTimeForDb($modPengiriman->tgl_rekam_medik_akhir);
				?>
			</div>
		</div>

		<?php echo $form->textFieldRow($modPengiriman, 'no_rekam_medik', array('class' => 'span3', 'maxlength' => 10)); ?>
		<div class="control-group ">
			<?php echo CHtml::label('Sampai dengan','', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modPengiriman, 'no_rekam_medik_akhir', array('class' => 'span3', 'maxlength' => 10)); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($modPengiriman, 'nama_pasien', array('class' => 'span3', 'maxlength' => 50)); ?>
		<?php echo $form->dropDownListRow($modPengiriman, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAllByAttributes(array('instalasi_aktif'=>true), array('order'=>'instalasi_nama ASC')), 'instalasi_id', 'instalasi_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'onchange'=>'getRuangan();')); ?>
	</div>
	<div class="span4">
		<?php echo $form->dropDownListRow($modPengiriman, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true), array('order'=>'ruangan_nama ASC')), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>
		<?php echo $form->textFieldRow($modPengiriman, 'no_pendaftaran', array('class' => 'span3', 'maxlength' => 20)); ?>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>
<?php $this->endWidget(); ?>