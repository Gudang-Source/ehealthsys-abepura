<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sadtd-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'dtd_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'diagnosa_id',array('class'=>'span3')); ?>

	<?php // echo $form->textFieldRow($model,'dtd_no',array('class'=>'span1','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'dtd_noterperinci',array('class'=>'span1','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'dtd_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'dtd_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'dtd_katakunci',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'dtd_nourut',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'dtd_menular',array('checked'=>'dtd_menular')); ?>

	<?php echo $form->checkBoxRow($model,'dtd_aktif',array('checked'=>'dtd_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
