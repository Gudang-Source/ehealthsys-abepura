
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakelompok-diagnosa-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onSubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($model,'kelompokdiagnosa_nama'),
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table width='100%'>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kelompokdiagnosa_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kelompokdiagnosa_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'kelompokdiagnosa_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
    
</table>

<div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                        array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                        $this->createUrl('admin'), 
                array('class'=>'btn btn-danger',
                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Diagnosa', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                            $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
          <?php
            $content = $this->renderPartial($this->path_view.'tips/tipsCreateUpdate',array(),true);
            $this->widget('UserTips',array('content'=>$content));
         ?>      

</div>

<?php $this->endWidget(); ?>
