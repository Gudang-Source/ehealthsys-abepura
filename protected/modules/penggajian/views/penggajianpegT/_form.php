<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js',  CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js',  CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gjpenggajianpeg-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<?php
if (isset($_GET['sukses']))
    echo '<div id="yw0"><div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a><strong>Berhasil!</strong> Data berhasil disimpan.</div></div>';
?>
<!--	<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
<?php $this->renderPartial($this->path_view. '_pegawai', array('model' => $modPegawai, 'form' => $form)); ?>
<?php echo $form->errorSummary($model); ?>

<?php //echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
<?php //echo $form->textFieldRow($model,'tglpenggajian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
<div class="block-tabel">
    <h6><b>Penggajian</b></h6>
    <table width="100%">
        <tr>
            <td>
                    <?php echo $form->labelEx($model, 'tglpenggajian', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $model->tglpenggajian = MyFormatter::formatDateTimeForUser($model->tglpenggajian);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglpenggajian',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'dtPicker3',
                        ),
                    ));
                    ?> 
                </div>

            </td>
            <td>
                <div class="control-group">    
                    <?php echo $form->label($model, 'Nomor Penggajian', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nopenggajian', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <?php //echo $form->textFieldRow($model,'mengetahui',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  ?>
    <div class="row-fluid">
        <div class="span12">
                <!--<table class='table'>-->
            <table class="table table-striped table-condensed" >
                <thead>
                    <tr>
                        <th>
                            Deskripsi
                        </th>
                        <th>
                            Gaji
                        </th>
                        <th>
                            Potongan
                        </th>
                    </tr>
                </thead>
                </tbody>
                <?php
                $modKomponen = KomponengajiM::model()->findAll('komponengaji_aktif = true order by nourutgaji');
                if (count($modKomponen > 0)) {
                    foreach ($modKomponen as $i => $v) {
                        ?>
                        <tr>
                            <td>
                            <?php echo $v->komponengaji_nama; ?>
                            </td>
                            <?php
                            echo ($v->ispotongan == false) ? "<td>" . $form->textField($komponen, "komponengaji_id[" . $v->komponengaji_id . "]", array('value' => 0, 'class' => 'span2 integer2 gaji pph', 'onblur' => 'setGaji(); hitungpph();')) . "</td><td></td>" : "<td></td><td>" . $form->textField($komponen, "komponengaji_id[" . $v->komponengaji_id . "]", array('class' => 'span2 integer2 potongan', 'onblur' => 'setPotongan();', 'value' => 0)) . "</td>";
                            ?>
                        </tr>
                    <?php
                    }
                }
                ?>
                <tbody>
                <tfoot>
                    <tr>
                        <th style="text-align: right">
                            Total
                        </th>
                        <th>
                            <?php echo $form->textField($model, 'totalterima', array('class' => 'span2 integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </th>
                        <th>
                            <?php echo $form->textField($model, 'totalpotongan', array('class' => 'span2 integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<table class="box" width="100%">
    <tr>
        <td width="65%">
            <table width="100%">
                <tr>
                    <td>
                        <?php echo $form->textFieldRow($model, 'totalpajak', array('class' => 'span2 integer2', 'onblur' => 'setHarga();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                        <?php echo $form->textFieldRow($model, 'penerimaanbersih', array('class' => 'span2 integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <!-- Form Keterangan -->        
                            <?php echo $form->textAreaRow($model, 'keterangan', array('rows' => 3, 'cols' => 20, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>        
                    </td>
                    <td>
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'mengetahui', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    //                                        'name'=>'namapegawai',
                                    'attribute' => 'mengetahui',
                                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 4,
                                        'focus' => 'js:function( event, ui ) {
                                                                                                                                    $("#' . CHtml::activeId($model, 'mengetahui') . '").val(ui.item.nama_pegawai);
                                                                                                                                    return false;
                                                                                                                            }',
                                        'select' => 'js:function( event, ui ) {
                                                                                                                                    $("#' . CHtml::activeId($model, 'mengetahui') . '").val(ui.item.nama_pegawai);
                                                                                                                                    return false;
                                                                                                                            }',
                                    ),
                                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawai2', 'idTombol' => 'tombolPasienDialog'),
                                ));
                                ?>
                            </div>
                        </div>
                                <?php //echo $form->textFieldRow($model,'menyetujui',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'menyetujui', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'menyetujui', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    //                                        'name'=>'namapegawai',
                                    'attribute' => 'menyetujui',
                                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 4,
                                        'focus' => 'js:function( event, ui ) {
                                                                                                                                    $("#' . CHtml::activeId($model, 'menyetujui') . '").val(ui.item.nama_pegawai);
                                                                                                                                    return false;
                                                                                                                            }',
                                        'select' => 'js:function( event, ui ) {
                                                                                                                                    $("#' . CHtml::activeId($model, 'menyetujui') . '").val(ui.item.nama_pegawai);
                                                                                                                                    return false;
                                                                                                                            }',
                                    ),
                                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawai3', 'idTombol' => 'tombolPasienDialog'),
                                ));
                                ?>
                            </div>
                        </div>

                    </td>
                </tr>
            </table>
        </td>
        <td>
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'form-pph21',
                'content' => array(
                    'content-pjpasien' => array(
                        'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Perhitungan PPH 21')) . '<b> Perhitungan PPH 21</b>',
                        'isi' => $this->renderPartial($this->path_view. '_perhitunganPph21', array(
                            'form' => $form,
                            'model' => $model,
                                ), true),
                        'active' => false,
                    ),
                ),
            ));
            ?>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php    
    if (isset($_GET['id'])) {
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'disabled' => 'disabled'));
    } else {
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    }
    
    
    ?>
    <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/create',array('modul_id' =>Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/create',array('modul_id' =>Yii::app()->session['modul_id'])) . '";}); return false;'));?>
    <?php
    if (isset($_GET['id'])) {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        echo "&nbsp;";
    } else {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'disabled' => 'disabled'));
        echo "&nbsp;";
    }
    ?>
<?php
$tips = array(
    '0' => 'waktutime',
    '1' => 'autocomplete-search',
    '2' => 'simpan',
    '3' => 'ulang',
    '4' => 'print',
    '5' => 'status_print',
    '6' => 'bootaccordion',
);
$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips'=>$tips), true);
$this->widget('UserTips', array('type' => 'create', 'content' => $content));
?>	

</div>


<?php
if (isset($_GET['id'])) {
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/Print&id=' . $model->penggajianpeg_id . '&pegawai_id=' . $modPegawai->pegawai_id);
    ?>
    <script type="text/javascript">
        function print(caraPrint)
        {
            window.open("<?php echo $urlPrint ?>" + $('#search').serialize() + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
        }
    </script>
<?php } ?>
<?php $this->endWidget(); ?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

<?php Yii::app()->clientScript->registerScript('onheadfunction', '
//    function setGaji(){
//        var totalGaji = 0;
//        $(".gaji").each(function(){
//            value =  unformatNumber($(this).val());
//            if (value > 0){
//                totalGaji += value;
//            }
//        });
//        $("#' . CHtml::activeId($model, 'totalterima') . '").val(formatNumber(totalGaji));
//        setHarga();
//    }
    function setPotongan(){
        var totalPotongan = 0;
        $(".potongan").each(function(){
        value = unformatNumber($(this).val());
            if (jQuery.isNumeric(value)){
                totalPotongan += value;
            }
        });
        $("#' . CHtml::activeId($model, 'totalpotongan') . '").val(formatNumber(totalPotongan));
        setHarga();
    }
    function setHarga(){
        var pajak = unformatNumber($("#' . CHtml::activeId($model, 'totalpajak') . '").val());
        var gaji = unformatNumber($("#' . CHtml::activeId($model, 'totalterima') . '").val());
        var potongan = unformatNumber($("#' . CHtml::activeId($model, 'totalpotongan') . '").val());
        value = gaji-(potongan+pajak);
            
        if (jQuery.isNumeric(value)){
            $("#' . CHtml::activeId($model, 'penerimaanbersih') . '").val(formatNumber(value));
        }
    }
', CClientScript::POS_HEAD); ?>

<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai2',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJRegistrasifingerprint();
if (isset($_GET['GJRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['GJRegistrasifingerprint'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai4-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#' . CHtml::activeId($model, 'mengetahui') . '\").val(\"$data->nama_pegawai\");
                                                      $(\"#dialogPegawai2\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        'tgl_lahirpegawai',
        'jeniskelamin',
        'statusperkawinan',
        'jabatan.jabatan_nama',
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai3',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJRegistrasifingerprint();
if (isset($_GET['GJRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['GJRegistrasifingerprint'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai5-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#' . CHtml::activeId($model, 'menyetujui') . '\").val(\"$data->nama_pegawai\");
                                                      $(\"#dialogPegawai3\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        'tgl_lahirpegawai',
        'jeniskelamin',
        'statusperkawinan',
        'jabatan.jabatan_nama',
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script>

    function konfirmasi()
    {
        location.reload();
    }

    function setGaji() {
        var totalGaji = 0;
        $(".gaji").each(function () {
            value = unformatNumber($(this).val());
            //value = value.replace(/(\d+),(?=\d{3}(\D|$))/g, "$1");
            if (value > 0) {
                totalGaji += parseInt(value);
            }
        });
        $("#<?php echo CHtml::activeId($model, 'totalterima') ?>").val(formatNumber(totalGaji));
        setHarga();
    }

    function hitungpph()
    {
        var totalgajipph = 0;
        $(".pph").each(function () {
            value = unformatNumber($(this).val());
            if (value > 0) {
                totalgajipph += value;
            }
        });

        totalgajipphtahun = totalgajipph * 12;
        $("#GJPenggajianpegT_gajipph").val(formatNumber(totalgajipphtahun));

        var biayajabatan = 0.05 * totalgajipphtahun;
        if (biayajabatan >= 6000000) {
            biayajabatan = 6000000;
        }
        $("#GJPenggajianpegT_biayajabatan").val(formatNumber(biayajabatan));
        $("#GJPenggajianpegT_iuranpensiun").val(formatNumber(2400000));
        var penerimaanbersih = totalgajipphtahun - biayajabatan - unformatNumber($("#GJPenggajianpegT_iuranpensiun").val());
        $("#GJPenggajianpegT_penerimaanpph").val(formatNumber(penerimaanbersih));

        var ptkp = unformatNumber($('#GJPenggajianpegT_ptkp').val());
        var pkp = penerimaanbersih - ptkp;
        if (pkp <= 0)
            pkp = 0;
        $("#GJPenggajianpegT_pkp").val(formatNumber(pkp));
        $.post('<?php echo Yii::app()->createUrl('penggajian/PenggajianpegTGJ/ambilpph'); ?>', {pkp: pkp}, function (data) {
            // $('#PenggajiankompT_komponengaji_id_10').val(data.jmltunjangan);
            // $('#harikerja').val(data.jmlhadir);
            // setTunjanganHarian();
            var persen = data.percent / 100;
            var persenpertahun = persen * pkp;
            var persenperbulan = persenpertahun / 12;
            var pembulatan = Math.round(persenperbulan * Math.pow(10, 0)) / Math.pow(10, 0);
            $('#GJPenggajianpegT_pphpersen').val(formatNumber(persenpertahun));
            $('#GJPenggajianpegT_pph21').val(formatNumber(persenperbulan));
            $('#PenggajiankompT_komponengaji_id_16').val(formatNumber(pembulatan));
            $('#PenggajiankompT_komponengaji_id_35').val(formatNumber(pembulatan));
            $('#GJPenggajianpegT_totalpajak').val(formatNumber(pembulatan));

            $("#label_persen").html('PPh (' + data.percent + ' %)');
            $('#GJPenggajianpegT_persentasepph21').val(data.percent);
            var statuskawin = $('#statusperkawinan').val();
            if (statuskawin == 'KAWIN') {
                var kodekawin = 'K';
            } else {
                var kodekawin = 'TK';
            }
            var jmlanak = $('#jml_tanggungan').val();
            if (jmlanak > 3) {
                jmlanak = 3;
            }
            var kdptkp = kodekawin + "/" + jmlanak;
            $('#GJPenggajianpegT_kodeptkp').val(kdptkp);
        }, 'json');

//        setPotongan();
//        setHarga();

    }



    function setPinjamanKoperasi(pegawai_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetPinjamanKoperasi'); ?>',
            data: {pegawai_id: pegawai_id},
            dataType: "json",
            success: function (data) {
                if (data.status = "ada") {
                    $('#PenggajiankompT_komponengaji_id_25').val(data.jmlcicilan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

</script>