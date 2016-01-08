

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sadiet-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'tipediet_id'),
)); ?>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        
	<?php /* echo $form->textField($model,'tipediet_id'); */ ?>
                <?php echo $form->dropDownListRow($model,'tipediet_id',
                CHtml::listData($model->TipeDietItems, 'tipediet_id', 'tipediet_nama'),
                array('readonly'=>true),
                array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
        
	<?php /* echo $form->textField($model,'jenisdiet_id'); */ ?>
                <?php echo $form->dropDownListRow($model,'jenisdiet_id',
                CHtml::listData($model->JenisdietItems, 'jenisdiet_id', 'jenisdiet_nama'),
                array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                'empty'=>'-- Pilih --',)); ?>
              
	<?php echo $form->dropDownListRow($model,'zatgizi_id',CHtml::listData($model->ZatgiziItems,'zatgizi_id','zatgizi_nama')); ?>

	<?php echo $form->textFieldRow($model,'diet_kandungan'); ?>    
        <div class="form-actions">
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/dietM/admin'), 
                    array('class'=>'btn btn-danger',
                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Diet', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/sistemAdministrator/DietM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
            <?php
                $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->