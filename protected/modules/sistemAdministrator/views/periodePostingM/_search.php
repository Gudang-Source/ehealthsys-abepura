<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saperiodeposting-m-search',
	'type'=>'horizontal',
)); ?>

<div class="row-fluid">
	<div class="span4">
		<?php echo $form->dropDownListRow($model,'konfiganggaran_id',CHtml::listData(KonfiganggaranK::model()->findAll(array('order'=>'deskripsiperiode ASC')), 'konfiganggaran_id', 'deskripsiperiode'),array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
		<?php echo $form->textFieldRow($model,'periodeposting_nama',array('class'=>'span3','maxlength'=>100)); ?>
	</div>
	<div class="span4">
		<?php echo $form->dropDownListRow($model,'rekperiode_id',CHtml::listData(RekperiodM::model()->findAll(array('order'=>'deskripsi ASC')), 'rekperiod_id', 'deskripsi'),array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
		<?php echo $form->checkBoxRow($model,'periodeposting_aktif',array('checked'=>true)); ?>
	</div>
	<div class="span4"></div>
</div>

<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
