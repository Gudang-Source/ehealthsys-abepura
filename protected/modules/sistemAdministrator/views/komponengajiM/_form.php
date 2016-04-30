
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'komponengaji-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#KomponengajiM_nourutgaji',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'nourutgaji',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'komponengaji_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'komponengaji_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'komponengaji_singkt',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
        <div class = "control-group" >  
            <?php echo $form->labelEx($model,'penerimaan', array('class'=>'control-label')); ?>
            <div class = "control">                
                <?php echo '&nbsp;&nbsp;'.$form->radioButton($model,'penerimaan', array('onkeypress'=>"return $(this).focusNextInputField(event);", 'name'=>"komponen")); ?>            
            </div>
        </div>
        <div class = "control-group" >  
            <?php echo $form->labelEx($model,'ispotongan', array('class'=>'control-label')); ?>
            <div class = "control">                
                <?php echo '&nbsp;&nbsp;'.$form->radioButton($model,'ispotongan', array('onkeypress'=>"return $(this).focusNextInputField(event);", 'name'=>"komponen")); ?>            
            </div>
        </div>
        
            <?php echo $form->checkBoxRow($model,'komponengaji_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);", 'name'=>"aktif")); ?>
	<div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl('create'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Komponen Gaji', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                    $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        <?php
                            $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
    </div>

<?php $this->endWidget(); ?>
