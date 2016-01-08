<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pegawai-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('enctype'=>'multipart/form-data','onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); 
$arrMenu = array();
//array_push($arrMenu,array('label'=>Yii::t('mds','Kontrak').' Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="white-container">
    <legend class="rim2">Kontrak <b>Pegawai</b></legend>
    <fieldset id="fieldsetPasien">

            <?php echo $form->errorSummary(array($modKontrak,$modPegawai)); ?>
            <fieldset class="box">
                <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
                <legend class="rim">Data Pegawai</legend>
                <table width="100%" class="table-condensed">
                    <tr>
                        <td width="50%">
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'Nomor Induk Pegawai <span class="required">*</span>', array('class'=>'control-label required')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai,'nomorindukpegawai',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'placeholder'=>'Nomor Induk Pegawai')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'jenisidentitas', array('class'=>'control-label')) ?>
                                <div class="controls inline">
                                    <?php echo $form->dropDownList($modPegawai,'jenisidentitas',  LookupM::getItems('jenisidentitas'),
                                            array('empty'=>'-- Pilih --', 'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);",)
                                            ); ?>
                                    <?php echo $form->textField($modPegawai,'noidentitas',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'placeholder'=>'No. Identitas')); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'nama_pegawai', array('class'=>'control-label')) ?>
                                <div class="controls inline">
                                    <?php echo $form->dropDownList($modPegawai, 'gelardepan', CHtml::listData($modPegawai->getGelarDepanItems(), 'lookup_name', 'lookup_value'),
                                          array('empty'=>'-Pilih-', 'style'=>"width:60px",'onkeypress'=>"return $(this).focusNextInputField(event);",)); ?>
                                    <?php echo $form->textField($modPegawai,'nama_pegawai',array('placeholder'=>'Nama Pegawai','class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'placeholder'=>'Nama Pegawai')); ?>
                                    <?php echo $form->dropDownList($modPegawai, 'gelarbelakang_id', CHtml::listData($modPegawai->getGelarBelakangItems(), 'gelarbelakang_id', 'gelarbelakang_nama'),
                                          array('empty'=>'-Pilih-', 'style'=>"width:90px", 'onkeypress'=>"return $(this).focusNextInputField(event);",)); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'nama_keluarga', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai,'nama_keluarga',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>'Nama Keluarga')); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                    <?php echo $form->radioButtonListInlineRow($modPegawai,'jeniskelamin', LookupM::getItems('jeniskelamin'),
                                            array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'tempatlahir_pegawai', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai,'tempatlahir_pegawai',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30,'placeholder'=>'Kota/Kabupaten Tempat Lahir')); ?>

                                </div>
                            </div>
                            <div class="control-group ">
                                                <?php echo $form->labelEx($modPegawai,'tgl_lahirpegawai', array('class'=>'control-label')) ?>
                                                <div class="controls">
                                                        <?php   
                                                        $modPegawai->tgl_lahirpegawai = (!empty($modPegawai->tgl_lahirpegawai) ? date("d/m/Y",strtotime($modPegawai->tgl_lahirpegawai)) : null);
                                                        $this->widget('MyDateTimePicker',array(
                                                                                                        'model'=>$modPegawai,
                                                                                                        'attribute'=>'tgl_lahirpegawai',
                                                                                                        'mode'=>'date',
                                                                                                        'options'=> array(
                                //                                            'dateFormat'=>Params::DATE_FORMAT,
                                                                                                                'showOn' => false,
                                                                                                                'maxDate' => 'd',
                                                                                                                'onkeyup'=>"js:function(){setUmur(this.value);}",
                                                                                                                'onSelect'=>'js:function(){setUmur(this.value);}',
                                                                                                                'yearRange'=> "-150:+0",
                                                                                                        ),
                                                                                                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onblur'=>'setUmur(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)"
                                                                                                        ),
                                                        )); ?>
                                                        <?php echo $form->error($modPegawai, 'tgl_lahirpegawai'); ?>
                                                </div>
                                        </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'umur_bekerja', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai,'umur_bekerja',array('placeholder'=>'00 Thn 00 Bln 00 Hr','class'=>'span3 umur', 'onblur'=>'setTglLahir(this);','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                    <?php echo $form->dropDownListRow($modPegawai,'statusperkawinan', LookupM::getItems('statusperkawinan'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                            </div>
                            <div class="control-group ">
                                                        <?php echo $form->labelEx($modPegawai,'propinsi_id', array('class'=>'control-label')) ?>
                                                        <div class="controls">
                                                                <?php echo $form->dropDownList($modPegawai,'propinsi_id', CHtml::listData($modPegawai->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                                                                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                                                                                        'ajax'=>array('type'=>'POST',
                                                                                                                                'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($modPegawai))),
                                                                                                                                'update'=>"#".CHtml::activeId($modPegawai, 'kabupaten_id'),
                                                                                                        ),
                                                                                                        'onchange'=>"setClearDropdownKelurahan();setClearDropdownKecamatan();",));?>
                                                                <?php echo $form->error($modPegawai, 'propinsi_id'); ?>
                                                        </div>
                                                </div>
                                                <div class="control-group ">
                                                        <?php echo $form->labelEx($modPegawai,'kabupaten_id', array('class'=>'control-label')) ?>
                                                        <div class="controls">
                                                                <?php echo $form->dropDownList($modPegawai,'kabupaten_id', CHtml::listData($modPegawai->getKabupatenItems($modPegawai->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), 
                                                                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                                                                                        'ajax'=>array('type'=>'POST',
                                                                                                                                'url'=>$this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($modPegawai))),
                                                                                                                                'update'=>"#".CHtml::activeId($modPegawai, 'kecamatan_id'),
                                                                                                        ),
                                                                                                        'onchange'=>"setClearDropdownKelurahan();",));?>
                                                                <?php echo $form->error($modPegawai, 'kabupaten_id'); ?>
                                                        </div>
                                                </div>
                                                <div class="control-group ">
                                                        <?php echo $form->labelEx($modPegawai,'kecamatan_id', array('class'=>'control-label')) ?>
                                                        <div class="controls">
                                                                <?php echo $form->dropDownList($modPegawai,'kecamatan_id', CHtml::listData($modPegawai->getKecamatanItems($modPegawai->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), 
                                                                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                                                                                        'ajax'=>array('type'=>'POST',
                                                                                                                                'url'=>$this->createUrl('SetDropdownKelurahan',array('encode'=>false,'model_nama'=>get_class($modPegawai))),
                                                                                                                                'update'=>"#".CHtml::activeId($modPegawai, 'kelurahan_id'),
                                                                                                        ),
                                                                                                        'onchange'=>"",));?>
                                                        </div>
                                                </div>
                                                <div class="control-group ">
                                                        <?php echo $form->labelEx($modPegawai,'kelurahan_id', array('class'=>'control-label')) ?>
                                                        <div class="controls">
                                                                <?php echo $form->dropDownList($modPegawai,'kelurahan_id',CHtml::listData($modPegawai->getKelurahanItems($modPegawai->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                                                                                                                                  array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                                                <?php echo $form->error($modPegawai, 'kelurahan_id'); ?>
                                                        </div>
                                                </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'alamat_pegawai', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modPegawai,'alamat_pegawai',array('rows'=>4, 'cols'=>50, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Alamat Lengkap Pegawai')); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                                        <?php echo $form->dropDownListRow($modPegawai,'agama', LookupM::getItems('agama'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'golongandarah', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php //echo $form->textField($modPegawai,'golongandarah',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>2)); ?>
                                    <?php echo $form->dropDownList($modPegawai,'golongandarah', LookupM::getItems('golongandarah'),  
                                                                  array('empty'=>'Pilih', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1')); ?>
                                    <?php //echo $form->textField($modPegawai,'rhesus',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                                    <div class="radio inline">
                                        <div class="form-inline">
                                        <?php echo $form->radioButtonList($modPegawai,'rhesus',LookupM::getItems('rhesus'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>            
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'statuskepemilikanrumah_id', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php //echo $form->textField($modPegawai,'statusrumah',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                                    <div class="radio inline">
                                        <div class="form-inline">
                                        <?php 
                                        echo $form->radioButtonList($modPegawai,'statuskepemilikanrumah_id', CHtml::listData($modPegawai->getStatuskepemilikanrumahItems(), 'statuskepemilikanrumah_id', 'statuskepemilikanrumah_nama'),  
                                                                  array('empty'=>'Pilih', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if(!empty($modPegawai->photopegawai)){ 
                                $url = Params::urlPelamarPhotoTumbsDirectory();
                                $image = $url."kecil_".$modPegawai->photopegawai;
                             ?>
                            <div class="control-group">
                                <p class="control-label">Photo Pegawai </p> 
                                <div class="controls">
                                    <img src="<?php echo $image; ?>"  width="120" height="120" />
                                </div>
                            </div>

                            <?php } else { ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'photopegawai', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activeFileField($modPegawai, 'photopegawai'); ?>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'nomobile_pegawai', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai,'nomobile_pegawai',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>'No. Ponsel pegawai')); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'notelp_pegawai', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai,'notelp_pegawai',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>'No. Telepon Pegawai')); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'alamatemail', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai,'alamatemail',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>'contoh : example@gmail.com')); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'profilperusahaan_id', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPegawai, 'profilrs_id', CHtml::listData($modPegawai->getRumahSakitItems(), 'profilrs_id', 'nama_rumahsakit'),
                                            array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3'));?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'kelompokpegawai_id', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPegawai, 'kelompokpegawai_id', CHtml::listData($modPegawai->getKelompokPegawaiItems_unfiltered(), 'kelompokpegawai_id', 'kelompokpegawai_nama'),
                                            array('empty'=>'-- Kelompok Pegawai --','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3'));?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'pangkat_id', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPegawai, 'pangkat_id', CHtml::listData($modPegawai->getPangkatItems(), 'pangkat_id', 'pangkat_nama'),
                                            array('empty'=>'-- Pangkat --','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3'));?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'tglditerima', array('class'=>'control-label required','label'=>'Tanggal Diterima <span style="color:red">*</span>')) ?>
                                <div class="controls">
									<?php   
                                                                        $modPegawai->tglditerima = (!empty($modPegawai->tglditerima) ? date("d/m/Y",strtotime($modPegawai->tglditerima)) : null);
                                                                        $this->widget('MyDateTimePicker',array(
                                                                                                        'model'=>$modPegawai,
                                                                                                        'attribute'=>'tglditerima',
                                                                                                        'mode'=>'date',
                                                                                                        'options'=> array(
                                                                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                                                                                'maxDate' => 'd',                                                        
                                                                                                                'yearRange'=> "-150:+0",
                                                                                                        ),
                                                                                                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                                                                                                        ),
                                    )); ?>    
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'tglberhenti', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php   
                                                                        $modPegawai->tglberhenti = (!empty($modPegawai->tglberhenti) ? date("d/m/Y",strtotime($modPegawai->tglberhenti)) : null);
                                                                        $this->widget('MyDateTimePicker',array(
                                                                                                        'model'=>$modPegawai,
                                                                                                        'attribute'=>'tglberhenti',
                                                                                                        'mode'=>'date',
                                                                                                        'options'=> array(
                                                                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                                                                                'maxDate' => 'd',                                                        
                                                                                                                'yearRange'=> "-150:+0",
                                                                                                        ),
                                                                                                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                                                                        ),
                                    )); ?>            
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'pendidikan_id', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPegawai, 'pendidikan_id', CHtml::listData($modPegawai->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'),
                                            array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'pendkualifikasi_id', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPegawai, 'pendkualifikasi_id', CHtml::listData($modPegawai->getPendKualifikasiItems(), 'pendkualifikasi_id', 'pendkualifikasi_nama'),
                                            array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'npwp', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai,'npwp',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'placeholder'=>'Nomor Pokok Wajib Pajak')); ?>                            
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'warganegara_pegawai', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPegawai, 'warganegara_pegawai', LookupM::getItems('warganegara'),
                                            array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'suku_id', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPegawai, 'suku_id', CHtml::listData($modPegawai->getSukuItems(), 'suku_id', 'suku_nama'),
                                            array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'kategoripegawai', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPegawai, 'kategoripegawai', CHtml::listData($modPegawai->Kategoripegawai, 'lookup_name','lookup_name'),
                                            array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'statuspegawai', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php //echo $form->textField($modPegawai,'statuspegawai',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                                    <?php echo $form->dropDownList($modPegawai, 'statuspegawai', CHtml::listData($modPegawai->StatusPegawai, 'lookup_name', 'lookup_name'),
                                            array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'norekening', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai,'norekening',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'placeholder'=>'No. Rekening Pegawai')); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawai,'nofingerprint', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawai,'nofingerprint',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30,'placeholder'=>'No. Fingerprint Pegawai')); ?>

                                </div>
                            </div>
                        </td>
                    </tr>               
                </table>
            </fieldset>
            <?php echo $this->renderPartial('_formKontrak', array('modPegawai'=>$modPegawai,'modKontrak'=>$modKontrak,'form'=>$form)); ?>               
            <div class="form-actions">
                                    <?php
                                            $disableSave = isset($_GET['idKaryawan']) ? true : false;
                                            echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                                    array('class'=>'btn btn-primary','id'=>'btn_submit', 'type'=>'button','onclick'=>'cekValiditas()', 'onKeypress'=>'return cekValiditas()','disabled'=>$disableSave)); ?>

                                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
											$this->createUrl($this->id.'/kontrakPelamar'), 
											array('class'=>'btn btn-danger',
												  'onclick'=>'return refreshForm(this);')); ?>
            </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
<?php
if(!empty($_GET['idPelamar'])){
    ?><script type="text/javascript">setTimeout('usia()', 1000);</script><?php
}
$urlLamaKontrak = $this->createUrl('GetLamaKontrak');
$idTagUmur = CHtml::activeId($modPegawai,'umur');
$js = <<< JS
function lamaKontrak()
{
    var tgl_awal = $('#KPKontrakKaryawanR_tglmulaikontrak').val(); 
    var tgl_akhir = $('#KPKontrakKaryawanR_tglakhirkontrak').val(); 
    if(tgl_awal != '' && tgl_akhir != ''){
        $.post("${urlLamaKontrak}",{tgl_awal:tgl_awal, tgl_akhir:tgl_akhir},
            function(data){
               $('#KPKontrakKaryawanR_lamakontrak').val(data.kontrak);
        },"json");
    }
}
function clearKabupaten()
{
    $('#KPPegawaiM_kabupaten_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
JS;
Yii::app()->clientScript->registerScript('form',$js,CClientScript::POS_HEAD);
?>
<?php echo $this->renderPartial('_jsFunctions', array('modPegawai'=>$modPegawai)); ?>