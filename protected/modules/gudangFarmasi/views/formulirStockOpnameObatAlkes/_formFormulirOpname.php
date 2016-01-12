<div class="row-fluid">
<div class="span4">
    <div class="control-group ">
        <?php echo $form->labelEx($model, 'tglformulir', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php   
				echo $form->textField($model,'tglformulir',array('class'=>'span3','readonly'=>true))
//                $model->tglformulir = (!empty($model->tglformulir) ? date("d/m/Y H:i:s",strtotime($model->tglformulir)) : null);
//                $this->widget('MyDateTimePicker',array(
//                    'model'=>$model,
//                    'attribute'=>'tglformulir',
//                    'mode'=>'datetime',
//                    'options'=> array(
////                                            'dateFormat'=>Params::DATE_FORMAT,
//                        'showOn' => false,
//                        'maxDate' => 'd',
//                        'yearRange'=> "-150:+0",
//                    ),
//                    'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
//                    ),
//            )); ?>
        </div>
    </div>
    <?php //echo $form->textFieldRow($model, 'noformulir', array('readonly'=>true,'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
</div>
<div class="span4">
    <?php echo $form->textFieldRow($model, 'totalvolume', array('class' => 'span3 integer', 'readonly' => true,'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
</div>
<div class="span4">
    <?php echo $form->textFieldRow($model, 'totalharga', array('class' => 'span3 integer', 'readonly' => true,'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
</div>
</div>