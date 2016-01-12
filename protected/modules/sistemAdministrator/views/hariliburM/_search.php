<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kpharilibur-m-search',
	'type'=>'horizontal',
)); ?>

	<div class='control-group'>
			<?php echo CHtml::label('Tanggal Hari Libur <span class="required">*</span>', 'tglharilibur', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php 
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tglharilibur', 
						'mode'=>'date',
						'options'=>array(
							'dateFormat' => Params::DATE_FORMAT,
						),
						'htmlOptions' => array('readonly' => true,
							'class' => "span2 required",
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));  
				?>
			</div>
	</div>
	<?php echo $form->textFieldRow($model,'namaharilibur',array('class'=>'span3','maxlength'=>25)); ?>
	<?php // echo $form->textFieldRow($model,'keterangan_harilibur',array('class'=>'span3')); ?>

	<?php echo $form->checkBoxRow($model,'harilibur_aktif'); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
