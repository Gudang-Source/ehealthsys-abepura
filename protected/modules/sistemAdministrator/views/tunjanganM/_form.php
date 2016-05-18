<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kptunjangan-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#'.Chtml::activeId($model,'pangkat_id'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span6">
			<?php echo $form->dropdownListRow($model, 'pangkat_id', CHtml::listData(PangkatM::model()->findAll('pangkat_aktif = true ORDER BY pangkat_nama ASC'),'pangkat_id','pangkat_nama'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>
			<?php echo $form->dropdownListRow($model, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true ORDER BY jabatan_nama ASC'),'jabatan_id','jabatan_nama'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>
		</div>
		<div class = "span6">
			<?php echo $form->dropdownListRow($model, 'komponengaji_id', CHtml::listData(KomponengajiM::model()->findAll('komponengaji_aktif = true ORDER BY komponengaji_nama ASC'),'komponengaji_id','komponengaji_nama'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>
			<?php echo $form->textFieldRow($model,'nominaltunjangan',array('class'=>'span3 integer2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tunjangan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php 
                    $content = $this->renderPartial($this->path_tips.'tipsaddedit',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                    ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
