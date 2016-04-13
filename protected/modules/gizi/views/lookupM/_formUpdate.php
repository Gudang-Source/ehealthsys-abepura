<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'gzlookup-m-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($model,'lookup_name'),
)); ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'lookup_type',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event );", 'maxlength'=>100 ,'readOnly'=>true)); ?>
            <?php echo $form->textFieldRow($model,'lookup_name',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
            <?php echo $form->textFieldRow($model,'lookup_value',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
            <?php echo $form->textFieldRow($model,'lookup_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'lookup_urutan',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'lookup_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>        
        <?php echo $ulang  ?>
        <?php echo $pengaturan;?>
             <?php
                $content = $this->renderPartial($this->path_tips.'tipsaddedit',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
            ?>
    </div>

<?php $this->endWidget(); ?>