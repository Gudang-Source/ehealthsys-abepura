<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sashift-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
	<?php echo $form->textFieldRow($model,'shift_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'shift_kode',array('class'=>'span3','maxlength'=>1)); ?>
	
	<?php echo $form->textFieldRow($model,'shift_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Dari Jam','',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'shift_jamawal',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::TIME_FORMAT,
                        //'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Sampai Dengan','',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'shift_jamakhir',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::TIME_FORMAT,
                        //'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
			</div>
		</div>
	</div>
	<div class="span4">
	<?php echo $form->textFieldRow($model,'shift_urutan',array('class'=>'span1 integer')); ?>

	<?php echo $form->checkBoxRow($model,'shift_aktif'); ?>
	</div>
</div>
	
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
