<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sabahanlinen-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'bahanlinen_nama'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span4">
			<?php echo $form->textFieldRow($model,'bahanlinen_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
			<?php echo $form->textFieldRow($model,'bahanlinen_namalain',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
			<?php echo $form->textFieldRow($model,'suhurekomendasi',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
			<?php echo $form->checkBoxRow($model,'bahanlinen_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class = "span4">
		</div>
		<div class="span4">
		
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                 Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan', 'onKeypress'=>'return formSubmit(this,event)')); ?>
            
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Submenu Jenis Kain',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		 <?php
                            $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
