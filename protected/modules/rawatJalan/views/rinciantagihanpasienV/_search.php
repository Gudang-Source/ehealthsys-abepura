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
            <div class = "control-group">
                    <?php echo Chtml::label("No Pendaftaran",'no_pendaftaran', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php 
                        $ini = ModulK::model()->findByPk(Yii::app()->session['modul_id']);
                        $pr = Params::getPrefixNoPendaftaran();

                        if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI)
                        {
                            $prefix = array(
                                0 => Params::PREFIX_RAWAT_DARURAT,
                                1 => Params::PREFIX_RAWAT_INAP,
                                2 => Params::PREFIX_RAWAT_JALAN
                            );                                            
                        }else{
                            if (count($pr[$ini->modul_key])>0){
                                $prefix = array(
                                    0 => $pr[$ini->modul_key]
                                );
                            }else{
                                $prefix='';
                            }
                        }
                        echo $form->dropDownList($model,'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix),array('class'=>'numbers-only', 'style'=>'width:75px;')); 
                    ?>
                    <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10,'placeholder'=>'Ketik No. Pendaftaran')); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbers-only', 'maxlength'=>6)); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3 hurufs-only', 'maxlength'=>50)); ?>
            <?php echo $form->dropDownListRow($model, 'pegawai_id', 
                        CHtml::listData(DokterV::model()->findAllByAttributes(array(
                            'instalasi_id'=>Yii::app()->user->getState('instalasi_id'),
                        ), array(
                            'order'=>'nama_pegawai asc'
                        )), 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --')); ?>
        </td>
        <td>
            <?php 
            $carabayar = CarabayarM::model()->findAll(array(
                'condition'=>'carabayar_aktif = true',
                'order'=>'carabayar_nama ASC',
            ));
            foreach ($carabayar as $idx=>$item) {
                $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                    'carabayar_id'=>$item->carabayar_id,
                    'penjamin_aktif'=>true,
               ));
               if (empty($penjamins)) unset($carabayar[$idx]);
            }
            $penjamin = PenjaminpasienM::model()->findAll(array(
                'condition'=>'penjamin_aktif = true',
                'order'=>'penjamin_nama',
            ));
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
            <?php echo $form->dropDownListRow($model,'statusperiksa', Params::statusPeriksa(), array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>50)); ?>
            <?php echo $form->dropDownListRow($model,'statusBayar', LookupM::getItems('statusbayar'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>20)); ?>
        </td>
    </tr>
</table>