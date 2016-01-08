<div class = "span4">
			<?php // echo CHtml::hiddenField('pendaftaran_id',$modKunjungan->pendaftaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php
                $pasienadmisi_id = (isset($modKunjungan->pasienadmisi_id) ? $modKunjungan->pasienadmisi_id : null);
                echo CHtml::hiddenField('pasienadmisi_id',$pasienadmisi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
    <div class="control-group">		
        <?php echo CHtml::label("Instalasi <font color=red>*</font>", 'instalasi_id', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php 
            if(!empty($modKunjungan->pendaftaran_id)){
                echo CHtml::hiddenField('instalasi_id',$modKunjungan->instalasi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                echo CHtml::textField('instalasi_nama',$modKunjungan->instalasi_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            }else{
                echo CHtml::dropDownList('instalasi_id',$modKunjungan->instalasi_id,CHtml::listData(PJInstalasiM::model()->getInstalasiPelayanans(),'instalasi_id','instalasi_nama'),array('onchange'=>'setKunjunganReset();refreshDialogKunjungan();','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",)); 
            }
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Barcode <font color=red>*</font>", 'cari_pendaftaran_id', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textField('cari_pendaftaran_id',$modKunjungan->pendaftaran_id,array('onchange'=>"if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')",'class'=>'span3', 'placeholder'=>'Scan Barcode Pada Print Status','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran <font color=red>*</font>", 'no_pendaftaran', array('class'=>'control-label required')); ?>
        <div class="controls">            
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
                                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Pendaftaran','class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik no. pendaftaran / klik icon untuk mencari data kunjungan',
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
            <?php echo CHtml::hiddenField('tglselesaiperiksa',$modKunjungan->tglselesaiperiksa,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Poliklinik / Ruangan", 'ruangan_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php 
                $ruangan_id = null;
                if(isset($modKunjungan->ruangan_id)){
                    $ruangan_id = $modKunjungan->ruangan_id;
                }else if (isset($modKunjungan->ruanganakhir_id)){
                    $ruangan_id = $modKunjungan->ruanganakhir_id;
                    
                }
                echo CHtml::hiddenField('ruangan_id',$ruangan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <?php echo CHtml::textField('ruangan_nama',$modKunjungan->ruangan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('kelaspelayanan_id',$modKunjungan->kelaspelayanan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('kelaspelayanan_nama',$modKunjungan->kelaspelayanan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kasus Penyakit", 'jeniskasuspenyakit_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('jeniskasuspenyakit_id',$modKunjungan->jeniskasuspenyakit_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('jeniskasuspenyakit_nama',$modKunjungan->jeniskasuspenyakit_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
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
</div>
<div class = "span4">
    <div class="control-group">
        <?php echo CHtml::label("Penjamin", 'penjamin_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('penjamin_nama',$modKunjungan->penjamin_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik <font color=red>*</font>", 'no_rekam_medik', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php // echo CHtml::hiddenField('pasien_id',$modKunjungan->pasien_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php // echo CHtml::textField('no_rekam_medik',$modKunjungan->no_rekam_medik,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
                                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
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
        <?php echo CHtml::label("Nama Pasien <font color=red>*</font>", 'nama_pasien', array('class'=>'control-label required')); ?>
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
                                setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
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
            <?php echo CHtml::textArea('alamat_pasien',$modKunjungan->alamat_pasien,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>

<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKunjungan',
    'options'=>array(
        'title'=>'Pencarian Data Kunjungan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogKunjungan = new PJInfokunjunganrjV('searchDialogKunjungan');
    $modDialogKunjungan->unsetAttributes();
    $modDialogKunjungan->instalasi_id = Params::INSTALASI_ID_RJ;
    if(isset($_GET['PJInfokunjunganrjV'])) {
        $modDialogKunjungan->attributes = $_GET['PJInfokunjunganrjV'];
        $modDialogKunjungan->instalasi_id = $_GET['PJInfokunjunganrjV']['instalasi_id'];
        $modDialogKunjungan->no_pendaftaran = (isset($_GET['PJInfokunjunganrjV']['no_pendaftaran']) ? $_GET['PJInfokunjunganrjV']['no_pendaftaran'] : "");
        $modDialogKunjungan->no_rekam_medik = (isset($_GET['PJInfokunjunganrjV']['no_rekam_medik']) ? $_GET['PJInfokunjunganrjV']['no_rekam_medik'] : "");
        $modDialogKunjungan->nama_pasien = (isset($_GET['PJInfokunjunganrjV']['nama_pasien']) ? $_GET['PJInfokunjunganrjV']['nama_pasien'] : "");
        $modDialogKunjungan->carabayar_nama = (isset($_GET['PJInfokunjunganrjV']['carabayar_nama']) ? $_GET['PJInfokunjunganrjV']['carabayar_nama'] : "");
        $modDialogKunjungan->ruangan_nama = (isset($_GET['PJInfokunjunganrjV']['ruangan_nama']) ? $_GET['PJInfokunjunganrjV']['ruangan_nama'] : "");
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
                                "id" => "selectPendaftaran",
                                "onClick" => "
                                    setKunjungan($data->pendaftaran_id, \"\", \"\", \"\");
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
                'filter'=>CHtml::activeHiddenField($modDialogKunjungan,'instalasi_id'),
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

<script>
function setKunjunganReset(){
	$("#cari_pendaftaran_id").val("");
	$("#pendaftaran_id").val("");
	$("#pasien_id").val("");
	$("#pasienadmisi_id").val("");
	$("#jeniskasuspenyakit_id").val("");
	$("#carabayar_id").val("");
	$("#penjamin_id").val("");
	$("#penanggungjawab_id").val("");
	$("#kelaspelayanan_id").val("");
	$("#ruangan_id").val("");
	$("#no_pendaftaran").val("");
	$("#tgl_pendaftaran").val("");
	$("#ruangan_nama").val("");
	$("#jeniskasuspenyakit_nama").val("");
	$("#carabayar_nama").val("");
	$("#penjamin_nama").val("");
	$("#no_rekam_medik").val("");
	$("#namadepan").val("");
	$("#nama_pasien").val("");
	$("#nama_bin").val("");
	$("#tanggal_lahir").val("");
	$("#umur").val("");
	$("#jeniskelamin").val("");
	$("#nama_pj").val("");
	$("#pengantar").val("");
	$("#kelaspelayanan_nama").val("");
	$("#alamat_pasien").val("");
	$('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
	$("#form-datakunjungan > legend > .judul").html('Data Kunjungan');
	$("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
	$("#form-datakunjungan > .well").addClass("box").removeClass("well");
}

function refreshDialogKunjungan(){
    var instalasi_id = $("#instalasi_id").val();
    var instalasi_nama = $("#instalasi_id option:selected").text();
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
            "PJInfokunjunganrjV[instalasi_id]":instalasi_id,
            "PJInfokunjunganrjV[instalasi_nama]":instalasi_nama,
        }
    });
}  

function setKunjungan(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id ){
    $("#form-datakunjungan > div").addClass("animation-loading");
    var instalasi_id = $("#instalasi_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {instalasi_id:instalasi_id, pendaftaran_id:pendaftaran_id, no_pendaftaran:no_pendaftaran, no_rekam_medik:no_rekam_medik, pasienadmisi_id:pasienadmisi_id},
        dataType: "json",
        success:function(data){
            $("#cari_pendaftaran_id").val(data.pendaftaran_id);
            $("#PJPemakaianambulansT_pendaftaran_id").val(data.pendaftaran_id);
            $("#PJPemakaianambulansT_pasien_id").val(data.pasien_id);
            $("#pasienadmisi_id").val(data.pasienadmisi_id);
            $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
            $("#carabayar_id").val(data.carabayar_id);
            $("#penjamin_id").val(data.penjamin_id);
            $("#penanggungjawab_id").val(data.penanggungjawab_id);
            $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
            if(data.ruangan_id)
                $("#ruangan_id").val(data.ruangan_id);
            else
                $("#ruangan_id").val(data.ruanganakhir_id);
            $("#instalasi_id").val(data.instalasi_id);
            $("#instalasi_nama").val(data.instalasi_nama);
            $("#no_pendaftaran").val(data.no_pendaftaran);
            $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
            $("#ruangan_nama").val(data.ruangan_nama);
            $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
            $("#carabayar_nama").val(data.carabayar_nama);
            $("#penjamin_nama").val(data.penjamin_nama);
            $("#no_rekam_medik").val(data.no_rekam_medik);
            $("#namadepan").val(data.namadepan);
            $("#nama_pasien").val(data.nama_pasien);
            $("#nama_bin").val(data.nama_bin);
            $("#tanggal_lahir").val(data.tanggal_lahir);
            $("#umur").val(data.umur);
            $("#jeniskelamin").val(data.jeniskelamin);
            $("#nama_pj").val(data.nama_pj);
            $("#pengantar").val(data.pengantar);
            $("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
            $("#alamat_pasien").val(data.alamat_pasien);
//            $("#<?php // echo CHtml::activeId($modPemakaian,'norekammedis'); ?>").val(data.no_rekam_medik);
//            $("#<?php // echo CHtml::activeId($modPemakaian,'noidentitas'); ?>").val(data.no_identitas_pasien);
//            $("#<?php // echo CHtml::activeId($modPemakaian,'namapasien'); ?>").val(data.nama_pasien);
//            $("#<?php // echo CHtml::activeId($modPemakaian,'pasien_id'); ?>").val(data.pasien_id);
//            $("#<?php // echo CHtml::activeId($modPemakaian,'pendaftaran_id'); ?>").val(data.pendaftaran_id);
            if(data.photopasien === null || data.photopasien === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
            }
            $("#form-datakunjungan > legend > .judul").html('Data Kunjungan '+data.no_pendaftaran);
            $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
            $("#form-datakunjungan > .box").addClass("well").removeClass("box");
            
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#nama_pasien").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan !"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#instalasi_id").focus();
        }
    });

} 
</script>