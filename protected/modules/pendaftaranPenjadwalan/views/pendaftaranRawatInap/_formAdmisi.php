<?php echo $form->hiddenField($modPasienAdmisi, 'pasienadmisi_id', array('readonly'=>true,'class'=>'span3')); ?>
<div class = "span4">
    <fieldset class="box2">
        <?php 
            if(Yii::app()->user->getState('tgltransaksimundur')){
            ?>
                    <div class="control-group ">
                            <?php echo $form->labelEx($modPasienAdmisi,'tgladmisi', array('class'=>'control-label')) ?>
                            <div class="controls">
                            <?php
                                    $modPasienAdmisi->tgladmisi = (!empty($modPasienAdmisi->tgladmisi) ? date("d/m/Y H:i:s",strtotime($modPasienAdmisi->tgladmisi)) : date("d/m/Y H:i:s"));
                                    $this->widget('MyDateTimePicker',array(
                                                                    'model'=>$modPasienAdmisi,
                                                                    'attribute'=>'tgladmisi',
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
                    echo $form->textFieldRow($modPasienAdmisi,'tgladmisi',array('readonly'=>true,'class'=>'span3 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            }
            ?>
        <?php // echo $form->dropDownListRow($model,'keadaanmasuk', LookupM::getItems('keadaanmasuk'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        <?php // echo $form->dropDownListRow($model,'transportasi', LookupM::getItems('transportasi'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

        <div class='control-group'>
            <?php echo CHtml::label("Ruangan Inap <span class='required'>*</span>", CHtml::activeId($model,'ruangan_id'),array('class'=>'control-label required'))?>                                   
            <div class='controls'>
                <?php echo $form->dropDownList($modPasienAdmisi,'ruangan_id', CHtml::listData($model->getRuanganItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama') ,
                                      array('empty'=>'-- Pilih --',
                                    'onchange'=>"setDropdownDokter(this.value);setDropDownKelasPelayanan(this.value);setKarcis();setAntrianRuanganAdmisi();setDropdownJeniskasuspenyakit(this.value);",
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3',
                                    'ajax'=>array(
                                          'type'=>'POST',
                                          'url'=>$this->createUrl('SetDropdownKamarKosong',array('encode'=>false,'namaModel'=>get_class($modPasienAdmisi))),
                                          'update'=>'#'.CHtml::activeId($modPasienAdmisi, 'kamarruangan_id'),
                                          )));?>  
                <div class="checkbox inline">
                    <i class="icon-home" style="margin:0" rel="tooltip" title="Ceklis jika Kunjungan Rumah"></i>
                    <?php echo $form->checkBox($model,'kunjunganrumah', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php // echo CHtml::activeLabel($model, 'kunjunganrumah'); ?> 
                </div><?php echo CHtml::hiddenField('max-antrian-ruangan',0, array('rel'=>'tooltip','title'=>'Maksimum Antrian Ruangan','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:25px;',)); ?>
            </div>
        </div>

        <div class="control-group">
                    <?php echo $form->LabelEx($modPasienAdmisi,'kamarruangan_id',array('class'=>'control-label'));?>
            <div class='controls'>
                <?php echo $form->dropDownList($modPasienAdmisi,'kamarruangan_id', !empty($modPasienAdmisi->ruangan_id) ? CHtml::listData(KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$modPasienAdmisi->ruangan_id,'kamarruangan_status'=>true)),'kamarruangan_id','KamarDanTempatTidur') : array() ,
                                array('empty'=>'-- Pilih --',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                    'class'=>'span2',
                                  )); ?>
                <?php echo $form->checkBox($modPasienAdmisi,'rawatgabung', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->LabelEx($modPasienAdmisi,'rawatgabung');?>
            </div>
        </div>


        <?php echo $form->dropDownListRow($model,'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($modPasienAdmisi->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
        <?php echo $form->dropDownListRow($modPasienAdmisi,'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($modPasienAdmisi->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setKarcis()", 'class'=>'span3')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modPasienAdmisi,'pegawai_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPasienAdmisi,'pegawai_id', CHtml::listData($model->getDokterItems($modPasienAdmisi->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('onchange'=>'setAntrianDokterAdmisi();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
                <?php echo CHtml::hiddenField('max-antrian-dokter',0, array('rel'=>'tooltip','title'=>'Maksimum Antrian Dokter','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:25px;','value'=>0)); ?>
            </div>
        </div>
            <div class="control-group">
            <?php echo $form->labelEx($modPasienAdmisi,'carabayar_id',array('class'=>'control-label refreshable')); ?>
                    <div class="controls">
                            <?php echo $form->dropDownList($modPasienAdmisi,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",
                                                                                                                            'ajax' => array('type'=>'POST',
                                                                                                                                    'url'=> $this->createUrl('SetDropdownPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($modPasienAdmisi))), 
                    //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
                                                                                                                                    'success'=>'function(data){$("#'.CHtml::activeId($modPasienAdmisi, "penjamin_id").'").html(data);setKarcis();}',
                                                                                                                            ),
                                                                                                                            'onchange'=>'setFormAsuransi(this.value); cekCaraBayarBadak(this.value);',
                                                                                                                            'class'=>'span3',
                            )); ?>
                    </div>
            </div>

        <?php echo $form->dropDownListRow($modPasienAdmisi,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onchange'=>'setKarcis(); setAsuransiBadakAdmisi(this.value); cekValiditasPenjaminAdmisi(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
        <?php echo $form->textAreaRow($model,'keterangan_pendaftaran',array('placeholder'=>'Catatan Khusus Pendaftaran','rows'=>2, 'cols'=>50, 'class'=>'span3 ','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </fieldset>
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-asuransi',
            'content'=>array(
                'content-asuransi'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Asuransi')).'<b> <span class="judulasuransi">Asuransi Baru</span> </b> &nbsp &nbsp <span class="refreshasuransi" style="display:none;">'
							 .CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBaru();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk input asuransi baru')).'</span>',
                    'isi'=>$this->renderPartial($this->path_view.'_formAsuransi',array(
                            'form'=>$form,
                            'model'=>$modPasienAdmisi,
                            'modPasien'=>$modPasien,
                            'modAsuransiPasien'=>$modAsuransiPasien,
                            ),true),
                    'active'=>false,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_bpjs)?'display:none':'')),
    )); ?>
    <?php echo $form->hiddenField($model,'is_bpjs', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-bpjs',
            'content'=>array(
                'content-bpjs'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Asuransi',)).'<b> BPJS '.CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'resetFormBpjs();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang form bpjs.')).'</b>',
                    'isi'=>$this->renderPartial($this->path_view.'_formAsuransiBpjs',array(
                            'form'=>$form,
                            'model'=>$modPasienAdmisi,
                            'modPasien'=>$modPasien,
                            'modRujukanBpjs'=>$modRujukanBpjs,
                            'modAsuransiPasien'=>$modAsuransiPasienBpjs,
                            'modSep'=>$modSep,
                            ),true),
                    'active'=>$model->is_bpjs,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_bpjs)?'':'display:none')),
    )); ?>
	<?php 
	$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-asubadak',
            'content'=>array(
                'content-asubadak'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Form')).'<b> <span class="judulasuransi">Asuransi PT. Badak LNG </span> </b> &nbsp &nbsp <span class="refreshasuransi" >'
							 .CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBadakReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field')).'</span>',
                    'isi'=>$this->renderPartial($this->path_view.'_formAsuransiBadak',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien'=>$modPasien,
                            'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,
                            ),true),
                    'active'=>$model->is_asubadak,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_asubadak)?'':'display:none')),
    )); 
	?>
    <?php 
	$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-asudepartemen',
            'content'=>array(
                'content-asudepartemen'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Form')).'<b> <span class="judulasuransi">Asuransi Departemen </span> </b> &nbsp &nbsp <span class="refreshasuransi" >'
							 .CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBadakReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field')).'</span>',
                    'isi'=>
					$this->renderPartial($this->path_view.'_formAsuransiDepartemen',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien'=>$modPasien,
                            'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,
                            ),true),
                    'active'=>$model->is_asudepartemen,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_asudepartemen)?'':'display:none')),
    )); 
	?>
    <?php 
	$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-asupekerja',
            'content'=>array(
                'content-asupekerja'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk Tampilkan Form')).'<b> <span class="judulasuransi">Asuransi Pekerja PT. Badak LNG </span> </b> &nbsp &nbsp <span class="refreshasuransi" >'
							 .CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'setAsuransiBadakReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field')).'</span>',
                    'isi'=>
					$this->renderPartial($this->path_view.'_formAsuransiPekerja',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien'=>$modPasien,
                            'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,
                            'modPegawai'=>$modPegawai,
                            ),true),
                    'active'=>$model->is_asupekerja,
                ),   
            ),
            'htmlOptions'=>array('style'=>(($model->is_asupekerja)?'':'display:none')),
    )); 
	?>
</div>