<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmjenis-tindakanrm-m-search',
        'type'=>'horizontal',
)); ?>


	<?php echo $form->textFieldRow($model,'jenistindakanrm_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'jenistindakanrm_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->checkBoxRow($model,'jenistindakanrm_aktif', array('checked'=>'checked')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
