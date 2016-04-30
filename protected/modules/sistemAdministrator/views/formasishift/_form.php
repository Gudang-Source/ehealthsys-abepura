<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saformasishift-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span4">
			<?php echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'shift_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'jmlformasi',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->checkBoxRow($model,'formasishift_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class="span4">
				
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl('create'), 
                                    array('class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Formasi Shift',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		 <?php
                            $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
