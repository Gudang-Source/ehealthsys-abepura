<legend class="rim"><?php echo  Yii::t('mds','Search Patient') ?></legend>
<table width="100%" class="table-condensed">
    <tr>
        <td>
            <div class="control-group ">
                <?php 
                    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                    echo CHtml::label('Tanggal Pendaftaran','tglPendaftaran', array('class'=>'control-label inline')) 
                ?>
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
                                            'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                  <?php  $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
//                                                    'minDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                  <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','autofocus'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php /*
            <div class="control-group">
                <?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
                <div class="controls">
                <?php echo $form->textField($model,'nama_bin',array('placeholder'=>'Ketik Nama Panggilan','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
             * 
             */ ?>
        </td>
        <td>
            <?php //$model->statusperiksa = (!empty($model->statusperiksa)) ? $model->statusperiksa : 'SEDANG PERIKSA';?>
            <?php echo $form->dropDownListRow($model,'statusperiksa', LookupM::getItems('statusperiksa'),array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
            <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData($model->getRuanganItems(Params::INSTALASI_ID_RD), 'ruangan_id', 'ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php 
            $carabayar = CarabayarM::model()->findAll(array(
                'condition'=>'carabayar_aktif = true',
                'order'=>'carabayar_nourut',
            ));
            $penjamin = PenjaminpasienM::model()->findAll(array(
                'condition'=>'penjamin_aktif = true',
                'order'=>'penjamin_nama',
            ));
            /*
            $pegawai = DokterV::model()->findAllByAttributes(array(
                'instalasi_id'=>Params::INSTALASI_ID_RJ,
                'pegawai_aktif'=>true,
            ), array(
                'order'=>'nama_pegawai',
            )); */
            foreach ($carabayar as $idx=>$item) {
                $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                    'carabayar_id'=>$item->carabayar_id,
                    'penjamin_aktif'=>true,
               ));
               if (empty($penjamins)) unset($carabayar[$idx]);
            }
            
            // echo $form->dropDownListRow($model,'nama_pegawai', CHtml::listData($pegawai, 'nama_pegawai', 'namaLengkap'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
            echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                'empty'=>'-- Pilih --',
                'class'=>'span3', 
                'ajax' => array('type'=>'POST',
                    'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                    'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
                ),
             ));
            echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));

            ?>
        </td>
    </tr>
</table>