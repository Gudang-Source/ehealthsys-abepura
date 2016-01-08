<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakomponen-tarif-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'komponentarif_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'komponentarif_nama',array('class'=>'span3','maxlength'=>25)); ?>

	<?php echo $form->textFieldRow($model,'komponentarif_namalainnya',array('class'=>'span3','maxlength'=>25)); ?>

	<?php //echo $form->textFieldRow($model,'komponentarif_urutan',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'komponentarif_aktif', array('checked'=>'$data->komponentarif_aktif')); ?>

	<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
