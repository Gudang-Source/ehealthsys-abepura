<?php echo CHtml::css('input[type="checkbox"].span2{width:13px;}'); ?>
<?php if (!isset($modDetailPesan)) { ?>
    <fieldset class="box" id="fieldsetMenuDiet">
        <legend class="rim">Detail Menu Diet</legend>
        <table width="100%" border="0">
            <tr>
                <td width="80"> 	
                    <?php echo CHtml::hiddenField('jenisPesan'); ?>
                    <?php //echo $form->dropDownListRow($model, 'jenispesanmenu', GZPesanmenudietT::jenisPesan(), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'setJenisPesan()', 'maxlength' => 50)); ?>
                    <div class="control-group" id="jenispesanmenuGroup">
                        <label class='control-label'>Jenis Pesan Menu<span class="required">*</span></label>
                        <div class="controls">
                            <?php
                            echo CHtml::dropDownList('jenispesanmenu', '', GZPesanmenudietT::jenisPesan(), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'setJenisPesan()', 'maxlength' => 50));
                            ?>
                        </div>  
                    </div>

                    <div class="control-group" id="groupRuangan">
                        <label class='control-label'><?php echo CHtml::checkBox('cekRuangan', true, array('onclick' => 'setRuangan();', 'onkeypress' => "return $(this).focusNextInputField(event);",)) . ' '; ?><?php echo CHtml::encode($model->getAttributeLabel('ruangan_id')); ?><span class="required">*</span></label>
                        <div class="controls">
                            <?php echo CHtml::hiddenField('instalasi_id'); ?>
                            <?php echo CHtml::hiddenField('ruangan_id'); ?>
                            <?php
                            echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                                'ajax' => array('type' => 'POST',
                                    'url' => $this->createUrl('setDropdownRuangan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                    'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''),));
                            ?>
                            <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'clearAll()')); ?>
                            <?php echo $form->error($model, 'ruangan_id'); ?>
                        </div>
                    </div>
                    <div class="control-group" id="pegawaiGroup" style='display:none'>
                        <label class='control-label'>Nama Pegawai</label>
                        <div class="controls">
                            <?php echo CHtml::hiddenField('pegawai_id'); ?>

                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'namaPegawai',
                                'source' => 'js: function(request, response) {
                                                                   $.ajax({
                                                                       url: "' . Yii::app()->createUrl('ActionAutoComplete/pegawaiUntukMenuDiet') . '",
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
                                                                $("#pegawai_id").val(ui.item.pegawai_id); 
                                                                $("#ruangan_id").val(ui.item.ruangan_id);
                                                                $("#instalasi_id").val(ui.item.instalasi_id);
                                                                $("#namaPegawai").val(ui.item.label); 
                                                                return false;
                                                            }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                            ));
                            ?>
                        </div>
                    </div><div class="control-group" id="tamuGroup" style='display:none'>
                        <label class='control-label'>Jenis Kelamin</label>
                        <div class="controls">
                            <?php
                            echo CHtml::dropDownList('jeniskelamin', '', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'setJenisPesan()', 'maxlength' => 50));
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
                    </div></td>
                <td width="104" style="padding-right:180px;">
                    <div class="control-group ">
                        <label class='control-label'>Jenis Waktu</label>
                        <div class="controls">
                            <?php
                            $modJenisWaktu = JeniswaktuM::getJenisWaktu();
                            $myData = CHtml::encodeArray(CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_id'));
                            $myData = empty($myData) ? categories : $myData;
                            ?>
                            <?php //echo Chtml::checkBoxList('jeniswaktu', $myData, CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_nama'), array('template' => '<label class="checkbox inline">{input}{label}</label>', 'separator' => '', 'class' => 'span2 jeniswaktu', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>                
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
    <?php } ?>
    <div class="block-tabel">
        <h6>Tabel Pengiriman Menu <b>Diet Pegawai dan Tamu</b></h6>
        <table class="table table-striped table-condensed" id="tableMenuDiet">
            <thead>
                <tr>
                    <th rowspan="2"><center><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList', this);
                            hitungSemua();"></center></th>
            <th rowspan="2"><center>Instalasi/<br/>Ruangan</center></th>
            <th rowspan="2"><center>Nama Pegawai/Tamu</center></th>
            <th rowspan="2"><center>Jenis Kelamin</center></th>
            <th colspan="<?php echo count(JeniswaktuM::getJenisWaktu()); ?>"><center>Menu Diet</center></th>
            <th rowspan="2"><center>Jumlah</center></th>
            <th rowspan="2"><center>Satuan/URT</center></th>
            <th rowspan="2" hidden><center>Jenis Makanan</center></th>
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
                    foreach ($modDetailPesan AS $tampilData):
                        echo "<tr>
                    <td>"
                        . CHtml::checkBox('KirimmenupegawaiT[][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                        . CHtml::hiddenField('KirimmenupegawaiT[][ruangan_id]', $modPesan->ruangan_id)
                        . CHtml::hiddenField('KirimmenupegawaiT[][pegawai_id]', $tampilData->pegawai_id)
                        . CHtml::hiddenField('KirimmenupegawaiT[][satuanjml_urt]', $tampilData->satuanjml_urt)
                        . "</td>
                    <td>" . $modPesan->ruangan->instalasi->instalasi_nama . "/<br/>" . $modPesan->ruangan->ruangan_nama . "</td>";
                        if (!empty($tampilData->pegawai->nama_pegawai)) {
                            echo "<td>" . $tampilData->pegawai->nama_pegawai . "</td>   
                    <td>" . $tampilData->pegawai->jeniskelamin . "</td>";
                        } else {
                            echo "<td>Tamu " . $no . "</td>   
                    <td><center>-</center></td>";
                        }
                        foreach (JeniswaktuM::getJenisWaktu() as $row) {
                            $detail = GZPesanmenupegawaiT::model()->with('menudiet')->findByAttributes(array('pegawai_id' => $tampilData->pegawai_id, 'pesanmenudiet_id' => $tampilData->pesanmenudiet_id, 'jeniswaktu_id' => $row->jeniswaktu_id,));
                            if (empty($detail->menudiet_id)) {
                                echo "<td><center>-</center></td>";
                            } else {
                                echo "<td>" . CHtml::hiddenField('KirimmenupegawaiT[][jeniswaktu_id][' . $row->jeniswaktu_id . ']', $row->jeniswaktu_id)
                                . CHtml::hiddenField('KirimmenupegawaiT[][pesanmenupegawai_id][' . $row->jeniswaktu_id . ']', $detail->pesanmenupegawai_id)
                                . CHtml::hiddenField('KirimmenupegawaiT[][menudiet_id][' . $row->jeniswaktu_id . ']', $detail->menudiet_id, array('class' => 'menudiet')) . $detail->menudiet->menudiet_nama . "</td>";
                            }
                        };

                        echo "<td>" . CHtml::textField('KirimmenupegawaiT[][jml_kirim]', 0, array('class' => 'span1 numbersOnly jmlKirim', 'onblur' => 'cekStokMenuInput(this)')) . "</td>
                    <td>" . $tampilData->satuanjml_urt . "</td>";
                        echo "<td>" . CHtml::dropDownList('KirimmenupegawaiT[][status_menu]', '', LookupM::getItems('statusmakanan'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')) . "</td>";
                        "</tr>";
                        $no++;
                    endforeach;
                }
                ?>
            </tbody>
        </table>
    </div>