<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<fieldset class="box formjenisresep"  id="form-nonracikan">
    <legend class="rim-a">Data Obat (Non Racikan) <?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'terapiobat_reset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk me-refresh form obat non racik')); ?></legend>
    <div class="row-fluid">
        <?php echo CHtml::hiddenField('therapiobat_id', '', array('readonly' => true)) ?>
        <?php echo CHtml::hiddenField('therapiobat_id2', '', array('readonly' => true)) ?>
        <div class="control-group ">
            <?php echo CHtml::label('Kelas Therapi', 'therapiobat_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="input-append" style='display:inline'>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'therapiobat_nama',
                        'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('AutoCompleteTherapiObat') . '",
                                            dataType: "json",
                                            data: {
                                                    term: request.term,
                                                    therapiobat_id: $("#therapiobat_id").val(),
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
                                        $("#therapiobat_id").val(ui.item.therapiobat_id); 
                                        $("#therapiobat_nama").val(ui.item.therapiobat_nama); 
                                        setOAJoinTerapi();
                                        return false;
                                }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogTerapiObat'),
                    ));
                    ?>
                </div>      
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::hiddenField('obatalkes_id'); ?>
            <?php echo CHtml::hiddenField('obatalkes_kode'); ?>
            <label class="control-label" for="namaObat">Nama Obat</label>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namaObatNonRacik',
                    'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompleteObatReseptur') . '",
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
                        'select' => 'js:function( event, ui ) {
                                                       $(this).val( ui.item.label);
                                                       $("#form-nonracikan #obatalkes_id").val(ui.item.obatalkes_id);
                                                       $("#obatalkes_kode").val(ui.item.obatalkes_kode);
                                                                                                           setThreapiobat_id(ui.item.obatalkes_id);
                                                                                                           $("#form-nonracikan #signa").val(ui.item.signa);
                                                        return false;
                                                    }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogObat', 'idTombol' => 'tombolDialogOa'),
                    'htmlOptions' => array("rel" => "tooltip", "title" => "Pencarian Data Obat/Alkes", 'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Signa</label>
            <div class="controls">
                <?php echo CHtml::dropDownList('signa', '', LookupM::getItems('signa_oa'), array('class' => 'inputFormTabel span3', 'style' => 'width:100px;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
                <div class="control-group">
                        <label class="control-label">Etiket</label>
                        <div class="controls">
                                <?php echo CHtml::dropDownList('etiketnonracikan', '', LookupM::getItems('etiket'),array('style'=>'width:150px;')); ?>
                        </div>
                </div>
        <div class="control-group ">
            <label class="control-label" for="qty">Jumlah</label>
            <div class="controls">
                <?php echo CHtml::textField('qtyNonRacik', '1', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only')) ?>
            </div>
        </div>
        <div class="control-group ">
                        <label class="control-label" for=""></label>
                        <div class="controls">
                                <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                                array('onclick'=>'tambahObatNonRacik(this);return false;',
                                                          'class'=>'btn btn-primary',
                                                          'onkeypress'=>"tambahObatNonRacik(this);return false;",
                                                          'rel'=>"tooltip",
                                                          'title'=>"Klik untuk menambahkan ke tabel resep",)); ?>
                        </div>
                </div>
    </div>
</fieldset>
<fieldset class="box formjenisresep" id="form-racikan" >
                        <legend class="rim">Data Obat (Racikan)</legend>
                        <div id="formanak">
                                <div class="control-group " >
                                        <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                                        <label class="control-label" for="racikanKe">R ke</label>
                                        <div class="controls">
                                                <?php echo CHtml::dropDownList('racikanKe', '', CustomFunction::getDaftarAngka(),array('disabled'=>false,'class'=>'inputFormTabel span1','onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                                                <?php echo CHtml::htmlButton('<i class="icon-plus"></i> Racikan Baru',
                                                        array('onclick'=>'racikanBaru(this);return false;',
                                                                  'class'=>'btn-mini btn-default',
                                                                  'id'=>'tombolracikanbaru',
                                                                  'onkeypress'=>"racikanBaru(this);return false;",
                                                                        'disabled'=>true,
                                                                  'rel'=>"tooltip",
                                                                  'title'=>"Klik untuk input racikan baru",)); ?>
                                        </div>
                                </div>
                                <div class="control-group">
                                        <label class="control-label">Signa</label>
                                        <div class="controls">
                                                <?php echo CHtml::dropDownList('signaracikan', '', LookupM::getItems('signa_oa'),array('class'=>'inputFormTabel span1','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                                        </div>
                                </div>
                                <div class="control-group">
                                        <label class="control-label">Etiket</label>
                                        <div class="controls">
                                                <?php echo CHtml::dropDownList('etiketracikan', '', LookupM::getItems('etiket'),array('style'=>'width:150px;')); ?>
                                        </div>
                                </div>
                                <div class="control-group ">
                                        <label class="control-label" for="jmlKemasan">Jumlah Permintaan</label>
                                        <div class="controls">
                                                <?php echo CHtml::textField('jmlKemasanObat', '', array('disabled'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1  numbers-only','onblur'=>'hitungJumlahObat()', 'style'=>'text-align: right;')) ?>
                                                <?php echo CHtml::dropDownList('satuansediaan', '', LookupM::getItems(Params::LOOKUPTYPE_SEDIAANOBATRACIKAN),array('class'=>'inputFormTabel span1','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                                        </div>
                                </div>
                        </div>
                        <fieldset class="well">
                                <div class="control-group ">
                                        <label class="control-label" for="namaObatRacik">Nama Obat</label>
                                        <div class="controls">
                                                <?php 
                                                        $this->widget('MyJuiAutoComplete', array(
                                                                                        'name'=>'namaObatRacik',
                                                                                        'source'=>'js: function(request, response) {
                                                                                                                   $.ajax({
                                                                                                                           url: "'.$this->createUrl('AutocompleteObatReseptur').'",
                                                                                                                           dataType: "json",
                                                                                                                           data: {
                                                                                                                                   term: request.term,
                                                                                                                                   ruangantujuan_id: $("#RJResepturT_ruangan_id").val(),
                                                                                                                           },
                                                                                                                           success: function (data) {
                                                                                                                                           response(data);
                                                                                                                           }
                                                                                                                   })
                                                                                                                }',
                                                                                         'options'=>array(
                                                                                                   'showAnim'=>'fold',
                                                                                                   'minLength' => 2,
                                                                                                   'select'=>'js:function( event, ui ) {
                                                                                                                $(this).val( ui.item.label);
                                                                                                                $("#form-racikan #obatalkes_id").val(ui.item.obatalkes_id);
                                                                                                                $("#obatalkes_kode").val(ui.item.obatalkes_kode);
                                                                                                                $("#form-racikan #kekuatanObat").val(ui.item.kekuatan);
                                                                                                                hitungJumlahObat();
                                                                                                                return false;
                                                                                                        }',
                                                                                        ),
                                                                                        'htmlOptions'=>array("rel"=>"tooltip","title"=>"Pencarian Data Obat/Alkes",'disabled'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                                                                        'tombolDialog'=>array('idDialog'=>'dialogObatRacikan','idTombol'=>'tombolDialogOaRacikan'),
                                                                                )); 
                                                ?>
                                        </div>
                                </div>
                                <div class="control-group ">
                                        <label class="control-label" for="permintaan">Permintaan Dosis</label>
                                        <div class="controls">
                                                <?php echo CHtml::textField('permintaan', '', array('disabled'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1  float2','onblur'=>'hitungJumlahObat()', 'style'=>'text-align: right;')) ?>
                                                <?php echo CHtml::dropDownList('', '', LookupM::getItems('satuankekuatan'),array('class'=>'inputFormTabel span1','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                                                <?php echo Chtml::button("Pecahan", array('onclick'=>'$("#dialogPecahanDosis").dialog("open");', 'class'=>'btn btn-primary')); ?>
                                        </div>
                                </div>
                                <div class="control-group ">
                                        <label class="control-label" for="kekuatanObat">Kekuatan</label>
                                        <div class="controls">
                                                <?php echo CHtml::textField('kekuatanObat', '', array('disabled'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1  numbers-only','readonly'=>true,"rel"=>"tooltip","title"=>"Kekuatan diambil dari data obat yang dipilih", 'style'=>'text-align: right;')) ?>
                                                <span id="satuanKekuatanObat"></span>
                                        </div>
                                </div>
                                <div class="control-group ">
                                        <label class="control-label" for="qty">Jumlah Obat</label>
                                        <div class="controls">
                                                <?php echo CHtml::textField('qtyRacik', '', array('readonly'=>true,'onkeyup'=>'$("#qty").val($(this).val());','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'float2',"rel"=>"tooltip","title"=>"Jumlah Obat = Permintaan Dosis X Jumlah Permintaan / Kekuatan",'style'=>'width:50px;')) ?>
                                        </div>
                                </div>
                        </fieldset>

                        <div class="control-group ">
                                <label class="control-label" for=""></label>
                                <div class="controls">
                                        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                                        array('onclick'=>'tambahObatRacik(this);return false;',
                                                                  'class'=>'btn btn-primary',
                                                                  'id'=>'tomboltambahracikan',
                                                                  'onkeypress'=>"tambahObatRacik(this);return false;",
                                                                  'rel'=>"tooltip",
                                                                  'title'=>"Klik untuk menambahkan ke tabel resep",
                                                                  'disabled'=>true,)); ?>
                                </div>
                        </div>


        <!--<div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 42%;float2:right;margin-top:-70px;'>-->
        <!--<font style='font-size:9pt'>Keterangan : </font><br>-->
        <!--<font style='font-size:8pt'>Jumlah = Permintaan*Jumlah Kemasan/Kekuatan</font>-->
</fieldset>
<?php
//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTerapiObat',
    'options' => array(
        'title' => 'Obat Alkes Berdasarkan Therapi Obat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 480,
        'height' => 320,
        'resizable' => false,
    ),
));

$modTherapiobat = new FATherapiobatM('search');
$modTherapiobat->unsetAttributes();
if (isset($_GET['FATherapiobatM'])) {
//    $modTherapiobat->attributes = $_GET['FATherapiobatM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'therapiobat-grid',
    'dataProvider' => $modTherapiobat->searchDialog(),
    'filter' => $modTherapiobat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
												$(\"#therapiobat_id\").val(\"$data->therapiobat_id\"); 
												$(\"#therapiobat_nama\").val(\"$data->therapiobat_nama\"); 
                                                $(\'#dialogTerapiObat\').dialog(\'close\');
												setOAJoinTerapi();
											return false;"))',
        ),
        'therapiobat_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>	

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPecahanDosis',
    'options' => array(
        'title' => 'Pecahan Dosis',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 50,
        'minHeight' => 100,
        'resizable' => false,
    ),
)); ?>
        <?php echo CHtml::textField('dosis_pembliang', '', array('class'=>'span1 numbers-only', 'style'=>'text-align: right;'))." / ".
        CHtml::textField('dosis_penyebut', '', array('class'=>'span1 numbers-only', 'style'=>'text-align: right;'))." "; ?>
        <?php echo CHtml::button('OK', array('onclick'=>'hitungPecahanDosisRacikan()', 'class'=>'btn btn-primary')); ?>
<?php $this->endWidget(); ?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObat',
    'options' => array(
        'title' => 'Daftar Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));

$modObatDialog = new FAObatalkesM('searchObatFarmasi');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['FAObatalkesM'])) {
    $modObatDialog->attributes = $_GET['FAObatalkesM'];
    if (isset($_GET['FAObatalkesM']['therapiobat_id'])) {
        $modObatDialog->therapiobat_id = $_GET['FAObatalkesM']['therapiobat_id'];
    }
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkesDialog-m-grid',
    'dataProvider' => $modObatDialog->searchObatFarmasi(),
    'filter' => $modObatDialog,
    //'template' => "{items}\n{pager}",
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            $(\"#form-nonracikan #obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#obatalkes_kode\").val(\"$data->obatalkes_kode\");
                            $(\"#form-nonracikan #namaObatNonRacik\").val(\"$data->obatalkes_nama\");
							setThreapiobat_id(\"$data->obatalkes_id\");
							$(\"#form-nonracikan #signa\").val(\"$data->signa\");
							$(\"#dialogObat\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),
        array(
            'header'=>'Jenis Obat Alkes',
            'name'=>'jenisobatalkes_id',
            'type'=>'raw',
            'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes_nama : "")',
            'filter'=>  CHtml::activeDropDownList($modObatDialog, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll(array(
                'condition'=>'jenisobatalkes_aktif = true',
                'order'=>'jenisobatalkes_nama'
            )), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --')),
        ),

        array(
            'name'=>'obatalkes_kategori',
            'filter'=> CHtml::activeDropDownList($modObatDialog, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --'))
        ),
        array(
            'name'=>'obatalkes_golongan',
            'filter'=> CHtml::activeDropDownList($modObatDialog, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --'))
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'header' => 'Tgl. Kadaluarsa',
            'name' => 'tglkadaluarsa',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
            'filter' => '',
        ),
        array(
            'name' => 'satuankecil.satuankecil_nama',
            'header' => 'Satuan Kecil',
        ),
        array(
            'name' => 'satuanbesar.satuanbesar_nama',
            'header' => 'Satuan Besar',
        ),
        // dicomment karena RND-5732
//        array(
//            'header'=>'HJA Resep',
//            'type'=>'raw',
//            'value'=>'number_format($data->hjaresep, 0, ",", ".")',
//            'filter'=>'',
//            'htmlOptions'=>array('style'=>'text-align:right;'),
//        ),
//        array(
//            'header'=>'HJA Non Resep',
//            'value'=>'number_format($data->hjanonresep, 0, ",", ".")',
//            'filter'=>'',
//            'htmlOptions'=>array('style'=>'text-align:right;'),
//        ),
        array(
            'header' => 'Stok',
            'type' => 'raw',
            'value' => '$data->StokObatRuangan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObatRacikan',
    'options' => array(
        'title' => 'Daftar Obat Alkes Racikan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));

$modObatDialogRacikan = new FAObatalkesM('searchObatFarmasi');
$modObatDialogRacikan->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['FAObatalkesM']))
    $modObatDialogRacikan->attributes = $_GET['FAObatalkesM'];
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkesDialogRacikan-m-grid',
    'dataProvider' => $modObatDialogRacikan->searchObatFarmasi(),
    'filter' => $modObatDialogRacikan,
    'template' => "{items}\n{pager}",
//    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                           
                            $(\"#form-racikan #obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#obatalkes_kode\").val(\"$data->obatalkes_kode\");
                            $(\"#form-racikan #namaObatRacik\").val(\"$data->obatalkes_nama\");
                            $(\"#form-racikan #kekuatanObat\").val(\"$data->kekuatan\");
                            $(\"#dialogObatRacikan\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'header' => 'Tanggal Kadaluarsa',
            'name' => 'tglkadaluarsa',
            'filter' => '',
        ),
        array(
            'name' => 'satuankecil.satuankecil_nama',
            'header' => 'Satuan Kecil',
        ),
        array(
            'name' => 'satuanbesar.satuanbesar_nama',
            'header' => 'Satuan Besar',
        ),
        // dicomment karena RND-5732
//            array(
//                'header'=>'HJA Resep',
//                'type'=>'raw',
//                'value'=>'number_format($data->hjaresep, 0, ",", ".")',
//                'filter'=>'',
//                'htmlOptions'=>array('style'=>'text-align:right;'),
//            ),
//            array(
//                'header'=>'HJA Non Resep',
//                'value'=>'number_format($data->hjanonresep, 0, ",", ".")',
//                'filter'=>'',
//                'htmlOptions'=>array('style'=>'text-align:right;'),
//            ),
        array(
            'header' => 'Stok',
            'type' => 'raw',
            'value' => '$data->StokObatRuangan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
