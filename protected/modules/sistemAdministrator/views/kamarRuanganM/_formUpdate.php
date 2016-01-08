
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakamar-ruangan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#SAKamarRuanganM_kelaspelayanan_id',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

           <?php echo $form->dropDownListRow($model,'kelaspelayanan_id',  CHtml::listData($model->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                                array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'empty'=>'-- Pilih Kelas Pelayanan --', 'ajax' => array('type'=>'POST',
                                                'url'=> Yii::app()->createUrl('ActionDynamic/GetRuangan',array('encode'=>false,'namaModel'=>'SAKamarRuanganM')), 
                                                'update'=>'#SAKamarRuanganM_ruangan_id'  //selector to update
                )                   )); ?>                    
            <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData($model->KelasRuanganItems, 'ruangan_id', 'ruangan.ruangan_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih Ruangan --')); ?>                    
            <div class="control-group"> 
                <div class="control-label">
                    <?php echo $form->labelEx($model, 'keterangan_kamar');?>
                </div>
                <div class="controls">
                <?php echo $form->dropDownList($model,'keterangan_kamar',  CHtml::listData($model->KeteranganKamarItems, 'lookup_value', 'lookup_name'),
                        array('empty'=>'-- Pilih Keterangan Kamar --',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            )); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'kamarruangan_nokamar',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2)); ?>
            <?php echo $form->textFieldRow($model,'kamarruangan_jmlbed',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);",'maxlength'=>2)); ?>
            <?php echo $form->textFieldRow($model,'kamarruangan_nobed',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2)); ?>
            <?php echo $form->checkBoxRow($model,'kamarTerpakai', array('onkeypress'=>"return $(this).focusNextInputField(event);"));?>
            <?php echo $form->checkBoxRow($model,'kamarruangan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/kamarRuanganM/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
		<?php
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kamar Ruangan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$content = $this->renderPartial('../tips/tipsaddedit',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
