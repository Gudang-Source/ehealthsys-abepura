<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
        'id'=>'form_kategoriObt_search',
)); ?>

	<?php //echo $form->textFieldRow($model,'lookup_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'lookup_type',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'lookup_name',array('class'=>'span3','maxlength'=>50)); ?>
        <?php echo CHtml::hiddenfield('ObatAlkesKategori[lookup_value]');?>
        <?php echo CHtml::hiddenfield('ObatAlkesKategori[lookup_kode]');?>
        <?php echo CHtml::hiddenfield('ObatAlkesKategori[lookup_urutan]');?>

	<?php //echo $form->textFieldRow($model,'lookup_value',array('class'=>'span5','maxlength'=>200)); ?>

	<?php //echo $form->textFieldRow($model,'lookup_kode',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'lookup_urutan',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'lookup_aktif',array('checked'=>'lookup_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
