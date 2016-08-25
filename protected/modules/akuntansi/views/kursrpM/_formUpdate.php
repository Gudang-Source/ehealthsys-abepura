<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kursrp-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this)'),
        'focus'=>'#AKKursrpM_matauang_id',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>
        
        <table>
            <tr>
                <td>
                      <div class="control-group">
                         <?php echo $form->labelEx($model,'matauang_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php 
                                echo $form->dropDownList($model,'matauang_id', CHtml::listData($model->MataUangItems, 'matauang_id', 'matauang') ,
                                        array('style'=>'width:150px;','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); 
                            ?>
                        </div>
                    </div> 
                    
                     <div class='control-group'>
                            <?php echo $form->labelEx($model,'tglkursrp', array('class'=>'control-label')) ?>
                            <div class="controls">
                                 <?php //$minDate = (Yii::app()->user->getState('tglpemakai')) ? '' : 'd'; ?>
                                 <?php 
                                     $this->widget('MyDateTimePicker',array(
                                                            'model'=>$model,
                                                            'attribute'=>'tglkursrp',
                                                            'mode'=>'date',
                                                            'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
        //                                                        'minDate' => 'd',
//                                                                'maxDate'=>$minDate,
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                      )); 
                                 ?>
                            </div>
                    </div> 
                    
                    <div class='control-group'>
                            <?php echo $form->labelEx($model,'nilai', array('class'=>'control-label')) ?>
                            <div class="controls">
                                    <?php echo $form->textField($model,'nilai',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            </div>
                     </div> 
                    
                     <div class='control-group'>
                            <?php echo $form->labelEx($model,'rupiah', array('class'=>'control-label')) ?>
                            <div class="controls">
                                     <?php echo $form->textField($model,'rupiah',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            </div>
                      </div>
                    
                      <div class='control-group'>
                            <?php echo $form->labelEx($model,'kursrp_aktif', array('class'=>'control-label')) ?>
                            <div class="controls">
                                    <?php echo $form->checkBox($model,'kursrp_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            </div>
                       </div>                     
                </td>
            </tr>
        </table>
        
	<div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                   Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                   array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/admin'),
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kurs Rp.',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>                    
                        <?php
                            $content = $this->renderPartial('akuntansi.views.tips.tipsaddedit4b',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
	</div>

<?php $this->endWidget(); ?>
