<div class = "span4">
    <?php echo CHtml::hiddenField('pendaftaran_id',$modKunjungan->pendaftaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php
        $pasienadmisi_id = (isset($modKunjungan->pasienadmisi_id) ? $modKunjungan->pasienadmisi_id : null);
        echo CHtml::hiddenField('pasienadmisi_id',$pasienadmisi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
    ?>
    <div class="control-group">
        <?php echo CHtml::label("Instalasi <span class='required'>*</span>", 'instalasi_id', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php 
            if(!empty($modKunjungan->pendaftaran_id)){
                echo CHtml::hiddenField('instalasi_id',$modKunjungan->instalasi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                echo CHtml::textField('instalasi_nama',$modKunjungan->instalasi_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            }else{
                if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_AMBULAN){
                    $ins = Params::INSTALASI_ID_RJ;
                }else{
                    $ins = Yii::app()->user->getState('instalasi_id');
                }
                echo CHtml::dropDownList('instalasi_id',$ins,CHtml::listData(AMInstalasiM::model()->getInstalasiPelayanans(),'instalasi_id','instalasi_nama'),array('onchange'=>'setKunjunganReset();refreshDialogKunjungan();','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",)); 
            }
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Barcode <span class='required'>*</span>", 'cari_pendaftaran_id', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textField('cari_pendaftaran_id',$modKunjungan->pendaftaran_id,array('onchange'=>"if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')",'class'=>'span3', 'placeholder'=>'Scan Barcode Pada Print Status','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran <span class='required'>*</span>", 'no_pendaftaran', array('class'=>'control-label required')); ?>
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
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Pendaftaran', 'autofocus'=>true, 'class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik no. pendaftaran / klik icon untuk mencari data kunjungan',
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
    <div class="control-group">
        <?php echo CHtml::label("Penjamin", 'penjamin_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('penjamin_nama',$modKunjungan->penjamin_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class = "span4">
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik <span class='required'>*</span>", 'no_rekam_medik', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pasien_id',$modKunjungan->pasien_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
        <?php echo CHtml::label("Nama Pasien <span class='required'>*</span>", 'nama_pasien', array('class'=>'control-label required')); ?>
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
    <div class="control-group">
        <?php echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penanggungjawab_id',$modKunjungan->penanggungjawab_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('nama_pj',$modKunjungan->nama_pj,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
 $item = LookupM::getItems('statusperiksa');
unset($item['BATAL PERIKSA']);
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
    $modDialogKunjungan = new AMInfokunjunganrjV('searchDialogKunjungan');
    $modDialogKunjungan->unsetAttributes();
    $modDialogKunjungan->instalasi_id = Yii::app()->user->getState('instalasi_id');//Params::INSTALASI_ID_RJ
    $modDialogKunjungan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if(isset($_GET['AMInfokunjunganrjV'])) {
        $modDialogKunjungan->attributes = $_GET['AMInfokunjunganrjV'];
       // $modDialogKunjungan->instalasi_id = $_GET['AMInfokunjunganrjV']['instalasi_id'];
        $modDialogKunjungan->no_pendaftaran = (isset($_GET['AMInfokunjunganrjV']['no_pendaftaran']) ? $_GET['AMInfokunjunganrjV']['no_pendaftaran'] : "");
        $modDialogKunjungan->no_rekam_medik = (isset($_GET['AMInfokunjunganrjV']['no_rekam_medik']) ? $_GET['AMInfokunjunganrjV']['no_rekam_medik'] : "");
        $modDialogKunjungan->nama_pasien = (isset($_GET['AMInfokunjunganrjV']['nama_pasien']) ? $_GET['AMInfokunjunganrjV']['nama_pasien'] : "");
        $modDialogKunjungan->carabayar_nama = (isset($_GET['AMInfokunjunganrjV']['carabayar_nama']) ? $_GET['AMInfokunjunganrjV']['carabayar_nama'] : "");
       // $modDialogKunjungan->ruangan_nama = (isset($_GET['AMInfokunjunganrjV']['ruangan_nama']) ? $_GET['AMInfokunjunganrjV']['ruangan_nama'] : "");
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
                'filter'=> CHtml::dropDownList('AMInfokunjunganrjV[jeniskelamin]',$modDialogKunjungan->jeniskelamin,LookupM::model()->getItems('jeniskelamin'),array('empty'=>'--Pilih--')),
            ),
           /* array(
                'header' => 'Instalasi',
                'name'=>'instalasi_id',
                'value'=>'$data->instalasi_nama',
                'type'=>'raw',
                'filter'=>CHtml::activeHiddenField($modDialogKunjungan,'instalasi_id'),
            ),*/
            array(
                'header'=>'Ruangan',
                'name' => 'ruangan_id',
                'type'=>'raw',
                'value' => '$data->ruangan_nama',
                'filter' => Chtml::activeDropDownList($modDialogKunjungan, 'ruangan_id', Chtml::listData(AMRuanganM::getRuanganPesanAM(), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --'))
            ),
            array(
                'name'=>'carabayar_id',
                'type'=>'raw',
                'value'=>'$data->carabayar_nama',
                'filter'=> CHtml::dropDownList('AMInfokunjunganrjV[carabayar_id]',$modDialogKunjungan->carabayar_id,CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif IS TRUE ORDER BY carabayar_nama ASC"),'carabayar_id','carabayar_nama'),array('empty'=>'--Pilih--'))
            ),
            array(
                'header' => 'Status Periksa',
                'name' => 'statusperiksa',
                'value' => '$data->statusperiksa',
                'filter' => Chtml::dropDownList('AMInfokunjunganrjV[statusperiksa]', $modDialogKunjungan->statusperiksa, $item, array('empty'=>'-- Pilih --'))
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
$this->endWidget();
////======= end pendaftaran dialog =============
?>