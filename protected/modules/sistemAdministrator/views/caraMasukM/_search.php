<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'saalatmedis-m-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'caramasuk_nama'),
)); ?>

	<?php //echo $form->textFieldRow($model,'caramasuk_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'caramasuk_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->checkBoxRow($model,'caramasuk_aktif', array('checked'=>'$data->caramasuk_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
