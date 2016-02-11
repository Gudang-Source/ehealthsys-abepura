<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/protected/extensions/jpegcam/assets/webcam.js'); ?>
<?php
    $nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps":"");
    $alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps":"");
?>
<style>
.ui-autocomplete {
    max-height: 300px;
    overflow-y: auto;
}
</style>
<div class = "span4">
    <?php /*
    <div class="control-group">
        <?php echo CHtml::label("Dari Instalasi", 'instalasi_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::dropDownList('instalasi_id',Params::INSTALASI_ID_RJ,CHtml::listData(PPPasienAdmisiT::model()->getInstalasis(),'instalasi_id','instalasi_nama'),array('onchange'=>'setJudulDialogPasien(this.value);setPasienRJRDReset();refreshDialogKunjungan(); $(".f_rm").focus();','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
        </div>
    </div>
     * 
     */ ?>
	<div class="control-group">
        <?php echo CHtml::label("Cari NIP", 'nomorindukpegawai', array('class'=>'control-label'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'cari_nomorindukpegawai',
                                'value'=>$modPegawai->nomorindukpegawai,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompletePasienLama').'",
                                                   dataType: "json",
                                                   data: {
                                                       nomorindukpegawai: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 3,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            setPasienLama(ui.item.pasien_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogPasienBadak'),
                                'htmlOptions'=>array('placeholder'=>'Ketik NIP','rel'=>'tooltip','title'=>'Ketik NIP untuk mencari pasien',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
//                                    'onblur'=>"if($(this).val()=='') setPasienBaru(); else setPasienLama('',this.value)",
                                    'class'=>'numbers-only'),
                            )); 
            ?>
            <?php // echo $form->error($modPasien,'no_rekam_medik'); ?>                        
            <?php // echo $form->hiddenField($modPasien,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Cari ".$model->getAttributeLabel('no_pendaftaran')." <span class='required'>*</span>", 'no_pendaftaran', array('class'=>'control-label required'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'cari_no_pendaftaran',
                                'value'=>$model->no_pendaftaran,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompletePasienRJRD').'",
                                                   dataType: "json",
                                                   data: {
                                                        instalasi_id: $("#instalasi_id").val(),
                                                        no_pendaftaran: request.term,
                                                   },
                                                   success: function (data) {
                                                        response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            //setPasienRJRD(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Pendaftaran','rel'=>'tooltip','title'=>'Ketik No. pendaftaran untuk mencari pasien',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'onblur'=>"if($(this).val()=='') setPasienRJRDReset(); else setPasienRJRD('',this.value,'','')",
                                    ),
                            )); 
            ?>
            <?php echo $form->hiddenField($model,'pendaftaran_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Cari ".$modPasien->getAttributeLabel('no_rekam_medik')." <span class='required'>*</span>", 'no_rekam_medik', array('class'=>'control-label required'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'cari_no_rekam_medik',
                                'value'=>$modPasien->no_rekam_medik,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompletePasienRJRD').'",
                                                   dataType: "json",
                                                   data: {
                                                       instalasi_id: $("#instalasi_id").val(),
                                                       no_rekam_medik: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.no_rekam_medik);
                                            //setPasienRJRD(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Rekam Medik','rel'=>'tooltip','title'=>'Ketik No. RM untuk mencari pasien',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'onblur'=>"if($(this).val()=='') setPasienRJRDReset(); else setPasienRJRD('','','',this.value)",
                                    'class'=>'numbers-only f_rm'),
                            )); 
            ?>
            <?php echo $form->hiddenField($modPasien,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'no_jamkespa', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPasien, 'no_jamkespa', array('class'=>'span3')); ?>
            <?php echo $form->error($modPasien,'no_jamkespa'); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label refreshable')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:80px')); ?>   
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPasien,
                                'attribute'=>'no_identitas_pasien',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompletePasienRJRD').'",
                                                   dataType: "json",
                                                   data: {
                                                       instalasi_id: $("#instalasi_id").val(),
                                                       no_identitas_pasien: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.no_identitas_pasien);
                                            setPasienRJRD(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'No. Identitas Pasien','rel'=>'tooltip','title'=>'Ketik No. Identitas untuk masukan data / mencari pasien','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span2'),
                            )); 
            ?>

            <?php echo $form->error($modPasien,'jenisidentitas'); ?>
            <?php echo $form->error($modPasien,'no_identitas_pasien'); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'namadepan', LookupM::getItems('namadepan'),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:80px')); ?>   
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPasien,
                                'attribute'=>'nama_pasien',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompletePasienRJRD').'",
                                                   dataType: "json",
                                                   data: {
                                                       instalasi_id: $("#instalasi_id").val(),
                                                       nama_pasien: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 2,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.nama_pasien);
                                            setPasienRJRD(ui.item.pendaftaran_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'Nama Lengkap Pasien','rel'=>'tooltip','title'=>'Ketik Nama untuk masukan data / mencari pasien','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span2 '.$nama_kapital),
                            )); 
            ?>
            <?php echo $form->error($modPasien,'namadepan'); ?>
            <?php echo $form->error($modPasien,'nama_pasien'); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPasien,'nama_bin',array('placeholder'=>'Alias / Nama Panggilan Pasien','class'=>'span3 '.$nama_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($modPasien,'tempat_lahir',array('placeholder'=>'Kota/Kabupaten Kelahiran','class'=>'span3 all-caps', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'tanggal_lahir', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php   
            $this->widget('MyDateTimePicker',array(
                                    'model'=>$modPasien,
                                    'attribute'=>'tanggal_lahir',
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
            <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($model,'umur',array('placeholder'=>'00 Thn 00 Bln 00 Hr','class'=>'span3 umur', 'onblur'=>'setTglLahir(this);','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>

    <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>"setNamaDepan()", 'class'=>'')); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'golongandarah', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'golongandarah', LookupM::getItems('golongandarah'),  
                                          array('empty'=>'- Pilih -', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1')); ?>   
            <div class="radio inline">
                <div class="form-inline">
                <?php echo $form->radioButtonList($modPasien,'rhesus',LookupM::getItems('rhesus'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'rhesus')); ?>            
                </div>
            </div>
            <?php echo $form->error($modPasien, 'golongandarah'); ?>
            <?php echo $form->error($modPasien, 'rhesus'); ?>
        </div>
    </div>
    <?php echo $form->dropDownListRow($modPasien,'statusperkawinan', LookupM::getItems('statusperkawinan'),array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'setNamaDepan()','class'=>'span3')); ?>
    <?php echo $form->textFieldRow($modPasien,'nama_ayah',array('placeholder'=>'Nama Ayah Kandung Pasien','class'=>'span3 '.$nama_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    <?php echo $form->textFieldRow($modPasien,'nama_ibu',array('placeholder'=>'Nama Ibu Kandung Pasien','class'=>'span3 '.$nama_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'anakke', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPasien,'anakke', array('class'=>'span1 integer','maxlength'=>2,'onkeypress'=>"return $(this).focusNextInputField(event)", )).' dari '; ?> 
            <?php echo $form->textField($modPasien,'jumlah_bersaudara', array('class'=>'span1 integer','maxlength'=>2,'onkeypress'=>"return $(this).focusNextInputField(event)", )).' bersaudara'; ?>    
        </div>
    </div>
    
</div>
<div class = "span4">
    <?php echo $form->textAreaRow($modPasien,'alamat_pasien',array('placeholder'=>'Alamat Lengkap Pasien','rows'=>2, 'cols'=>50, 'class'=>'span3 '.$alamat_kapital, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'rt', array('class'=>'control-label inline')) ?>
        <div class="controls">
            <?php echo $form->textField($modPasien,'rt', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbers-only','maxlength'=>3,'placeholder'=>'RT')); ?>   / 
            <?php echo $form->textField($modPasien,'rw', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbers-only','maxlength'=>3,'placeholder'=>'RW')); ?>            
            <?php echo $form->error($modPasien, 'rt'); ?>
            <?php echo $form->error($modPasien, 'rw'); ?>
        </div>
    </div>

    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'propinsi_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($modPasien))),
                                            'update'=>"#".CHtml::activeId($modPasien, 'kabupaten_id'),
                                ),
                                'onchange'=>"setClearDropdownKelurahan();setClearDropdownKecamatan();",));?>
            <?php echo $form->error($modPasien, 'propinsi_id'); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'kabupaten_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'kabupaten_id', CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($modPasien))),
                                            'update'=>"#".CHtml::activeId($modPasien, 'kecamatan_id'),
                                ),
                                'onchange'=>"setClearDropdownKelurahan();",));?>
            <?php echo $form->error($modPasien, 'kabupaten_id'); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'kecamatan_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'kecamatan_id', CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKelurahan',array('encode'=>false,'model_nama'=>get_class($modPasien))),
                                            'update'=>"#".CHtml::activeId($modPasien, 'kelurahan_id'),
                                ),
                                'onchange'=>"",));?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'kelurahan_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php // $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id))?$modPasien->kelurahan_id:Yii::app()->user->getState('kelurahan_id');?>
            <?php echo $form->dropDownList($modPasien,'kelurahan_id',CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                                              array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->error($modPasien, 'kelurahan_id'); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPasien,'alamatemail',array('placeholder'=>'contoh: info@piinformasi.com','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    <?php echo $form->textFieldRow($modPasien,'no_mobile_pasien',array('placeholder'=>'No. Ponsel yang bisa dihubungi','class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
    <?php echo $form->textFieldRow($modPasien,'no_telepon_pasien',array('placeholder'=>'No. Telepon yang bisa dihubungi','class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>15)); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'pekerjaan_id', array('class'=>'control-label refreshable')) ?>
        <div class="controls">
			<?php echo $form->dropDownList($modPasien,'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'cekStatusPekerjaan(this)')); ?>
		</div>
	</div>
    <?php echo $form->dropDownListRow($modPasien,'warga_negara', LookupM::getItems('warganegara'),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'agama', array('class'=>'control-label refreshable')) ?>
        <div class="controls">
		    <?php echo $form->dropDownList($modPasien,'agama', LookupM::getItems('agama'),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
	</div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'suku_id', array('class'=>'control-label refreshable')) ?>
        <div class="controls">
                    <?php echo $form->dropDownList($modPasien,'suku_id', CHtml::listData($modPasien->getSukuItems(), 'suku_id', 'suku_nama'),array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPasien,'pendidikan_id', array('class'=>'control-label refreshable')) ?>
        <div class="controls">
                    <?php echo $form->dropDownList($modPasien,'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
    </div>
</div>
<div class = "span4">
        <?php echo  $form->hiddenField($modPasien,'photopasien',array('readonly'=>true,'class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
        <div align="center">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ambil Foto',array('{icon}'=>'<i class="icon-camera icon-white"></i>')), 
                        array('class'=>'btn btn-primary','onclick'=>"$('#dialog-addphoto').dialog('open');",
                              'id'=>'btn-addphoto','onkeyup'=>"return $(this).focusNextInputField(event)",
                              'rel'=>'tooltip','title'=>'Klik untuk Ambil Foto')) ?>
            <br>
            <?php 
            $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : Params::urlPhotoPasienDirectory()."no_photo.jpeg");
            ?>
            <img id="photo-preview" src="<?php echo $url_photopasien?>"width="84px"/> 
        </div>
        <?php /* $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-detailpasien',
            'content'=>array(
                'content-detailpasien'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan detail pasien')).'<b> Detail Pasien</b>',
                    'isi'=>$this->renderPartial($this->path_view_rj.'_formDetailPasien',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien' => $modPasien,
                            'nama_kapital' => $nama_kapital,
                            ),true),
                    'active'=>false,
                    ),   
                ),
        )); 
         * ?>
         */ ?>
	
		<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-pegawai',
            'content'=>array(
                'content-pegawai'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan data pegawai')).'<b> Pegawai Penanggung Jawab</b>'.'&nbsp'
							.CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'resetFormPegawai();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field pegawai penanggung jawab')).'</span>',
                    'isi'=>$this->renderPartial($this->path_view_rj.'_formPegawai',array(
                            'form'=>$form,
                            'model'=>$model,
                            'modPasien' => $modPasien,
                            'modPegawai' => $modPegawai,
                            ),true),
                    'active'=>!empty($modPasien->pegawai_id) ? true : false,
                    ),   
                ),
        )); ?>

</div>

<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKunjungan',
    'options'=>array(
        'title'=>'Pencarian Data Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1100,
        'height'=>800,
        'resizable'=>false,
    ),
));
    $kec_id = null;
    $modDialogKunjungan = new PPPasientindaklanjutkeriV('searchDialogUntukPendaftaranRI');
    $modDialogKunjungan->unsetAttributes();
    $format = new MyFormatter();
    // $modDialogKunjungan->instalasi_id = Params::INSTALASI_ID_RJ;
    if(isset($_GET['PPPasientindaklanjutkeriV'])) {
        $modDialogKunjungan->attributes = $_GET['PPPasientindaklanjutkeriV'];
        //$modDialogKunjungan->tanggal_lahir =  isset($_GET['PPPasientindaklanjutkeriV']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasientindaklanjutkeriV']['tanggal_lahir']) : null;
        $modDialogKunjungan->instalasi_id = $_GET['PPPasientindaklanjutkeriV']['instalasi_id'];
        
        if (isset($_GET['PPPasientindaklanjutkeriV']['kecamatan_id'])) $modDialogKunjungan->kecamatan_id = $_GET['PPPasientindaklanjutkeriV']['kecamatan_id'];
        if (isset($_GET['PPPasientindaklanjutkeriV']['kelurahan_id'])) $modDialogKunjungan->kelurahan_id = $_GET['PPPasientindaklanjutkeriV']['kelurahan_id'];
        
        /*
        $kec = KecamatanM::model()->findByAttributes(array(
            'kecamatan_id' => $modDialogKunjungan->kecamatan_id
        ));
        
        if (empty($kec)) $kec_id = null;
        else $kec_id = $kec->kecamatan_id;
         * 
         */
    }
    
    $cr = new CDbCriteria();
    if (!empty($modDialogKunjungan->instalasi_id)) $cr->compare('instalasi_id', $modDialogKunjungan->instalasi_id);
    else $cr->compare('instalasi_id', array(2,3));
    $cr->addCondition('ruangan_aktif = true');
    $cr->order = 'ruangan_nama';

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datakunjungan-grid',
            'dataProvider'=>$modDialogKunjungan->searchDialogUntukPendaftaranRI(),
            'filter'=>$modDialogKunjungan,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            setPasienRJRD($data->pendaftaran_id, \"\", \"\", \"\", $data->instalasi_id);
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
                    ),
                    'no_pendaftaran',
                    array(
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        'filter'=> false,
                    ),
                    array(
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                        'name'=>'nama_pasien',
                        'value'=>'$data->namadepan.$data->nama_pasien',
                    ),
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=>LookupM::model()->getItems('jeniskelamin'),
                    ), /*
                    array(
                        'name'=>'tanggal_lahir',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                         'filter'=>$this->widget('MyDateTimePicker',array(
                                        'model'=>$modDialogKunjungan,
                                        'attribute'=>'tanggal_lahir',
                                        'mode'=>'date',
                                        'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','id'=>'tanggal_lahir','placeholder'=>'23 Jan 1993'),
                                        ),true
                                    ),
                        'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
                    ), */
                    array(
                        'name'=>'instalasi_id',
                        'value'=>'$data->instalasi_nama',
                        'type'=>'raw',
                        'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'instalasi_id', array(2=>'Rawat Jalan', 3=>'Rawat Darurat'), array('empty'=>'-- Pilih --')), //dipilih dari instalasi form pasien
                        //'filter'=>CHtml::activeHiddenField($modDialogKunjungan,'instalasi_id'),
                    ),
                    array(
                        'name'=>'ruangan_id',
                        'header'=>'Ruangan',
                        'type'=>'raw',
                        'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll($cr), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --')), 
                    ),
//                    'kabupaten_nama',
                    array(
                        'header'=>'Nama Kecamatan',
                        'name'=>'kecamatan_id',
                        'type'=>'raw',
                        'value'=>'$data->kecamatan_nama',
                        'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'kecamatan_id', 
                                CHtml::listData(KecamatanM::model()->findAll(array(
                                    'condition'=>'kecamatan_aktif = true',
                                    'order'=>'kecamatan_nama asc',
                                )), 'kecamatan_id', 'kecamatan_nama'), array(
                                    'empty'=>'-- Pilih --',
                                )),
                    ),
                    array(
                        'header'=>'Nama Kelurahan',
                        'name'=>'kelurahan_id',
                        'type'=>'raw',
                        'value'=>'$data->kelurahan_nama',
                        'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'kelurahan_id', 
                                CHtml::listData(KelurahanM::model()->findAllByAttributes(array(
                                    'kecamatan_id'=>empty($modDialogKunjungan->kecamatan_id)?null:$modDialogKunjungan->kecamatan_id,
                                ), array(
                                    'condition'=>'kelurahan_aktif = true',
                                    'order'=>'kelurahan_nama asc',
                                )), 'kelurahan_id', 'kelurahan_nama'), array(
                                    'empty'=>'-- Pilih --',
                                )),
                    ),
                    array(
                        'header'=>'Cara Bayar',
                        'name'=>'carabayar_id',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                        'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'carabayar_id', 
                                CHtml::listData(CarabayarM::model()->findAll(array(
                                    'condition'=>'carabayar_aktif = true',
                                    'order'=>'carabayar_nama asc',
                                )), 'carabayar_id', 'carabayar_nama'), array(
                                    'empty'=>'-- Pilih --',
                                )),
                    ),
                    array(
                        'header'=>'Penjamin',
                        'name'=>'penjamin_id',
                        'type'=>'raw',
                        'value'=>'$data->penjamin_nama',
                        'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'penjamin_id', 
                                CHtml::listData(PenjaminpasienM::model()->findAllByAttributes(array(
                                    'carabayar_id'=>empty($modDialogKunjungan->carabayar_id)?null:$modDialogKunjungan->carabayar_id,
                                ), array(
                                    'condition'=>'penjamin_aktif = true',
                                    'order'=>'penjamin_nama asc',
                                )), 'carabayar_id', 'penjamin_nama'), array(
                                    'empty'=>'-- Pilih --',
                                )),
                    ),
                    //'carabayar_nama',
                    //'penjamin_nama',
                    'statusperiksa',
                    
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
            }',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogPasienBadak',
        'options'=>array(
            'title'=>'Pencarian Data Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>800,
            'resizable'=>false,
        ),
    ));
	
	$modDataPasien = new PPPasienM('searchDialog');
    $modDataPasien->unsetAttributes();
    $format = new MyFormatter();
    $modDataPasien->ispasienluar = FALSE;
    if(isset($_GET['PPPasienM'])) {
        $modDataPasien->attributes = $_GET['PPPasienM'];
//        $modDataPasien->tanggal_lahir =  isset($_GET['PPPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['PPPasienM']['tanggal_lahir']) : null;
        $modDataPasien->cari_kelurahan_nama = $_GET['PPPasienM']['cari_kelurahan_nama'];
        $modDataPasien->cari_kecamatan_nama = $_GET['PPPasienM']['cari_kecamatan_nama'];
        $modDataPasien->nomorindukpegawai = $_GET['PPPasienM']['nomorindukpegawai'];
        
    }
	
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pasienbadak-m-grid',
            'dataProvider'=>$modDataPasien->searchDialogBadak(),
            'filter'=>$modDataPasien,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                            setPasienLama(\"$data->pasien_id\");
                                            $(\"#dialogPasienBadak\").dialog(\"close\");
                                        "))',
                    ),
                    array(
                        'header'=>'NIP',
						'name'=> 'nomorindukpegawai',
                        'type'=>'raw',
                        'value'=>'$data->pegawai->nomorindukpegawai',
                    ),
                    'no_rekam_medik',
                    'nama_pasien',
                    'nama_bin',
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=> LookupM::model()->getItems('jeniskelamin'),
                        'value'=>'$data->jeniskelamin'
                    ),
                
//                    array(
//                        'name'=>'tanggal_lahir',
//                        'type'=>'raw',
//                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
//                    ),
                    array(
                        'name'=>'tanggal_lahir',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                        'filter'=>$this->widget('MyDateTimePicker',array(
                                        'model'=>$modDataPasien,
                                        'attribute'=>'tanggal_lahir',
                                        'mode'=>'date',
                                        'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','id'=>'tanggal_lahir','placeholder'=>'23 Jan 1993'),
                                        ),true
                                    ),
                        'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
                    ),
                    'alamat_pasien',
                    'rw',
                    'rt',
                    array(
                        'header'=>'Nama Kelurahan',
                        'name'=>'cari_kelurahan_nama',
                        'type'=>'raw',
                        'value'=>'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""'
                    ),
                    array(
                        'header'=>'Nama Kecamatan',
                        'name'=>'cari_kecamatan_nama',
                        'type'=>'raw',
                        'value'=>'$data->kecamatan->kecamatan_nama'
                    ),
                    'norm_lama',
                    array(
                        'name'=>'statusrekammedis',
                        'type'=>'raw',
                        'filter'=> LookupM::getItems('statusrekammedis'),
                        'value'=>'$data->statusrekammedis',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
                
            
            }',
    ));
    $this->endWidget();
    ?>

<?php
//================= dialog webcam =====================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialog-addphoto',
    'options'=>array(
        'title'=>'Ambil Photo',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>360,
        'minHeight'=>420,
        'resizable'=>false,
    ),
));
?>

<div id="dialog-content" style="text-align: center;">
    <div id="cam-preview"></div>
    <br>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-cog icon-white"></i>')),array('rel'=>'tooltip','title'=>'Konfigurasi Kamera','class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'webcam.configure();','style'=>'font-size:10px; width:32px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ambil',array('{icon}'=>'<i class="icon-camera icon-white"></i>')),array('id'=>'btn_ambil_gambar','class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'ambilGambar();','style'=>'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-download-alt icon-white"></i>')),array('id'=>'btn_simpan_gambar','disabled'=>true,'class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'simpanGambar();','style'=>'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('id'=>'btn_ulang_gambar','class'=>'btn btn-mini btn-danger', 'type'=>'button', 'onclick'=>'ulangGambar();','style'=>'font-size:10px; width:76px; height:24px;')); ?>
    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
<?php
    $random=rand(0000000000000000, 9999999999999999);
?>
/**
 * ambil gambar pada webcam
 * @returns {Boolean}
 */
function ambilGambar(){
    webcam.freeze();
    $("#btn_ambil_gambar").attr("disabled",true);
    $("#btn_simpan_gambar").removeAttr("disabled");
}
/**
 * menyimpan / meng-upload gambar
 * @returns {undefined}
 */
function simpanGambar() {
    $("#btn_simpan_gambar").attr("disabled",true);
    document.getElementById('upload_results').innerHTML = '<h3>Proses Penyimpanan...</h3>';
//    webcam.snap(); << sering bugs hasil photo blank putih
    webcam.upload();
}
/**
 * mengulang pengambilan gambar
 * @returns {undefined}
 */
function ulangGambar(){
    $("#btn_ambil_gambar").removeAttr("disabled");
    $("#btn_simpan_gambar").attr("disabled",true);
    webcam.reset();
}
/**
 * keterangan setelah berhasil ambil gambar webcam
 * @returns {Boolean}
 */
function suksesUpload(msg) {
    if (msg == 'OK'){
            $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            setTimeout(function(){
                document.getElementById('upload_results').innerHTML = '';
                $("#<?php echo CHtml::activeId($modPasien,'photopasien') ?>").val("<?php echo $random ?>.jpg")
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_".$random;?>.jpg');
                $('#dialog-addphoto').dialog('close');
            },3000);
            
    }else{
        myAlert("PHP Error: " + msg);
    }
}
$( document ).ready(function(){
    /**
    * set webcam
    * @returns {Boolean}
    */
    function setWebcam(){
        webcam.set_api_url( 'index.php?r=photoWebCam/jpegcam.saveJpg&random=<?php echo $random;?>&pathTumbs=<?php echo Params::pathPasienTumbsDirectory();?>&path=<?php echo Params::pathPasienDirectory(); ?>' );
        webcam.set_quality( 90 );
        webcam.set_shutter_sound( false );
        webcam.set_stealth( 1 );
        webcam.set_swf_url('<?php echo Yii::app()->baseUrl.'/js/jpegcam/assets/'; ?>webcam.swf');
        $('#cam-preview').append(webcam.get_html(303, 320));
        webcam.set_hook( 'onComplete', 'suksesUpload' );
    }
    setWebcam();
});
</script>

<?php //================= end dialog webcam ===================== ?>