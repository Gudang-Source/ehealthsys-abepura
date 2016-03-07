<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sajenispemeriksaanlab-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span4">
			<?php echo $form->textFieldRow($model,'jenispemeriksaanlab_urutan',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'jenispemeriksaanlab_kode',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'jenispemeriksaanlab_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
			<?php echo $form->textFieldRow($model,'jenispemeriksaanlab_namalainnya',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'jenispemeriksaanlab_kelompok',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->checkBoxRow($model,'jenispemeriksaanlab_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php //echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Pemeriksaan Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Pemeriksaan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php 
		$content = $this->renderPartial($this->path_view.'tips/tipsCreate',array(),true);
		$this->widget('UserTips',array('content'=>$content));
		?>
		</div>
	</div>
<?php $this->endWidget(); ?>
