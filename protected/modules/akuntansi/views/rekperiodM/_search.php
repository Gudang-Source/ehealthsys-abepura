<?php 
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'rekperiod-m-search',
            'type'=>'horizontal',
    )); 
?>
        <table width='100%'>
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
                </td>
                <td>
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
                </td>
                <td>
                    <div class='control-group'>
                             <?php echo $form->labelEx($model,'isclosing', array('class'=>'control-label')) ?>
                         <div class="controls">
                             <?php echo $form->checkBox($model,'isclosing', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                         </div>
                   </div>
                </td>
            </tr>
        </table>

	<div class="form-actions">
                <?php 
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit')); 
                ?>
	</div>

<?php $this->endWidget(); ?>
