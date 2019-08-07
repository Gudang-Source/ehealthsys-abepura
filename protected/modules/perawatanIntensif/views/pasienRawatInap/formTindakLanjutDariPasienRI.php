<div class="white-container">
    <legend class="rim2">Pasien <b>Pulang</b></legend>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pasienpulang-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        'focus' => '#' . CHtml::activeId($modelPulang, 'penerimapasien'),
    ));
    ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data pasien pulang berhasil disimpan !");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php
    //    if(empty($modTariftindakan->harga_tariftindakan)){
    //        echo "<script>
    //                    myAlert('Maaf, Harga Tarif Kamar Rawat Inap Belum Ada. Silahkan Hubungi Bagian Administrasi');
    //                    window.location.href(".Yii::app()->createUrl('/PasienRawatInap/index').");
    //                </script>";
    //    }else{
    //        echo "<script>
    //                    myAlert('Harga Tarif Kamar Rawat Inap Ada');
    //                </script>";
    //    }
    ?>
    <table width="100%" class="table-condensed">
        <tr>

            <td><?php echo CHtml::label('Tanggal Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'tgl_pendaftaran', array('readonly' => true)); ?></td>

            <td> <div class="control-label"> <?php echo CHtml::activeLabel($modPasienRIV, 'no_rekam_medik', array('class' => 'no_rek')); ?> </div></td>
            <td>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modPasienRIV,
                    'attribute' => 'no_rekam_medik',
                    'value' => '',
                    'source' => 'js: function(request, response) {
                               $.ajax({
                                   url: "' . Yii::app()->createUrl('ActionAutoComplete/PasienRawatInap') . '",
                                   dataType: "json",
                                   data: {
                                       term: request.term,
                                   },
                                   success: function (data) {
                                           response(data);
                                   }
                               })
                            }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val( ui.item.label);
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                  $("#' . CHtml::activeId($modPasienRIV, 'tgl_pendaftaran') . '").val(ui.item.tgl_pendaftaran);
                                  $("#' . CHtml::activeId($modPasienRIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                  $("#' . CHtml::activeId($modPasienRIV, 'umur') . '").val(ui.item.umur);     
                                  $("#' . CHtml::activeId($modPasienRIV, 'jeniskasuspenyakit_nama') . '").val(ui.item.jeniskasuspenyakit_nama);
                                  $("#' . CHtml::activeId($modPasienRIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                  $("#' . CHtml::activeId($modPasienRIV, 'nama_pasien') . '").val(ui.item.nama_pasien);     
                                  $("#' . CHtml::activeId($modPasienRIV, 'jeniskelamin') . '").val(ui.item.jeniskelamin);  
                                  $("#' . CHtml::activeId($modPasienRIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);  
                                  $("#' . CHtml::activeId($modPasienRIV, 'nama_bin') . '").val(ui.item.nama_bin);   
                                  $("#' . CHtml::activeId($modelPulang, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);     
                                  $("#' . CHtml::activeId($modelPulang, 'pasien_id') . '").val(ui.item.pasien_id);    
                                  $("#' . CHtml::activeId($modelPulang, 'pasienadmisi_id') . '").val(ui.item.pasienadmisi_id);
                                  $("#' . CHtml::activeId($modMasukKamar, 'masukkamar_id') . '").val(ui.item.masukkamar_id); 
                                  $("#' . CHtml::activeId($modMasukKamar, 'tglmasukkamar') . '").val(ui.item.tglmasukkamar); 
                                      }'
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'No. Rekam Medik',
                        'size' => 20,
                        'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDaftarPasien', 'idTombol' => 'tombolPasienDialog'),
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td><label class="control-label">No. Pendaftaran</label></td>
            <td>
<?php echo CHtml::activeTextField($modPasienRIV, 'no_pendaftaran', array('readonly' => true, 'class' => 'span2')); ?>
            </td>

            <td><?php echo CHtml::activeLabel($modPasienRIV, 'jeniskelamin', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'jeniskelamin', array('readonly' => true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienRIV, 'umur', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'umur', array('readonly' => true)); ?></td>

            <td><?php echo CHtml::activeLabel($modPasienRIV, 'nama_pasien', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'nama_pasien', array('readonly' => true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienRIV, 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?></td>

            <td><?php echo CHtml::activeLabel($modPasienRIV, 'nama_alias', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'nama_bin', array('readonly' => true)); ?></td>
        </tr>
    </table>
    <hr />
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
                <?php echo $form->errorSummary(array($modelPulang)); ?>
    <table width="100%">
        <tr>
            <td>
                <?php //echo $form->textFieldRow($modelPulang,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                        <?php echo $form->labelEx($modelPulang, 'tglpasienpulang', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modelPulang,
                            'attribute' => 'tglpasienpulang',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                        ));
                        ?>
                <?php echo $form->error($modelPulang, 'tglpasienpulang'); ?> 
                    </div>
                </div>
                    <?php echo $form->hiddenField($modelPulang, 'pasienadmisi_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modelPulang, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($modelPulang, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                <div class="control-group ">
                        <?php echo $form->labelEx($modelPulang, 'carakeluar_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modelPulang, 'carakeluar_id', CHtml::listData($modelPulang->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'carakeluar(this.value);',
                            'ajax' => array('type' => 'POST',
                                'url' => $this->createUrl('SetDropDownKondisiKeluar', array('encode' => false, 'model_nama' => get_class($modelPulang))),
                                'update' => "#" . CHtml::activeId($modelPulang, 'kondisikeluar_id'),
                            ),));
                        ?>                            
                    <?php echo $form->error($modelPulang, 'carakeluar_id'); ?>
                    </div>
                </div>
                <div class="control-group ">
                        <?php echo CHtml::label('Kondisi Pulang <font color=red>*</font>', 'RIPasienPulangT_kondisikeluar_id', array('class' => 'control-label required')) ?>
<?php //echo $form->labelEx($modelPulang,'kondisikeluar_id', array('class'=>'control-label'))  ?>
                    <div class="controls">
                <?php echo $form->dropDownList($modelPulang, 'kondisikeluar_id', CHtml::listData($modelPulang->getKondisikeluarItems($modelPulang->carakeluar_id), 'kondisikeluar_id', 'kondisikeluar_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'pasienmeninggal(this.value);'));
                ?>
                    <?php echo $form->error($modelPulang, 'kondisikeluar_id'); ?>
                    </div>
                </div>                  
                        <?php echo $form->textFieldRow($modelPulang, 'penerimapasien', array('placeholder' => 'Penerima Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

                <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Masuk Kamar', 'tglmasukkamar', array('class' => 'control-label')); ?>
                    <div class="controls">
<?php echo $form->textField($modMasukKamar, 'tglmasukkamar', array('class' => 'span3', 'readonly' => true)) ?>
                    <?php
                    echo $form->hiddenField($modMasukKamar, 'masukkamar_id', array('onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span2', 'readonly' => TRUE));
                    ?>
                    </div>
                </div>                    
                <div class="control-group ">
                        <?php //echo $form->labelEx($modMasukKamar,'tglkeluarkamar', array('class'=>'control-label')) ?>
                        <?php echo CHtml::label('Tanggal Pulang Kamar', 'tglkeluarkamar', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modMasukKamar,
                            'attribute' => 'tglkeluarkamar',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'class' => 'dtPicker3',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                        ));
                        ?>
                        <?php echo $form->error($modMasukKamar, 'tglkeluarkamar'); ?>   
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                        <?php //echo $form->labelEx($modMasukKamar,'jamkeluarkamar', array('class'=>'control-label')); ?>
                        <?php echo CHtml::label('Jam Pulang Kamar', 'jamkeluarkamar', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modMasukKamar,
                            'attribute' => 'jamkeluarkamar',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'class' => 'dtPicker3',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                        ));
                        ?>
                    <?php echo $form->error($modMasukKamar, 'jamkeluarkamar'); ?>
                    </div>
                </div>
                <div class="control-group ">
<?php echo $form->labelEx($modMasukKamar, 'lamadirawat_kamar', array('class' => 'control-label')) ?>
                    <div class="controls">
<?php echo $form->textField($modMasukKamar, 'lamadirawat_kamar', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                    </div>
                </div>
                <div class="control-group ">
                        <?php echo $form->labelEx($modelPulang, 'hariperawatan', array('class' => 'control-label')) ?>
                    <div class="controls">
<?php echo $form->textField($modelPulang, 'hariperawatan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modelPulang,'keterangankeluar', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modelPulang,'keterangankeluar',array('placeholder'=>'Keterangan Pasien Pulang','class'=>'span3', 'cols'=>50, 'rows'=>3)); ?>
                    </div>
                </div>
            </td>
            <td>
               <fieldset class="box">
                    <legend class="rim">
                        <?php echo CHtml::checkBox('isDead', $modelPulang->isDead, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                        Pasien Meninggal
                    </legend>
                    <div class="control-group ">
                            <?php echo $form->labelEx($modelPulang, 'tgl_meninggal', array('class' => 'control-label')) ?>
                        <div class="controls">
<?php
$this->widget('MyDateTimePicker', array(
    'model' => $modelPulang,
    'attribute' => 'tgl_meninggal',
    'mode' => 'datetime',
    'options' => array(
        'dateFormat' => Params::DATE_FORMAT,
    ),
    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'disabled' => true),
));
?>

                        </div>
                    </div>
                </fieldset> 
                <fieldset class="box">
                    <legend class="rim">
                        <?php echo CHtml::checkBox('isKontrol', $modelPulang->isKontrol, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>

                        Rencana Kontrol Pasien
                    </legend>
                    <div class="control-group ">
                            <?php echo CHtml::label('Tanggal Rencana Kontrol', 'tglrenkontrol', array('class' => 'control-label')) ?>
                        <div class="controls">
<?php
$this->widget('MyDateTimePicker', array(
    'model' => $modPendaftaran,
    'attribute' => 'tglrenkontrol',
    'mode' => 'datetime',
    'options' => array(
        'dateFormat' => Params::DATE_FORMAT,
    ),
    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'disabled' => true),
));
?>

                        </div>
                    </div>
                </fieldset> 
            </td>
        </tr>
    </table>
        <?php
        // echo $this->renderPartial('_formUpdateMasukKamar',array('form'=>$form,'modMasukKamar'=>$modMasukKamar));
        echo $this->renderPartial('_formRujukanKeluar', array('form' => $form, 'modelPulang' => $modelPulang, 'modRujukanKeluar' => $modRujukanKeluar))
        ?>	
    <div class="form-actions">
        <?php
        $disableSave = false;
        $disableSave = (!empty($_GET['id'])) ? true : ($tersimpan == 'Ya') ? true : false;
        ?>
        <?php $disablePrint = ($disableSave) ? false : true; ?>
        <?php
        echo CHtml::htmlButton($modelPulang->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
<?php
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary-blue', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
?>
<?php
echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->module->id . '/TindakLanjutDrTransaksi'), array('class' => 'btn btn-danger',
    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('TindakLanjutDrTransaksi') . '";} ); return false;'));
?>
<?php
$content = $this->renderPartial('../tips/transaksi', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
?>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            // Notifikasi Pasien
<?php
if (isset($smspasien)) {
    if ($smspasien == 0) {
        ?>
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi: 'GAGAL KIRIM SMS PASIEN', isinotifikasi: 'Pasien <?php echo $modelPulang->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
                    insert_notifikasi(params);
        <?php
    }
}
?>

<?php
if (isset($_GET['smspasien'])) {
    if ($_GET['smspasien'] == 0) {
        ?>
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi: 'GAGAL KIRIM SMS PASIEN', isinotifikasi: 'Pasien <?php echo $modelPulang->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
                    insert_notifikasi(params);
        <?php
    }
}
?>

    <?php
    if (isset($modelPulang->pasienpulang_id)) {
        ?>
                var params = [];
                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi: 'Pasien Pulang', isinotifikasi: '<?php echo $modelPulang->pasien->nama_pasien; ?> dengan <?php echo $modelPulang->pasien->no_rekam_medik; ?> telah pulang pada <?php echo $modelPulang->tglpasienpulang ?> dari <?php echo $modelPulang->ruangan_nama ?>'}; // 16 
                        insert_notifikasi(params);
        <?php
    }
    ?>
                });
    </script>
<?php $this->endWidget(); ?>
<?php
if ($tersimpan == 'Ya') {
    ?>
        <script>
            //parent.location.reload(); RND-6894
        </script>
    <?php
}
?>
    <script>
        function carakeluar(value)
        {
            if (value == "<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>")
            {
                $('#pakeRujukan').attr('checked', true);
                $('#divRujukan input').removeAttr('disabled');
                $('#divRujukan select').removeAttr('disabled');
                $('#divRujukan').slideToggle(500);

            }
            else if (value == "<?php echo Params::CARAKELUAR_ID_MENINGGAL ?>")
            {
                var date = new Date();
                $('#pakeRujukan').removeAttr('checked');
                $('#divRujukan input').attr('disabled', 'true');
                $('#divRujukan select').attr('disabled', 'true');
                $('#divRujukan input').attr('value', '');
                $('#divRujukan select').attr('value', '');
                $('#divRujukan').hide(500);
                $('#RIPasienPulangT_tgl_meninggal').val('<?php echo Yii::app()->dateFormatter->formatDateTime(
        CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd HH:ii:ss'));
?>');

            }
            else
            {
                $('#pakeRujukan').removeAttr('checked');
                $('#divRujukan input').attr('disabled', 'true');
                $('#divRujukan select').attr('disabled', 'true');
                $('#divRujukan input').attr('value', '');
                $('#divRujukan select').attr('value', '');
                $('#divRujukan').hide(500);

            }
        }
        function pasienmeninggal(value)
        {
            if (value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_1 ?>" || value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_2 ?>")
            {
                $('#isDead').attr('checked', true);
                $('#RIPasienPulangT_tgl_meninggal').removeAttr('disabled');
            }
            else
            {
                $('#isDead').removeAttr('checked');
                $('#RIPasienPulangT_tgl_meninggal').attr('disabled', 'true');
            }
        }
        $('#isDead').change(function () {
            if ($(this).is(':checked')) {
                $('#RIPasienPulangT_tgl_meninggal').removeAttr('disabled');
                $('#RIPasienPulangT_kondisipulang_id').val('<?php echo Params::KONDISIPULANG_MENINGGAL_1 ?>');
                $('#RIPasienPulangT_tgl_meninggal').val('<?php echo Yii::app()->dateFormatter->formatDateTime(
        CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd HH:ii:ss'));
?>');
            } else {
                $('#RIPasienPulangT_tgl_meninggal').attr('disabled', 'true');
                $('#RIPasienPulangT_kondisipulang_id').val('');
                $('#RIPasienPulangT_tgl_meninggal').val('');

            }
        });
        function konfirmasi()
        {
            myConfirm("<?php echo Yii::t('mds', 'Do You want to cancel?') ?>", "Perhatian!", function (r) {
                if (r)
                {
                    $('#dialogPasienPulang').dialog('close');
                }
                else
                {
                    $('#RIPasienPulangT_carakeluar_id').focus();
                    return false;
                }
            });
        }
        $('#isKontrol').change(function () {
            if ($(this).is(':checked')) {
                $('#RIPendaftaranT_tglrenkontrol').removeAttr('disabled');
                $('#RIPendaftaranT_tglrenkontrol').val('<?php echo Yii::app()->dateFormatter->formatDateTime(
        CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd HH:ii:ss'));
?>');
            } else {
                $('#RIPendaftaranT_tglrenkontrol').attr('disabled', 'true');
                $('#RIPendaftaranT_tglrenkontrol').val('');

            }
        });

        /**
         * untuk print pasien pulang
         */
        function print(caraPrint)
        {
            var pasienpulang_id = '<?php echo isset($modelPulang->pasienpulang_id) ? $modelPulang->pasienpulang_id : null ?>';
            window.open('<?php echo $this->createUrl('printPasienPulang'); ?>&pasienpulang_id=' + pasienpulang_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
        }
    </script>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogDaftarPasien',
        'options' => array(
            'title' => 'Daftar Pasien',
            'autoOpen' => false,
            'resizable' => false,
            'modal' => true,
            'width' => 900,
            'height' => 600,
        ),
    ));

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'daftarpasien-v-grid',
        'dataProvider' => $modPasienRIV->searchRI(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed',
        'filter' => $modPasienRIV,
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogDaftarPasien\").dialog(\"close\");

                                            $(\"#RIInfopasienmasukkamarV_tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
                                            $(\"#RIInfopasienmasukkamarV_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                            $(\"#RIInfopasienmasukkamarV_umur\").val(\"$data->umur\");

                                            $(\"#RIInfopasienmasukkamarV_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");

                                            $(\"#RIInfopasienmasukkamarV_jeniskelamin\").val(\"$data->jeniskelamin\");
                                            $(\"#RIInfopasienmasukkamarV_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                            $(\"#RIInfopasienmasukkamarV_nama_pasien\").val(\"$data->nama_pasien\"); 
                                            $(\"#RIInfopasienmasukkamarV_nama_bin\").val(\"$data->nama_bin\");
                                            $(\"#RIMasukKamarT_tglmasukkamar\").val(\"$data->tglmasukkamar\");
                                            $(\"#RIMasukKamarT_masukkamar_id\").val(\"$data->masukkamar_id \");
                                            $(\"#RIMasukKamarT_lamadirawat_kamar\").val(\"$data->LamaRawat\");
                                            $(\"#RIPasienPulangT_pendaftaran_id\").val(\"$data->pendaftaran_id \");
                                            $(\"#RIPasienPulangT_pasien_id\").val(\"$data->pasien_id \");
                                            $(\"#RIPasienPulangT_pasienadmisi_id\").val(\"$data->pasienadmisi_id \");

                                        "))',
            ),
            'no_rekam_medik',
            'tgl_pendaftaran',
            'no_pendaftaran',
            'nama_pasien',
            array(
                'header' => 'Alias',
                'type' => 'raw',
                'value' => '"$data->nama_bin"',
            ),
            array(
                'header' => 'Penjamin' . ' /<br/>' . 'Cara Bayar',
                'type' => 'raw',
                'value' => '"$data->penjamin_nama"."<br/>"."$data->carabayar_nama"',
            ),
            array(
                'header' => 'Nama Dokter',
                'type' => 'raw',
                'name' => 'nama_pegawai',
                'value' => '"$data->nama_pegawai"',
            ),
            // 'ruangan_nama',
            'jeniskasuspenyakit_nama',
        // 'statusperiksa',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
</div>