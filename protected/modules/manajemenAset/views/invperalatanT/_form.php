
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'guinvperalatan-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>

	

    <?php echo $form->errorSummary($model); ?>   
    <div>
    <!--<legend class="rim">Transaksi Inventarisasi Peralatan dan Mesin</legend>-->

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

        <?php $this->renderPartial('/_dataBarang', array('modBarang' => $modBarang, 'model'=>$model)); ?>
        <fieldset class="box">
            <legend class="rim">Data Inventarisasi Peralatan dan Mesin</legend>
            <table width="100%">
                <tr>
                    <td>
                        <?php echo $form->dropDownListRow($model,'pemilikbarang_id',CHtml::listData(PemilikbarangM::model()->findAll(), 'pemilikbarang_id', 'pemilikbarang_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                        <?php echo $form->hiddenField($model,'barang_id'); ?>
                        <?php echo $form->hiddenField($model,'barang_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->dropDownListRow($model,'asalaset_id',CHtml::listData(AsalasetM::model()->findAll(), 'asalaset_id', 'asalaset_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                        <?php echo $form->dropDownListRow($model,'lokasi_id',CHtml::listData(LokasiasetM::model()->findAll(), 'lokasi_id', 'lokasiaset_namalokasi'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_kode',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_noregister',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_namabrg',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_merk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_ukuran',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_bahan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    </td>
                    <td>
                        <?php echo $form->textFieldRow($model,'invperalatan_thnpembelian',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5)); ?>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model,'invperalatan_tglguna', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$model,
                                                        'attribute'=>'invperalatan_tglguna',
                                                        'mode'=>'date',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                            'maxDate' => 'd',
                                                            //
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                        ),
                                )); ?>
                                <?php echo $form->error($model, 'invperalatan_tglguna'); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model,'invperalatan_nopabrik',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_norangka',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_nomesin',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_nopolisi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_nobpkb',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_harga',array('class'=>'span2 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_akumsusut',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </td>
                    <td>
                        <?php echo $form->textAreaRow($model,'invperalatan_ket',array('rows'=>4, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_kapasitasrata',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                        <?php echo $form->checkBoxRow($model,'invperalatan_ijinoperasional', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_serftkkalibrasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_umurekonomis',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model,'invperalatan_keadaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    </td>
                </tr>
                <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php // echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </table>
        </fieldset>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
            Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
            $this->createUrl($this->module->id.'/Create'), 
            array('class'=>'btn btn-danger',
            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Create').'";} ); return false;'));  ?>
        <?php $content = $this->renderPartial('tips/transaksi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>

<?php $this->endWidget(); ?>

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
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);?>