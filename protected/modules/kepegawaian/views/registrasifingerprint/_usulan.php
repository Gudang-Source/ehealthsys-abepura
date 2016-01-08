<?php //echo $form->textFieldRow($model, 'pengangkatanpns_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php //echo $form->textFieldRow($model, 'usulanpns_tglsk', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<div class="control-group ">
    <?php echo $form->labelEx($model, 'usulanpns_tglsk', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'usulanpns_tglsk',
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
<?php echo $form->textFieldRow($model, 'usulanpns_nosk', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<div class="control-group">
    <?php echo CHtml::label('Masa Kerja','namapegawai',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($model, 'usulanpns_masakerjatahun', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Tahun</label>
        <?php echo $form->textField($model, 'usulanpns_masakerjabulan', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Bulan</label>
    </div>    
</div>
<?php //echo $form->textFieldRow($model, 'usulanpns_masakerjatahun', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php //echo $form->textFieldRow($model, 'usulanpns_masakerjabulan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'usulanpns_gajipokok', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'usulanpns_pejabatygberwenang', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>