<div class = "span4">
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran <span class='required'>*</span>", 'no_pendaftaran', array('class'=>'control-label required')); ?>
        <div class="controls">
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
                                            setKunjungan(ui.item.pasienmasukpenunjang_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Pendaftaran','class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik no. pendaftaran',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                    ),
                            )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Masuk Penunjang", 'no_masukpenunjang', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('ruangan_id',$modKunjungan->ruangan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('pasienmasukpenunjang_id',$modKunjungan->pasienmasukpenunjang_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'no_masukpenunjang',
                                'value'=>$modKunjungan->no_masukpenunjang,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteKunjungan').'",
                                                   dataType: "json",
                                                   data: {
                                                       no_masukpenunjang: request.term,
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
                                             $(this).val("");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Masuk Penunjang','class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik no. masuk penunjang / klik icon untuk mencari data kunjungan',
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
        <?php echo CHtml::label('Tgl. Masuk Penunjang', 'tglmasukpenunjang', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tglmasukpenunjang',$modKunjungan->tglmasukpenunjang,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
                                            setKunjungan(ui.item.pasienmasukpenunjang_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'Ketik No. Rekam Medik','class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik no. rekam medik untuk mencari data kunjungan',
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
                $modKunjungan->nama_pasien = $modKunjungan->namadepan.$modKunjungan->nama_pasien;
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
                                            setKunjungan(ui.item.pasienmasukpenunjang_id);
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
    <div class="control-group" hidden>
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
    
<!--    <div class="control-group">
        <?php echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penanggungjawab_id',$modKunjungan->penanggungjawab_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('nama_pj',$modKunjungan->nama_pj,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Status Penanggung Jawab", 'pengantar', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('pengantar',$modKunjungan->pengantar,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>-->
    
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
        'title'=>'Pencarian Data Kunjungan Pasien Rehabilitasi Medis',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogKunjungan = new RMPasienMasukPenunjangV('searchDialogKunjungan');
    $modDialogKunjungan->unsetAttributes();
    $modDialogKunjungan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if(isset($_GET['ROPasienMasukPenunjangV'])) {
        $modDialogKunjungan->attributes = $_GET['ROPasienMasukPenunjangV'];
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
                        'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectKunjungan",
                                        "onClick" => "
                                            setKunjungan($data->pasienmasukpenunjang_id);
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
                    ),
                    'no_pendaftaran',
                    'no_masukpenunjang',
                    array(
                        'name'=>'tglmasukpenunjang',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)',
                        'filter'=> false,
                    ),
                    'no_rekam_medik',
                    'nama_pasien',
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=>LookupM::model()->getItems('jeniskelamin'),
                    ),
                    'instalasiasal_nama',
                    'ruanganasal_nama',
                    array(
                        'name'=>'carabayar_id',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                        'filter'=>CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif IS TRUE"),'carabayar_id','carabayar_nama'),
                    ),


            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>