<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmjenissebab-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'jenissebab_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'jenissebab_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'jenissebab_namalainnya',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->checkBoxRow($model,'jenissebab_aktif',array('checked'=>'$data->jenissebab_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
