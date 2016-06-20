<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapangkat-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'pangkat_id',array('class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'golonganpegawai_id',CHtml::listData($model->GolonganPegawaiItems, 'golonganpegawai_id', 'golonganpegawai_nama'),array('empty'=>'-- Pilih --')); ?>

	<?php echo $form->textFieldRow($model,'pangkat_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'pangkat_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->checkBoxRow($model,'pangkat_aktif',array('checked'=>'pangkat_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
