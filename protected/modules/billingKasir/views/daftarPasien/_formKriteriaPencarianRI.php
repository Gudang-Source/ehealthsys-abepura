<legend class="rim"><?php echo  Yii::t('mds','Search Patient') ?></legend>
<table width="100%" class="table-condensed">
    <tr>
        <td width="30%">
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Admisi','tgl_awal_admisi', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php $model->tgl_awal_admisi = $format->formatDateTimeForUser($model->tgl_awal_admisi); ?>
                    <?php $format = new MyFormatter;
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tgl_awal_admisi',
                            'mode'=>'date',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); 
                    ?>
                    <?php $model->tgl_awal_admisi = $format->formatDateTimeForDb($model->tgl_awal_admisi); ?>
                </div> 
                <?php echo CHtml::label(' Sampai Dengan',' s/d', array('class'=>'control-label')) ?>

                <div class="controls"> 
                    <?php $model->tgl_akhir_admisi = $format->formatDateTimeForUser($model->tgl_akhir_admisi); ?>
                    <?php   
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tgl_akhir_admisi',
                            'mode'=>'date',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>
                    <?php $model->tgl_akhir_admisi = $format->formatDateTimeForDb($model->tgl_akhir_admisi); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                <label for="namaPasien" class="control-label">
                    <?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'rel'=>'tooltip', 'onClick'=>'cekTanggal()','data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                    Tanggal Pasien Pulang 
                </label>
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
                                            'htmlOptions'=>array('class'=>'dtPicker3', 'disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
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
                                            'htmlOptions'=>array('class'=>'dtPicker3', 'disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div>
            </div>
        </td>
        <td width="35%">
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'statusBayar', LookupM::getItems('statusbayar'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>20)); ?>
            <?php /*
            <div class="control-group">
                <?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
                <div class="controls">
                <?php echo $form->textField($model,'nama_bin',array('placeholder'=>'Ketik Nama Panggilan Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div><br/>
                
            </div>
             * 
             */ ?>
            <?php echo $form->dropDownListRow($model,'ruanganakhir_id', CHtml::listData($model->getRuanganItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php //$model->statusperiksa = (!empty($model->statusperiksa)) ? $model->statusperiksa : 'SEDANG PERIKSA';?>
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

<script type="text/javascript">
    
    document.getElementById('BKInformasikasirinappulangV_tgl_awal_date').setAttribute("style","display:none;");
    document.getElementById('BKInformasikasirinappulangV_tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal(){
        
        var checklist = $('#BKInformasikasirinappulangV_ceklis');
        var pilih = checklist.attr('checked');
        // var tgl_masuk = $(document)
        if(pilih){
            document.getElementById('BKInformasikasirinappulangV_tgl_awal').disabled = false;
            document.getElementById('BKInformasikasirinappulangV_tgl_akhir').disabled = false;
            document.getElementById('BKInformasikasirinappulangV_tgl_awal_date').setAttribute("style","display:block;");
            document.getElementById('BKInformasikasirinappulangV_tgl_akhir_date').setAttribute("style","display:block;");
        }else{
            document.getElementById('BKInformasikasirinappulangV_tgl_awal').disabled = true;
            document.getElementById('BKInformasikasirinappulangV_tgl_akhir').disabled = true;
            document.getElementById('BKInformasikasirinappulangV_tgl_awal_date').setAttribute("style","display:none;");
            document.getElementById('BKInformasikasirinappulangV_tgl_akhir_date').setAttribute("style","display:none;");
        }
    }

</script>