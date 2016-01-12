<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saloket-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
		<?php //echo $form->textFieldRow($model,'loket_id',array('class'=>'span3')); ?>

		<?php echo $form->textFieldRow($model,'loket_nama',array('class'=>'span3','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'loket_namalain',array('class'=>'span3','maxlength'=>50)); ?>

		<?php echo $form->textAreaRow($model,'loket_fungsi',array('rows'=>3, 'cols'=>30, 'class'=>'span4')); ?>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'loket_singkatan',array('class'=>'span3','maxlength'=>1)); ?>

		<?php echo $form->textFieldRow($model,'loket_nourut',array('class'=>'span3')); ?>

		<?php echo $form->textFieldRow($model,'loket_formatnomor',array('class'=>'span3','maxlength'=>5)); ?>

		<?php echo $form->textFieldRow($model,'loket_maksantrian',array('class'=>'span3')); ?>

		<?php echo $form->checkBoxRow($model,'loket_aktif'); ?>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'carabayar_id',array('class'=>'span3')); ?>

		<?php echo $form->textFieldRow($model,'filesuara',array('class'=>'span3','maxlength'=>500)); ?>

		<?php echo $form->checkBoxRow($model,'ispendaftaran'); ?>

		<?php echo $form->checkBoxRow($model,'iskasir'); ?>
	</div>
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
