<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
        'id'=>'sajenis-pendidikan-m-search',
)); ?>

	<?php //echo $form->textFieldRow($model,'pendidikan_id',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'pendidikan_nama',array('class'=>'span3','maxlength'=>50)); ?>
	<?php //echo $form->textFieldRow($model,'pendidikan_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>
        <div>
            <?php echo $form->checkBoxRow($model,'pendidikan_aktif',array('checked'=>'pendidikan_aktif')); ?>
        </div>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
