<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sasubkelompok-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'subkelompok_id',array('class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'kelompok_id',CHtml::listData(KelompokM::model()->findAll(), 'kelompok_id', 'kelompok_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>

	<?php echo $form->textFieldRow($model,'subkelompok_kode',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'subkelompok_nama',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'subkelompok_namalainnya',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->checkBoxRow($model,'subkelompok_aktif',array('checked'=>'subkelompok_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
