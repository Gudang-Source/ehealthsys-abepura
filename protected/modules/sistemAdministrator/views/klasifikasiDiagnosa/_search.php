<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saklasifikasidiagnosa-m-search',
	'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'klasifikasidiagnosa_id',array('class'=>'span3')); ?>
	<div class='row-fluid'>
		<div class='span4'>
			<?php echo $form->textFieldRow($model,'klasifikasidiagnosa_kode',array('class'=>'span3','maxlength'=>10)); ?>
			<?php echo $form->textFieldRow($model,'klasifikasidiagnosa_nama',array('class'=>'span3','maxlength'=>500)); ?>
		</div>
		<div class='span4'>
			<?php echo $form->textFieldRow($model,'klasifikasidiagnosa_namalain',array('class'=>'span3')); ?>
			<?php echo $form->textFieldRow($model,'klasifikasidiagnosa_desc',array('class'=>'span3')); ?>
		</div>
		<div class='span4'>
			<?php echo $form->checkBoxRow($model,'klasifikasidiagnosa_aktif'); ?>
		</div>
	</div>



	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
