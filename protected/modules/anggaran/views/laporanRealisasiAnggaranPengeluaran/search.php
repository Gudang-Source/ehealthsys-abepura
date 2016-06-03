<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'type' => 'horizontal',
	'id' => 'laporan-search',
		));
?>
<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model, 'rencanggaranpeng_no', array('class' => 'span3 numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Ketik no. pengeluaran')); ?>
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'Periode Anggaran', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'konfiganggaran_id', CHtml::listData(AGKonfiganggaranK::model()->findAll(), 'konfiganggaran_id', 'deskripsiperiode'), array('empty' => '--Pilih--', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'periodeAnggaran();')); ?>
				<?php echo CHtml::hiddenField('konfiganggaran_id', '', array('class' => 'span2 integer', 'style' => 'width:90px;', 'readonly' => true)) ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'Unit Kerja', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'unitkerja_id', CHtml::listData(AGUnitkerjaM::model()->findAllByAttributes(array(), array('order' => 'namaunitkerja')), 'unitkerja_id', 'namaunitkerja'), array('empty' => '--Pilih--', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
		<div class='control-group bulan'>
			<?php echo CHtml::label('Bulan Pelaksanaan', 'bln_awal', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
				<?php
				$this->widget('MyMonthPicker', array(
					'model' => $model,
					'attribute' => 'bln_awal',
					'options' => array(
						'dateFormat' => Params::MONTH_FORMAT,
					),
					'htmlOptions' => array('readonly' => true,
						'class' => "span2",
						'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>
				<?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
			</div> 
		</div>

	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
	?>

	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-danger',
		'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'));
	?>
</div>
<?php
$this->endWidget();
?>
<script type="text/javascript">
function periodeAnggaran(){
var konfig_id=$("#<?php echo CHtml::activeId($model,"konfiganggaran_id");?>").val();
$("#konfiganggaran_id").val(konfig_id);
}
</script>