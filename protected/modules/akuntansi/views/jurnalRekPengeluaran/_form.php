<?php
if (isset($_GET['id'])) {
	Yii::app()->user->setFlash('success', "Data Jenis Pengeluaran Berhasil Disimpan!");
}
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'jenispengeluaran-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'requiredCheck();'),
	'focus' => '#AKJenispengeluaranM_jenispengeluaran_kode',
		));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>

<table>
	<tr>
		<td>
			<div class='control-group'>
					<?php echo $form->labelEx($model, 'jenispengeluaran_kode', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'jenispengeluaran_kode', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
				</div>
			</div>

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'jenispengeluaran_nama', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'jenispengeluaran_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
				</div>
			</div>

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'jenispengeluaran_namalain', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'jenispengeluaran_namalain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
				</div>
			</div>

			<div class='control-group'>
<?php //echo $form->checkBoxRow($model,'jenispengeluaran_aktif',array('checked'=>'checked'));  ?>
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
	echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/jurnalRekPengeluaran/admin'), array('class' => 'btn btn-danger',
		'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
	?>
	<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jurnal Rekening Pengeluaran', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>

	<?php
	$content = $this->renderPartial('akuntansi.views.tips.tipsaddedit', array(), true);
	$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
	?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
	function namaLain(nama)
	{
		document.getElementById('AKJenispengeluaranM_jenispengeluaran_namalain').value = nama.value.toUpperCase();
	}
</script>