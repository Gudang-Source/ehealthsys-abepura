<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sabagiantubuh-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#SABagiantubuhM_namabagtubuh',
)); ?>
	<br>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<br>
	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span6">
			<?php echo $form->textFieldRow($model,'namabagtubuh',array('class'=>'span3', 'placeholder'=>'Bagian Tubuh Manusia', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
			<?php echo $form->textFieldRow($model,'bagtubuh_namalain',array('class'=>'span3', 'placeholder'=>'Bagian Tubuh Manusia', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
			<?php echo $form->textFieldRow($model,'kordinat_x',array('class'=>'span3 numbers-only', 'placeholder'=>'Koordinat axis X pada gambar tubuh', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'kordinat_y',array('class'=>'span3 numbers-only', 'placeholder'=>'Koordinat axis Y pada gambar tubuh', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                        <div>
                            <?php echo $form->checkBoxRow($model,'bagiantubuh_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                        </div>
                </div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		 <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        '',
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Bagian Tubuh',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('tab'=>'frame','modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
                <?php
		$content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<script>
function namaLain(nama)
{
	document.getElementById('SABagiantubuhM_bagtubuh_namalain').value = nama.value.toUpperCase();
}
</script>