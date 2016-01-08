<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>


<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pasienpulang-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

<?php 
    echo $this->renderPartial('_formDataPasienPulang',array('form'=>$form,'modRD'=>$modRD)) 
?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary(array($modelPulang,$modRujukanKeluar)); ?>
        <table>
            <tr>
                <td width="50%">
                    <?php //echo $form->textFieldRow($modelPulang,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modelPulang,'tglpasienpulang', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modelPulang,
                                                    'attribute'=>'tglpasienpulang',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); ?>
                            <?php echo $form->error($modelPulang, 'tglpasienpulang'); ?> 
                        </div>
                    </div>

                    <?php echo $form->hiddenfield($modelPulang,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                    <?php echo $form->hiddenfield($modelPulang,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                    <?php //RND-3003 >>echo $form->dropDownListRow($modelPulang,'carakeluar_id', CarakeluarM::getCarakeluarItems(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'onchange'=>'carakeluar(this.value)')); ?>
                    <?php //RND-3003 >>echo $form->dropDownListRow($modelPulang,'kondisikeluar_id', KondisiKeluarM::getCarakeluarItems(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'onchange'=>'pasienmeninggal(this.value)')); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modelPulang,'carakeluar_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modelPulang,'carakeluar_id', CHtml::listData($modelPulang->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'), 
                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'onclick'=>'carakeluar(this.value);',
                                                'ajax'=>array('type'=>'POST',
                                                            'url'=>$this->createUrl('SetDropDownKondisiKeluar',array('encode'=>false,'model_nama'=>get_class($modelPulang))),
                                                            'update'=>"#".CHtml::activeId($modelPulang, 'kondisikeluar_id'),
                                                ),));?>                            
                            <?php echo $form->error($modelPulang, 'carakeluar_id'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Kondisi Pulang <font color=red>*</font>', 'kondisikeluar_id', array('class'=>'control-label'))?>
                        <?php //echo $form->labelEx($modelPulang,'kondisikeluar_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modelPulang,'kondisikeluar_id', CHtml::listData($modelPulang->getKondisikeluarItems($modelPulang->carakeluar_id), 'kondisikeluar_id', 'kondisikeluar_nama'), 
                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'pasienmeninggal(this.value);'));?>
                            <?php echo $form->error($modelPulang, 'kondisikeluar_id'); ?>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($modelPulang,'ruanganakhir_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modelPulang,'penerimapasien',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    
<!--                    <?//php if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) { ?>
                        <?//php echo $form->textFieldRow($modMasukKamar,'tglmasukkamar',array('readonly'=>true)) ?>
                        <div class="control-group ">
                            <?//php echo $form->labelEx($modMasukKamar,'lamadirawat_kamar', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?//php echo $form->textField($modMasukKamar,'lamadirawat_kamar',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> Hari
                                <?//php echo $form->hiddenField($modelPulang,'lamarawat',array('class'=>'span1','value'=>$modMasukKamar->lamadirawat_kamar, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>-->
                    <?//php } else{ ?>
                        <div class="control-group ">
                            <?php echo $form->labelEx($modelPulang,'lamarawat', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modelPulang,'lamarawat',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> Jam
                            </div>
                        </div>
                        <?php echo $form->error($modelPulang, 'lamarawat'); ?>
                   <?Php //} ?>
                     <?php //echo $form->textFieldRow($modelPulang,'satuanlamarawat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
                <td width="50%">
                   <fieldset class="">
                        <legend>
                            <?php echo CHtml::checkBox('isDead', $modelPulang->isDead, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                            Pasien Meninggal
                        </legend>
                        <div class="control-group ">
                                <?php echo $form->labelEx($modelPulang,'tgl_meninggal', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php   
                                            $this->widget('MyDateTimePicker',array(
                                                            'model'=>$modelPulang,
                                                            'attribute'=>'tgl_meninggal',
                                                            'mode'=>'datetime',
                                                            'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','disabled'=>true),
                                    )); ?>

                                </div>
                            </div>
                    </fieldset> 
                </td>
            </tr>
        </table>
        
        <?php
                echo $this->renderPartial('_formUpdateMasukKamar',array('form'=>$form,'modMasukKamar'=>$modMasukKamar));
        ?>
        
        <?php //echo $this->renderPartial('_formRujukanKeluarRD',array('form'=>$form,'modelPulang'=>$modelPulang,'modRujukanKeluar'=>$modRujukanKeluar)) ?>

		
	<div class="form-actions">
                 <?php echo CHtml::htmlButton($modelPulang->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                       Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                        array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                                        array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)')); ?>
		
	</div>

<?php $this->endWidget(); ?>

<script>
    function carakeluar(value)
    {
        if(value == "<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>")
        {
            $('#dialogPasienPulang #pakeRujukan').attr('checked',true);
            $('#dialogPasienPulang #divRujukan input').removeAttr('disabled');
            $('#dialogPasienPulang #divRujukan select').removeAttr('disabled');
            $('#dialogPasienPulang #divRujukan').slideToggle(500);
            
        }
        else
        {
            $('#dialogPasienPulang #pakeRujukan').removeAttr('checked');
            $('#dialogPasienPulang #divRujukan input').attr('disabled','true');
            $('#dialogPasienPulang #divRujukan select').attr('disabled','true');
            $('#dialogPasienPulang #divRujukan input').attr('value','');
            $('#dialogPasienPulang #divRujukan select').attr('value','');
            $('#dialogPasienPulang #divRujukan').hide(500);
            
        }
    }
    function pasienmeninggal(value)
    {
        if(value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_1 ?>" || value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_2 ?>")
        {
             $('#dialogPasienPulang #isDead').attr('checked',true);
             $('#dialogPasienPulang #RDPasienPulangT_tgl_meninggal').removeAttr('disabled');
        }
        else
        {
            $('#dialogPasienPulang #isDead').removeAttr('checked');
            $('#dialogPasienPulang #RDPasienPulangT_tgl_meninggal').attr('disabled','true');
        }
    }
    $('#dialogPasienPulang #isDead').change(function(){
        if ($(this).is(':checked')){
                $('#dialogPasienPulang #RDPasienPulangT_tgl_meninggal').removeAttr('disabled');
                $('#dialogPasienPulang #RDPasienPulangT_kondisipulang').val('<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_1 ?>');
                $('#dialogPasienPulang #RDPasienPulangT_tgl_meninggal').val('<?php echo date('Y-m-d H:i:s') ?>');
        }else{
                $('#dialogPasienPulang #RDPasienPulangT_tgl_meninggal').attr('disabled','true');
                $('#dialogPasienPulang #RDPasienPulangT_kondisipulang').val('');
                $('#dialogPasienPulang #RDPasienPulangT_tgl_meninggal').val('');
                
        }
    });
    function konfirmasi()
    {
        if(confirm('<?php echo Yii::t('mds','Do You want to cancel?') ?>'))
        {
            $('#dialogPasienPulang').dialog('close');
        }
        else
        {   
            $('#RDPasienPulangT_carakeluar_id').focus();
            return false;
        }
    }
</script>
