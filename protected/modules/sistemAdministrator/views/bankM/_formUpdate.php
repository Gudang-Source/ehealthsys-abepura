<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php 
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'bank-m-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
            'focus'=>'#',
    )); 
?>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>
        
    <table>
        <tr>
            <td>
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'propinsi_id', array('class'=>'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->textField($model,'propinsi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:150px;')); ?>
                     </div>
                </div>  
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'kabupaten_id', array('class'=>'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->textField($model,'kabupaten_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:150px;')); ?>
                     </div>
                </div>  
                
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'kodepos', array('class'=>'control-label')) ?>
                     <div class="controls">
                          <?php echo $form->textField($model,'kodepos',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'style'=>'width:150px;')); ?>
                     </div>
                </div> 
                                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'negara', array('class'=>'control-label')) ?>
                     <div class="controls">
                          <?php echo $form->textField($model,'negara',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'style'=>'width:150px;')); ?>
                     </div>
                </div> 
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'matauang_id', array('class'=>'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->textField($model,'matauang_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:150px;')); ?>
                     </div>
                </div>  
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'namabank', array('class'=>'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->textField($model,'namabank',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'style'=>'width:150px;')); ?>
                     </div>
                </div>  
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'norekening', array('class'=>'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->textField($model,'norekening',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'style'=>'width:150px;')); ?>
                     </div>
                </div>  
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'alamatbank', array('class'=>'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->textArea($model,'alamatbank',array('rows'=>4, 'cols'=>30, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                     </div>
                </div>  
                  
            </td>
            <td>     
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'telpbank1', array('class'=>'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->textField($model,'telpbank1',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'style'=>'width:150px;')); ?>
                     </div>
                </div> 
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'telpbank2', array('class'=>'control-label')) ?>
                     <div class="controls">
                          <?php echo $form->textField($model,'telpbank2',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'style'=>'width:150px;')); ?>
                     </div>
                </div> 
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'faxbank', array('class'=>'control-label')) ?>
                     <div class="controls">
                            <?php echo $form->textField($model,'faxbank',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'style'=>'width:150px;')); ?>
                     </div>
                </div> 
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'emailbank', array('class'=>'control-label')) ?>
                     <div class="controls">
                          <?php echo $form->textField($model,'emailbank',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'style'=>'width:150px;')); ?>
                     </div>
                </div> 
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'website', array('class'=>'control-label')) ?>
                     <div class="controls">
                          <?php echo $form->textField($model,'website',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'style'=>'width:150px;')); ?>
                     </div>
                </div> 
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'cabangdari', array('class'=>'control-label')) ?>
                     <div class="controls">
                          <?php echo $form->textField($model,'cabangdari',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'style'=>'width:150px;')); ?>
                     </div>
                </div> 
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'telpbank2', array('class'=>'control-label')) ?>
                     <div class="controls">
                          <?php echo $form->textField($model,'telpbank2',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'style'=>'width:150px;')); ?>
                     </div>
                </div> 
                
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'bank_aktif', array('class'=>'control-label')) ?>
                     <div class="controls">
                          <?php echo $form->checkBox($model,'bank_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                     </div>
                </div>                 
            </td>
        </tr>
    </table>
        <div class="form-actions">
                <?php 
                        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                         array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); 
                ?>
                <?php 
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/'.bankM.'/admin'), 
                                        array('class'=>'btn btn-danger',
                                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
               ?>
               <?php $this->widget('UserTips',array('type'=>'update'));?>
	</div>

<?php $this->endWidget(); ?>
