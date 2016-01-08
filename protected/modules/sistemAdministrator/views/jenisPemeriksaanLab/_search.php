<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sajenispemeriksaanlab-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model,'jenispemeriksaanlab_urutan',array('class'=>'span3 numbers-only')); ?>

		<?php echo $form->textFieldRow($model,'jenispemeriksaanlab_kode',array('class'=>'span3','maxlength'=>10)); ?>

	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'jenispemeriksaanlab_nama',array('class'=>'span3','maxlength'=>30)); ?>

		<?php echo $form->textFieldRow($model,'jenispemeriksaanlab_namalainnya',array('class'=>'span3','maxlength'=>30)); ?>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'jenispemeriksaanlab_kelompok',array('class'=>'span3','maxlength'=>100)); ?>
            <div>
		<?php echo $form->checkBoxRow($model,'jenispemeriksaanlab_aktif'); ?>
            </div>
        </div>
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
