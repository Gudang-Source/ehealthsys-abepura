<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'golongan-gaji-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#KPHariKerjaGolM_harikerjagol_id',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
<?php //echo $form->textFieldRow($model,'harikerjagol_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->dropDownListRow($model,'kelompokpegawai_id', CHtml::listData(KPKelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true ORDER BY kelompokpegawai_nama ASC'), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", "empty"=>'-- Pilih --')); ?>
  <?php //echo $form->textFieldRow($model,'tglpresensi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'periodeharikerjaawl', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'periodeharikerjaawl',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                         ),
                )); ?> 
                </div>
            </div>
    <?php //echo $form->textFieldRow($model,'tglpresensi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'periodehariakhir', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'periodehariakhir',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                         ),
                )); ?> 
                </div>
            </div>
        
          <?php //echo $form->textFieldRow($model,'tglpresensi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'periodeharikerjaakhir', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'periodeharikerjaakhir',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                         ),
                )); ?> 
                </div>
            </div>
        
        <?php echo $form->textFieldRow($model,'jmlharibln',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right')); ?>
        <div>
                <?php echo $form->checkBoxRow($model,'harikerjagol_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
	<div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                       <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/hariKerjaGolM/create'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Hari Kerja Golongan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                    $this->createUrl('hariKerjaGolM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        <?php
                            $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit4b',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
    </div>

<?php $this->endWidget(); ?>
