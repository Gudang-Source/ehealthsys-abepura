<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gfpabrik-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'pabrik_kode'),
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'pabrik_kode',array('class'=>'span3','maxlength'=>20, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readOnly'=>true)); ?>
			<?php //echo $form->dropDownListRow($model, 'jenismodal', LookupM::getItems('jenismodal'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50,'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'pabrik_nama',array('class'=>'span3','maxlength'=>100,'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'pabrik_namalain',array('class'=>'span3','maxlength'=>100, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'pabrik_alamat',array('rows'=>4, 'cols'=>20, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
        <td>
            <?php // echo $form->textFieldRow($model,'pabrik_negara',array('class'=>'span3','maxlength'=>50, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'pabrik_propinsi',array('class'=>'span3','maxlength'=>100, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'pabrik_kabupaten',array('class'=>'span3','maxlength'=>100, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'pabrik_aktif'); ?>
            </div>
        </td>
    </tr>
</table>
<div class="row-fluid">
    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            $this->createUrl('create'), 
                            array('class'=>'btn btn-danger',
                                      'onclick'=>'return refreshForm(this);')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Pabrik',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php
                    $content = $this->renderPartial($this->path_tips.'tipsaddedit',array(),true);
                    $this->widget('UserTips',array('type'=>'master','content'=>$content));
            ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAPabrikM_pabrik_namalain').value = nama.value.toUpperCase();
    }
</script>