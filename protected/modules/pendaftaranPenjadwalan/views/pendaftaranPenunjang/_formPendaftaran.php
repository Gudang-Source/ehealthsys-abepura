<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($model, 'kelaspelayanan_id', array('readonly'=>true,'class'=>'span3')); ?>
<div class = "span4">
        <?php 
            if(Yii::app()->user->getState('tgltransaksimundur')){
            ?>
                    <div class="control-group ">
                            <?php echo $form->labelEx($model,'tgl_pendaftaran', array('class'=>'control-label')) ?>
                            <div class="controls">
                            <?php
                                    $model->tgl_pendaftaran = (!empty($model->tgl_pendaftaran) ? date("d/m/Y H:i:s",strtotime($model->tgl_pendaftaran)) : date("d/m/Y H:i:s"));
                                    $this->widget('MyDateTimePicker',array(
                                                                    'model'=>$model,
                                                                    'attribute'=>'tgl_pendaftaran',
                                                                    'mode'=>'datetime',
                                                                    'options'=> array(
                                                                            'showOn' => false,
                                                                            'maxDate' => 'd',
                                                                    ),
                                                                    'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
                                    )); 
                                    ?>
                            </div>
                    </div>
            <?php
            }else{
                    echo $form->textFieldRow($model,'tgl_pendaftaran',array('readonly'=>true,'class'=>'span3 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            }
            ?>
        <div class="control-group ">
            <?php echo $form->labelEx($model,'tglrenkontrol', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                    $model->tglrenkontrol = (!empty($model->tglrenkontrol) ? date("d/m/Y H:i:s",strtotime($model->tglrenkontrol)) : null);
                    $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tglrenkontrol',
                                    'mode'=>'datetime',
                                    'options'=> array(
        //                                    'dateFormat'=>Params::DATE_FORMAT,
                                        'showOn' => false,
                                        'minDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'00/00/0000 00:00:00'),
                )); ?>
                <?php echo $form->error($model, 'tglrenkontrol'); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",
                                                        'ajax' => array('type'=>'POST',
                                                            'url'=> $this->createUrl('SetDropdownPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                                                            'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data);setKarcis();}',
                                                        ),
                                                        'onchange'=>'setFormAsuransi(this.value); cekCaraBayarBadak(this.value);',
                                                        'class'=>'span3',
        )); ?>
        <?php echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onchange'=>'setKarcis(); setAsuransiBadak(this.value); cekValiditasPenjamin(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
        <?php echo $form->textAreaRow($model,'keterangan_pendaftaran',array('placeholder'=>'Catatan Khusus Pendaftaran','rows'=>2, 'cols'=>50, 'class'=>'span3 ','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

        
</div>