<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'bank-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
	'focus' => '#AKBankM_propinsi_id',
		));
?>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>

<table width='100%'>
	<tr>
		<td>
			<div class="control-group ">
				<?php echo $form->labelEx($model, 'propinsi_id', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
						'ajax' => array('type' => 'POST',
							'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($model))),
							'update' => "#" . CHtml::activeId($model, 'kabupaten_id'),
						),
						'onchange' => "",));
					?>
					<?php /* RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
					  array('class'=>'btn btn-primary','onclick'=>"{addPropinsi(); $('#dialog-addpropinsi').dialog('open');}",
					  'id'=>'btn-addpropinsi','onkeyup'=>"return $(this).focusNextInputField(event)",
					  'rel'=>'tooltip','title'=>'Klik untuk menambah '.$model->getAttributeLabel('propinsi_id'))) */ ?>
<?php echo $form->error($model, 'propinsi_id'); ?>
				</div>
			</div>
			<div class="control-group ">
					<?php echo $form->labelEx($model, 'kabupaten_id', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->dropDownList($model, 'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
						'ajax' => array('type' => 'POST',
							'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($model))),
							'update' => "#" . CHtml::activeId($model, 'kecamatan_id'),
						),
						'onchange' => "",));
					?>
					<?php /* RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
					  array('class'=>'btn btn-primary','onclick'=>"{addKabupaten(); $('#dialog-addkabupaten').dialog('open');}",
					  'id'=>'btn-addkabupaten','onkeyup'=>"return $(this).focusNextInputField(event)",
					  'rel'=>'tooltip','title'=>'Klik untuk menambah '.$model->getAttributeLabel('kabupaten_id'))) */ ?>
<?php echo $form->error($model, 'kabupaten_id'); ?>
				</div>
			</div>


			<div class='control-group'>
					<?php echo $form->labelEx($model, 'kodepos', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'kodepos', array('class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;text-align:right;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'negara', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'negara', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'matauang_id', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->dropDownList($model, 'matauang_id', CHtml::listData(MatauangM::model()->findAll(), 'matauang_id', 'matauang'), array('style' => 'width:160px;', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)"));
?>
				</div>
			</div>  
		</td>
		<td>
			<div class='control-group'>
					<?php echo $form->labelEx($model, 'namabank', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'namabank', array('placeholder' => 'Nama Bank', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;')); ?>
				</div>
			</div>  

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'norekening', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'norekening', array('placeholder' => 'No. Rekening', 'class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;text-align:right;')); ?>
				</div>
			</div>  

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'alamatbank', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textArea($model, 'alamatbank', array('placeholder' => 'Alamat Bank', 'rows' => 3, 'cols' => 30, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:150px;')); ?>
				</div>
			</div>
			<div class='control-group'>
					<?php echo $form->labelEx($model, 'telpbank1', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'telpbank1', array('class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;text-align:right;')); ?>
				</div>
			</div>
		</td>
		<td>     
			<div class='control-group'>
					<?php echo $form->labelEx($model, 'telpbank2', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'telpbank2', array('class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;text-align:right;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'faxbank', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'faxbank', array('class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;text-align:right;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'emailbank', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'emailbank', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'website', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'website', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'cabangdari', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'cabangdari', array('class' => 'span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'bank_aktif', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->checkBox($model, 'bank_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
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
	echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
//                                    Yii::app()->createUrl($this->module->id.'/bankM/admin'), 
			'javascript:void(0);', array('class' => 'btn btn-danger',
//                                            'onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")) return false;'));
		'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
	?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Bank',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
<?php
$content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
?>
</div>

<?php $this->endWidget(); ?>