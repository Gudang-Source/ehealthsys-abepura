<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sajabatan-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'jabatan_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'jabatan_nama',array('class'=>'span3','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'jabatan_lainnya',array('class'=>'span5','maxlength'=>20)); ?>

        <div>
            <?php echo $form->checkBoxRow($model,'jabatan_aktif',array('checked'=>'jabatan_aktif')); ?>
        </div>
            
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
