
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'falookup-m-form',
		'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onSubmit'=>'return validasi()','onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'lookup_name'),
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->hiddenField($model,'lookup_type',array('class'=>'span2 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <div class="control-group">
                <?php echo CHtml::label('Signa Obat <font color="red">*</font>', 'lookup_name',array('class'=>'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textField($model,'lookup_name',array('class'=>'span4','maxlength'=>200)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Signa Obat Lainnya <font color="red">*</font>', 'lookup_value',array('class'=>'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textField($model,'lookup_value',array('class'=>'span4','maxlength'=>200)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'lookup_urutan',array('class'=>'span1','maxlength'=>9)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'lookup_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
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

        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Signa Obat', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                   $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>

        <?php $content = $this->renderPartial($this->path_view.'tips/tipsCreateUpdate',array(),true);
                        $this->widget('UserTips',array('content'=>$content)); ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
function validasi(){
    var x = 0;
    $('input.required,textarea.required,select.required').each(function(){
        if($(this).val()==""){
            $(this).addClass("error");
            x++;
        }else{
            $(this).removeClass("error");
        }
    });
    if(x>0){
      return false;  
    }else{
        return true;
    }
    
}
</script>
