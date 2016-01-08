
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sadetailnapza-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onSubmit'=>'return validasi()'),
        'focus'=>'#SADetailnapzaM_napza_id',
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'napza_id',CHtml::listData($model->NapzaItems, 'napza_id', 'napza_nama'),array('class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'detailnapza_nama',array('class'=>'span3 required', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'detailnapza_namalain',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'detailnapza_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
</table>
<?php //echo $form->textFieldRow($model,'napza_id',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
        $this->createUrl('admin'), 
        array('class'=>'btn btn-danger',
              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Detail Napza', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php
        $content = $this->renderPartial($this->path_view.'tips/tipsCreateUpdate',array(),true);
        $this->widget('UserTips',array('content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SADetailnapzaM_detailnapza_namalain').value = nama.value.toUpperCase();
    }
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