<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kpjenispenilaian-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span6">
			<?php // echo $form->textFieldRow($model,'jabatan_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'jenispenilaian_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($model,'jenispenilaian_namalain',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->dropDownListRow($model, 'jenispenilaian_sifat', LookupM::getItems('sifatjenispenilaian'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 25,'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
			<div class="control-group">
				<?php echo CHtml::label('Status','lookup_name', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'jenispenilaian_aktif'); ?>
				</div>
			</div>
		</div>
		<div class = "span6">
			<?php // echo $form->checkBoxRow($model,'jenispenilaian_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Penilaian',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php
            $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
        ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('KPJenispenilaianM_jenispenilaian_namalain').value = nama.value.toUpperCase();
    }
</script>