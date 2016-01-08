<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakonfigfarmasi-k-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <div class = "span4">
        <?php // echo $form->textFieldRow($model,'tglberlaku',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <div class="control-label">
                <?php echo CHtml::label('Tanggal Berlaku','tgl_awal'); ?>
            </div>
            <div class="controls">
                <?php   
                        $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tglberlaku',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                )); 
                        ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model,'persenppn',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'persenpph',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->checkBoxRow($model,'bayarlangsung', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'formulajasadokter',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        <?php echo $form->textFieldRow($model,'formulajasaparamedis',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        <?php echo $form->dropDownListRow($model,'hargaygdigunakan', LookupM::getItems('hargaygdigunakan'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model,'ri_persjualppn',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'rd_persjualppn',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'rj_persjualppn',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
    <div class = "span4">
        <?php echo $form->textFieldRow($model,'pembulatanharga',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php // RND-7953 echo $form->textFieldRow($model,'pembulatanretail',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'administrasi',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'persjualbebas',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php // RND-7953 echo $form->textFieldRow($model,'admracikan',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->checkBoxRow($model,'hargajualglobal', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'persdiskpasien',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->checkBoxRow($model,'otomatismargin', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'persenmargin',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php // echo $form->dropDownListRow($model,'metodeantrian', LookupM::getItems('metodeantrian'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		<?php echo $form->checkBoxRow($model,'konfigfarmasi_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
	<div class="span4">
		<?php echo $form->textAreaRow($model,'pesandistruk',array('rows'=>6, 'cols'=>50, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($model,'pesandifaktur',array('rows'=>6, 'cols'=>50, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        
	</div>
</div>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), 
                                    array('class'=>'btn btn-danger',
                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php
//                    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Konfigurasi Farmasi', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
                    $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
        </div>

<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerScript('angka', "
$(document).ready(function () {
        $('.numbersOnly').keypress(function(event) {
                var charCode = (event.which) ? event.which : event.keyCode
                if ((charCode >= 48 && charCode <= 57)
                        || charCode == 46
                        || charCode == 44)
                        return true;
                return false;
        });
});
", CClientScript::POS_HEAD); ?>
