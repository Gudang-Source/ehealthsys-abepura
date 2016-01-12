<?php echo CHtml::css('input[type="checkbox"].span2{width:13px;}'); ?>
<fieldset class="box" id="fieldsetMenuDiet">
    <?php // if (!isset($modDetailPesan)){ ?>
    <legend class="rim">Detail Menu Diet</legend>
    <table width="100%" border="0">
        <tr>
            <td width="80">
                <div class="control-group ">
                    <label class='control-label'><?php echo CHtml::encode($model->getAttributeLabel('instalasi_id')); ?><span class="required">*</span></label>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'instalasi_id', CHtml::listData($model->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                            'ajax' => array('type' => 'POST',
                                'url' => $this->createUrl('setDropdownRuangan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''),));
                        ?>
                        <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'clearAll()')); ?>
                        <?php echo $form->error($model, 'ruangan_id'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class='control-label'>Nama Pasien</label>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('pasien_id'); ?>
                        <?php echo CHtml::hiddenField('kelaspelayanan_id'); ?>
                        <?php echo CHtml::hiddenField('pendaftaran_id'); ?>
                        <?php echo CHtml::hiddenField('pasienadmisi_id'); ?>
                        <?php echo CHtml::hiddenField('daftartindakan_id'); ?>
                        <?php echo CHtml::hiddenField('satuanTarif'); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'namaPasien',
                            'source' => 'js: function(request, response) {
                                                                   $.ajax({
                                                                       url: "' . Yii::app()->createUrl('ActionAutoComplete/pasienUntukMenuDiet') . '",
                                                                       dataType: "json",
                                                                       data: {
                                                                           term: request.term,
                                                                           idRuangan:$("#' . CHtml::activeId($model, 'ruangan_id') . '").val(),
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
                                                                $("#pasien_id").val(ui.item.pasien_id); 
                                                                $("#pendaftaran_id").val(ui.item.pendaftaran_id); 
                                                                $("#pasienadmisi_id").val(ui.item.pasienadmisi_id); 
                                                                return false;
                                                            }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPasien'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group ">
                    <label class='control-label'>Menu Diet</label>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('menudiet_id'); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'menuDiet',
                            'source' => 'js: function(request, response) {
                                                                   $.ajax({
                                                                       url: "' . Yii::app()->createUrl('ActionAutoComplete/menuDiet') . '",
                                                                       dataType: "json",
                                                                       data: {
                                                                           term: request.term,
                                                                           kelaspelayananId: $("#kelaspelayanan_id").val(),
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
                                                                $("#menudiet_id").val(ui.item.menudiet_id);
                                                                $("#daftartindakan_id").val(ui.item.daftartindakan_id);
                                                                $("#URT").val(ui.item.ukuranrumahtangga); 
                                                                return false;
                                                            }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span2',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogMenuDiet'),
                        ));
                        ?>

                    </div>
                </div>
            </td>
            <td width="104" style="padding-right:180px;">
                <div class="control-group ">
                    <label class='control-label'>Jenis Waktu</label>
                    <div class="controls">
                        <?php
                        $modJenisWaktu = JeniswaktuM::model()->findAll('jeniswaktu_aktif = true');
                        $myData = CHtml::encodeArray(CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_id'));
                        $myData = empty($myData) ? categories : $myData;
                        ?>
                        <?php echo Chtml::checkBoxList('jeniswaktu', false, CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_nama'), array('template' => '<label class="checkbox inline">{input}{label}</label>', 'separator' => '', 'class' => 'span2 jeniswaktu', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>                
                    </div>
                </div>
                <div class="control-group ">
                    <label class='control-label'>Jumlah</label>
                    <div class="controls">
                        <?php echo Chtml::textField('jumlah', 1, array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
                        <?php echo Chtml::dropDownList('URT', '', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>                
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'inputMenuDiet();return false;',
                            'class' => 'btn btn-primary',
                            'onkeypress' => "inputMenuDiet();return $(this).focusNextInputField(event)",
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan Menu Diet",));
                        ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</fieldset>
    <?php // }?>
    <div class="block-tabel">
        <h6>Tabel Pengiriman <b>Menu Diet Pasien</b></h6>
        <div style="overflow:auto;width:100%">
            <table class="table table-striped table-condensed" id="tableMenuDiet" >
                <thead>
                    <tr>
                        <th rowspan="2"><center><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList', this);
                                hitungSemua();"></center></th>
                <th rowspan="2"><center>Instalasi/<br/>Ruangan</center></th>
                <th rowspan="2"><center>No. Pendaftaran/<br/>No. Rekam Medik</center></th>
                <th rowspan="2"><center>Nama Pasien</center></th>
                <th rowspan="2"><center>Umur</center></th>
                <th rowspan="2"><center>Jenis Kelamin</center></th>
                <th colspan="<?php echo count(JeniswaktuM::getJenisWaktu()); ?>"><center>Menu Diet</center></th>
                <th rowspan="2"><center>Jumlah</center></th>
                <th rowspan="2"><center>Satuan/URT</center></th>
                <th rowspan="2"><center>Jenis Makanan</center></th>
                <th rowspan="2"><center>Riwayat Pemeriksaan</center></th>
                </tr>
                <tr>
                    <?php
                    foreach (JeniswaktuM::getJenisWaktu() as $row) {
                        echo '<th><center>' . $row->jeniswaktu_nama . '</center></th>';
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                    <?php
                    if ($modDetailPesan > 0) {
                        $no = 1;
                        foreach ($modDetailPesan AS $i => $tampilData):
                            echo "<tr>
                    <td>"
                            . CHtml::checkBox('KirimmenupasienT[' . $i . '][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][ruangan_id]', $modPesan->ruangan_id)
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][pendaftaran_id]', $tampilData->pendaftaran_id)
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][pasienadmisi_id]', $tampilData->pasienadmisi_id)
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][pasien_id]', $tampilData->pasien_id)
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][satuanjml_urt]', $tampilData->satuanjml_urt)
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][penjamin_id]', $tampilData->pendaftaran->penjamin_id)
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][jeniskasuspenyakit_id]', $tampilData->pendaftaran->jeniskasuspenyakit_id)
                            . "</td>
                    <td>" . $modPesan->ruangan->instalasi->instalasi_nama . "/<br/>" . $modPesan->ruangan->ruangan_nama . "</td>
                    <td>" . $tampilData->pendaftaran->no_pendaftaran . "/<br/>" . $tampilData->pasien->no_rekam_medik . "</td>   
                    <td>" . $tampilData->pasien->nama_pasien . "</td>   
                    <td>" . $tampilData->pendaftaran->umur . "</td>   
                    <td>" . $tampilData->pasien->jeniskelamin . "</td>";

                            foreach (JeniswaktuM::getJenisWaktu() as $row) {
                                $detail = GZPesanmenudetailT::model()->with('menudiet')->findByAttributes(array('pendaftaran_id' => $tampilData->pendaftaran_id, 'pasienadmisi_id' => $tampilData->pasienadmisi_id, 'pesanmenudiet_id' => $tampilData->pesanmenudiet_id, 'jeniswaktu_id' => $row->jeniswaktu_id, 'menudiet_id' => $tampilData->menudiet_id));
                                if (empty($detail->pasienadmisi_id)) {
                                    if (isset($detail->pendaftaran)) {
                                        $kelaspelayanan_id = $detail->pendaftaran->kelaspelayanan_id;
                                    } else {
                                        $kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                                    }
                                } else {
                                    $kelaspelayanan_id = $detail->pasienadmisi->kelaspelayanan_id;
                                }
                                $modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id' => (isset($detail->menudiet) ? $detail->menudiet->daftartindakan_id : 0), 'kelaspelayanan_id' => $kelaspelayanan_id, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL), array('order' => 'tariftindakan_id asc', 'limit' => 1));
    //                    $tarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id'=>$daftartindakan_id,'kelaspelayanan_id'=>$kelaspelayanan_id,'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
                                if (count($modTarif) < 0) {
                                    $modTarif = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id' => $detail->menudiet->daftartindakan_id, 'kelaspelayanan_id' => Params::KELASPELAYANAN_ID_TANPA_KELAS, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL), array('order' => 'tariftindakan_id asc', 'limit' => 1));
                                }

                                //echo '--->' . count($modTarif);
                                if (empty($detail->menudiet_id)) {
                                    echo "<td><center>-</center></td>";
                                } else {
                                    echo "<td>" . CHtml::hiddenField('KirimmenupasienT[' . $i . '][jeniswaktu_id][' . $row->jeniswaktu_id . ']', $row->jeniswaktu_id, array('class' => 'jeniswaktu_id'))
                                    . CHtml::hiddenField('KirimmenupasienT[' . $i . '][pesanmenudetail_id][' . $row->jeniswaktu_id . ']', $detail->pesanmenudetail_id)
                                    . CHtml::hiddenField('KirimmenupasienT[' . $i . '][menudiet_id][' . $row->jeniswaktu_id . ']', $detail->menudiet_id)
                                    . CHtml::textField('KirimmenupasienT[' . $i . '][menudiet_nama][' . $row->jeniswaktu_id . ']', $detail->menudiet->menudiet_nama, array('class' => 'span2 menudiet_nama', 'readonly' => false))
                                    . CHtml::link("<span class='icon-list-alt'></span><span class='icon-search'></span>", '', array('href' => '', 'onclick' => '$("#dialogDaftarMenuDiet").dialog("open");getIdJenisWaktu(' . $row->jeniswaktu_id . ',' . $i . ');return false;', 'style' => 'text-decoration:none;', 'rel' => 'tooltip', 'title' => 'Klik untuk mengubah menu diet'))
    //                                    . $detail->menudiet->menudiet_nama
                                    . CHtml::hiddenField('KirimmenupasienT[' . $i . '][daftartindakan_id][' . $row->jeniswaktu_id . ']', $detail->menudiet->daftartindakan_id)
                                    . CHtml::hiddenField('KirimmenupasienT[' . $i . '][carabayar_id][' . $row->jeniswaktu_id . ']', $detail->pendaftaran->carabayar_id)
                                    . CHtml::hiddenField('KirimmenupasienT[' . $i . '][kelaspelayanan_id][' . $row->jeniswaktu_id . ']', $detail->pendaftaran->kelaspelayanan_id)
                                    . '<br/>' . CHtml::hiddenField('KirimmenupasienT[' . $i . '][satuanTarif][' . $row->jeniswaktu_id . ']', (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0, array('class' => 'span2')) .
                                    "</td>";
                                }
                            };

                            echo "<td>" . CHtml::textField('KirimmenupasienT[' . $i . '][jml_kirim]', $tampilData->jml_pesan_porsi, array('class' => 'span1 numbersOnly')) . "</td>
                    <td>" . $tampilData->satuanjml_urt . "</td>";
                            echo "<td>" . CHtml::dropDownList('KirimmenupasienT[' . $i . '][status_menu]', '', LookupM::getItems('statusmakanan'), array('class' => 'inputFormTabel span2', 'empty' => '--Pilih--')) . "</td>";
                            echo "<td><center>" . CHtml::link("<i class='icon-list-alt'></i> ", Yii::app()->controller->createUrl("/gizi/RiwayatPasienMenuDiet/index", array("pendaftaran_id" => $tampilData->pendaftaran_id)), array("pendaftaran_id" => "$tampilData->pendaftaran_id",
                                "target" => "frameRiwayat",
                                "rel" => "tooltip",
                                "title" => "Klik untuk melihat riwayat pemeriksaan pasien",
                                "onclick" => "window.parent.$('#dialogRiwayat').dialog('open')")) . "</center></td>";
                            "</tr>";
                            $no++;

                        endforeach;
                    }
                    ?>

                    <?php
                    if ($modDetailKirim > 0) {
                        $no = 1;
                        foreach ($modDetailKirim AS $i => $tampilData):
                            echo "<tr>
                    <td>"
                            . CHtml::checkBox('KirimmenupasienT[' . $i . '][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][ruangan_id]', $tampilData->ruangan_id)
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][pendaftaran_id]', $tampilData->pendaftaran_id)
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][pasienadmisi_id]', $tampilData->pasienadmisi_id)
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][pasien_id]', $tampilData->pasien_id)
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][satuanjml_urt]', $tampilData->satuanjml_urt)
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][penjamin_id]', $tampilData->pendaftaran->penjamin_id)
                            . CHtml::hiddenField('KirimmenupasienT[' . $i . '][jeniskasuspenyakit_id]', $tampilData->pendaftaran->jeniskasuspenyakit_id)
                            . "</td>
                    <td>" . $tampilData->ruangan->instalasi->instalasi_nama . "/<br/>" . $tampilData->ruangan->ruangan_nama . "</td>
                    <td>" . $tampilData->pendaftaran->no_pendaftaran . "/<br/>" . $tampilData->pasien->no_rekam_medik . "</td>   
                    <td>" . $tampilData->pasien->nama_pasien . "</td>   
                    <td>" . $tampilData->pendaftaran->umur . "</td>   
                    <td>" . $tampilData->pasien->jeniskelamin . "</td>";

                            foreach (JeniswaktuM::getJenisWaktu() as $row) {
                                $detail = GZPesanmenudetailT::model()->with('menudiet')->findByAttributes(array('pendaftaran_id' => $tampilData->pendaftaran_id, 'pasienadmisi_id' => $tampilData->pasienadmisi_id, 'pesanmenudiet_id' => $tampilData->kirimmenudiet->pesanmenudiet_id, 'jeniswaktu_id' => $row->jeniswaktu_id, 'menudiet_id' => $tampilData->menudiet_id));
                                if (empty($detail->pasienadmisi_id)) {
                                    if (isset($detail->pendaftaran)) {
                                        $kelaspelayanan_id = $detail->pendaftaran->kelaspelayanan_id;
                                    } else {
                                        $kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                                    }
                                } else {
                                    $kelaspelayanan_id = $detail->pasienadmisi->kelaspelayanan_id;
                                }
                                $modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id' => (isset($detail->menudiet) ? $detail->menudiet->daftartindakan_id : 0), 'kelaspelayanan_id' => $kelaspelayanan_id, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL), array('order' => 'tariftindakan_id asc', 'limit' => 1));
    //                    $tarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id'=>$daftartindakan_id,'kelaspelayanan_id'=>$kelaspelayanan_id,'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
                                if (count($modTarif) < 0) {
                                    $modTarif = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id' => $detail->menudiet->daftartindakan_id, 'kelaspelayanan_id' => Params::KELASPELAYANAN_ID_TANPA_KELAS, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL), array('order' => 'tariftindakan_id asc', 'limit' => 1));
                                }

                                //echo '--->' . count($modTarif);
                                if (empty($detail->menudiet_id)) {
                                    echo "<td><center>-</center></td>";
                                } else {
                                    echo "<td>" . CHtml::hiddenField('KirimmenupasienT[' . $i . '][jeniswaktu_id][' . $row->jeniswaktu_id . ']', $row->jeniswaktu_id, array('class' => 'jeniswaktu_id'))
                                    . CHtml::hiddenField('KirimmenupasienT[' . $i . '][pesanmenudetail_id][' . $row->jeniswaktu_id . ']', $detail->pesanmenudetail_id)
                                    . CHtml::hiddenField('KirimmenupasienT[' . $i . '][menudiet_id][' . $row->jeniswaktu_id . ']', $detail->menudiet_id)
    //                                    .CHtml::textField('KirimmenupasienT['.$i.'][menudiet_nama]['.$row->jeniswaktu_id.']',$detail->menudiet->menudiet_nama,array('class'=>'span2 menudiet_nama','readonly'=>false))
    //                                    .CHtml::link("<span class='icon-list-alt'></span><span class='icon-search'></span>",'',array('href'=>'','onclick'=>'$("#dialogDaftarMenuDiet").dialog("open");getIdJenisWaktu('.$row->jeniswaktu_id.','.$i.');return false;','style'=>'text-decoration:none;','rel'=>'tooltip','title'=>'Klik untuk mengubah menu diet'))
                                    . $detail->menudiet->menudiet_nama
                                    . CHtml::hiddenField('KirimmenupasienT[' . $i . '][daftartindakan_id][' . $row->jeniswaktu_id . ']', $detail->menudiet->daftartindakan_id)
                                    . CHtml::hiddenField('KirimmenupasienT[' . $i . '][carabayar_id][' . $row->jeniswaktu_id . ']', $detail->pendaftaran->carabayar_id)
                                    . CHtml::hiddenField('KirimmenupasienT[' . $i . '][kelaspelayanan_id][' . $row->jeniswaktu_id . ']', $detail->pendaftaran->kelaspelayanan_id)
                                    . '<br/>' . CHtml::hiddenField('KirimmenupasienT[' . $i . '][satuanTarif][' . $row->jeniswaktu_id . ']', (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0, array('class' => 'span2')) .
                                    "</td>";
                                }
                            };

                            echo "<td>" . $tampilData->jml_kirim . "</td>
                    <td>" . $tampilData->satuanjml_urt . "</td>";
                            echo "<td>" . $tampilData->satuanjml_urt . "</td>";
    //                echo "<td>".CHtml::dropDownList('KirimmenupasienT['.$i.'][status_menu]', '', LookupM::getItems('statusmakanan'),array('class'=>'inputFormTabel span2','empty'=>'--Pilih--'))."</td>";
                            "</tr>";
                            $no++;

                        endforeach;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
//========= Dialog buat cari Bahan Diet =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDaftarMenuDiet',
        'options' => array(
            'title' => 'Daftar Menu Diet',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modMenuDiet = new GZMenuDietM('search');
    $modMenuDiet->unsetAttributes();
    if (isset($_GET['GZMenuDietM']))
        $modMenuDiet->attributes = $_GET['GZMenuDietM'];
    if (isset($_GET['kelaspelayanan_id'])) {
        $modMenuDiet->kelaspelayanan_id = $_GET['kelaspelayanan_id'];
    }
    if (isset($_GET['GZJenisdietM']['jenisdiet_id'])) {
        $modMenuDiet->idJenisDiet = $_GET['GZJenisdietM']['jenisdiet_id'];
    }
    if (isset($_POST['kelaspelayanan_id'])) {
        $kelaspelayanan = $_POST['kelaspelayanan_id'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'gzmenudiet-m',
        'dataProvider' => $modMenuDiet->searchMenuDiet(),
        'filter' => $modMenuDiet,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "$(\'#menudiet_id\').val($data->menudiet_id);
                                    $(\'#menuDiet\').val(\'$data->menudiet_nama\');
                                    $(\'#daftartindakan_id\').val(\'$data->daftartindakan_id\');
                                    $(\'#URT\').val(\'$data->ukuranrumahtangga\');
                                    ubahMenu(\'$data->menudiet_id\',\'$data->menudiet_nama\',\'$data->daftartindakan_id\');
                                    $(\'#dialogDaftarMenuDiet\').dialog(\'close\');return false;"))',
            ),
//        array(
//                        'name'=>'menudiet_id',
//                        'value'=>'$data->menudiet_id',
//                        'filter'=>false,
//                ),
            array(
                'header' => 'No. Urut',
                'value' => '$row+1',
                'filter' => false,
            ),
            array(
                'header' => 'Jenis Diet',
                'name' => 'jenisdiet_nama',
                'type' => 'raw',
                'value' => '$data->jenisdiet->jenisdiet_nama',
            ),
            'menudiet_nama',
            'menudiet_namalain',
            'jml_porsi',
            'ukuranrumahtangga',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    ?>        

    <?php
//========= Dialog untuk Melihat Riwayat Pemeriksaan Pasien =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogRiwayat',
        'options' => array(
            'title' => 'Riwayat Pemeriksaan Pasien Menu Diet',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1020,
            'height' => 480,
            'resizable' => true,
        ),
    ));

    echo '<iframe src="" name="frameRiwayat" width="100%" height="100%">
</iframe>';

    $this->endWidget();
    ?>
