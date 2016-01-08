<fieldset>
    <legend class="rim"><?php echo  Yii::t('mds','Search Patient') ?></legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td>
                <div class="control-group ">
                    <?php $model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
                    <?php echo CHtml::label('Tgl. Bukti Bayar','tgl_awal', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_awal',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        
                    </div>
                </div>
                <div class="control-group ">
                    <?php $model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
                    <?php echo CHtml::label('Sampai Dengan','tgl_akhir', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
//                                                    'minDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'nobuktibayar',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
                    <div class="controls">
                    <?php echo $form->textField($model,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</fieldset>