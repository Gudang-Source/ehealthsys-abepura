<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'mcklasifikasifitnes-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
	<?php echo $form->textFieldRow($model,'age_elev',array('class'=>'span3','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'lama_menit',array('class'=>'span3 integer')); ?>
	<?php echo $form->textFieldRow($model,'workload_kph',array('class'=>'span3 integer')); ?>
	<?php echo $form->textFieldRow($model,'estimasirate',array('class'=>'span3 integer')); ?>
	<?php echo $form->textFieldRow($model,'max_intake',array('class'=>'span3 integer')); ?>
	</div>
	<div class="span4">
	<?php echo $form->textFieldRow($model,'umur_min',array('class'=>'span3 integer')); ?>
	<?php echo $form->textFieldRow($model,'umur_maks',array('class'=>'span3 integer')); ?>
	<?php echo $form->textFieldRow($model,'mets',array('class'=>'span3 integer')); ?>
	<?php echo $form->textFieldRow($model,'klasifikasifitnes',array('class'=>'span3','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'functional_class',array('class'=>'span3','maxlength'=>5)); ?>
	</div>
	<div class="span4">
	<?php echo $form->textFieldRow($model,'walking_kmhr',array('class'=>'span3','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'jogging_kmhr',array('class'=>'span3','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'bicycling_kmhr',array('class'=>'span3','maxlength'=>50)); ?>
	<?php echo $form->textAreaRow($model,'other_sports',array('rows'=>2, 'cols'=>50, 'class'=>'span3')); ?>
	<?php echo $form->checkBoxRow($model,'klasifikasifitnes_aktif'); ?>
	</div>
</div>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
