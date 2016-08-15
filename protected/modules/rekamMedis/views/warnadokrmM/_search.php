<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'warnadokrm-m-search',
	'type'=>'horizontal',
)); ?>

	<?php // echo $form->textFieldRow($model,'warnadokrm_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'warnadokrm_namawarna',array('class'=>'span3','maxlength'=>20)); ?>

	<?php // echo $form->textFieldRow($model,'warnadokrm_kodewarna',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->textAreaRow($model,'warnadokrm_fungsi',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->checkBoxRow($model,'warnadokrm_aktif', array('checked'=>'warnadokrm_aktif')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
