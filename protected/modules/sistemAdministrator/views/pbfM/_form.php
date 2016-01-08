<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gfpbf-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'pbf_kode'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <table width="100%">
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model,'pbf_kode',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                    <?php echo $form->textFieldRow($model,'pbf_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textFieldRow($model,'pbf_singkatan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                </td>
                <td>
                    <?php echo $form->textAreaRow($model,'pbf_alamat',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($model,'pbf_propinsi',
                                   CHtml::listData($model->PropinsiItems, 'propinsi_nama', 'propinsi_nama'),
                                   array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                   'empty'=>'-- Pilih --',)); ?>
                    <?php echo $form->dropDownListRow($model,'pbf_kabupaten',
                                   CHtml::listData($model->KabupatenItems, 'kabupaten_nama', 'kabupaten_nama'),
                                   array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                   'empty'=>'-- Pilih --',)); ?>
                    <div>
                        <?php echo $form->checkBoxRow($model,'pbf_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                </td>
            </tr>
        </table>
                    
                    
                    
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl('admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php
                            $content = $this->renderPartial($this->path_view.'tips.tipsCreateUpdate',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pbf', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
        </div>

<?php $this->endWidget(); ?>
