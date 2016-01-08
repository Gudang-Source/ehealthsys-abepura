<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'jenispenerimaan-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
	'focus' => '#AKJenispenerimaanM_jenispenerimaan_kode',
		));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>

<table>
	<tr>
		<td>
			<div class='control-group'>
					<?php echo $form->labelEx($model, 'jenispenerimaan_kode', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'jenispenerimaan_kode', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
				</div>
			</div>

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'jenispenerimaan_nama', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'jenispenerimaan_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
				</div>
			</div>

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'jenispenerimaan_namalain', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'jenispenerimaan_namalain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
				</div>
			</div>
		</td>
	</tr>
</table>

<div class="form-actions">
	<?php
	echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
					Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
	?>
	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/jurnalRekPenerimaan/admin'), array('class' => 'btn btn-danger',
		'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
	?>
	<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jurnal Rekening Penerimaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
	<?php
	$content = $this->renderPartial('akuntansi.views.tips.tipsaddedit', array(), true);
	$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
	?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
	function namaLain(nama)
	{
		document.getElementById('AKJenispenerimaanM_jenispenerimaan_namalain').value = nama.value.toUpperCase();
	}
</script>