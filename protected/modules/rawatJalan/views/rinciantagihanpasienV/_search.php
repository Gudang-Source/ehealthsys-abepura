<legend class='rim'><i class="icon-white icon-search"></i> Pencarian</legend>
<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'tgl_pendaftaran', array('class'=>'control-label')) ?>
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
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); 
                        ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'tgl_akhir', array('class'=>'control-label')) ?>
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
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>    
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3', 'maxlength'=>20)); ?>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3', 'maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3', 'maxlength'=>50)); ?>
            <?php echo $form->dropDownListRow($model,'statusBayar', LookupM::getItems('statusbayar'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>20)); ?>
        </td>
    </tr>
</table>