<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'symbol'=>'Rp. ',
//        'showSymbol'=>true,
//        'symbolStay'=>true,
        'defaultZero'=>true,
        'allowZero'=>true,
        'precision'=>0
    )
));
?>
<fieldset class="box">
    <legend class="rim">Rencana Operasi</legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td width="50%">
                <?php echo $form->textFieldRow($modRencanaOperasiAttrib,'norencanaoperasi',array('readonly'=>true)) ?>
                <div class="control-group">
                    <?php
                        echo $form->labelEx($modRencanaOperasiAttrib,'tglrencanaoperasi',
                            array(
                                'class'=>'control-label'
                            )
                        );
                    ?>
                    <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',
                                array(
                                    'model'=>$modRencanaOperasiAttrib,
                                    'attribute'=>'tglrencanaoperasi',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>true,
                                        'class'=>'dtPicker3',
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'style'=>'width:110px;'
                                    ),
                                )
                            );
                        ?>
                    </div>
                </div>
                <?php
                    echo $form->dropDownListRow($modRencanaOperasiAttrib,'kamarruangan_id',
                        CHtml::listData($modPenunjang->getKamarKosongItems(Params::RUANGAN_ID_BEDAH), 'kamarruangan_id', 'KamarDanTempatTidur'),
                        array(
                            'empty'=>'-- Pilih --',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"
                        )
                    );
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modRencanaOperasiAttrib,'dokterpelaksana1_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php 
                            echo $form->dropDownList($modRencanaOperasiAttrib,'dokterpelaksana1_id',
                                CHtml::listData($modPenunjang->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap'),
                                array(
                                    'empty'=>'-- Pelaksana 1 --',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)"
                                )
                            );
                        ?>
                        <?php echo $form->error($modRencanaOperasiAttrib, 'dokterpelaksana1_id'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modRencanaOperasiAttrib,'dokterpelaksana2_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php 
                            echo $form->dropDownList($modRencanaOperasiAttrib,'dokterpelaksana2_id', 
                                CHtml::listData($modPenunjang->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'namaLengkap'),
                                array(
                                    'empty'=>'-- Pelaksana 2 --',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)"
                                )
                            );
                            echo $form->error($modRencanaOperasiAttrib, 'dokterpelaksana2_id');
                        ?>
                    </div>
                </div>
                <?php
                    echo $form->dropDownListRow($modRencanaOperasiAttrib,'paramedis_id',
                        CHtml::listData($modPenunjang->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai'),
                        array(
                            'empty'=>'-- Pilih --',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"
                        )
                    );
                    echo $form->dropDownListRow($modRencanaOperasiAttrib,'bidan_id', 
                        CHtml::listData($modPenunjang->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai'),
                        array(
                            'empty'=>'-- Pilih --',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"
                        )
                    );
                    echo $form->dropDownListRow($modRencanaOperasiAttrib,'suster_id', 
                        CHtml::listData($modPenunjang->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai'),
                        array(
                            'empty'=>'-- Pilih --',
                            'onkeypress'=>"return $(this).focusNextInputField(event)"
                        )
                    );
                    echo $form->textAreaRow($modRencanaOperasiAttrib,'keterangan_rencana',
                        array(
                            'class'=>'span3'
                        )
                    );
                ?>
            </td>
            <td width="50%">
                <?php
                echo $this->renderPartial('_formPasienAnastesi',
                    array(
                        'form'=>$form,
                        'modAnastesi'=>$modAnastesi,
                        'modRencanaOperasiAttrib'=>$modRencanaOperasiAttrib,
                        'modPenunjang'=>$modPenunjang
                    )
                );
                ?>
            </td>
        </tr>
    </table>

    <?php  
        $this->beginWidget('zii.widgets.jui.CJuiDialog',
            array(
                'id'=>'dialogOperasi',
                'options'=>array(
                    'title'=>'Pilih Operasi',
                    'autoOpen'=>false,
                    'width'=>660,
                    'height'=>500,
                    'modal'=>false,
                    'hide'=>'explode',
                    'resizelable'=>false,
                ),
            )
        );
    ?>
    <?php
        echo $this->renderPartial('_formOperasi',
            array(
                'modKegiatanOperasi'=>$modKegiatanOperasi,
                'modOperasi'=>$modOperasi
            )
        );
    ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
    <br/>
    <fieldset class="box2">
        <legend class="rim">Detail Operasi</legend>
        <table id="tblFormRencanaOperasi" class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th>
                        <?php
                            echo CHtml::checkBox('kingCheck', true,
                                array(
                                    'onclick'=>'checkAll("ceklis",this);',
                                    'data-original-title'=>'Klik untuk cek semua operasi' ,
                                    'rel'=>'tooltip',
                                )
                            )
                        ?>
                    </th>
                    <th>Mulai Operasi</th>
                    <th>Perkiraan Selesai Operasi</th>
                    <!--<th>Golongan Operasi</th> GOLONGAN BESAR / KECIL DIBUAT TINDAKAN YG BERBEDA-->
                    <th>
                        <a href="#" onclick="openDialogItem(false);return false;" data-original-title="Klik untuk tambah Operasi" rel="tooltip">
                            Jenis Operasi
                            <i class="icon-zoom-in"></i>
                        </a>
                    </th>
                    <th>Jumlah</th>
                    <th>Tarif Satuan</th>
                    <th>Type Anastesi</th>
                    <th>Cyto</th>
                    <th>Tarif Cyto</th>
					<th>Total</th>
                    <th>Status Operasi</th>
                    <th style="display: none;">Jenis Penyulit</th>
                    <th style="text-align:center">
                        <?php
                            echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>"openDialogItem(true);return false;",'rel'=>'tooltip','title'=>'Klik untuk menambah operasi bersama')); 
                        ?>                        
                    </th>
                </tr>
            </thead>
                <?php 
//                    $idx = -1;
                    foreach ($modRencanaOperasi as $i => $rencanaOperasi) 
                    {
//                        $idx++;
                        /* @var $modTindOperasi OperasiM  */
                        /* @var $modTindakanTarif TariftindakanM  */
                        $jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id'=>$modPasienPenunjang->penjamin_id))->jenistarif_id;
                        $modTindOperasi = BSOperasiM::model()->with('kegiatanoperasi')->findByPk(
                            $rencanaOperasi->operasi_id
                        ); 
                        $modTindakanTarif = TariftindakanM::model()->findByAttributes(
                            array(
                                'daftartindakan_id'=>$modTindOperasi->daftartindakan_id,
                                'kelaspelayanan_id'=>$modPasienPenunjang->kelaspelayanan_id,
                                'jenistarif_id'=>$jenistarif_id,
                                'komponentarif_id'=> Params::KOMPONENTARIF_ID_TOTAL
                            )
                        );
                        $cekTindakan = TindakanpelayananT::model()->findByAttributes(
                            array(
                                'daftartindakan_id'=>$modTindOperasi->daftartindakan_id,
                                'pasienmasukpenunjang_id'=>$modPasienPenunjang->pasienmasukpenunjang_id
                            )
                        );
						
                        if($cekTindakan){
                            $qty = (!empty($cekTindakan->qty_tindakan) ? $cekTindakan->qty_tindakan : 1) ;
                            $tarifSatuan = (!empty($cekTindakan->tarif_satuan)) ? $cekTindakan->tarif_satuan : 0 ;
                            $persen_cyto = (!empty($cekTindakan->persencyto_tind)) ? $cekTindakan->persencyto_tind : 0 ;
							$is_cyto = (($rencanaOperasi->is_cyto == TRUE)? 1 : 0);
							$persencyto_tind = $modTindakanTarif->persencyto_tind;
							$tarif_cyto = (($rencanaOperasi->is_cyto == TRUE)? $qty * $tarifSatuan * $modTindakanTarif->persencyto_tind / 100 : 0);
                            $tarif = ($qty * $tarifSatuan) + $tarif_cyto;
							$tarif_cyto = $format->formatNumberForUser($tarif_cyto);
						}else{
                            $qty = (!empty($modTindakanTarif->qty_tindakan) ? $modTindakanTarif->qty_tindakan : 1) ;
                            $tarifSatuan = (!empty($modTindakanTarif->harga_tariftindakan)) ? $modTindakanTarif->harga_tariftindakan : 0 ;
                            $persen_cyto = (!empty($modTindakanTarif->persencyto_tind)) ? $modTindakanTarif->persencyto_tind : 0 ;
							$is_cyto = (($rencanaOperasi->is_cyto == TRUE)? 1 : 0);
							$persencyto_tind = $modTindakanTarif->persencyto_tind;
							$tarif_cyto = (($rencanaOperasi->is_cyto == TRUE)? $qty * $tarifSatuan * $modTindakanTarif->persencyto_tind / 100 : 0);
                            $tarif = ($qty * $tarifSatuan) + $tarif_cyto;
							$tarif_cyto = $format->formatNumberForUser($tarif_cyto);
						}
                        $idDaftarTindakan = $modTindOperasi->daftartindakan_id;
                        $idOperasi = $rencanaOperasi->operasi_id;
                        $kegiatanOperasi = $modTindOperasi->kegiatanoperasi->kegiatanoperasi_nama . ' - ' . $modTindOperasi->operasi_nama;
                        $daftarTindakanNama = $kegiatanOperasi;
                        
//                        $tarif_cyto = 0;
//                        if($modTindakanPelayanan)
//                        {
//                            $tarifcyto_tindakan = 0;

                            //UBAH METODE PENULISAN
//                    PERHITUNGAN TARIF CYTO DINONAKTIFKAN KARENA DIBUAT TINDAKAN YANG BERBEDA
//                            $criteria = new CDbCriteria();
//                            $criteria->addInCondition(komponentarif_id, Params::komponenTarif());
//                            $criteria->addCondition("daftartindakan_id = ".$modTindOperasi->daftartindakan_id);
//                            $criteria->addCondition("kelaspelayanan_id = ".$modPasienPenunjang->kelaspelayanan_id);
//                            $record = TariftindakanM::model()->findAll($criteria);
//                                
//                            foreach($record as $idxz=>$values)
//                            {
//                                /** penentuan tarif cyto  **/
//                                if($values['komponentarif_id'] == Params::komponenTarif('jasa_operator_bedah'))
//                                {
//                                    $cyto_tarif_operator = $values['harga_tariftindakan'] * ($values['persencyto_tind']/100);
//                                }
//
//                                if($values['komponentarif_id'] == Params::komponenTarif('jasa_asisten_operator'))
//                                {
//                                    $cyto_tarif_asisten = $values['harga_tariftindakan'] * ($values['persencyto_tind']/100);
//                                }
//                                /** end penentuan tarif cyto  **/
//                                $tarifcyto_tindakan = $cyto_tarif_operator + $cyto_tarif_asisten;
//                            }
//                            $tarif_cyto = $tarifcyto_tindakan;
//                        }
                ?>
            
                <tr id="operasi_<?php echo $idOperasi; ?>">
                    <td>
                        <?php 
                            echo CHtml::checkBox('BSTindakanPelayananT['.$i.'][ceklis]',true,
                                array(
                                    'value'=>$i,
                                    'id'=>'BSTindakanPelayananT_'.$i.'_ceklis',
                                    'class'=>'ceklis'
                                )
                            );
                        ?>
                    </td>
                    <td>
                        <?php
                            $this->widget('MyDateTimePicker',
                                array(
                                    'name'=>'BSTindakanPelayananT['.$i.'][mulaioperasi]',
                                    'value'=>$rencanaOperasi->mulaioperasi,
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>true,
                                        'class'=>'dtPicker3',
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'style'=>'width:110px;'
                                    ),
                                )
                            );
                        ?>
                    </td>
                    <td>
                        <?php
                            $this->widget('MyDateTimePicker',
                                array(
                                    'name'=>'BSTindakanPelayananT['.$i.'][selesaioperasi]',
                                    'value'=>$rencanaOperasi->selesaioperasi,
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>true,
                                        'class'=>'dtPicker3',
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'style'=>'width:110px;'
                                    ),
                                )
                            ); 
                        ?>
                    </td>
                    <td style="display:none;">
                        <?php
                            echo CHtml::dropDownList('BSTindakanPelayananT['.$i.'][golonganoperasi_id]', $rencanaOperasi->golonganoperasi_id,
                                CHtml::listData(GolonganoperasiM::model()->getAll(), 'golonganoperasi_id', 'golonganoperasi_nama'),
                                array(
                                    'class'=>'inputFormTabel lebar3',
                                    'empty'=>'- Pilih -'
                                )
                            );
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $kegiatanOperasi;
                            echo CHtml::hiddenField("BSTindakanPelayananT[".$i."][daftartindakan_nama]",
                                $daftarTindakanNama,
                                array(
                                    'class'=>'inputFormTabel',
                                    'readonly'=>true
                                )
                            );
                            echo CHtml::hiddenField("BSTindakanPelayananT[".$i."][daftartindakan_id]",
                                $idDaftarTindakan,
                                array(
                                    'class'=>'inputFormTabel',
                                    'readonly'=>true
                                )
                            );
                            echo CHtml::hiddenField("BSTindakanPelayananT[".$i."][rencanaoperasi_id]",
                                $rencanaOperasi->rencanaoperasi_id,
                                array(
                                    'class'=>'inputFormTabel lebar3',
                                    'readonly'=>true
                                )
                            );
                            echo CHtml::hiddenField('BSTindakanPelayananT['.$i.'][is_operasibersama]',
                                ($rencanaOperasi->is_operasibersama) ? 1:0,
                                array(
                                    'class'=>'inputFormTabel lebar3',
                                    'readonly'=>true
                                )
                            );
                            echo CHtml::hiddenField('BSTindakanPelayananT['.$i.'][operasi_id]',
                                $idOperasi,
                                array(
                                    'class'=>'inputFormTabel lebar3',
                                    'readonly'=>true
                                )                                        
                            );
                            echo CHtml::hiddenField('BSTindakanPelayananT['.$i.'][tindakanpelayanan_id]',
                                $rencanaOperasi->tindakanpelayanan_id,
                                array(
                                    'class'=>'inputFormTabel lebar3',
                                    'readonly'=>true
                                )                                        
                            );
                        ?>
                    </td>
					<td>
						<?php
                            echo CHtml::textField("BSTindakanPelayananT[".$i."][qty_tindakan]",
                                $qty,
                                array(
                                    'class'=>'inputFormTabel lebar3 currency'
                                )
                            );
                        ?>
					</td>
                    <td>
                        <?php
//                            echo CHtml::textField("BSTindakanPelayananT[".$i."][tarif_tindakan]",
//                                number_format($tarif),
//                                array(
//                                    'class'=>'inputFormTabel lebar3 currency',
//                                    'readonly'=>true
//                                )
//                            );
                            echo CHtml::textField("BSTindakanPelayananT[".$i."][tarif_satuan]",
                                number_format($tarifSatuan),
                                array(
                                    'class'=>'inputFormTabel lebar3',
                                    'readonly'=>true
                                )
                            );
//                    TARIF CYTO DINONAKTIFKAN KARENA DIBUAT TINDAKAN YANG BERBEDA
//                            echo CHtml::hiddenField("BSTindakanPelayananT[".$i."][tarifcyto_tindakan]", 
////                                $tarif_cyto,
//                                0,
//                                array(
//                                    'class'=>'inputFormTabel lebar3 currency'
//                                )
//                            );
                            
                            
                        ?>
                    </td>
                    <td>
                        <?php 
                        echo CHtml::hiddenField('BSTindakanPelayananT['.$i.'][typeanastesi_id_sebelum]', (isset($rencanaOperasi->pasienanastesi->typeanastesi_id) ? $rencanaOperasi->pasienanastesi->typeanastesi_id : null), array('readonly'=>true)); 
                        echo CHtml::dropDownList('BSTindakanPelayananT['.$i.'][typeanastesi_id]', null, //nilai di load dengan javascript
//                                TypeAnastesiM::getItems(), //DISET NULL KARENA HARUS PILIH JENIS & ANASTESI DULU
                                array(),
                                array('disabled'=>false,'class'=>'inputFormTabel labar3 typeanastesi','style'=>'width:150px;','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",));
                        ?>
                    </td>
                    <td>
                        <?php
                            echo CHtml::dropDownList('BSTindakanPelayananT['.$i.'][cyto_tindakan]', $is_cyto,
                                array(
                                    1=>'Ya',
                                    0=>'Tidak'
                                ),
                                array(
                                    'class'=>'inputFormTabel lebar3',
                                    'onchange'=>'hitungCyto('.$i.',this.value)'
                                )
                            );
                        ?>
                        <?php
                            echo CHtml::hiddenField("BSTindakanPelayananT[".$i."][persencyto_tind]", $persencyto_tind,
                                array(
                                    'class'=>'inputFormTabel lebar3',
                                    'readonly'=>true
                                )
                            );
                        ?>
                    </td>
                    <td>
                        <?php
                            echo CHtml::textField("BSTindakanPelayananT[".$i."][tarif_cyto]", $tarif_cyto,
                                array(
                                    'class'=>'inputFormTabel lebar3 currency'
                                )
                            );
                        ?>
                    </td>
                    <td>
                        <?php
                            echo CHtml::textField("BSTindakanPelayananT[".$i."][tarif_tindakan]", number_format($tarif),
                                array(
                                    'class'=>'inputFormTabel lebar3 currency'
                                )
                            );
                        ?>
                    </td>
                    <td>
                        <?php
                            echo CHtml::dropDownList('BSTindakanPelayananT['.$i.'][statusoperasi]', "MULAI",
                                LookupM::getItems('statusoperasi'),  
                                array(
                                    'class'=>'inputFormTabel lebar4',
                                    'empty'=>'-- Pilih --',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
									'disabled'=>true
                                )
                            );
                        ?>
                    </td>
                    <td style="display: none;">
                        <?php
                            echo CHtml::dropDownList('BSTindakanPelayananT['.$i.'][jenis_penyulit]',
                                $rencanaOperasi->jenis_penyulit,
                                LookupM::getItems('jenis_penyulit'),
                                array(
                                    'class'=>'inputFormTabel lebar3',
                                    'empty'=>'-- Pilih --',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)"
                                )
                            );
                        ?>
                    </td>
                    <td style="text-align:center;">
                        <?php
//                            echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'hapusRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk hapus item'));
                        ?>
                    </td>
                </tr>
                <?php //  $idx++; 
				};?>
            </table>  
            <table width="100%">
                <tr>
                    <td width="50%">
                        <?php
                            $this->renderPartial('_formPemakaianBahan',
                                array(
                                    'modViewBahan'=>$modViewBahan
                                )
                            );
                        ?>
                    </td>
                    <td>
                        <?php
                            $this->renderPartial('_formPaketBmhp',
                                array(
                                    'modViewBmhp'=>$modViewBmhp
                                )
                            );
                        ?>
                    </td>
                </tr>
            </table>        
    </fieldset>
</fieldset>

<script>
function hapusRowTindakan(obj)
{
    $(obj).parents('tr').detach();
}

function openDialogItem(params)
{
    $('#dialogOperasi').dialog('open');
    $("#is_operasi").val(params);
    $("#is_operasibersama").val(1);
}

function hitungCyto(id, obj)
{
    
    if(obj == 1)
    {
        /*
        var persen_cytotind = $('#BSTindakanPelayananT_persencyto_tind_'+id+'').val(); 
        var harga_tarif = $('#BSTindakanPelayananT_tarif_tindakan_'+id+'').val(); 
        var tarif_cyto = harga_tarif * (persen_cytotind/100);
        $('#BSTindakanPelayananT_tarif_cyto_'+id+'').val(tarif_cyto);
        */
       var tarif_cyto = $('#BSTindakanPelayananT_'+id+'_tarifcyto_tindakan').val(); 
       $('#BSTindakanPelayananT_'+id+'_tarif_cyto').val(tarif_cyto);
    }
    else
    {
        $('#BSTindakanPelayananT_'+id+'_tarif_cyto').val(0);
    }
    
}

function anastesiOn(id)
{
    if(id != '')
    {
        $('#divAnastesi input').removeAttr('disabled');
        $('#divAnastesi select').removeAttr('disabled');
        $('#PasienanastesiT_dokteranastesi_id').val(id);
        if ($('#pakeAnastesi').is(':checked')){
            ''
        }else{
            ''  //$('#divAnastesi').slideToggle(500);
        }
        $('#pakeAnastesi').attr('checked',true);
        
        
    }
    if(id == '')
    {
        $('#pakeAnastesi').removeAttr('checked');
        $('#divAnastesi input').attr('disabled','true');
        $('#divAnastesi select').attr('disabled','true');
    }
    
    
}


function validasiItem()
{
    $('#tblFormRencanaOperasi > tbody').find('input[name$="[daftartindakan_id]"]').each(
        function()
        {
            
            var item = $(this).val();
            var index_item = $(this).val();
            item = 'key_' + item.toString();
            items[item] = 'yes';
            
            $("#dialogOperasi").find("input[tag="+ index_item +"]").attr('checked', 'true');
            $("#dialogOperasi").find("input[tag="+ index_item +"]").attr('disabled', 'true');
            
            var daftartindakan_id = $(this).parent().find("input[name$='[daftartindakan_id]']").val();
            var daftartindakan_nama = $(this).parent().find("input[name$='[daftartindakan_nama]']").val();
            tambahTindakanPemakaianBahan(daftartindakan_id, daftartindakan_nama);
        }
    );
}
validasiItem();

function tambahTindakanPemakaianBahan(value,label)
{
    $('#daftartindakanPemakaianBahan').append('<option value="'+value+'">'+label+'</option>');
}
function checkAll(kelas,obj)
{
    if(obj.checked) {
        $('.'+kelas+'').each(function() {
            $(this).attr('checked', 'checked');
        });
    }
    else
    {
        obj.checked = false;
        $('.'+kelas+'').each(function() {
            $(this).removeAttr('checked');
        });
    }
}
</script>
