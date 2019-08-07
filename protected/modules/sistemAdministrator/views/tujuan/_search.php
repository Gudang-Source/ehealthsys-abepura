<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'id' => 'sarekeningcolumn-m-search',
	'type' => 'horizontal',
		));
?>

<div class="row-fluid">
	<div class="span6">
		<div class='control-group'>
			<?php echo CHtml::label('Diagnosa Keperawatan', 'diagnosakep_nama', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model, 'diagnosakep_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'tujuan_nama', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model, 'tujuan_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
		<?php echo $form->checkBoxRow($model, 'tujuan_aktif', array('checked' => 'tujuan_aktif')); ?>
	</div>
</div>

<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset')); ?>
</div>

<?php $this->endWidget(); ?>
