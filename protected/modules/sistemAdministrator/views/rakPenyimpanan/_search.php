<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sarakpenyimpanan-m-search',
	'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'rakpenyimpanan_id',array('class'=>'span3')); ?>

	<?php echo $form->dropDownListRow($model,'lokasipenyimpanan_id',  CHtml::listData($model->LokasipenyimpananItems, 'lokasipenyimpanan_id', 'lokasipenyimpanan_nama'), array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>

	<?php echo $form->textFieldRow($model,'rakpenyimpanan_label',array('class'=>'span3','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'rakpenyimpanan_kode',array('class'=>'span3','maxlength'=>5)); ?>

	<?php echo $form->textFieldRow($model,'rakpenyimpanan_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'rakpenyimpanan_namalain',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->checkBoxRow($model,'rakpenyimpanan_aktif', array('checked'=>'rakpenyimpanan_aktif')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
