<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmwarna-nomor-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'warnanomorrm_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'warnanomorrm_angka',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'warnanomorrm_warna',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'warnanomorrm_kodewarna',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->checkBoxRow($model,'warnanomorrm_aktif',array(
                        'checked'=>'$data->warnanomorrm_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
