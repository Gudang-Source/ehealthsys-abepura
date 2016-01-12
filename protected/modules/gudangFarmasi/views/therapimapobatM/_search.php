<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
	'focus'=>'#GFTherapimapobatM_obatalkes_nama',
)); ?>
<div class="row-fluid">
    <div class="span4">
	<div class='control-group'>
		<?php echo $form->labelEx($model,'Nama Obat', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'obatalkes_nama',array('class'=>'span3','maxlength'=>100,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
    </div>
    <div class="span8">
	<div class='control-group'>
		<?php echo $form->labelEx($model,'Nama Kelas Terapi', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'therapiobat_nama',array('class'=>'span3','maxlength'=>100,'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
    </div>
</div>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
