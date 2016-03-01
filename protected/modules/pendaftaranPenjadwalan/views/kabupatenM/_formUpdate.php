<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppkabupaten-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'propinsi_id'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
		<div class="span4">
			<?php echo $form->dropDownListRow($model,'propinsi_id',CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
			<?php echo $form->textFieldRow($model,'kabupaten_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'kabupaten_namalainnya',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->checkBoxRow($model,'kabupaten_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
					Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
					array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					Yii::app()->createUrl($this->module->id.'/kabupatenM/admin'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kabupaten', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
			$this->createUrl('/pendaftaranPenjadwalan/kabupatenM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                <?php
			$content = $this->renderPartial('../tips/tipsaddedit',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
		?>
    </div>

<?php $this->endWidget(); ?>