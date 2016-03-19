<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php 
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'rekperiod-m-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
            'focus'=>'#AKRekperiodM_deskripsi',
    )); 
?>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>
        
        <table>
            <tr>
                <td>
                   <div class='control-group'>
                              <?php echo $form->labelEx($model,'perideawal', array('class'=>'control-label')) ?>
                         <div class="controls">
                             <?php //$minDate = (Yii::app()->user->getState('tglpemakai')) ? '' : 'd'; ?>
                             <?php 
                                 $this->widget('MyDateTimePicker',array(
                                                        'model'=>$model,
                                                        'attribute'=>'perideawal',
                                                        'mode'=>'date',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
    //                                                        'minDate' => 'd',
//                                                            'maxDate'=>$minDate,
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                  )); 
                             ?>
                         </div>
                   </div> 
                    
                   <div class='control-group'>
                                <?php echo $form->labelEx($model,'sampaidgn', array('class'=>'control-label')) ?>
                         <div class="controls">
                                <?php //$minDate = (Yii::app()->user->getState('tglpemakai')) ? '' : 'd'; ?>
                             <?php 
                                 $this->widget('MyDateTimePicker',array(
                                                        'model'=>$model,
                                                        'attribute'=>'sampaidgn',
                                                        'mode'=>'date',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
    //                                                        'minDate' => 'd',
//                                                            'maxDate'=>$minDate,
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                  )); 
                             ?>
                         </div>
                   </div> 
                    
                   <div class='control-group'>
                             <?php echo $form->labelEx($model,'deskripsi', array('class'=>'control-label')) ?>
                         <div class="controls">
                             <?php echo $form->textField($model,'deskripsi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                         </div>
                   </div> 
                    
<!--                   <div class='control-group'>
                             <?php //echo $form->labelEx($model,'isclosing', array('class'=>'control-label')) ?>
                         <div class="controls">
                             <?php //echo $form->checkBox($model,'isclosing', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                         </div>
                   </div> -->
                    
                </td>
            </tr>
        </table>
        
	<div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/rekperiodM/admin'), 
                                    array('class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Rekening Periode',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
                        <?php
                            $content = $this->renderPartial('akuntansi.views.tips.tipsaddedit4b',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
        </div>

<?php $this->endWidget(); ?>
