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
                <label class='control-label'>Sampai Dengan</label>
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
        </td>
        <td>
            <?php //echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran', 'class'=>'span3', 'maxlength'=>20)); ?>
            <div class = "control-group">
                    <?php echo Chtml::label("No Pendaftaran",'no_pendaftaran', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php 
                        $prefix = array(
                           0 => Params::PREFIX_RAWAT_JALAN
                        );
                        echo $form->dropDownList($model,'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix),array('class'=>'numbers-only', 'style'=>'width:75px;')); 
                    ?>
                    <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10,'placeholder'=>'Ketik No. Pendaftaran')); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik', 'class'=>'span3 numbers-only', 'maxlength'=>6)); ?>

            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien', 'class'=>'span3 hurufs-only','maxlength'=>50)); ?>
        </td>
        <td>
            

            <?php 
            $mods = LookupM::getItems('statusperiksa');
            unset($mods['BATAL PERIKSA']);
            echo $form->dropDownListRow($model,'statusperiksa', $mods, array('empty'=>'-- Pilih --')); ?>
            <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Dokter Pemeriksa
                      </label>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'nama_pegawai', CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState('ruangan_id'), 'pegawai_aktif'=>true), array('order'=>'nama_pegawai')), 'nama_pegawai', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                    </div>
                </div>
            <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                                                'ajax' => array('type'=>'POST',
                                                    'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                                                    'update'=>'#'.CHtml::activeId($model,'penjamin_id').''  //selector to update
                                                ),
                        )); ?>

            <?php echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
        </td>
    </tr>
</table>
