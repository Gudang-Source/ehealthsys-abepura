<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saformasishift-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Ruangan','ruangan_nama',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'ruangan_nama',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Shift','shift_nama',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'shift_nama',array('class'=>'span3')); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Jumlah Formasi','jmlformasi',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'jmlformasi',array('class'=>'span2 integer')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Aktif','formasishift_aktif',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->checkBox($model,'formasishift_aktif',array('checked'=>'checked')); ?>
			</div>
		</div>
	</div>
</div>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
