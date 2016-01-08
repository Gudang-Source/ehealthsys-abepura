<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakamar-ruangan-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'kamarruangan_id',array('class'=>'span5')); ?>
        <?php echo $form->dropDownListRow($model,'kelaspelayanan_id',CHtml::listData($model->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData($model->RuanganItems, 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --'));?>
        
	<?php //echo $form->textFieldRow($model,'kamarruangan_nokamar',array('class'=>'span1','maxlength'=>2)); ?>

	<?php //echo $form->textFieldRow($model,'kamarruangan_jmlbed',array('class'=>'span1','maxlength'=>2)); ?>

	<?php //echo $form->textFieldRow($model,'kamarruangan_nobed',array('class'=>'span1','maxlength'=>2)); ?>

	<?php echo $form->checkBoxRow($model,'kamarruangan_status'); ?>

	<?php echo $form->checkBoxRow($model,'kamarruangan_aktif',array('checked'=>'kamarruangan_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
