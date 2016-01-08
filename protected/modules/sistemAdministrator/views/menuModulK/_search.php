<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'samenu-modul-k-search',
        'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
		<?php echo $form->dropDownListRow($model,'kelmenu_id', CHtml::listData($model->getKelompokMenuItems(), 'kelmenu_id', 'kelmenu_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

		<?php echo $form->dropDownListRow($model,'modul_id', CHtml::listData($model->getModulItems(), 'modul_id', 'modul_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

	
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'menu_nama',array('class'=>'span3','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'menu_url',array('class'=>'span3','maxlength'=>100)); ?>

	</div>
	<div class="span4">
		<?php echo $form->checkBoxRow($model,'menu_aktif',array('checked'=>'menu_aktif')); ?>
		
	</div>
</div>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
