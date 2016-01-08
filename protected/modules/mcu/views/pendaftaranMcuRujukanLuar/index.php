<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB  ?>
<div class="white-container">
    <legend class="rim2">Pendaftaran Rujukan <b>Pasien Medical Check Up</b></legend>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'mcpendaftaran-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
        'focus' => '#' . CHtml::activeId($modPasien, 'jenisidentitas'),
    ));
    ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->errorSummary($modPasien); ?>
    <fieldset class="box" id="form-pasien">
        <legend class="rim"><span class='judul'>Data Pasien Baru </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span></legend>
        <div class="row-fluid">    
<?php $this->renderPartial($this->path_view . '_formPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai)); ?>
        </div>
    </fieldset>
    <fieldset class="box">
        <legend class="rim">Data Kunjungan</legend>
        <div class="row-fluid">
<?php echo $this->renderPartial($this->path_view . '_formPendaftaran', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai, 'modSep' => $modSep, 'modRujukanKeluar' => $modRujukanKeluar)); ?>
        </div>		
        <fieldset class="box2">
            <legend class="rim">Pemeriksaan Medical Check Up</legend>
            <fieldset class="box3">
                <legend class="rim">Paket Medical Check Up</legend>
                <div id='content-pemeriksaan-mcu-paket'>
                    <?php
                    $this->renderPartial($this->path_view_mcu . '_formCariPemeriksaan', array(
                        'modPaketPelayanan' => $modPaketPelayanan,
                    ));
                    ?>
                    <div class='checklists'></div>
                </div>
            </fieldset>
            <fieldset class="box3">
                <legend class="rim">Diluar Paket</legend>
                <div id='content-pemeriksaan-mcu-diluar-paket'>
                    <?php
                    $this->renderPartial($this->path_view_mcu . '_formCariPemeriksaanDiluarPaket', array(
                        'modPaketPelayanan' => $modPaketPelayanan,
                    ));
                    ?>
                    <div class='checklists-mcu-diluar-paket'></div>
                </div>			
            </fieldset>
            <!-- di comment : LNG-368 -->
            <!--			<div class="span12">
                                            <div class="control-group">
                                            <div class="checkbox inline">
                                                    <label><b>Pernah Ke MCU</b></label>
<?php
//							echo CHtml::activeCheckBox($modPermintaanMcu,'pernahmcu', array());
?>
                                            </div>
                                    </div>
                                    <div class="control-group ">
            <?php // echo $form->labelEx($modPermintaanMcu,'tglrencanaperiksa', array('class'=>'control-label')) ?>
                                            <div class="controls">
            <?php
//						$modPermintaanMcu->tglrencanaperiksa = (!empty($modPermintaanMcu->tglrencanaperiksa) ? date("d/m/Y H:i:s",strtotime($modPermintaanMcu->tglrencanaperiksa)) : null);
//						$this->widget('MyDateTimePicker',array(
//										'model'=>$modPermintaanMcu,
//										'attribute'=>'tglrencanaperiksa',
//										'mode'=>'datetime',
//										'options'=> array(
//			//                                    'dateFormat'=>Params::DATE_FORMAT,
//											'showOn' => false,
//											'maxDate' => 'd',
//										),
//										'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
//						)); 
            ?>
<?php // echo $form->error($modPermintaanMcu, 'tglrencanaperiksa');  ?>
                                            </div>
                                    </div>
<?php // echo $form->textAreaRow($modPermintaanMcu,'keteranganpermintaan',array('placeholder'=>'Keterangan Permintaan','rows'=>2, 'cols'=>50, 'class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  ?>                
                                    </div>-->
            <div class="block-tabel">
                <h6>Tabel Pemeriksaan <b>Medical Check Up</b></h6>
                <div id="form-tindakanpemeriksaan" style="">
                    <table class="table table-condensed table-striped">
                        <thead>
                        <th>No.</th>
                        <th>Nama Pemeriksaan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Tarif Tindakan</th>
                        <th>Total Tarif</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="block-tabel">
                <h6>Tabel Pemeriksaan Medical <b>Check Up - Diluar Paket</b></h6>
                <div id="form-tindakanpemeriksaan-diluar-paket" style="">
                    <table class="table table-condensed table-striped">
                        <thead>
                        <th>No.</th>
                        <th>Nama Pemeriksaan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Tarif Tindakan</th>
                        <th>Total Tarif</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>
    </fieldset>
    <div class="row-fluid">
        <div class="form-actions">
            <?php //JIKA TANPA VERIFIKASI >> echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)')); ?>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();')); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            }
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
                'onclick' => 'return refreshForm(this);'));
            ?>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;')) . '&nbsp;';
                echo CHtml::link(Yii::t('mds', '{icon} Kirim', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;')) . '&nbsp;';
                if (Yii::app()->user->getState('isbridging')) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printSuratMcu();return false", 'disabled' => FALSE)) . '&nbsp;';
                echo CHtml::link(Yii::t('mds', '{icon} Kirim', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKartuPasien('$model->pasien_id');return false", 'disabled' => FALSE)) . '&nbsp;';
                if (Yii::app()->user->getState('isbridging')) {
                    if (isset($modSep->sep_id)) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printSEP();return false", 'disabled' => FALSE));
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Belum memiliki No. SEP!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                    }
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                    echo "&nbsp;";
                }
            }
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsPendaftaranMcu', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?> 
        </div>
    </div>
    <hr />
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view_mcu . '_tablePendaftaranTerakhir', array()); ?>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-verifikasi',
    'options' => array(
        'title' => 'Verifikasi Pendaftaran',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 960,
        'minHeight' => 480,
        'resizable' => false,
    ),
));

echo '<div class="dialog-content"></div>';
?>
<div class="row-fluid">
    <div class="form-actions">
<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'disableOnSubmit(this); $("#mcpendaftaran-t-form").submit();')); ?>
<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="icon-ban-circle icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'batalDialog("dialog-verifikasi");')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAsuransi',
    'options' => array(
        'title' => 'Pencarian Asuransi Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
$modCariAsuransiPasien = new MCAsuransipasienM('search');
$modCariAsuransiPasien->unsetAttributes();
if (isset($_GET['MCAsuransipasienM'])) {
    $modCariAsuransiPasien->attributes = $_GET['MCAsuransipasienM'];
    isset($_GET['MCAsuransipasienM']['pasien_id']) ? $modCariAsuransiPasien->pasien_id = $_GET['MCAsuransipasienM']['pasien_id'] : '';
    isset($_GET['MCAsuransipasienM']['penjamin_id']) ? $modCariAsuransiPasien->penjamin_id = $_GET['MCAsuransipasienM']['penjamin_id'] : '';
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'asuransi-m-grid',
    'dataProvider' => $modCariAsuransiPasien->searchDialog(),
    'filter' => $modCariAsuransiPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectAsuransi",
                                        "onClick" => "
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') . '\").val($data->asuransipasien_id);
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'nopeserta') . '\").val(\"$data->nopeserta\");
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') . '\").val(\"$data->nokartuasuransi\");
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') . '\").val(\"$data->namapemilikasuransi\");
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'jenispeserta_id') . '\").val(\"$data->jenispeserta_id\");
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') . '\").val(\"$data->nomorpokokperusahaan\");
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'namaperusahaan') . '\").val(\"$data->namaperusahaan\");
                                            $(\"#' . CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') . '\").val(\"$data->kelastanggunganasuransi_id\");
                                            setAsuransiLama()
                                            $(\"#dialogAsuransi\").dialog(\"close\");
                                        "))',
        ),
        'nokartuasuransi',
        'nopeserta',
        array(
            'header' => 'Nama Pemilik Asuransi',
            'value' => '$data->namapemilikasuransi',
            'filter' => CHtml::activeHiddenField($modCariAsuransiPasien, 'pasien_id', array('readonly' => true)) . "" . CHtml::activeHiddenField($modCariAsuransiPasien, 'penjamin_id', array('readonly' => true)) . "" . CHtml::activeTextField($modCariAsuransiPasien, 'namapemilikasuransi', array()),
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        'namaperusahaan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAsuransiBpjs',
    'options' => array(
        'title' => 'Pencarian Asuransi Pasien Bpjs',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
$modCariAsuransiPasienBpjs = new MCAsuransipasienbpjsM('search');
$modCariAsuransiPasienBpjs->unsetAttributes();
if (isset($_GET['MCAsuransipasienbpjsM'])) {
    $modCariAsuransiPasienBpjs->attributes = $_GET['MCAsuransipasienbpjsM'];
    isset($_GET['MCAsuransipasienbpjsM']['pasien_id']) ? $modCariAsuransiPasienBpjs->pasien_id = $_GET['MCAsuransipasienbpjsM']['pasien_id'] : '';
    isset($_GET['MCAsuransipasienbpjsM']['penjamin_id']) ? $modCariAsuransiPasienBpjs->penjamin_id = $_GET['MCAsuransipasienbpjsM']['penjamin_id'] : '';
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'asuransibpjs-m-grid',
    'dataProvider' => $modCariAsuransiPasienBpjs->searchDialog(),
    'filter' => $modCariAsuransiPasienBpjs,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
								"id" => "selectAsuransi",
								"onClick" => "
									$(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'asuransipasien_id') . '\").val($data->asuransipasien_id);
									$(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') . '\").val(\"$data->nopeserta\");
									$(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') . '\").val(\"$data->nokartuasuransi\");
									$(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') . '\").val(\"$data->namapemilikasuransi\");
									$(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_id') . '\").val(\"$data->jenispeserta_id\");
									$(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'nomorpokokperusahaan') . '\").val(\"$data->nomorpokokperusahaan\");
									$(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'namaperusahaan') . '\").val(\"$data->namaperusahaan\");
									$(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') . '\").val(\"$data->kelastanggunganasuransi_id\");
									getAsuransiNoKartu(\'$data->nopeserta\');
									setAsuransiLama()
									$(\"#dialogAsuransiBpjs\").dialog(\"close\");
								"))',
        ),
        'nokartuasuransi',
        'nopeserta',
        array(
            'header' => 'Nama Pemilik Asuransi',
            'value' => '$data->namapemilikasuransi',
            'filter' => CHtml::activeHiddenField($modCariAsuransiPasienBpjs, 'pasien_id', array('readonly' => true)) . "" . CHtml::activeHiddenField($modCariAsuransiPasienBpjs, 'penjamin_id', array('readonly' => true)) . "" . CHtml::activeTextField($modCariAsuransiPasienBpjs, 'namapemilikasuransi', array()),
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        'namaperusahaan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modPermintaanMcu' => $modPermintaanMcu, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai, 'modTindakan' => $modTindakan, 'modRujukanKeluar' => $modRujukanKeluar)); ?>
<?php echo $this->renderPartial($this->path_view_mcu . '_jsFunctionsAntrian', array('model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modAntrian' => $modAntrian)); ?>
