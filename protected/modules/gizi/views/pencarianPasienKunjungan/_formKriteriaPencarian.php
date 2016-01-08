<fieldset>
    <legend class="rim"><?php echo  Yii::t('mds','Search Patient') ?></legend>
    <table class="table-condensed">
        <tr>
            <td>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'tgl_awal', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php  
                                $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                                $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_awal',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                    //
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'tgl_akhir', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'minDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'autofocus'=>true, 'placeholder'=>'Ketik no. rekam medik')); ?>
                <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Ketik no. pendaftaran')); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Ketik nama pasien')); ?>
                <?php echo $form->textFieldRow($model,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'Alias')); ?>
            </td>
        </tr>
    </table>
</fieldset>