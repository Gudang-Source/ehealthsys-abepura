<style>
    .control-group{
        padding:5px;
    }
    td .control-group:hover{
        background-color: #B5C1D7;
    }
    .additional-text{
        display:inline-block;
        font-size: 11px;
    }
    </style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<div class='white-container'>
    <?php // $this->renderPartial('/_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
    <?php $this->renderPartial('persalinan.views.pemeriksaanPasienPersalinan._dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); ?>
    <?php $this->renderPartial('persalinan.views.pemeriksaanPasienPersalinan._jsFunctions',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); ?>
    <?php $this->renderPartial('_persalinan', array('modPersalinan'=>$modPersalinan)); ?>
    <?php $this->renderPartial('_kelahiran', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modKelahiran'=>$modKelahiran)); ?>
    <fieldset class='box'>
        <legend class='rim'>Kelahiran Bayi</legend>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array( 
            'id'=>'pskelahiranbayi-t-form', 
            'enableAjaxValidation'=>false, 
                'type'=>'horizontal', 
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'), 
                'focus'=>'#', 
        )); ?>
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
        <?php echo CHtml::hiddenField('kelahiranbayi_id', $model->kelahiranbayi_id); ?>
        <table width='100%' class='table-condensed'>
            <tr>
                <td width="45%">
                    <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'persalinan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'nourutbayi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'tgllahirbayi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'tgllahirbayi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgllahirbayi',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                    //
                                    'onkeypress' => "js:function(){getUmur(this);}",
                                    'onSelect' => 'js:function(){getUmur(this);}',
                                    'yearRange' => "-60:+0",
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tgllahirbayi'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'jamlahir', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'jamlahir',
                                'mode' => 'time',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                    //
                                    'onkeypress' => "js:function(){getUmur(this);}",
                                    'onSelect' => 'js:function(){getUmur(this);}',
                                    'yearRange' => "-60:+0",
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'jamlahir'); ?>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($model,'jamlahir',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($model,'namabayi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100, 'placeholder'=>'Bayi Ny. '.$modPasien->nama_pasien)); ?>
                    <?php //echo $form->textFieldRow($model,'jeniskelamin',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                    <?php echo $form->radioButtonListInlineRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php //echo $form->textFieldRow($model,'bb_gram',array('maxlength'=>3,'class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'tb_cm',array('maxlength'=>3, 'class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'bb_gram', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'bb_gram', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>Gram</div><br/>
                            <?php echo $form->error($model, 'bb_gram'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'tb_cm', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'tb_cm', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>CM</div><br/>
                            <?php echo $form->error($model, 'tb_cm'); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php 
                    if ($model->isNewRecord){echo $form->checkBoxRow($model,'islahirtunggal', array('onkeypress'=>"return $(this).focusNextInputField(event);")); } else {
                        echo $form->checkBoxRow($model,'islahirtunggal', array('disabled'=>'disabled', 'onkeypress'=>"return $(this).focusNextInputField(event);"));}?>
                    <?php echo $form->dropDownListRow($model,'lahirkembar',  LookupM::getItems('lahirkembar'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 

                    ?>
                        <?php 
                        echo CHtml::hiddenField('jmlkembar',$model->jmlkembar); ?>
                    <?php echo $form->textFieldRow($model,'jmlkembar',array('maxlength'=>3, 'class'=>'span3 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textAreaRow($model,'kelainanbayi',array('rows'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textAreaRow($model,'warnakulit',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textAreaRow($model,'denyutjantung',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textAreaRow($model,'aktivitasotot',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textAreaRow($model,'responrefleks',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textAreaRow($model,'pernapasan',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'interpretasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->textAreaRow($model,'catatan_bayi',array('rows'=>2, 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                     ?>
                    <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                </tr>
        </table>
    </fieldset>
    <fieldset class='box'>
        <?php $this->renderPartial('_metodeappgard', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'model'=>$model, 'appgards'=>$appgards, 'model'=>$model, 'form'=>$form)); ?><div class="form">
        <div class="form-actions"> 
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) :  
                Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), 
                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),  
                Yii::app()->createUrl($this->module->id.'/daftarPasien/index'),  
                array('class'=>'btn btn-danger', 
                'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            <?php
                $content = $this->renderPartial('../kelahiranbayiT/tips/transaksi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
<?php 
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>

        <?php    Yii::app()->clientScript->registerScript('kembar',"
    $(document).ready(function(){
        var jmlkembar = $('#PSKelahiranbayiT_jmlkembar').val();
        if (jmlkembar > 1){
            $('#PSKelahiranbayiT_jmlkembar').attr('disabled','disabled');
            $('#PSKelahiranbayiT_lahirkembar').attr('disabled','disabled');
            $('#PSKelahiranbayiT_islahirtunggal').attr('disabled','disabled');
        }
        
        $('#PSKelahiranbayiT_jmlkembar').attr('disabled','disabled');
        $('#PSKelahiranbayiT_lahirkembar').attr('disabled','disabled');

        $('#PSKelahiranbayiT_islahirtunggal').change(function(){

           if (!($(this).is(':checked'))){
                
                $('#PSKelahiranbayiT_jmlkembar').removeAttr('disabled');
                $('#PSKelahiranbayiT_lahirkembar').removeAttr('disabled');
               
            }
            else{
                
                $('#PSKelahiranbayiT_jmlkembar').attr('disabled','disabled');
                $('#PSKelahiranbayiT_lahirkembar').attr('disabled','disabled');
                               
            }
        });
    });
",  CClientScript::POS_BEGIN); ?>

       