<legend class="rim"><i class='icon-white icon-search'></i> Pencarian</legend>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'type' => 'horizontal',
	'id' => 'searchLaporan',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
		));
?>

<div class="row-fluid">
	<div class="span4">
		<fieldset class="box2">
			<legend class="rim">Tahun:</legend>

			<div class='control-group tahun'>
				<?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('onkeypress' => "return $(this).focusNextInputField(event)", 'prompt'=>'--Pilih--'));
					?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="span8">
		<fieldset class="box2">
			<legend class="rim">Bulan:</legend>
			<div class="controls" id="cbBulan">
				<label><?php echo CHtml::checkBox('pilihSemua', false, array('onclick' => 'pilihSemuaBulan();')); ?> <b>Pilih Semua</b> </label><br>
				<?php echo CHtml::activecheckBoxList($model, 'bulan', CustomFunction::getBulan(null, null), array('separator' => '    ', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
			</div>
		</fieldset>
	</div>
</div>
<!--<table width='100%'>
    <tr>
        <td>
        <div class="control-group ">
<?php echo $form->labelEx($model, 'Periode Awal', array('class' => 'control-label')); ?>
            <div class="controls">
<?php
$this->widget('MyDateTimePicker', array(
	'model' => $model,
	'attribute' => 'tgl_awal',
	'mode' => 'date',
	'options' => array(
		'dateFormat' => Params::DATE_FORMAT,
	),
	'htmlOptions' => array('readonly' => true,
		'onkeypress' => "return $(this).focusNextInputField(event)",
		'class' => 'dtPicker3',
	),
));
?> 
            </div>
        </div>
        </td>
        <td>
        <div class="control-group ">
<?php echo $form->labelEx($model, 'sampai', array('class' => 'control-label')); ?>
            <div class="controls">
<?php
$this->widget('MyDateTimePicker', array(
	'model' => $model,
	'attribute' => 'tgl_akhir',
	'mode' => 'date',
	'options' => array(
		'dateFormat' => Params::DATE_FORMAT,
	),
	'htmlOptions' => array('readonly' => true,
		'onkeypress' => "return $(this).focusNextInputField(event)",
		'class' => 'dtPicker3',
	),
));
?> 
            </div>
        </div>
        </td>
    </tr>
</table>-->

<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>            
	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/Index'), array('class' => 'btn btn-danger',
		'onclick' => 'return refreshForm(this);'));
	?>
</div>
<?php
$this->endWidget();
?>
<script>
	function pilihSemuaBulan() {
		if ($("#pilihSemua").is(':checked')) {
			$("#cbBulan").find("input[type=\'checkbox\']").attr("checked", "checked");
		} else {
			$("#cbBulan").find("input[type=\'checkbox\']").attr("checked", false);
		}
	}
//	pilihSemuaBulan();
</script>