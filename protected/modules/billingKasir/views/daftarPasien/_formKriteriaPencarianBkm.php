<legend class="rim"><i class="icon-white icon-search"></i> <?php echo  Yii::t('mds','Search Patient') ?></legend>
<table width="100%" class="table-condensed">
    <tr>
        <td>
            <div class="control-group ">
                <?php //$model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
                <?php echo CHtml::label('Tanggal Bukti Bayar','tglPendaftaran', array('class'=>'control-label inline')) ?>
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

                </div>
            </div>
            <div class="control-group ">
                <?php //$model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
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

                </div>
            </div>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                <!--<?php //echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
                <div class="controls">
                <?php //echo $form->textField($model,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>-->
                </div>
            </div>
            <?php //echo $form->textFieldRow($model,'petugasadministrasi_nama',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'petugasadministrasi_id',  CHtml::listData($model->getKasirRuanganItems(),'pegawai_id','pegawai.nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php //echo $form->textFieldRow($model,'dokterpendaftaran_nama',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php //echo $form->textFieldRow($model,'dokteradmisi_nama',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
           <!-- <div class="control-group ">
                <label for="tglbkm" class="control-label">-->
                    <?php //echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal bkm')); ?>
                   <!-- Tanggal Bkm-->
                <!--/label>
                 <div class="control-group ">-->
                <?php //$model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
                <?php // echo CHtml::label('','tglbkm', array('class'=>'control-label inline')) ?>
               <!-- <div class="controls">-->
                    <?php   
                         /*   $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_bkm_awal',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); */?>

               <!-- </div>
            </div>
            <div class="control-group ">-->
                <?php //$model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
                <?php //echo CHtml::label('Sampai Dengan','sampaiDenganbkm', array('class'=>'control-label inline')) ?>
                <!--<div class="controls">-->
                    <?php   
                            /*$this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_bkm_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
//                                                    'minDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    ));*/ ?>
                <!--</div>
            </div>-->
            <div class="control-group">
                <?php
                $carabayar = CarabayarM::model()->findAll(array(
                    'condition'=>'carabayar_aktif = true',
                    'order'=>'carabayar_nourut',
                ));
                $penjamin = PenjaminpasienM::model()->findAll(array(
                    'condition'=>'penjamin_aktif = true',
                    'order'=>'penjamin_nama',
                ));
                $pegawai = DokterV::model()->findAllByAttributes(array(
                    'instalasi_id'=>Params::INSTALASI_ID_RJ,
                    'pegawai_aktif'=>true,
                ), array(
                    'order'=>'nama_pegawai',
                ));
                foreach ($carabayar as $idx=>$item) {
                    $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                        'carabayar_id'=>$item->carabayar_id,
                        'penjamin_aktif'=>true,
                   ));
                   if (empty($penjamins)) unset($carabayar[$idx]);
                }


                echo $form->dropDownListRow($model,'carabayar_nama', CHtml::listData($carabayar, 'carabayar_nama', 'carabayar_nama'), array(
                    'empty'=>'-- Pilih --',
                    'class'=>'span3', 
                    'ajax' => array('type'=>'POST',
                        'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                        'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
                    ),
                 ));
                echo $form->dropDownListRow($model,'penjamin_nama', CHtml::listData($penjamin, 'penjamin_nama', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));
                
                ?>
                <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?> 
                <?php echo $form->dropDownListRow($model,'closingkasir_id', array(2=>'BELUM',1=>'SUDAH'),array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?> 
            </div>
        </td>
    </tr>
</table>