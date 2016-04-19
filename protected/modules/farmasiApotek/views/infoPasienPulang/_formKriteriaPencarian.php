<fieldset class="box">
    <legend class="rim"><i class="icon-search icon-white"></i> <?php echo  Yii::t('mds','Search Patient') ?></legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td>
                <div class="control-group ">
                    <?php //$model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <?php echo CHtml::label('Tanggal Awal','tgl_awal', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                        <?php   
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
                        <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php //$model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <?php echo CHtml::label('Tanggal Akhir','tgl_akhir', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php //echo $form->textFieldRow($model,'nama_bin',array('placeholder'=>'Nama Panggilan Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'No. Rekam Medik','class'=>'span3', 'autofocus'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Nama Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
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
                    echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
                    ?>
                
                    <?php if ($this->action->id == 'indexRJ'): ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Ruangan','ruangan_id',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true, 'instalasi_id'=>array(Params::INSTALASI_ID_RJ)), array('order'=>'instalasi_id, ruangan_nama ASC')),'ruangan_id', 'ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div> 
                    <?php endif; ?> 
                
                    <?php if($this->action->id == 'indexRI'): ?>
                    <?php echo $form->dropDownListRow($model, 'kelaspelayanan_id', 
                            CHtml::listData(KelaspelayananM::model()->findAllByAttributes(array(
                                'kelaspelayanan_aktif'=>true,
                            ), array(
                                'order'=>'kelaspelayanan_nama',
                            )), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Ruangan','ruangan_id',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true, 'instalasi_id'=>array(Params::INSTALASI_ID_RI)), array('order'=>'instalasi_id, ruangan_nama ASC')),'ruangan_id', 'ruangan_nama'),
                                    array(
                                        'class'=>'span3',
                                        'empty'=>'-- Pilih --',
                                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                                        'ajax' => array('type'=>'POST',
                                            'url'=> $this->createUrl('/actionDynamic/getKamarRuangan',array('encode'=>false,'namaModel'=>get_class($model))), 
                                            'success'=>'function(data){$("#'.CHtml::activeId($model, "kamarruangan_id").'").html(data); }',
                                        ),
                                    )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kamar Ruangan','kamarruangan_id',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'kamarruangan_id', array(),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div> 
                    <?php endif; ?>
                    <?php echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData(
                            DokterV::model()->findAll(array(
                                'order'=>'nama_pegawai'
                            )),'pegawai_id','namaLengkap'), array(
                                'empty'=>'-- Pilih--', 'class'=>'span3',
                    )); ?>
            </td>
            
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	<?php  
        $content = $this->renderPartial('../tips/informasiPasienPulang',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</fieldset>