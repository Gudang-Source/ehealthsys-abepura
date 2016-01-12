<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gfatc-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <div class = "span4">
                <?php echo $form->textFieldRow($model,'atc_kode',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                <?php echo $form->textFieldRow($model,'atc_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->textFieldRow($model,'atc_namalain',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event); ", 'maxlength'=>100)); ?>
                <?php echo $form->textFieldRow($model,'atc_singkatan',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            </div>
            <div class="span4">
                <?php echo $form->textFieldRow($model,'atc_ddd',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model, 'atc_units', LookupM::getItems('unitatc'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50,'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model, 'atc_admr', LookupM::getItems('routeofadmatc'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50,'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
            <div class = "span4">
                <?php echo $form->textAreaRow($model,'atc_note',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                <?php echo $form->checkBoxRow($model,'atc_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Atc',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('GFAtcM_atc_namalain').value = nama.value.toUpperCase();
    }
</script>