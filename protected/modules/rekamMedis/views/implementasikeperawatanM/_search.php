<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saimplementasikeperawatan-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'implementasikeperawatan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'diagnosakeperawatan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'rencanakeperawatan_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'implementasikeperawatan_kode',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->textAreaRow($model,'implementasi_nama',array('rows'=>6, 'cols'=>20, 'class'=>'span3')); ?>

	<?php echo $form->checkBoxRow($model,'iskolaborasiimplementasi',array('checked'=>'iskolaborasiimplementasi')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
