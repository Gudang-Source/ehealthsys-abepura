<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmlokasi-rak-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'lokasirak_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'lokasirak_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'lokasirak_namalainnya',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->checkBoxRow($model,'lokasirak_aktif',array(
                        'checked'=>'$data->lokasirak_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
