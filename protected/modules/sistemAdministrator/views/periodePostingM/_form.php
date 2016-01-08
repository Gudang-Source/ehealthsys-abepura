<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'saperiodeposting-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
	'focus' => '#',
		));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">

	<div class = "span6">
		<?php echo $form->dropDownListRow($model, 'rekperiode_id', CHtml::listData(RekperiodM::model()->findAll(), 'rekperiod_id', 'deskripsi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
		<?php echo $form->textFieldRow($model, 'periodeposting_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>			
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'tglperiodeposting_awal', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'tglperiodeposting_awal',
					'mode' => 'date',
					'options' => array(
						'showOn' => false,
						'dateFormat' => Params::DATE_FORMAT,
						'yearRange' => "-150:+0",
						'onSelect' => "js:function() {
							cekTanggal();
							return false;
						}",
					),
					'htmlOptions' => array('class' => 'dtPicker2', 'onkeyup' => "return $(this).focusNextInputField(event)"
					),
				));
				?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'tglperiodeposting_akhir', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'tglperiodeposting_akhir',
					'mode' => 'date',
					'options' => array(
						'showOn' => false,
						'dateFormat' => Params::DATE_FORMAT,
						'yearRange' => "-150:+0",
						'onSelect' => "js:function() {
							cekTanggal();
							return false;
						}",
					),
					'htmlOptions' => array('class' => 'dtPicker2', 'onkeyup' => "return $(this).focusNextInputField(event)"
					),
				));
				?>
			</div>
		</div>
	</div>
	<div class = "span6">
		<?php echo $form->dropDownListRow($model, 'konfiganggaran_id', CHtml::listData(KonfiganggaranK::model()->findAll(), 'konfiganggaran_id', 'deskripsiperiode'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
		<?php echo $form->textAreaRow($model, 'deskripsiperiodeposting', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",)); ?>
		<?php
		if (!empty($model->periodeposting_id)) {
			?>
			<?php echo $form->checkBoxRow($model, 'periodeposting_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
		<?php } ?>			

	</div>
</div>
<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
		<?php
		echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('create'), array('class' => 'btn btn-danger',
			'onclick' => 'return refreshForm(this);'));
		?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Periode Posting', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
		<?php $this->widget('UserTips', array('content' => '')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<script>
	function cekTanggal()
	{
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('cekTanggal'); ?>',
			data: $("#saperiodeposting-m-form").serialize(),
			dataType: "json",
			success: function (data) {
				if(data.pesan !== ""){
					myAlert(data.pesan);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				myAlert(data.pesan);
			}
		});
	}
</script>