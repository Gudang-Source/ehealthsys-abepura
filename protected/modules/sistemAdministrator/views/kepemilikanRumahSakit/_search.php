<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gfatc-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class = "span1"></div>
	<div class = "span6">
		<?php echo CHtml::activeHiddenField($model,'lookup_type',array('class'=>'span3','value'=>'namakepemilikanrs')); ?>
		<div class="control-group">
			<?php echo CHtml::label('Nama Kepemilikan Rumah Sakit','lookup_name', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model,'lookup_name',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Nama Lain Kepemilikan Rumah Sakit','lookup_value', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model,'lookup_value',array('class'=>'span3')); ?>
			</div>
		</div>
		<?php echo $form->checkBoxRow($model,'lookup_aktif',array('checked'=>'checked')); ?>
	</div>
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
