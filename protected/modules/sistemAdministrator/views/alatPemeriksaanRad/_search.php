<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapemeriksaanmapalatrad-m-search',
	'type'=>'horizontal',
)); ?>
	
<div class="row-fluid">
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Nama Alat Rad.','pemeriksaanalatrad_nama',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'pemeriksaanalatrad_nama',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Nama Pemeriksaan','pemeriksaanrad_nama',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'pemeriksaanrad_nama',array('class'=>'span3')); ?>
			</div>
		</div>
	</div>
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
