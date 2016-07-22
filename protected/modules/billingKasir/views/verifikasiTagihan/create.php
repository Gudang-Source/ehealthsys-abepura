<style>
    .tarif{
        color:red;
    }
</style>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js'); ?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js'); ?>
<div class="white-container">
    <legend class="rim2">Verifikasi <b>Tagihan</b></legend>
    <?php
        //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); 
        //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');
        $pembulatanHarga = Yii::app()->user->getState('pembulatanharga');
        // $this->widget('application.extensions.moneymask.MMask',
        //     array(
        //         'element'=>'.currency',
        //         'currency'=>'PHP',
        //         'config'=>array(
        //             'symbol'=>'Rp ',
        //             'defaultZero'=>true,
        //             'allowZero'=>true,
        //             'precision'=>0,
        //         )
        //     )
        // );

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
            array(
                'id'=>'verifikasi-tagihan-form',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#BKPendaftaranT_instalasi_id',
                'htmlOptions'=>array(
                    'onKeyPress'=>'return disableKeyPress(event)',
                    'onsubmit'=>'return requiredCheck(this);return false;'
                ),
            )
        );    
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); 

        if(isset($_GET['id'])){
            echo Yii::app()->user->setFlash('success',"Data berhasil disimpan");
        }

    ?>
    <?php echo $form->errorSummary(array($modVerifikasi)); ?>
    <?php
        $this->renderPartial('billingKasir.views.verifikasiTagihan._ringkasDataPasien',
            array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien
            )
        );
    ?>
    <div class="block-tabel" id="daftar_tindakan">
        <h6>Daftar <b>Tindakan</b></h6>
        <table id="tblBayarTind" class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th width="20" style="display:none;">Pilih<br>
                        <?php 
                            $checkSemua = true;
                            echo CHtml::checkBox(
                                'checkTindakan',
                                $checkSemua,
                                array(
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                    'class'=>'checkbox-column',
                                    'onclick'=>'checkAllTindakan()',
                                    'id'=>'checkTindakan',
                                )
                            );
                        ?>
                    </th>
                    <th width="80">Tanggal</th>
                    <th>Nama Tindakan</th>
                    <!-- <th width="100">Ruangan</th> -->
                    <th width="100">Jumlah</th>
                    <th width="100">Tarif</th>
                    <th width="100">Tarif Cyto</th>
                    <th width="100">Discount (Rp.)</th>
                    <th width="100">Subsidi Asuransi</th>
                    <th width="100">Subsidi Rumah Sakit</th>
                    <th width="100">Iur Biaya</th>
                    <th width="100">Sub Total</th>
                    <!-- <th width="20" style="text-align:center;">
                        <a onclick="tambahTindakan(this);return false;" rel="tooltip" href="#" data-original-title="Klik untuk menambah tindakan">
                            <i class="icon-plus"></i>
                        </a>
                    </th> -->
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="block-tabel" id="daftar_alkes">
        <h6>Daftar <b>Obat Alkes</b></h6>
        <!-- <table>
            <tr>
                <td colspan="2">
                    <?php echo CHtml::radioButton('pilihAlkes', true, array('value'=>'bahan','onclick'=>'pilihAlkesMedis(this);')); ?>
                    Pemakaian Bahan
                    <?php echo CHtml::radioButton('pilihAlkes', false, array('value'=>'medis','onclick'=>'pilihAlkesMedis(this);')); ?>
                    Paket BMHP
                </td>
            </tr>
            <tr>
                <td width="180px">
                    <?php echo CHtml::dropDownList('daftartindakanPemakaianBahan', '',array(),array('empty'=>'Nama Tindakan')) ?>
                </td>
                <td>
                    <?php $this->widget('MyJuiAutoComplete',array(
                                'name'=>'pakaiBahan',
                                'value'=>'',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.Yii::app()->createUrl('ActionAutoComplete/PemakaianBahan').'",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                       idTipePaket: $("#RJTindakanPelayananT_0_tipepaket_id").val(),
                                                       idKelasPelayanan: $("#RJPendaftaranT_kelaspelayanan_id").val(),
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                'options'=>array(
                                   'showAnim'=>'fold',
                                   'minLength' => 2,
                                   'focus'=> 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                    }',
                                   'select'=>'js:function( event, ui ) {
                                        inputPemakaianBahan(ui.item.obatalkes_id);
                                        return false;
                                    }',

                                ),
                                'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2', 'placeholder'=>'Pemakaian Bahan'),
                                'tombolDialog'=>array('idDialog'=>'dialogAlkes'),
                    )); ?>                

                    <?php
                        $this->widget('MyJuiAutoComplete',
                            array(
                                'name'=>'alatMedis',
                                'value'=>'',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.Yii::app()->createUrl('ActionAutoComplete/PemakaianAlatMedis').'",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                'options'=>array(
                                   'showAnim'=>'fold',
                                   'minLength' => 2,
                                   'focus'=> 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                    }',
                                   'select'=>'js:function( event, ui ) {
                                        inputAlatmedis(ui.item.alatmedis_id);
                                        return false;
                                    }',

                                ),
                                'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2', 'placeholder'=>'Paket BMHP'),
                                'tombolDialog'=>array('idDialog'=>'dialogAlatmedis'),
                            )
                        );
                    ?>
                </td>
            </tr>
        </table> -->
        <table id="tblBayarOA" class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th width="20" style="display:none;">Pilih<br>
                        <?php 
                            echo CHtml::checkBox('checkAllObat',$checkSemua,
                                array(
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                    'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked'
                                )
                            );
                        ?>
                    </th>
                    <th width="80">Tanggal</th>
                    <th>Nama Obat Alkes</th>
                    <th width="100">Jumlah</th>
                    <th width="100">Harga Satuan</th>
                    <th width="100">Discount (Rp.)</th>
                    <th width="100">Adm/Serv/Kons</th>
                    <th width="100">Subsidi Asuransi</th>
                    <!-- <th width="100">Subsidi Pemerintah</th> -->
                    <th width="100">Subsidi Rumah Sakit</th>
                    <th width="100">Iur Biaya</th>
                    <th width="100">Sub Total</th>
                    <!-- <th width="20" style="text-align:center;">&nbsp; -->
                        <!--
                        <a onclick="tambahObatAlkes(this);return false;" rel="tooltip" href="#" data-original-title="Klik untuk menambah obat alkes">
                            <i class="icon-plus"></i>
                        </a>
                        -->
                    <!-- </th> -->
                </tr>
            </thead>
            <tbody></tbody>    
        </table>
    </div>
    <br>
    <fieldset class="box" id="form_verifikasi">
        <legend class="rim">Verifikasi Tagihan</legend>
        <table style="width:100%;">
            <tr>
                <td>
                    <div class="control-group ">
                        <label for="total_pembayaran" class="control-label">
                            Total Pembayaran
                        </label>
                        <div class="controls">
                            <?php
                                echo CHtml::textField("total_pembayaran", 
                                    0,
                                    array(
                                        'onblur'=>'hitungTotalSemuaTind();',
                                        'class'=>'span2 integer'
                                    )
                                );
                            ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <label for="total_subsidi_asuransi" class="control-label">
                            Total Subsidi Asuransi
                        </label>
                        <div class="controls">
                            <?php
                                echo CHtml::textField("total_subsidi_asuransi", 
                                    0,
                                    array(
                                        'onblur'=>'hitungTotalSemuaTind();',
                                        'class'=>'span2 integer'
                                    )
                                );
                            ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <label for="total_subsidi_rs" class="control-label">
                            Total Subsidi RS
                        </label>
                        <div class="controls">
                            <?php
                                echo CHtml::textField("total_subsidi_rs", 
                                    0,
                                    array(
                                        'onblur'=>'hitungTotalSemuaTind();',
                                        'class'=>'span2 integer'
                                    )
                                );
                            ?>
                        </div>
                    </div>
                    <!-- <div class="control-group ">
                        <label for="total_subsidi_pemerintah" class="control-label">
                            Total Subsidi Pemerintah
                        </label>
                        <div class="controls">
                            <?php
                                echo CHtml::textField("total_subsidi_pemerintah", 
                                    0,
                                    array(
                                        'onblur'=>'hitungTotalSemuaTind();',
                                        'class'=>'span2 currency'
                                    )
                                );
                            ?>
                        </div>
                    </div> -->
                </td>
                <td>
                    <div class="control-group ">
                        <label for="VerifikasitagihanT_tglverifikasi" class="control-label required">
                            Tanggal Verifikasi <span class="required">*</span>
                        </label>
                        <div class="controls">
                            <?php
                                $this->widget('MyDateTimePicker',
                                    array(
                                        'model'=>$modVerifikasi,
                                        'attribute'=>"tglverifikasi",
                                        'mode'=>'datetime',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                            'yearRange'=> "-60:+0",
                                        ),
                                        'htmlOptions'=>array(
                                            'readonly'=>true,
                                            'class'=>'dtPicker3', 
                                            'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                                    )
                                );    
                            ?>
                        </div>
                    </div>    
                    <?php
                        echo $form->textFieldRow($modVerifikasi,'noverifikasi',
                            array(
                                'class'=>'inputRequire', 
                                'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                'maxlength'=>50,
                                'readonly'=>TRUE
                            )
                        );
                    ?>
                    <?php
                        echo $form->dropDownListRow($modVerifikasi,'mengetahuioleh_id', CHtml::listData($modVerifikasi->getPegawaiItems(Yii::app()->user->getState('ruangan_id')), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)"));

                        // echo $form->dropDownListRow($modVerifikasi,'mengetahuioleh_id', CHtml::listData($model->getDokterItems($model->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                    ?>               
                </td>
                <td>
                    <?php
                        echo $form->textAreaRow($modVerifikasi,'keteranganverifikasi',
                            array(
                                'class'=>'inputRequire', 
                                'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                'maxlength'=>50,
                            )
                        );
                    ?> 
                </td>
            </tr>
        </table>
    </fieldset>
    <div class="form-actions">
            <?php 
                if(!isset($_GET['id'])){
                    echo CHtml::htmlButton(
                        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array(
                            'class'=>'btn btn-primary', 
                            'type'=>'submit',
                            'id'=>'btn_simpan',
                            'onKeypress'=>'return formSubmit(this,event)',
                            //'onClick'=>'onClickSubmit();return false;',

                        )
                    );
                    echo "&nbsp;";
                }else{
                    echo CHtml::htmlButton(
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array(
                            'class'=>'btn btn-primary', 
                            'type'=>'submit',
                            'id'=>'btn_simpan',
                            'onKeypress'=>'return formSubmit(this,event)',
                            //'onClick'=>'onClickSubmit();return false;',
                            'disabled'=>true,

                        )
                    );
                    echo "&nbsp;";
                }
                                
        
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index') . '";}); return false;'));
        
                echo "&nbsp;";
                $content = $this->renderPartial('tips',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        
    </div>
    <?php
        $this->endWidget();
    ?>

    <?php
        //========= Dialog buat cari data Alat Kesehatan =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog',
            array(
                'id'=>'dialogAlkes',
                'options'=>array(
                    'title'=>'Alat Kesehatan',
                    'autoOpen'=>false,
                    'modal'=>true,
                    'width'=>680,
                    'height'=>600,
                    'resizable'=>false,
                ),
            )
        );

            $moObatAlkes = new ObatalkesM();
            $moObatAlkes->unsetAttributes();
            if(isset($_GET['ObatalkesM']))
                $moObatAlkes->attributes = $_GET['ObatalkesM'];

            $this->widget('ext.bootstrap.widgets.BootGridView',
                array(
                    'id'=>'rjobat-alkes-m-grid',
                    'dataProvider'=>$moObatAlkes->searchObatFarmasi(),
                    'filter'=>$moObatAlkes,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                            'obatalkes_kategori',
                            'obatalkes_nama',
                            'obatalkes_golongan',
                            array(
                                'name'=>'satuankecilNama',
                                'value'=>'$data->satuankecil->satuankecil_nama',
                            ),
                            array(
                                'name'=>'sumberdanaNama',
                                'value'=>'$data->sumberdana->sumberdana_nama',
                            ),
                            'minimalstok',
                            array(
                                'name'=>'hargajual',
                                'value'=>'number_format($data->hargajual)',
                            ),
                            array(
                                'header'=>'Pilih',
                                'type'=>'raw',
                                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                                "id" => "selectObat",
                                                "onClick" => "inputPemakaianBahan($data->obatalkes_id);return false;"))',
                            ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )
            );
        $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>

    <?php
    //========= Dialog buat cari data Alat Kesehatan =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog',
            array(
                'id'=>'dialogAlatmedis',
                'options'=>array(
                    'title'=>'Paket BMHP',
                    'autoOpen'=>false,
                    'modal'=>true,
                    'width'=>600,
                    'height'=>600,
                    'resizable'=>false,
                ),
            )
        );

        // $filtersForm = new MyFiltersForm;
        // if (isset($_GET['MyFiltersForm']))
        //     $filtersForm->filters=$_GET['MyFiltersForm'];

        // $command = Yii::app()->db->createCommand();
        // $command->select = 'paketbmhp_m.daftartindakan_id, daftartindakan_m.daftartindakan_nama, paketbmhp_m.kelompokumur_id, kelompokumur_m.kelompokumur_nama, SUM(hargapemakaian) as hargapemakaian';
        // $command->from = 'paketbmhp_m';
        // $command->group = 'paketbmhp_m.daftartindakan_id, daftartindakan_m.daftartindakan_nama, paketbmhp_m.kelompokumur_id, kelompokumur_m.kelompokumur_nama';
        // $command->order = 'paketbmhp_m.daftartindakan_id';
        // $command->leftJoin('daftartindakan_m', 'paketbmhp_m.daftartindakan_id = daftartindakan_m.daftartindakan_id', array());
        // $command->leftJoin('kelompokumur_m','paketbmhp_m.kelompokumur_id = kelompokumur_m.kelompokumur_id');

        // if(!empty($filtersForm->filters['daftartindakanNama'])){
        //     $command->where(array('like', 'LOWER(daftartindakan_m.daftartindakan_nama)', '%'.strtolower($filtersForm->filters['daftartindakanNama']).'%'));
        // }
        // if(!empty($filtersForm->filters['kelompokumurNama'])){
        //     $command->where(array('like', 'LOWER(kelompokumur_m.kelompokumur_nama)', '%'.strtolower($filtersForm->filters['kelompokumurNama']).'%'));
        // }

        // $rawData=$command->queryAll();
        // $dataProvider=new CArrayDataProvider($rawData, array(
        //     'id'=>'daftartindakan-dataprovider',
        //     'sort'=>array(
        //         'attributes'=>array(
        //              'daftartindakanNama','hargapemakaian',
        //         ),
        //     ),
        //     'pagination'=>array(
        //         'pageSize'=>10,
        //     ),
        // ));

        // $this->widget('ext.bootstrap.widgets.BootGridView',
        //     array(
        //         'id'=>'rjpaketobat-alkes-m-grid',
        //         'dataProvider'=>$dataProvider,
        //         'filter'=>$filtersForm,
        //         'template'=>"{summary}\n{items}\n{pager}",
        //         'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        //         'columns'=>array(
        //             array(
        //                 'header'=>'Daftar Tindakan',
        //                 'name'=>'daftartindakanNama',
        //                 'value'=>'$data["daftartindakan_nama"]',
        //             ),
        //             array(
        //                 'header'=>'Kelompok Umur',
        //                 'name'=>'kelompokumurNama',
        //                 'value'=>'$data["kelompokumur_nama"]',
        //             ),
        //             array(
        //                 'header'=>'Harga Pemakaian',
        //                 'name'=>'hargapemakaian',
        //                 'value'=>'number_format($data["hargapemakaian"])',
        //             ),
        //             array(
        //                 'header'=>'Pilih',
        //                 'type'=>'raw',
        //                 'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
        //                                 "id" => "selectObat",
        //                                 "onClick" => "inputBMHP($data[daftartindakan_id],$data[kelompokumur_id]);return false;"))',
        //             ),
        //         ),
        //         'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        //     )
        // );

            $modBmhp = new BKPaketbmhpM();
            $modBmhp->unsetAttributes();
            if(isset($_GET['BKPaketbmhpM']))
                $modBmhp->attributes = $_GET['BKPaketbmhpM'];

            $this->widget('ext.bootstrap.widgets.BootGridView',
                array(
                    'id'=>'PaketBmhp-m-grid',
                    'dataProvider'=>$modBmhp->searchData(),
                    'filter'=>$modBmhp,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                            'hargapemakaian',
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )
            );

        $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
</div>
<script type="text/javascript">
    $('#alatMedis').parent().addClass('hide');
    <?php if (isset($modTindPelayanan)) { ?>
    var trTindakan = new String(<?php echo CJSON::encode($this->renderPartial('_formTindakan',array('is_load'=>true,'i'=>99,'model'=>$modTindPelayanan),true));?>);
    <?php } else { ?>
     var trTindakan = null;
    <?php } ?>
    function pilihAlkesMedis(obj)
    {
        $('#tblInputPemakaianBahan > tbody').html('');
        $('#totPemakaianBahan').val('0');
        if(obj.value=='bahan'){
            $('#alatMedis').parent().addClass('hide');
            $('#pakaiBahan').parent().removeClass('hide');
        } else if(obj.value=='medis') {
            $('#pakaiBahan').parent().addClass('hide');
            $('#alatMedis').parent().removeClass('hide');
        }
    }
    
    function tambahTindakan()
    {
        if($("#BKPendaftaranT_ruangan_id").val() == '')
        {
            myAlert('Pasien masih kosong, coba cek lagi !!');
        }else{
            $("#tblBayarTind > tbody").append(trTindakan.replace());
            renameRows();
        }
    }
    
    function inputPemakaianBahan(idObatAlkes)
    {
        var idDaftartindakan = $('#daftartindakanPemakaianBahan option:selected').val();
        var idTindPelayanan = $('#daftartindakanPemakaianBahan option:selected').attr('tag');
        var ruangan_id = $('#daftartindakanPemakaianBahan option:selected').attr('ruangan_id');
        
        if(idDaftartindakan == ''){
            myAlert('Belum ada Tindakan');
            return false;
        }
        
        $.ajax({
            url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/addFormPemakaianBahan');?>',
            dataType: "json",
            data:{
                idObatAlkes:idObatAlkes,
                idDaftartindakan:idDaftartindakan,
                idTindPelayanan:idTindPelayanan,
                ruangan_id:ruangan_id
            },
            success: function(data)
            {
                $("#tblBayarOA > tbody").append(data.form);
                renameRowsPemakaianBahan();
            }
        });
    }
    
    function inputAlatmedis(idAlat)
    {
        var idDaftartindakan = $('#daftartindakanPemakaianBahan option:selected').val();
        var idTindPelayanan = $('#daftartindakanPemakaianBahan option:selected').attr('tag');
        var ruangan_id = $('#daftartindakanPemakaianBahan option:selected').attr('ruangan_id');
        
        if(idDaftartindakan == ''){
            myAlert('Belum ada Tindakan');
            return false;
        }

        $.ajax({
            url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/addFormPemakaianAlat');?>',
            dataType: "json",
            data:{
                idAlat:idAlat,
                idDaftartindakan:idDaftartindakan,
                idTindPelayanan:idTindPelayanan,
                ruangan_id:ruangan_id
            },
            success: function(data)
            {
                $("#tblBayarOA > tbody").append(data.form);
                renameRowsPemakaianBahan();
            }
        });
        
    }
    
    function renameRowsPemakaianBahan()
    {
        var idx = 0;
        $("#tblBayarOA > tbody").find('tr').each(
            function()
            {
                $(this).find('input').each(
                    function()
                    {
                        var name_field = $(this).attr('name');
                        var id_field = $(this).attr('id');
                        $(this).attr('name', name_field.replace('99', idx));
                        $(this).attr('id', id_field.replace('99', idx));

                    }
                );
                idx++;
            }
        );
        
    }
    
    function renameRows()
    {
        var idx = 0;
        var input_id,that,ruangan_id = null;
        
        $("#tblBayarTind > tbody").find('tr').each(
            function()
            {
                $(this).find('input').each(
                    function()
                    {
                        var name_field = $(this).attr('name');
                        var id_field = $(this).attr('id');
                        $(this).attr('name', name_field.replace('99', idx));
                        $(this).attr('id', id_field.replace('99', idx));

                    }
                );
                    
                $(this).find('select ').each(
                    function()
                    {
                        var name_field = $(this).attr('name');
                        var id_field = $(this).attr('id');
                        $(this).attr('name', name_field.replace('99', idx));
                        $(this).attr('id', id_field.replace('99', idx));

                    }
                );
                    
                $(".currency").maskMoney(
                    {
                        "symbol":"Rp ",
                        "defaultZero":true,
                        "allowZero":true,
                        "precision":0
                    }
                );
                    
                if($(this).find('input[name$="[daftartindakan_nama]"]'))
                {
                    input_id = $(this).find('input[name$="[daftartindakan_nama]"]');
                    that = this;
                    
                    jQuery(input_id).autocomplete(
                        {
                            'showAnim':'fold',
                            'minLength':2,
                            'focus':function( event, ui )
                            {
                                $(this).val(ui.item.label);
                                return false;
                            },
                            'select':function( event, ui )
                            {
                                $(this).parent().parent().find('input[name$="[daftartindakan_id]"]').val(ui.item.value);
                                var params = {
                                    daftartindakan_id:ui.item.value,
                                    ruangan_id:$(that).find('select[name$="[ruangan_id]"]').val(),
                                    kelaspelayanan_id:$("#BKPendaftaranT_kelaspelayanan_id").val()
                                };
                                getTarifTindakan(this, params);
                                return false;
                            },
                            'source': function(request, response)
                            {
                                $.ajax({
                                    url: "/ehospitaljk_loc/index.php?r=ActionAutoComplete/daftarTindakanBilling",
                                    dataType: "json",
                                    data:{
                                        term: request.term,
                                        idTipePaket: 1,
                                        idKelasPelayanan: $("#BKPendaftaranT_kelaspelayanan_id").val(),
                                        ruangan_id:$(that).find('select[name$="[ruangan_id]"]').val()
                                    },
                                    success: function(data){
                                        response(data);
                                    }
                                })
                            }
                        }
                    );
                }
                
                if($(this).find('input[name$="[tgl_tindakan]"]'))
                {
                    var input_id = $(this).find('input[name$="[tgl_tindakan]"]');
                    jQuery(input_id).datetimepicker(
                        jQuery.extend(
                            {showMonthAfterYear:false},
                            jQuery.datepicker.regional['id'],
                            {
                                'dateFormat':'dd M yy',
                                'maxDate':'d',
                                'timeText':'Waktu',
                                'hourText':'Jam',
                                'minuteText':'Menit',
                                'secondText':'Detik',
                                'showSecond':true,
                                'timeOnlyTitle':'Pilih Waktu',
                                'timeFormat':'hh:mm:ss',
                                'changeYear':true,
                                'changeMonth':true,
                                'showAnim':'fold',
                                'yearRange':'-80y:+20y'
                            }
                        )
                    );
                }
                idx++;
            }
        );
    }
    
    function loadDataPembayaran(params, obj)
    {
        $("#tblBayarTind").find("tbody").empty();
        $("#tblBayarOA").find("tbody").empty();
        
        $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/loadDataPembayaran');?>',{pendaftaran_id: params},
        function(data)
        {
            $(obj).modal('hide');
            $("#tblBayarTind").find("tbody").append(data.tindakan);
            $("#tblBayarOA").find("tbody").append(data.alkes);
            createAddOns();
        }, 'json');
    }
    
    function createAddOns()
    {
        $('#daftartindakanPemakaianBahan').empty();
        $('#daftartindakanPemakaianBahan').append(
            '<option value="">Nama Tindakan</option>'
        );        
        $(".currency").maskMoney(
            {
                "symbol":"Rp ",
                "defaultZero":true,
                "allowZero":true,
                "precision":0
            }
        )
            
        var input_id,ruangan_id = null;
        $("#tblBayarTind > tbody").find('tr').each(
            function()
            {
                var that = this;
                $(this).find('input[class$="currency"]').each(
                    function()
                    {
                        this.value = formatInteger(this.value)
                    }
                );
                    
                $('#daftartindakanPemakaianBahan').append(
                    '<option ruangan_id="'+ $(that).find('select[name$="[ruangan_id]"]').val() +'" tag="'+ $(this).find('input[name$="[tindakanpelayanan_id]"]').val() +'" value="'+ $(this).find('input[name$="[daftartindakan_id]"]').val() +'">'+ $(this).find('input[name$="[daftartindakan_nama]"]').val() +'</option>'
                );
                    
                if($(this).find('input[name$="[daftartindakan_nama]"]'))
                {
                    input_id = $(this).find('input[name$="[daftartindakan_nama]"]');
                    jQuery(input_id).autocomplete(
                        {
                            'showAnim':'fold',
                            'minLength':2,
                            'focus':function( event, ui )
                            {
                                $(this).val(ui.item.label);
                                return false;
                            },
                            'select':function( event, ui )
                            {
                                $(this).parents().find('input[name$="[daftartindakan_id]"]').val(ui.item.value);
                                return false;
                            },
                            'source': function(request, response)
                            {
                                ruangan_id = $(that).find('select[name$="[ruangan_id]"]').val();
                                $.ajax({
                                    url: "/ehospitaljk_loc/index.php?r=ActionAutoComplete/daftarTindakanBilling",
                                    dataType: "json",
                                    data:{
                                        term: request.term,
                                        idTipePaket: 1,
                                        idKelasPelayanan: $("#BKPendaftaranT_kelaspelayanan_id").val(),
                                        ruangan_id:ruangan_id
                                    },
                                    success: function(data){
                                        response(data);
                                    }
                                })
                            }
                        }
                    );
                }
                
                if($(this).find('input[name$="[tgl_tindakan]"]'))
                {
                    var input_id = $(this).find('input[name$="[tgl_tindakan]"]');
                    jQuery(input_id).datetimepicker(
                        jQuery.extend(
                            {showMonthAfterYear:false},
                            jQuery.datepicker.regional['id'],
                            {
                                'dateFormat':'dd M yy',
                                'maxDate':'d',
                                'timeText':'Waktu',
                                'hourText':'Jam',
                                'minuteText':'Menit',
                                'secondText':'Detik',
                                'showSecond':true,
                                'timeOnlyTitle':'Pilih Waktu',
                                'timeFormat':'hh:mm:ss',
                                'changeYear':true,
                                'changeMonth':true,
                                'showAnim':'fold',
                                'yearRange':'-80y:+20y'
                            }
                        )
                    );
                }
            }
        );
        hitungTotalPembayaran();
    }

    function hitungCyto(obj)
    {
        if($(obj).val() == 1)
        {
            $(obj).parent().find('input[name$="[tarifcyto_tindakan]"]').attr('style', 'display:both');
            $(obj).parent().find('input[name$="[tarifcyto]"]').attr('style', 'display:both');
        }else{
            $(obj).parent().find('input[name$="[tarifcyto_tindakan]"]').attr('style', 'display:none');
            $(obj).parent().find('input[name$="[tarifcyto]"]').attr('style', 'display:none');
        }
        
    }
    
    function getTarifTindakan(obj, params)
    {
        $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getTarifTindakan');?>',params,
        function(data)
        {
            for(x in data)
            {
                $(obj).parents('tr').find('input[name$="['+ x +']"]').val(data[x]);
            }
            $(obj).parents('tr').find('input[class$="currency"]').each(
                function()
                {
                    this.value = formatInteger(this.value)
                }
            );
            hitungTotalPembayaran();
        }, 'json');
    }
    
    function hitungTotalPembayaran()
    {
        hitungTanggungan();
        var total_pembayaran = 0;
        var tot_subsidiasuransi_tindakan = 0;
        var tot_subsidipemerintah_tindakan = 0;
        var tot_subsisidirumahsakit_tindakan = 0;
        $("#tblBayarTind > tbody").find('tr').each(
            function()
            {
                var tarif_tindakan = unformatNumber($(this).find('input[name$="[tarif_tindakan]"]').val());
                total_pembayaran += tarif_tindakan;
                
                var subsidiasuransi_tindakan = unformatNumber($(this).find('input[name$="[subsidiasuransi_tindakan]"]').val());
                tot_subsidiasuransi_tindakan += subsidiasuransi_tindakan;
                
                var subsidipemerintah_tindakan = unformatNumber($(this).find('input[name$="[subsidipemerintah_tindakan]"]').val());
                tot_subsidipemerintah_tindakan += subsidipemerintah_tindakan;
                
                
                var subsisidirumahsakit_tindakan = unformatNumber($(this).find('input[name$="[subsisidirumahsakit_tindakan]"]').val());
                tot_subsisidirumahsakit_tindakan += subsisidirumahsakit_tindakan;
                
                
                var discount_tindakan = unformatNumber($(this).find('input[name$="[discount_tindakan]"]').val());
                $(this).find('input[name$="[iurbiaya_tindakan]"]').val(formatInteger(
                    tarif_tindakan - (subsidiasuransi_tindakan + subsidipemerintah_tindakan + subsisidirumahsakit_tindakan + discount_tindakan)
                ));
                    
                /*
                $(this).find('input[name$="[total_biaya]"]').val(
                    tarif_tindakan + (subsidiasuransi_tindakan + subsidipemerintah_tindakan + subsisidirumahsakit_tindakan + discount_tindakan)
                );
                */
               
            }
        );
            
        $("#total_pembayaran").val(formatInteger(total_pembayaran));
        $("#total_subsidi_asuransi").val(formatInteger(tot_subsidiasuransi_tindakan));
        $("#total_subsidi_rs").val(formatInteger(tot_subsisidirumahsakit_tindakan));
        $("#total_subsidi_pemerintah").val(formatInteger(tot_subsidipemerintah_tindakan));
    }
    
    function hitungTanggungan()
    {
        var makstanggpel = $("#verifikasi-tagihan-form").find('input[name$="[makstanggpel]"]').val();
        
        var subsidirumahsakittind = $("#verifikasi-tagihan-form").find('input[name$="[subsidirumahsakittind]"]').val();
        var subsidipemerintahtind = $("#verifikasi-tagihan-form").find('input[name$="[subsidipemerintahtind]"]').val();
        var subsidiasuransitind = $("#verifikasi-tagihan-form").find('input[name$="[subsidiasuransitind]"]').val();
        
        var subsidirumahsakitoa = $("#verifikasi-tagihan-form").find('input[name$="[subsidirumahsakitoa]"]').val();
        var subsidipemerintahoa = $("#verifikasi-tagihan-form").find('input[name$="[subsidipemerintahoa]"]').val();
        var subsidiasuransioa = $("#verifikasi-tagihan-form").find('input[name$="[subsidiasuransioa]"]').val();
        
        var total_pembayaran = unformatNumber($("#total_pembayaran").val());
        var hargaJual = null;
        var tanggunganRata = null;

        var subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan = 0;
        $("#tblBayarTind > tbody").find('tr').each(
            function()
            {
                hargaJual = unformatNumber($(this).find('input[name$="[tarif_tindakan]"]').val());
                
                if(makstanggpel > 0)
                {
                    tanggunganRata = (hargaJual / total_pembayaran) * makstanggpel;
                    
                    subsidiasuransi_tindakan = 0;
                    subsidipemerintah_tindakan = 0;
                    subsisidirumahsakit_tindakan = tanggunganRata;
                }else{
                    subsidiasuransi_tindakan = hargaJual * (subsidiasuransitind/100);
                    subsidipemerintah_tindakan = hargaJual * (subsidipemerintahtind/100);
                    subsisidirumahsakit_tindakan = hargaJual * (subsidirumahsakittind/100);
                }
                
                $(this).find('input[name$="[subsidiasuransi_tindakan]"]').val(formatInteger(subsidiasuransi_tindakan));
                $(this).find('input[name$="[subsidipemerintah_tindakan]"]').val(formatInteger(subsidipemerintah_tindakan));
                $(this).find('input[name$="[subsisidirumahsakit_tindakan]"]').val(formatInteger(subsisidirumahsakit_tindakan));

            }
        );
        
    }

function hitungTagihan(obj)
{
    var obQty = $(obj).parents('tr').find('input[name$="[qty_oa]"]');
    var obTarif = $(obj).parents('tr').find('input[name$="[hargajual_oa]"]');
    var obCyto = $(obj).parents('tr').find('input[name$="[tarifcyto]"]');
    var obSubas = $(obj).parents('tr').find('input[name$="[subsidiasuransi]"]');
    var obSubpem = $(obj).parents('tr').find('input[name$="[subsidipemerintah]"]');
    var obSubrs = $(obj).parents('tr').find('input[name$="[subsidirs]"]');
    var obIurbiaya = $(obj).parents('tr').find('input[name$="[iurbiaya]"]');
    var obSubtotal = $(obj).parents('tr').find('input[name$="[sub_total]"]');
    
    var qty = unformatNumber($(obQty).val());
    var tarif = unformatNumber($(obTarif).val());
}

function hitungTotalOa(obj)
{
    var qty = unformatNumber(obj.value);
    var hargasatuan = unformatNumber($(obj).parents('tr').find('input[name$="[hargasatuan]"]').val());
    var harga = qty * hargasatuan;
    var tarifCyto = unformatNumber($(obj).parents('tr').find('input[name$="[tarifcyto]"]').val());
    var subAsu = unformatNumber($(obj).parents('tr').find('input[name$="[subsidiasuransi]"]').val());
    var subPem = unformatNumber($(obj).parents('tr').find('input[name$="[subsidipemerintah]"]').val());
    var subRs = unformatNumber($(obj).parents('tr').find('input[name$="[subsidirs]"]').val());
    var discount = unformatNumber($(obj).parents('tr').find('input[name$="[discount]"]').val());
    var iurBiaya = harga + tarifCyto - subAsu - subPem - subRs - discount;
    $(obj).parents('tr').find('input[name$="[iurbiaya]"]').val(formatFloat(iurBiaya));
    $(obj).parents('tr').find('input[name$="[sub_total]"]').val(formatFloat((iurBiaya)));
    $(obj).parents('tr').find('input[name$="[totalcyto_oa]"]').val(formatFloat(tarifCyto));
}

function hitungTotalSemuaOa()
{
    var totSubTotal = 0;
    var totIurBiaya = 0;
    var totSubRs = 0;
    var totSubPem = 0;
    var totSubAsu = 0;
    var totCyto = 0;
    var totTarifOa = 0;
    var totQty = 0;
    var totDiscount = 0;

    $('#tblBayarOA').find('input[name$="[qty_oa]"]').each(function(){
        hitungTotalOa(this);
        if($(this).parents('tr').find('input[name$="[obatalkespasien_id]"]').is(':checked')){
            totSubTotal += unformatNumber($(this).parents('tr').find('input[name$="[sub_total]"]').val());
            totIurBiaya += unformatNumber($(this).parents('tr').find('input[name$="[iurbiaya]"]').val());
            totSubRs += unformatNumber($(this).parents('tr').find('input[name$="[subsidirs]"]').val());
            totSubPem += unformatNumber($(this).parents('tr').find('input[name$="[subsidipemerintah]"]').val());
            totSubAsu += unformatNumber($(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val());
            totCyto += unformatNumber($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var qtyOa = unformatNumber($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var tarifCyto = unformatNumber($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            totTarifOa += tarifCyto +(unformatNumber($(this).parents('tr').find('input[name$="[hargasatuan]"]').val()) * qtyOa);
            totQty += unformatNumber($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            totDiscount += unformatNumber($(this).parents('tr').find('input[name$="[discount]"]').val());
        }
        
    });
    $('#totalbayar_oa').val(formatFloat(totSubTotal));
    $('#totaliurbiaya_oa').val(formatFloat(totIurBiaya));
    $('#totalsubsidirs_oa').val(formatFloat(totSubRs));
    $('#totalsubsidipemerintah_oa').val(formatFloat(totSubPem));
    $('#totalsubsidiasuransi_oa').val(formatFloat(totSubAsu));
    $('#totalcyto_oa').val(formatFloat(totCyto));
    $('#totalbiaya_oa').val(formatFloat(totTarifOa));
    $('#totalqty_oa').val(formatFloat(totQty));
    $('#totaldiscount_oa').val(formatFloat(totDiscount));
    
    hitungJmlBayar();
    hitungTotalSemua();
}

function checkAll() {
    if ($("#checkAllObat").is(":checked")) {
        $('#tblBayarOA input[name*="obatalkespasien_id"]').each(function(){
           $(this).attr('checked',true);
        })
//        myAlert('Checked');
    } else {
       $('#tblBayarOA input[name*="obatalkespasien_id"]').each(function(){
           $(this).removeAttr('checked');
        })
    }
    hitungTotalSemuaOa();
}

function checkAllTindakan() {
    if ($("#checkTindakan").is(":checked")) {
        $('#tblBayarTind input[name*="tindakanpelayanan_id"]').each(function(){
           $(this).attr('checked',true);
        })
//        myAlert('Checked');
    } else {
       $('#tblBayarTind input[name*="tindakanpelayanan_id"]').each(function(){
           $(this).removeAttr('checked');
        })
    }
    hitungTotalSemuaTind();
}

function hitungTotalSemuaTind()
{
    var totIurBiaya = 0;
    var totSubRs = 0;
    var totSubPem = 0;
    var totSubAsu = 0;
    var totCyto = 0;
    var totTarifTind = 0;
    var totQty = 0;
    var totDiscount = 0;
    var totSubTotal = 0;

    // myAlert("diskon");
    
    $('#tblBayarTind').find('input[name$="[qty_tindakan]"]').each(function(){
        hitungTotalTind(this);
        if($(this).parents('tr').find('input[name$="[tindakanpelayanan_id]"]').is(':checked')){
            totIurBiaya += unformatNumber($(this).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val());
            totSubRs += unformatNumber($(this).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val());
            totSubPem += unformatNumber($(this).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val());
            totSubAsu += unformatNumber($(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val());
            totCyto += unformatNumber($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var qtyTind = unformatNumber($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifCyto = unformatNumber($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            totTarifTind += tarifCyto + (unformatNumber($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val()) * qtyTind);
            totQty += unformatNumber($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            totDiscount += unformatNumber($(this).parents('tr').find('input[name$="[discount_tindakan]"]').val());
            totSubTotal += unformatNumber($(this).parents('tr').find('input[name$="[sub_total]"]').val());
        }
    });
    $('#totaliurbiaya').val(formatFloat(totIurBiaya));
    $('#totalsubsidirs').val(formatFloat(totSubRs));
    $('#totalsubsidipemerintah').val(formatFloat(totSubPem));
    $('#totalsubsidiasuransi').val(formatFloat(totSubAsu));
    $('#totalcyto').val(formatFloat(totCyto));
    $('#totalbiayatindakan').val(formatFloat(totTarifTind));
    $('#totalqtytindakan').val(formatFloat(totQty));
    $('#totaldiscount_tindakan').val(formatFloat(totDiscount));
    $('#totalbayartindakan').val(formatFloat(totSubTotal));
        
    hitungJmlBayar();
    hitungTotalSemua();
}

function hitungTotalTind(obj)
{
    // var discount = unformatNumber($(obj).parents('tr').find('input[name$="[discount_tindakan]"]').val());
    // myAlert(discount);
    var qty = unformatNumber(obj.value);
    var tarifSatuan = unformatNumber($(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val());
    var tarif = qty * tarifSatuan;
    var tarifTind = unformatNumber($(obj).parents('tr').find('input[name$="[tarif_tindakan]"]').val());
    var tarifCyto = unformatNumber($(obj).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
    var subAsu = unformatNumber($(obj).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val());
    var subPem = unformatNumber($(obj).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val());
    var subRs = unformatNumber($(obj).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val());
    var discTindakan = unformatNumber($(obj).parents('tr').find('input[name$="[discount_tindakan]"]').val());
    var iurBiaya = tarif + tarifCyto - subAsu - subPem - subRs - discTindakan;
    $(obj).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val(formatFloat(iurBiaya));
    $(obj).parents('tr').find('input[name$="[sub_total]"]').val(formatFloat((iurBiaya)));
}

function hitungJmlBayar()
{
    var totBiaya = unformatNumber($('#totalbayartindakan').val()) + unformatNumber($('#totalbayar_oa').val());
    var totAsuransi = unformatNumber($('#totalsubsidiasuransi').val()) + unformatNumber($('#totalsubsidiasuransi_oa').val());
    var totSubsidi = unformatNumber($('#totalsubsidirs').val()) + unformatNumber($('#totalsubsidirs_oa').val());

    var totTagihan = unformatNumber($('#totalbayar_oa').val()) + unformatNumber($('#totalbayartindakan').val());
    var biayaAdministrasi = unformatNumber($('#TandabuktibayarT_biayaadministrasi').val());
    var biayaMaterai = unformatNumber($('#TandabuktibayarT_biayamaterai').val());
    var deposit = unformatNumber($('#deposit').val());
    var totPembebasan = unformatNumber($('#totPembebasan').val());
    var totDiscountTind = unformatNumber($('#totaldiscount_tindakan').val());
    var totDiscountOa = unformatNumber($('#totaldiscount_oa').val());
    var totDiscount = totDiscountTind+totDiscountOa;
    var totBayar = 0;
    var discount = unformatNumber($('#discount').val());
    var jmlPembulatan = unformatNumber($('#TandabuktibayarT_jmlpembulatan').val());
    var pembulatan = <?php if ($pembulatanHarga > 0){?>(totTagihan - discount) % <?php echo $pembulatanHarga; }else echo 0;?>;
    jmlPembulatan = <?php echo $pembulatanHarga; ?> - pembulatan;
    if (jQuery.isNumeric(jmlPembulatan)){  
        if (jmlPembulatan >= <?php echo $pembulatanHarga; ?>){
            jmlPembulatan = 0;
        }
        $('#TandabuktibayarT_jmlpembulatan').val(formatFloat(jmlPembulatan));
    }
    // $('#totBiaya').val(formatFloat(totBiaya));
    $('#total_pembayaran').val(formatFloat(totBiaya));
    $('#total_subsidi_asuransi').val(formatFloat(totAsuransi));
    $('#total_subsidi_rs').val(formatFloat(totSubsidi));

    $('#totTagihan').val(formatFloat(totTagihan));
    totBayar = totTagihan + jmlPembulatan + biayaAdministrasi + biayaMaterai - discount - totPembebasan - deposit;
    if(deposit > totTagihan)
    {
        totBayar = totTagihan + jmlPembulatan + biayaAdministrasi + biayaMaterai - discount - totPembebasan;
    }
    
    $('#TandabuktibayarT_uangditerima').val(totBayar);
    $('#TandabuktibayarT_jmlpembayaran').val(formatFloat(totBayar));
    
    if($('#TandabuktibayarT_carapembayaran').val() != 'TUNAI' && $('#TandabuktibayarT_carapembayaran').val() != 'PIUTANG')
    {
        $('#TandabuktibayarT_uangditerima').val(0);
    }
    
    hitungKembalian();
}

function hitungKembalian(obj)
{
    var jmlBayar = unformatNumber($('#TandabuktibayarT_jmlpembayaran').val());
    var uangDiterima = unformatNumber($('#TandabuktibayarT_uangditerima').val());
    var uangKembalian;
    
    if ($("#<?php echo CHtml::activeId($modTandaBukti,'carapembayaran'); ?>").val() == 'TUNAI' || $("#<?php echo CHtml::activeId($modTandaBukti,'carapembayaran'); ?>").val() == 'PIUTANG')
    {
        uangKembalian = uangDiterima - jmlBayar;
    }else{
        if($("#<?php echo CHtml::activeId($modTandaBukti,'carapembayaran'); ?>").val() != 'HUTANG')
        {
            if($(obj).attr("id") == '<?php echo CHtml::activeId($modTandaBukti,'uangditerima'); ?>' )
            {
                if(uangDiterima > jmlBayar)
                {
                    uangDiterima = jmlBayar;
                }
            }else{
                uangDiterima = jmlBayar;
            }
        }else{
            uangDiterima = 0;
        }
        uangKembalian = 0;        
    }
    
    /*
    if ($("#<?php // echo CHtml::activeId($modTandaBukti,'carapembayaran'); ?>").val() == 'CICILAN')
    {
        if ($(obj).attr("id") == '<?php // echo CHtml::activeId($modTandaBukti,'uangditerima'); ?>' )
        {
            if (uangDiterima > jmlBayar){
                uangDiterima = jmlBayar;
//                myAlert("Uang diterima tidak boleh kurang dari jumlah pembayaran");
            }
        }
        else{
            uangDiterima = jmlBayar;
        }
        uangKembalian = 0;
    }else{
        uangKembalian = uangDiterima - jmlBayar;
    }
    */
   
    $('#TandabuktibayarT_uangditerima').val(formatFloat(uangDiterima));
    $('#TandabuktibayarT_uangkembalian').val(formatFloat(uangKembalian));
}

function hitungTotalSemua(){
    var totalCyto = unformatNumber($('#totalcyto').val()) + unformatNumber($('#totalcyto_oa').val());
    var totalDiskon = unformatNumber($('#totaldiscount_tindakan').val()) + unformatNumber($('#totaldiscount_oa').val());
    var totalSubsidiAsuransi = unformatNumber($('#totalsubsidiasuransi').val()) + unformatNumber($('#totalsubsidiasuransi_oa').val());
    var totalSubsidiRs = unformatNumber($('#totalsubsidirs').val()) + unformatNumber($('#totalsubsidirs_oa').val());
    var totalBiaya = unformatNumber($('#totalbiayatindakan').val()) + unformatNumber($('#totalbiaya_oa').val());
    var totalIurBiaya = unformatNumber($('#totaliurbiaya').val()) + unformatNumber($('#totaliurbiaya_oa').val());
    var total = unformatNumber($('#totalbayartindakan').val()) + unformatNumber($('#totalbayar_oa').val());
//    if($("#inputTotalSemua").is(":checked")){
//        //jangan di total jika input dari total
//    }else{
        $("#totalseluruhcyto").val(formatFloat(totalCyto));
        $("#totalseluruhdiscount").val(formatFloat(totalDiskon));
        $("#totalseluruhsubsidiasuransi").val(formatFloat(totalSubsidiAsuransi));
        $("#totalseluruhsubsidirs").val(formatFloat(totalSubsidiRs));
//    }
    $("#totalseluruhiurbiaya").val(formatFloat(totalIurBiaya));
    $("#totalseluruhbiaya").val(formatFloat(totalBiaya));
    $("#totalseluruhbayar").val(formatFloat(total));
}

function cekParentValue(value,obj){
    if ($(obj).is(":checked")){
        $('#tblBayarOA input[name*="obatalkespasien_id"][parent-value="'+value+'"]').each(function(){
           $(this).attr('checked',true);
        });
    }else{
        $('#tblBayarOA input[name*="obatalkespasien_id"][parent-value="'+value+'"]').each(function(){
           $(this).removeAttr('checked');
        });
    }
    hitungTotalSemuaOa();
}

function hitungTarifTindakan(obj,tindakanpelayanan){

    $('#tblBayarTind').find('input[name$="[qty_tindakan]"]').each(function(){
        if($(obj).parents('tr').find('input[name$="[tindakanpelayanan_id]"]').is(':checked'))
        {
            // myAlert("a");
            // var tarif_rsakomodasi = unformatNumber($(obj).parents('tr').find('input[name$="[tarif_rsakomodasi]"]').val());
            // var tarif_medis = unformatNumber($(obj).parents('tr').find('input[name$="[tarif_medis]"]').val());
            // tarif_tindakan = tarif_rsakomodasi + tarif_medis;

            var total = 0;
            $("."+tindakanpelayanan+"").each(function(){
                value = unformatNumber($(this).val());
                total += value;
            });
            // myAlert(total);
            $(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val(formatFloat(total));

            tarif_tindakan = total * $(obj).parents('tr').find('input[name$="[qty_tindakan]"]').val();

            $(obj).parents('tr').find('input[name$="[tarif_tindakan]"]').val(formatFloat(tarif_tindakan));

        }
    });
    hitungTotalSemuaTind();
}

function hitungTarifObat(obj,obatalkes){

    $('#tblBayarOA').find('input[name$="[qty_oa]"]').each(function(){
        if($(obj).parents('tr').find('input[name$="[obatalkespasien_id]"]').is(':checked'))
        {
            // myAlert("a");
            // var tarif_rsakomodasi = unformatNumber($(obj).parents('tr').find('input[name$="[tarif_rsakomodasi]"]').val());
            // var tarif_medis = unformatNumber($(obj).parents('tr').find('input[name$="[tarif_medis]"]').val());
            // tarif_tindakan = tarif_rsakomodasi + tarif_medis;

            var total = 0;
            $("."+obatalkes+"").each(function(){
                value = unformatNumber($(this).val());
                total += value;
            });
            // myAlert(total);
            $(obj).parents('tr').find('input[name$="[hargasatuan]"]').val(formatFloat(total));

            hargajual_oa = total * $(obj).parents('tr').find('input[name$="[qty_oa]"]').val();

            $(obj).parents('tr').find('input[name$="[hargajual_oa]"]').val(formatFloat(hargajual_oa));

        }
    });
    hitungTotalSemuaTind();
}

function onClickSubmit()
{
    if(cekInput())
    {
    }
}

function simpanProses()
{
    $("#verifikasi-tagihan-form").submit();
}


function cekInput()
{
    // myAlert('ok');
    
    if($('#FAPendaftaranT_no_pendaftaran').val() == ''){
        myAlert('Belum input Pasien');
        $('#FAPasienM_no_rekam_medik').focus();
        return false;
    }
    else{
        $("#verifikasi-tagihan-form").submit();
    }
    
    // var index = 0;
        
    // if(index > 0)
    // {
    //     myAlert('Isi inputan yang bertanda bintang !!');
    //     return false;
    // }
    
}


/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    <?php if(!empty($modPendaftaran->pendaftaran_id)){ ?>
            loadPembayaran(<?php echo $modPendaftaran->pendaftaran_id; ?>);
            $("#tombolPasienDialog").parent().attr("style","display:none");
    <?php } ?>
});
</script>
    
