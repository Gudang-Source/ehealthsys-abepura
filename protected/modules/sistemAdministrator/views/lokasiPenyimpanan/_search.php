<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'salokasipenyimpanan-m-search',
	'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'lokasipenyimpanan_id',array('class'=>'span3')); ?>

	<?php echo $form->dropDownListRow($model,'instalasi_id',  CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'), array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>

	<?php echo $form->textFieldRow($model,'lokasipenyimpanan_kode',array('class'=>'span3','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'lokasipenyimpanan_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'lokasipenyimpanan_namalain',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->checkBoxRow($model,'lokasipenyimpanan_aktif', array('checked'=>'lokasipenyimpanan_aktif')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
