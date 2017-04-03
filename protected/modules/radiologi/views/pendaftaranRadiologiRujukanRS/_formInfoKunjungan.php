<div class = "span4">
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran <span class='required'>*</span>", 'no_pendaftaran', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('ruangan_id',$modKunjungan->ruangan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('pendaftaran_id',$modKunjungan->pendaftaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'no_pendaftaran',
                                'value'=>$modKunjungan->no_pendaftaran,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteKunjungan').'",
                                                   dataType: "json",
                                                   data: {
                                                       no_pendaftaran: request.term,
                                                       ruangan_id: $("#ruangan_id").val(),
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
                                            $(this).val( ui.item.no_pendaftaran);
                                            setKunjungan(ui.item.pasienkirimkeunitlain_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Pendaftaran','class'=>'all-caps alphanumeric-only','rel'=>'tooltip','title'=>'Ketik no. pendaftaran',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                    ),
                            )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgl_pendaftaran',$modKunjungan->tgl_pendaftaran,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Instalasi Asal", 'instalasiasal_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('instalasiasal_id',$modKunjungan->instalasiasal_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('instalasiasal_nama',$modKunjungan->instalasiasal_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Ruangan Asal", 'ruanganasal_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('ruanganasal_id',$modKunjungan->ruanganasal_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('ruanganasal_nama',$modKunjungan->ruanganasal_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kelas Pelayanan Asal", 'kelaspelayanan_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('kelaspelayananasal_id',$modKunjungan->kelaspelayanan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('kelaspelayananasal_nama',$modKunjungan->kelaspelayanan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kasus Penyakit Asal", 'jeniskasuspenyakit_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('jeniskasuspenyakitasal_id',$modKunjungan->jeniskasuspenyakit_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('jeniskasuspenyakitasal_nama',$modKunjungan->jeniskasuspenyakit_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Cara Bayar", 'carabayar_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('carabayar_id',$modKunjungan->carabayar_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('carabayar_nama',$modKunjungan->carabayar_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Penjamin", 'penjamin_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('penjamin_nama',$modKunjungan->penjamin_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
	
	<div class="control-group">
        <?php echo CHtml::label("Dokter Pengirim", 'penjamin_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('dokterpengirim',$modKunjungan->gelardepan." ".$modKunjungan->nama_pegawai." ".$modKunjungan->gelarbelakang_nama,array('readonly'=>true,'class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>            
        </div>
    </div>
</div>
<div class = "span4">
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pasien_id',$modKunjungan->pasien_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'no_rekam_medik',
                                'value'=>$modKunjungan->no_rekam_medik,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteKunjungan').'",
                                                   dataType: "json",
                                                   data: {
                                                       no_rekam_medik: request.term,
                                                       ruangan_id: $("#ruangan_id").val(),
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
                                            setKunjungan(ui.item.pasienkirimkeunitlain_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Rekam Medik','class'=>'all-caps numbers-only','rel'=>'tooltip','title'=>'Ketik no. rekam medik untuk mencari data kunjungan',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    ),
                            )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pasien", 'nama_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('namadepan',$modKunjungan->namadepan,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'nama_pasien',
                                'value'=>$modKunjungan->nama_pasien,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteKunjungan').'",
                                                   dataType: "json",
                                                   data: {
                                                       nama_pasien: request.term,
                                                       ruangan_id: $("#ruangan_id").val(),
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
                                            setKunjungan(ui.item.pasienkirimkeunitlain_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('class' => 'hurufs-only','placeholder'=>'Ketik Nama Pasien','rel'=>'tooltip','title'=>'Ketik nama pasien untuk mencari data kunjungan',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    ),
                            )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_bin',$modKunjungan->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tanggal Lahir', 'tanggal_lahir', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tanggal_lahir',$modKunjungan->tanggal_lahir,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Umur", 'umur', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('umur',$modKunjungan->umur,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin',$modKunjungan->jeniskelamin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
   
	<?php /*
    <div class="control-group">
        <?php //echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php //echo CHtml::hiddenField('penanggungjawab_id',$modKunjungan->penanggungjawab_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo CHtml::textField('nama_pj',$modKunjungan->nama_pj,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php //echo CHtml::label("Status Penanggung Jawab", 'pengantar', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php //echo CHtml::textField('pengantar',$modKunjungan->pengantar,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
	*/ ?>
	<div class="control-group">
        <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien',$modKunjungan->alamat_pasien,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    
</div>
<div class = "span4">
    <div align="center">
        <?php 
        $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : Params::urlPhotoPasienDirectory()."no_photo.jpeg");
        ?>
        <img id="photo-preview" src="<?php echo $url_photopasien?>"width="128px"/> 
    </div><br>
    
</div>

<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKunjungan',
    'options'=>array(
        'title'=>'Pencarian Data Rujukan Ke Radiologi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1050,
        'height'=>610,
        'resizable'=>false,
    ),
));
    $modDialogKunjungan = new ROPasienKirimKeUnitLainV('searchDialogKunjungan');
    $modDialogKunjungan->unsetAttributes();
    if(isset($_GET['ROPasienKirimKeUnitLainV'])) {
        $modDialogKunjungan->attributes = $_GET['ROPasienKirimKeUnitLainV'];
    }
	
	$ruangan = array();
	if ( !empty($modDialogKunjungan->instalasiasal_id))
	{
		$cri = new CDbCriteria();
		$cri->addCondition("instalasi_id = '".$modDialogKunjungan->instalasiasal_id."' AND ruangan_aktif = TRUE ");
		$cri->order = 'ruangan_nama ASC';
		$ruangan = RuanganM::model()->findAll($cri);
	}
	

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datakunjungan-grid',
            'dataProvider'=>$modDialogKunjungan->searchDialogKunjungan(),
            'filter'=>$modDialogKunjungan,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectKunjungan",
                                        "onClick" => "
                                            setKunjungan($data->pasienkirimkeunitlain_id);
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
                    ),
					array(
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        'filter'=> false,
                    ),
					array(
						'name' => 'no_pendaftaran',
						'filter' => CHtml::activeTextField($modDialogKunjungan, 'no_pendaftaran', array('class' => 'alphanumeric-only'))
					),                    
                    array(
						'name' => 'no_rekam_medik',
						'filter' => CHtml::activeTextField($modDialogKunjungan, 'no_rekam_medik', array('class' => 'numbers-only'))
					),
                     array(
						'name' => 'nama_pasien',
						'filter' => CHtml::activeTextField($modDialogKunjungan, 'nama_pasien', array('class' => 'hurufs-only')),
						 'value' => '$data->namadepan." ".$data->nama_pasien'
					),                    
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=> CHtml::activeDropDownList($modDialogKunjungan,'jeniskelamin',LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
                    ),
					array(
						'header' => 'Instalasi Asal',
						'value' => '$data->instalasiasal_nama',
						'filter' => CHtml::activeDropDownList($modDialogKunjungan,'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --')),
					),
                    array(
						'header' => 'Ruangan Asal',
						'value' => '$data->ruanganasal_nama',
						'filter' => CHtml::activeDropDownList($modDialogKunjungan,'ruanganasal_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')),
					),
                   
                    array(
                        'name'=>'carabayar_id',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                        'filter'=> CHtml::activeDropDownList($modDialogKunjungan,'carabayar_id',CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif IS TRUE"),'carabayar_id','carabayar_nama'), array('empty' => '-- Pilih --')),
                    ),


            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
		. '$(".numbers-only").keyup(function(){setNumbersOnly(this);});'
		. '$(".hurufs-only").keyup(function(){setHurufsOnly(this);});'
		. '$(".alphanumeric-only").keyup(function(){setAlphaNumericOnly(this);});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>