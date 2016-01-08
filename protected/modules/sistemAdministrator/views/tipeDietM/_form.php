

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'satipediet-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'tipediet_nama'),
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'tipediet_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>25)); ?>
            <?php echo $form->textFieldRow($model,'tipediet_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>25)); ?>
            <?php echo $form->checkBoxRow($model,'tipediet_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
	<div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'submit', 'id'=>'btn_simpan','onKeypress'=>'return formSubmit(this,event)','onClick'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/TipeDietM/admin'), 
                        array('class'=>'btn btn-danger',
                        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
		<?php
                    $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tipe Diet', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/sistemAdministrator/TipeDietM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
        </div>

<?php $this->endWidget(); ?>
