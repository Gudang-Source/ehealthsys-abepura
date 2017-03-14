<div class="white-container">
    <legend class="rim2">Transaksi <b>Odontogram</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'odontogramdetail-t-form',
        'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
            'focus'=>'#', 
    )); ?>
    <?php 

    $this->widget('bootstrap.widgets.BootAlert');
    echo $form->errorSummary(array($modOdontogramDetail)); 

    ?>
    <table width="100%">
        <tr>
            <td width="50%">
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Pendaftaran','tglpendaftaran', array('class'=>'control-label')) ?>
                    <div class="controls">
                        : <span id="tglpendaftaran"></span>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('No. Pendaftaran','nopendaftaran', array('class'=>'control-label')) ?>
                    <div class="controls">
                        : <span id="nopendaftaran"></span>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Lahir / Umur','tgllahirumur', array('class'=>'control-label')) ?>
                    <div class="controls">
                        : <span id="tgllahirumur"></span>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Kasus Penyakit','jeniskasuspenyakit', array('class'=>'control-label')) ?>
                    <div class="controls">
                        : <span id="jeniskasuspenyakit"></span>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Golongan Darah','goldarah', array('class'=>'control-label')) ?>
                    <div class="controls">
                        : <span id="goldarah"></span>
                    </div>
                </div>
            </td>
            <td width="50%">
                <div class="control-group ">
                    <?php echo CHtml::label('No. Rekam Medik','noRekamMedik', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                            'name'=>'noRekamMedik',
                            'value'=>'',
                            'options'=>array(
                               'showAnim'=>'fold',
                               'minLength' => 2,
                               'focus'=> 'js:function( event, ui ) {
                                    $("#noRekamMedik").val( ui.item.value );
                                    return false;
                                }',
                               'select'=>'js:function( event, ui ) {
                                    ambilOdontogram(ui.item.pasien_id,ui.item.pendaftaran_id);
                                    $("#tglpendaftaran").text(ui.item.tgl_pendaftaran);
                                    $("#nopendaftaran").text(ui.item.no_pendaftaran);
                                    $("#tgllahirumur").text(ui.item.tanggal_lahir+" / "+ui.item.umur);
                                    $("#jeniskasuspenyakit").text(ui.item.jeniskasuspenyakit_nama);
                                    $("#goldarah").text(ui.item.golongandarah);
                                    $("#namapegawai").text(ui.item.nama_pegawai);
                                    $("#namapasien").text(ui.item.nama_pasien);
                                    $("#binbinti").text(ui.item.nama_bin);
                                    $("#jeniskelamin").text(ui.item.jeniskelamin);
                                    $("#alamat").text(ui.item.alamat_pasien);

                                    return false;
                                }',

                            ),
                            'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 numbers-only', 'maxlength' => 6),
                            'tombolDialog'=>array('idDialog'=>'dialogDaftarPasien','idTombol'=>'tombolPasienDialog'),
                        )); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Nama Pasien','namapasien', array('class'=>'control-label')) ?>
                    <div class="controls">
                        : <span id="namapasien"></span>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Nama Panggilan','binbinti', array('class'=>'control-label')) ?>
                    <div class="controls">
                        : <span id="binbinti"></span>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Jenis Kelamin','jeniskelamin', array('class'=>'control-label')) ?>
                    <div class="controls">
                        : <span id="jeniskelamin"></span>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Alamat','alamat', array('class'=>'control-label')) ?>
                    <div class="controls">
                        : <span id="alamat"></span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="control-group ">
                    <fieldset class="box" id="fieldsetKunjunagn">
                        <legend class="rim">
                            <?php echo CHtml::checkBox('cex_kunjunganpasien', false, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                            Data Kunjungan
                        </legend>
                        <div id="detail_kunjungna_pasien">
                            <?php echo $this->renderPartial($this->path_view.'_tabelKunjungan', array('model'=>$modOdontogramDetail)); ?>
                        </div>
                    </fieldset>
                </div>
            </td>
        </tr>
    </table>
    <?php 
    $this->widget('Odontogram',array('gigis'=>$gigi)); 
    ?>
    <br/>
    <table style="margin:0 auto;">
        <tr>
            <td>
                <div class="control-group ">
                    <?php echo $form->labelEx($modOdontogramDetail,'tglperiksa', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modOdontogramDetail,
                                                'attribute'=>'tglperiksa',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 realtime'),
                        )); 
                                 ?>
                    </div>
                </div>
                <?php echo $form->hiddenField($modOdontogramDetail,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($modOdontogramDetail,'pendaftaran_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($modOdontogramDetail,'pegawai_id', 
                    array('class'=>'span3', 
                        'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo CHtml::label('Dokter ','namapegawai', array('class'=>'control-label')) ?>
                    <div class="controls">
                        : <span id="namapegawai"></span>
                    </div>
                </div>  
            </td>
            <td>
                <?php echo $form->textAreaRow($modOdontogramDetail,'catatan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
    </table>

    <center class="form-actions">
        <table style="width:615px;margin:0;">
            <tr>
                <td><div id="icon-odontogram" class="belum-erupsi">UE</div><?php echo CHtml::button('Belum Erupsi', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);addCode("E");')); ?></td>
                <td><div id="icon-odontogram" class="tambalan-logam"></div><?php echo CHtml::button('Tambalan Logam', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);changeCode("r");')); ?></td>
                <td><div id="icon-odontogram" class="sisa-akar"></div><?php echo CHtml::button('Sisa Akar', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);addCode("A");')); ?></td>
                <td><?php echo CHtml::button('Sembunyikan Gigi Hilang', array('class'=>'btn btn-primary span3')); ?></td>
            </tr>
            <tr>
                <td><div id="icon-odontogram" class="erupsi-sebagian">PE</div><?php echo CHtml::button('Erupsi Sebagian', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);addCode("S");')); ?></td>
                <td><div id="icon-odontogram" class="tambalan-nonlogam"></div><?php echo CHtml::button('Tambalan Non Logam', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);changeCode("b");')); ?></td>
                <td><div id="icon-odontogram" class="gigi-hilang">X</div><?php echo CHtml::button('Gigi Hilang', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);addCode("H");')); ?></td>
                <td><?php echo CHtml::button('Tampilkan Gigi Hilang', array('class'=>'btn btn-primary span3')); ?></td>
            </tr>
            <tr>
                <td><div id="icon-odontogram" class="anomali-bentuk">A</div><?php echo CHtml::button('Anomali Bentuk', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);addCode("B");')); ?></td>
                <td><div id="icon-odontogram" class="mahkota-logam"></div><?php echo CHtml::button('Mahkota Logam', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);changeCode("g");')); ?></td>
                <td><div id="icon-odontogram" class="jembatan"></div><?php echo CHtml::button('Jembatan', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);addCode("J");')); ?></td>
				<td><?php echo CHtml::button('Hapus Tanda', array('class'=>'btn btn-primary span3')); ?></td>
            </tr>
            <tr>
                <td><div id="icon-odontogram" class="karies"></div><?php echo CHtml::button('Karies', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);changeCode("K");')); ?></td>
                <td><div id="icon-odontogram" class="mahkota-nonlogam"></div><?php echo CHtml::button('Mahkota Non Logam', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);changeCode("n");')); ?></td>
                <td><div id="icon-odontogram" class="gigi-tiruanlepas"></div><?php echo CHtml::button('Gigi Tiruan Lepas', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);addCode("L");')); ?></td>
            </tr>
            <tr>
                <td><div id="icon-odontogram" class="non-vital"></div><?php echo CHtml::button('Non Vital', array('class'=>'btn btn-primary span3','onclick'=>'onKlikTombol(this);addCode("V");')); ?></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </center>
    <div class="form-actions">
        <?php
        // if(!empty($_GET['id'])){
        //     echo CHtml::htmlButton(Yii::t('mds', '{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary','type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>true));
        // }else{
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')), array('class'=>'btn btn-primary','type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'));
        // }
        ?>
         <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    $this->createUrl($this->module->id.'/index'), 
                                    array('class'=>'btn btn-danger',
                                        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak',array('{icon}'=>'<i class="entypo-print"></i>')), array('class'=>'btn btn-info','onclick'=>'cetakOdontogram()')); ?>
        <?php
        $content = $this->renderPartial('rawatJalan.views.tips.transaksiPeriksaGigi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>

    <?php $this->endWidget(); ?>


    <script type="text/javascript">

    function ambilOdontogram(pasien_id,pendaftaran_id)
    {
        $.post('<?php echo $this->createUrl('ajaxOdontogram'); ?>', {pasien_id:pasien_id}, function(data){
            $('#<?php echo CHtml::activeId($modOdontogramDetail, 'pasien_id') ?>').val(pasien_id);
            $('#<?php echo CHtml::activeId($modOdontogramDetail, 'pendaftaran_id') ?>').val(pendaftaran_id);
            $('#dialogDaftarPasien').dialog('close');
            for(n in data) {
                url = '<?php echo $this->createUrl('myOdontogram'); ?>&code='+data[n];
                $('#gram_'+n).find('input[name^=\"codeOdon\"]').val(data[n]);
                $('#gram_'+n).css('background-image','url('+url+')');
            }
        }, 'json');

        setTimeout(function(){
            $.fn.yiiGridView.update('tableKunjungan', {
                    data: $("#odontogramdetail-t-form").serialize()
            });            
        }, 1000);
    }

    function cetakOdontogram()
    {
        var pasien_id = $('#<?php echo CHtml::activeId($modOdontogramDetail,'pasien_id'); ?>').val();
        var pendaftaran_id = $('#<?php echo CHtml::activeId($modOdontogramDetail,'pendaftaran_id'); ?>').val();
        var src = '<?php echo $this->createUrl('cetakOdontogram'); ?>&pasien_id='+pasien_id+'&pendaftaran_id='+pendaftaran_id;
        $('#iframeCetakOdontogram').attr('src', src);
        $('#dialogCetakOdontogram').dialog('open');
    }
    </script>

    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'dialogDaftarPasien',
                'options'=>array(
                    'title'=>'Data Kunjungan Pasien Hari Ini',
                    'autoOpen'=>false,
                    'resizable'=>false,
                    'modal'=>true,
                    'width'=>900,
                    'height'=>600,
                     'close'=>"js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $('#RJInfokunjunganrjV_statusperiksa').serialize()
                            }); }",

                ),
            ));
    $kunjunganPasien = new RJInfokunjunganrjV('searchKunjunganPasien');
    //$kunjunganPasien->statusperiksa = "SEDANG PERIKSA";
    // $kunjunganPasien->tgl_pendaftaran = date('Y-m-d');
    if(isset($_GET['RJInfokunjunganrjV'])){
        $kunjunganPasien->attributes = $_GET['RJInfokunjunganrjV'];
        $format = new MyFormatter();
        if (isset($_GET['RJInfokunjunganrjV']['tgl_pendataran'])) $kunjunganPasien->tgl_pendaftaran  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_pendaftaran']);
        $kunjunganPasien->statusperiksa  = $_REQUEST['RJInfokunjunganrjV']['statusperiksa'];

    }
    
    $statusperiksa =  LookupM::getItems('statusperiksa');
    unset($statusperiksa[Params::STATUSPERIKSA_SUDAH_PULANG]);
    unset($statusperiksa[Params::STATUSPERIKSA_BATAL_PERIKSA]);
    

        $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarpasien-v-grid',
            'dataProvider'=>$kunjunganPasien->searchKunjunganPasienPolikGigi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'filter'=>$kunjunganPasien,
            'columns'=>array(	
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $pegawai = PegawaiM::model()->findByPk($data->pegawai_id);
                            
                            return CHtml::link("<i class='icon-form-check'></i> ", "javascript:void(0)",array("onclick"=>"ambilOdontogram(".$data->pasien_id.",".$data->pendaftaran_id.");
                                    $('#tglpendaftaran').text('".  MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."');
                                    $('#nopendaftaran').text('".$data->no_pendaftaran."');
                                    $('#tgllahirumur').text('".MyFormatter::formatDateTimeForUser($data->tanggal_lahir)." / ".$data->umur."');
                                    $('#jeniskasuspenyakit').text('".$data->jeniskasuspenyakit_nama."');
                                    $('#goldarah').text('".$data->golongandarah."');
                                    $('#namapegawai').text('".$pegawai->namaLengkap."');
                                    $('#namapasien').text('".$data->nama_pasien."');
                                    $('#binbinti').text('".$data->nama_bin."');
                                    $('#jeniskelamin').text('".$data->jeniskelamin."');
                                    $('#OdontogramdetailT_pegawai_id').val('".$data->pegawai_id."');
                                    $('#alamat').text('".$data->alamat_pasien."');",

                                    "rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
                            },
                      'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                    ),                           
                    //tgl_pendaftaran',
                    array(
                        'name'=>'tgl_pendaftaran',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        'filter'=>$this->widget('MyDateTimePicker',array(
                        'model'=>$kunjunganPasien,
                        'attribute'=>'tgl_pendaftaran',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT
                        ),
                            'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','onclick'=>'showDateTime();'),
                        ),true
                        ),
                        'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
                    ),                    
                     array(
                         'header' => 'No Pendaftaran',
                         'name' => 'no_pendaftaran',
                         'value' => '$data->no_pendaftaran',
                         'filter' => Chtml::activeTextField($kunjunganPasien, 'no_pendaftaran', array('class' => 'angkahuruf-only', 'maxlength'=>12))
                     ),
                     array(
                         'header' => 'No Rekam Medik',
                         'name' => 'no_rekam_medik',
                         'value' => '$data->no_rekam_medik',
                         'filter' => Chtml::activeTextField($kunjunganPasien, 'no_rekam_medik', array('class' => 'numbers-only', 'maxlength'=>6))
                     ),
                     array(
                         'header' => 'Nama Pasien',
                         'name' => 'nama_pasien',
                         'value' => '$data->namadepan." ".$data->nama_pasien',
                         'filter' => Chtml::activeTextField($kunjunganPasien, 'nama_pasien', array('class' => 'hurufs-only', 'maxlength'=>100))
                     ),                    
                     array(
                         'header' => 'Alamat Pasien',
                         'name' => 'alamat_pasien',
                         'value' => '$data->alamat_pasien',
                         'filter' => Chtml::activeTextField($kunjunganPasien, 'alamat_pasien', array('class' => 'custom-only'))
                     ),
                     array(
                         'header' => 'Penjamin',
                         'name' => 'penjamin_id',
                         'value' => '$data->penjamin_nama',
                         'filter' => Chtml::activeDropDownList($kunjunganPasien, 'penjamin_id', Chtml::listData(PenjaminpasienM ::model()->findAll("penjamin_aktif = TRUE ORDER BY penjamin_nama ASC"), 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --'))
                     ),     
                     array(
                         'header' => 'Dokter',
                         'name' => 'nama_pegawai',
                         'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                         'filter' => Chtml::activeTextField($kunjunganPasien, 'nama_pegawai', array('class' => 'hurufs-only', 'maxlength'=>100))
                     ),                      
                     array(
                         'header' => 'Jenis Kasus Penyakit',
                         'name' => 'jeniskasuspenyakit_id',
                         'value' => '$data->jeniskasuspenyakit_nama',
                         'filter' => Chtml::activeDropDownList($kunjunganPasien, 'jeniskasuspenyakit_id', Chtml::listData(JeniskasuspenyakitM::model()->findAll("jeniskasuspenyakit_aktif = TRUE ORDER BY jeniskasuspenyakit_nama ASC"), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty'=>'-- Pilih --'))
                     ),                    
                    array(
                        'header' => 'Status Periksa',
                        'name'=>'statusperiksa',
                        'type'=>'raw',
                        'value'=>'$data->statusperiksa',
                        'filter' => CHtml::activeDropDownList($kunjunganPasien,'statusperiksa',$statusperiksa,array('empty'=>'--Pilih--')),
                        // 'filter' =>CHtml::activeDropDownList($kunjunganPasien,'statusperiksa',
                        //     LookupM::getItems('statusperiksa'),array('options' => array('ANTRIAN'=>array('selected'=>true)))),
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});

                jQuery(\'#RJInfokunjunganrjV_tgl_pendaftaran\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'id\'], {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                    \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                    \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'}));
                    
            $(".numbers-only").keyup(function() {
                setNumbersOnly(this);
            });
            $(".angkahuruf-only").keyup(function() {
                setAngkaHuruOnly(this);
            });
            $(".hurufs-only").keyup(function() {
                setHurufsOnly(this);
            });
            }',

    )); 

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>

    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'dialogCetakOdontogram',
                'options'=>array(
                    'title'=>'Odontogram Pasien',
                    'autoOpen'=>false,
                    'resizable'=>false,
                    'modal'=>true,
                    'width'=>900,
                    'height'=>600,
                ),
            ));
    echo '<iframe src="" id="iframeCetakOdontogram" name="iframeCetakOdontogram" width="100%" height="550" ></iframe>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    <script>
        function showDateTime(){
            $( "#RJInfokunjunganrjV_tgl_pendaftaran").datepicker();
        }
        
        
        
        $( document ).ready(function(){                        
            var ruanganLogin = <?php echo Yii::app()->user->getState('ruangan_id'); ?>;
            var checkRuangan = <?php echo Params::RUANGAN_ID_POLIK_GIGI; ?>;
            //alert("wew");
            
            if (ruanganLogin !== checkRuangan){
                $(document).on('keyup',function(evt) {
                    if (evt.keyCode == 27) {
                       window.location.href = "<?php echo  $this->createUrl("/rawatJalan/&modul_id=".Yii::app()->session['modul_id']);?>";
                    }
                });
                myConfirm(' Maaf Ini Hanya Digunakan Oleh Polik Gigi dan Mulut. <br> \n\
                            Silahkan Login ke Polik Gigi dan Mulut Untuk Dapat Mengakses Menu ','Perhatian!',function(r){
                    if (r){
                         window.location.href = "<?php echo  $this->createUrl("/rawatJalan/&modul_id=".Yii::app()->session['modul_id']);//$this->createUrl("/site/logout/"); ?>";
                   }else{
                       window.location.href = "<?php echo $this->createUrl("/rawatJalan/&modul_id=".Yii::app()->session['modul_id']); ?>";
                   }
                });
            }
        });
    </script>
</div>