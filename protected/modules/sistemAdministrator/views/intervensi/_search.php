<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'id' => 'bataskarakteristik-k-search',
	'type' => 'horizontal',
		));
?>
<table>
	<tr>
		<td>
			<div class="control-group">
				<?php echo Chtml::label('Diagnosa Keperawatan', 'diagnosakep_nama', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model, 'diagnosakep_nama', array('class' => 'span3', 'maxlength' => 50)); ?>
				</div>
			</div>
        </td>

    </tr>
	<tr>
		<td>
			<div class="control-group">
			<?php echo Chtml::label('Nama Intervensi', 'intervensi_nama', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				//echo $form->dropDownList($model, 'intervensi_nama', LookupM::getItems('intervensi_as'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
				//	'class' => 'inputRequire'));
                                    echo $form->textField($model, 'intervensi_nama', array('class' => 'span3', 'maxlength' => 50));
				?>
			</div>
		</div>
        </td>
	</tr>
    <tr>
		<td>
			<div class="control-group">
				<?php echo Chtml::label('Indikator', 'intervensidet_indikator', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model, 'intervensidet_indikator', array('class' => 'span3', 'maxlength' => 50)); ?>
				</div>
			</div>
        </td>

    </tr>
	<tr>
		<td>
			<?php echo $form->checkBoxRow($model, 'intervensidet_aktif', array('checked' => 'intervensidet_aktif')); ?>
        </td>
	</tr>
</table>
<?php //echo $form->textFieldRow($model,'lookup_id',array('class'=>'span5')); ?>

<?php //echo $form->textFieldRow($model,'lookup_value',array('class'=>'span5','maxlength'=>200)); ?>

<?php //echo $form->textFieldRow($model,'lookup_kode',array('class'=>'span5','maxlength'=>50)); ?>

<?php //echo $form->textFieldRow($model,'lookup_urutan',array('class'=>'span5'));  ?>

<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
</div>

<?php $this->endWidget(); ?>
