<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'monitoring-search-form',
                'type'=>'horizontal',
)); ?>

<?php //echo $form->textFieldRow($model,'peminjamanrm_id',array('class'=>'span5')); ?>

<div class="control-group ">
    <table width="100%" class="table-condensed">
        <tr>
            <td width="30%">
                <div class="control-label">
                    <?php echo CHtml::activeCheckBox($model, 'cekTanggalAdmisi'); ?>
                    <?php echo CHtml::label('Tanggal admisi','tgl_awal'); ?>
                </div>
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
                <?php echo CHtml::label('Sampai dengan','tgl_akhir',array('class'=>'control-label')); ?>
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
            </td>
            <td>
                <div class="control-group">
                    <div class="control-label">
                        <?php echo CHtml::label('Tanggal masuk kamar','tglmasukkamar'); ?>
                    </div>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tglmasukkamar',
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
                <?php echo $form->textFieldRow($model,'nama_pasien', array('class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)', 'autofocus'=>true, 'placeholder'=>'Ketik nama pasien')); ?>
                <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData(CarabayarM::model()->CarabayarItems, 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                            'ajax' => array('type'=>'POST',
                                'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>'RKMonitoringrawatinapV')), 
                                'update'=>'#RKMonitoringrawatinapV_penjamin_id'  //selector to update
                            ),
                )); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Penjamin',' Penjamin', array('class'=>'control-label')) ?>&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'penjamin_id', PenjaminrekM::model()->getPenjaminItems() ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)', 'placeholder'=>'Ketik no. rekam medik')); ?>
                <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)', 'placeholder'=>'Ketik no. pendaftaran')); ?>
                <?php //echo $form->dropDownListRow($model,'carakeluar',LookupM::getItems('carakeluar'),array('empty'=>'-- Pilih --','onkeypress'=>'$(this).focusNextInputField(event)')); ?>
                <?php //echo $form->dropDownListRow($model,'kondisipulang',LookupM::getItems('kondisipulang'),array('empty'=>'-- Pilih --','class'=>'','onkeypress'=>'$(this).focusNextInputField(event)')); ?>
                <br>
                <?php echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData(RuanganM::getRuanganByInstalasi(Params::INSTALASI_ID_RI),'ruangan_id','ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'','onkeypress'=>'$(this).focusNextInputField(event)')); ?>
                <?php echo $form->dropDownListRow($model, 'pegawai_id', 
                        CHtml::listData(DokterV::model()->findAllByAttributes(array(
                            'instalasi_id'=>Params::INSTALASI_ID_RI,
                        ), array(
                            'order'=>'nama_pegawai asc'
                        )), 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --')); ?>
            </td>
        </tr>
    </table>
</div>

<div class="form-actions">
            <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                        Yii::app()->createUrl($this->module->id.'/Monitoring/Rawatinap'), 
                                        array('class'=>'btn btn-danger',
                                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); 
                $content = $this->renderPartial('../tips/informasi',array(),true);
                echo "&nbsp;";
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
</div>

<?php $this->endWidget(); ?>