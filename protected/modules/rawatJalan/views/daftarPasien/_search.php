<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<table width="100%" class="table-condensed">
    <tr>
        <td>
            <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
           <div class="control-group ">
                <?php echo $form->labelEx($model,'tgl_pendaftaran', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
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
                <label class='control-label'>Tanggal Akhir</label>
                <div class="controls">
                    <?php 
                        $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>    
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran', 'class'=>'span3', 'maxlength'=>20)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik', 'class'=>'span3', 'maxlength'=>10)); ?>

            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien', 'class'=>'span3','maxlength'=>50)); ?>

            <?php 
            $mods = LookupM::getItems('statusperiksa');
            unset($mods['BATAL PERIKSA']);
            echo $form->dropDownListRow($model,'statusperiksa', $mods, array('empty'=>'-- Pilih --')); ?>
            <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Dokter Penanggung Jawab
                      </label>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'nama_pegawai', CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState('ruangan_id')), array('order'=>'nama_pegawai')), 'nama_pegawai', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                    </div>
                </div>   
        </td>
    </tr>
</table>
