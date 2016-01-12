<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kpindikatorperilaku-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span6">
			<?php echo $form->dropDownListRow($model,'jabatan_id', CHtml::listData(SAJabatanM::model()->getJabatanItems(), 'jabatan_id', 'jabatan_nama') ,
											array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
			<?php echo $form->dropDownListRow($model,'jenispenilaian_id', CHtml::listData(SAJenispenilaianM::model()->getJenisPenilaianItems(), 'jenispenilaian_id', 'jenispenilaian_nama') ,
											array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
			<?php echo $form->dropDownListRow($model,'kompetensi_id', CHtml::listData(SAKompetensiM::model()->getKompetensiItems(), 'kompetensi_id', 'kompetensi_nama') ,
											array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
			<div class="control-group">
				<?php echo CHtml::label('Status','indikatorperilaku_aktif', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'indikatorperilaku_aktif'); ?>
				</div>
			</div>
		</div>
		<div class = "span6">
		<?php echo $form->textAreaRow($model,'indikatorperilaku_nama',array('rows'=>2, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"namaLain(this)",'maxlength'=>300)); ?> 
		<?php echo $form->textAreaRow($model,'indikatorperilaku_namalain',array('rows'=>2, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Indikator Perilaku',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAIndikatorperilakuM_indikatorperilaku_namalain').value = nama.value.toUpperCase();
    }
</script>