<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'guinvjalan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?> 
<?php echo $form->errorSummary($model); ?>
<?php $this->renderPartial('/_dataBarang', array('modBarang' => $modBarang, 'model' => $model)); ?>
<fieldset class="box">
    <legend class="rim">Data Inventarisasi Gedung dan Bangunan</legend>
    <table width="100%">
        <tr>
            <td>
                <?php echo $form->dropDownListRow($model,'pemilikbarang_id',CHtml::listData(PemilikbarangM::model()->findAll(array('order'=>'pemilikbarang_kode')), 'pemilikbarang_id', 'pemilikbarang_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                <?php echo $form->hiddenField($model,'barang_id'); ?>
                <?php echo $form->hiddenField($model,'barang_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model,'asalaset_id',CHtml::listData(AsalasetM::model()->findAll(), 'asalaset_id', 'asalaset_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                <?php echo $form->dropDownListRow($model,'lokasi_id',CHtml::listData(LokasiasetM::model()->findAll(array('order' => 'lokasiaset_namalokasi')), 'lokasi_id', 'lokasiaset_namalokasi'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_kode', array('class' => 'span2 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_noregister', array('class' => 'span2 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_kontruksi', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model, 'invjalan_panjang', array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_lebar', array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_luas', array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_letak', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'invjalan_tgldokumen', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'invjalan_tgldokumen',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            //
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'invjalan_tgldokumen'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'invjalan_tglguna', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'invjalan_tglguna',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            //
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'invjalan_tglguna'); ?>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($model, 'invjalan_nodokumen', array('class' => 'span3 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_statustanah', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->dropDownListRow($model, 'invjalan_keadaaan', LookupM::getItems('inventariskeadaan'), array('empty'=>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_harga', array('class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style'=>'text-align: right')); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_akumsusut', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style'=>'text-align: right')); ?>
                <?php echo $form->textFieldRow($model, 'invjalan_ket', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </td>
            <?php //echo $form->textFieldRow($model,'craete_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
            <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
            <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
            <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
        </tr>
    </table>
</fieldset>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/invjalanT/admin'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>                
    <?php $content = $this->renderPartial('tips/transaksi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Inventarisasi Jalan Irigasi dan Jaringan ', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('invjalanT/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
</div>

<?php $this->endWidget(); ?>
