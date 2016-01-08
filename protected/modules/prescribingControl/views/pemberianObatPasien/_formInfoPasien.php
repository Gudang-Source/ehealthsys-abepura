<div class = "span4">
    <div class="control-group">
        <?php echo CHtml::label("Instalasi <font style=color:red;> * </font>", 'instalasi_id', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php 
             if(!empty($modInfoRI->pendaftaran_id)){ 
//                 echo CHtml::hiddenField('instalasi_id',$modInfoRI->ruangan->instalasi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                 echo CHtml::textField('instalasi_nama',$modInfoRI->instalasi_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
             }else{
                echo CHtml::dropDownList('instalasi_id',$modInfoRI->instalasi_id,CHtml::listData(PCInstalasiM::model()->getInstalasiPelayanans(),'instalasi_id','instalasi_nama'),array('onchange'=>'setInfoPasienReset();refreshDialogInfoPasien();','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",)); 
             }
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::hiddenField('pendaftaran_id',$modInfoRI->pendaftaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php
            $pasienadmisi_id = (isset($modInfoRI->pasienadmisi_id) ? $modInfoRI->pasienadmisi_id : null);
            echo CHtml::hiddenField('pasienadmisi_id',$pasienadmisi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo CHtml::label("Barcode", 'cari_pendaftaran_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('cari_pendaftaran_id',$modInfoRI->pendaftaran_id,array('onchange'=>"if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')",'class'=>'span3', 'placeholder'=>'Scan Barcode Pada Print Status','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran <font style=color:red;> * </font>", 'no_pendaftaran', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'no_pendaftaran',
                                'value'=>$modInfoRI->no_pendaftaran,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteInfoPasien').'",
                                                   dataType: "json",
                                                   data: {
                                                       no_pendaftaran: request.term,
                                                       instalasi_id: $("#instalasi_id").val(),
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
                                            setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Pendaftaran','class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik no. pendaftaran / klik icon untuk mencari data kunjungan',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                    ),
                            )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tanggal. Pendaftaran', 'tgl_pendaftaran', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgl_pendaftaran',$modInfoRI->tgl_pendaftaran,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo CHtml::hiddenField('tglselesaiperiksa',$modInfoRI->tglselesaiperiksa,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Poliklinik / Ruangan", 'ruangan_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php 
                $ruangan_id = null;
                if(isset($modInfoRI->ruangan_id)){
                    $ruangan_id = $modInfoRI->ruangan_id;
                }

                echo CHtml::hiddenField('ruangan_id',$ruangan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <?php echo CHtml::textField('ruangan_nama',$modInfoRI->ruangan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('kelaspelayanan_id',$modInfoRI->kelaspelayanan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('kelaspelayanan_nama',$modInfoRI->kelaspelayanan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kasus Penyakit", 'jeniskasuspenyakit_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('jeniskasuspenyakit_id',$modInfoRI->jeniskasuspenyakit_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('jeniskasuspenyakit_nama',$modInfoRI->jeniskasuspenyakit_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Cara Bayar", 'carabayar_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('carabayar_id',$modInfoRI->carabayar_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('carabayar_nama',$modInfoRI->carabayar_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Penjamin", 'penjamin_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penjamin_id',$modInfoRI->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('penjamin_nama',$modInfoRI->penjamin_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class = "span4">
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik <font style=color:red;> * </font>", 'no_rekam_medik', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pasien_id',$modInfoRI->pasien_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php // echo CHtml::textField('no_rekam_medik',$modInfoRI->no_rekam_medik,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'no_rekam_medik',
                                'value'=>$modInfoRI->no_rekam_medik,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteInfoPasien').'",
                                                   dataType: "json",
                                                   data: {
                                                       no_rekam_medik: request.term,
                                                       instalasi_id: $("#instalasi_id").val(),
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
                                            setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Rekam Medik','rel'=>'tooltip','title'=>'Ketik no. rekam medik untuk mencari data kunjungan',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'class'=>'numbers-only',
                                    ),
                            )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pasien <font style=color:red;> * </font>", 'nama_pasien', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('namadepan',$modInfoRI->namadepan,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'nama_pasien',
                                'value'=>$modInfoRI->nama_pasien,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteInfoPasien').'",
                                                   dataType: "json",
                                                   data: {
                                                       nama_pasien: request.term,
                                                       instalasi_id: $("#instalasi_id").val(),
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
                                            $(this).val( ui.item.value);
                                            setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'Ketik Nama Pasien','rel'=>'tooltip','title'=>'Ketik nama pasien untuk mencari data kunjungan',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    ),
                            )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_bin',$modInfoRI->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tanggal Lahir', 'tanggal_lahir', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tanggal_lahir',$modInfoRI->tanggal_lahir,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Umur", 'umur', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('umur',$modInfoRI->umur,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin',$modInfoRI->jeniskelamin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penanggungjawab_id',$modInfoRI->penanggungjawab_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('nama_pj',$modInfoRI->nama_pj,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
    <div class="control-group">
        <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien',$modInfoRI->alamat_pasien,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>

<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Kunjungan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogPasien = new PCPasienM('searchPasienRumahsakitV');
    $modDialogPasien->unsetAttributes();
    $modDialogPasien->idInstalasi = Params::INSTALASI_ID_RJ;
    if(isset($_GET['PCPasienM'])) {
        $modDialogPasien->attributes = $_GET['PCPasienM'];
        $modDialogPasien->idInstalasi = (isset($_GET['PCPasienM']['idInstalasi']) ? $_GET['PCPasienM']['idInstalasi'] : null);
        $modDialogPasien->no_pendaftaran = (isset($_GET['PCPasienM']['no_pendaftaran']) ? $_GET['PCPasienM']['no_pendaftaran'] : "");
        $modDialogPasien->tgl_pendaftaran_cari = (isset($_GET['PCPasienM']['tgl_pendaftaran_cari']) ? $_GET['PCPasienM']['tgl_pendaftaran_cari'] : "");
        $modDialogPasien->instalasi_nama = (isset($_GET['PCPasienM']['instalasi_nama']) ? $_GET['PCPasienM']['instalasi_nama'] : "");
        $modDialogPasien->carabayar_nama = (isset($_GET['PCPasienM']['carabayar_nama']) ? $_GET['PCPasienM']['carabayar_nama'] : "");
        $modDialogPasien->ruangan_nama = (isset($_GET['PCPasienM']['ruangan_nama']) ? $_GET['PCPasienM']['ruangan_nama'] : "");
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datakunjungan-grid',
            'dataProvider'=>$modDialogPasien->searchPasienRumahsakitV(),
            'filter'=>$modDialogPasien,
            'template'=>"{items}\n{pager}",
//            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            setInfoPasien($data->pendaftaran_id, \"\", \"\", \"\");
                                            $(\"#dialogPasien\").dialog(\"close\");
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
                    'nama_pasien',
//                    'jeniskelamin',
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=>LookupM::model()->getItems('jeniskelamin'),
                    ),
                    array(
                        'name'=>'instalasi_id',
                        'value'=>'$data->instalasi_nama',
                        'type'=>'raw',
//                        'filter'=>CHtml::listData(BKPendaftaranT::model()->getInstalasis(),'instalasi_id','instalasi_nama'), //dipilih dari instalasi form kunjungan
                        'filter'=>CHtml::activeHiddenField($modDialogPasien,'idInstalasi'),
                    ),
                    array(
                        'name'=>'ruangan_nama',
                        'type'=>'raw',
                    ),
                    array(
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                    ),


            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>