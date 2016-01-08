<?php
    $this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'readOnlyNoRm'=>true));
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'suratketerangan-r-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php //echo $form->errorSummary($model); ?>
    
    <table width="100%">
        <tr>
            <td>
                <?php echo $form->hiddenField($model,'pendaftaran_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($model,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($model,'profilrs_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model,'judulsurat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                <?php echo $form->dropDownListRow($model,'jenissurat_id',  CHtml::listData($model->getJenisSurat(), 'jenissurat_id', 'jenissurat_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model,'tglsurat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'nourutsurat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model,'nomorsurat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->dropDownListRow($model,'mengetahui_surat',  CHtml::listData($model->getMengetahuiItems(), 'nama_pegawai', 'nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php //echo $form->textFieldRow($model,'jmlprint_surat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
    </table>

    
    <div class="form-actions">
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')) : 
                                                         Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                
    </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
function printSuratKematian()
{    
   window.open('<?php echo $this->createUrl('suratKeterangan/PrintSuratKematian') ?>','printsuratkematian','left=100,top=100,width=700,height=450,scrollbars=1');
}
</script>