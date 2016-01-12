<?php $this->widget('bootstrap.widgets.BootAlert'); ?> 

<fieldset>
    <table width="100%" class="table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('readonly'=>true)); ?></td>
            
            <td><div class=" control-label"><?php echo CHtml::activeLabel($modPendaftaran, 'instalasi_id',array('class'=>'no_rek')); ?></div></td>
            <td>            
                <?php
                if(!empty($modPendaftaran->instalasi_id)){
                    echo CHtml::activeHiddenField($modPendaftaran,'instalasi_id',array('readonly'=>true));
                    echo CHtml::textField('BKPendaftaranT[instalasi_nama]', $modPendaftaran->instalasi->instalasi_nama, array('readonly'=>true));
                }else{
                    echo CHtml::dropDownList('BKPendaftaranT[instalasi_id]', NULL, 
                             CHtml::listData($modPendaftaran->getInstalasis(), 'instalasi_id', 'instalasi_nama'), array('empty'=>'-- Pilih --', 'onchange'=>'refreshDialogPendaftaran();', 'onkeypress'=>"return $(this).focusNextInputField(event)"));
                }
                ?>
            </td> 
            
            <td rowspan="5">
                <?php echo CHtml::activeHiddenField($modPasien,'photopasien', array('readonly'=>true)); ?>
                <?php 
                     $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : Params::urlPhotoPasienDirectory()."no_photo.jpeg");
                ?>
                <img id="photo-preview" src="<?php echo $url_photopasien?>"width="84px"/> 
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly'=>true)); ?></td>
            
            <td>
                <?php //echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?>
            <label class="no_rek control-label">No. Rekam Medik</label>
            </td>
            <td>
                <?php //echo CHtml::textField('FAPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true)); ?>
                <?php 
                   if (Yii::app()->controller->module->id =='billingKasir') {
                     $pasien = 'daftarPasien';
                 }else{
                     $pasien = 'daftarPasienRuangan';
                 }
                    $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'FAPasienM[no_rekam_medik]',
                                    'value'=>$modPasien->no_rekam_medik,
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.Yii::app()->createUrl('billingKasir/ActionAutoComplete/'.$pasien.'').'",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           instalasiId: $("#BKPendaftaranT_instalasi_id").val(),
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
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                isiDataPasien(ui.item);
                                                loadPembayaran(ui.item.pendaftaran_id);
                                                return false;
                                            }',
                                    ),
                                    'tombolDialog'=>array('idDialog'=>'dialogPasien','idTombol'=>'tombolPasienDialog'),
                                    'htmlOptions'=>array('onfocus'=>'return cekInstalasi();','class'=>'span2', 
                                                        'placeholder'=>'Ketik No. Rekam Medik','onkeypress'=>"return $(this).focusNextInputField(event)"),
                                )); 
                ?>
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[umur]', $modPendaftaran->umur, array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label no_rek')); ?></td>
            <td><?php //echo CHtml::textField('FAPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly'=>true)); 
                    $this->widget('MyJuiAutoComplete', array(
                                           'name'=>'FAPasienM[nama_pasien]',
                                           'value'=>$modPasien->nama_pasien,
                                           'source'=>'js: function(request, response) {
                                                          $.ajax({
                                                              url: "'.Yii::app()->createUrl('billingKasir/ActionAutoComplete/daftarPasienberdasarkanNama').'",
                                                              dataType: "json",
                                                              data: {
                                                                  '.strtolower($pasien).':true,
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
                                                       $(this).val(ui.item.value);
                                                       return false;
                                                   }',
                                                  'select'=>'js:function( event, ui ) {
                                                       isiDataPasien(ui.item);
                                                       loadPembayaran(ui.item.pendaftaran_id);
                                                       return false;
                                                   }',
                                           ),
                                       )); 
                   ?>
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[jeniskasuspenyakit_nama]',  ((isset($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama)) ? $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama : null), array('readonly'=>true)); ?></td>
            
            <?php 
                echo '<td>'. CHtml::label('No. Resep','',array('class'=>'control-label no_rek')).'</td><td>';
                $this->widget('MyJuiAutoComplete', array(
                               'name'=>'no_resep',
                                'id'=>'no_resep',
//                               'value'=>$modPasien->nama_pasien,
                               'source'=>'js: function(request, response) {
                                              $.ajax({
                                                  url: "'.Yii::app()->createUrl('billingKasir/ActionAutoComplete/getNoResepObatPasien').'",
                                                  dataType: "json",
                                                  data: {
                                                      pendaftaran_id : $("#FAPendaftaranT_pendaftaran_id").val(),
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
                                           $(this).val(ui.item.value);
                                           return false;
                                       }',
                                      'select'=>'js:function( event, ui ) {
                                           loadPembayaran($("#FAPendaftaranT_pendaftaran_id").val(), ui.item.penjualanresep_id);
                                           return false;
                                       }',
                               ),
//                               'htmlOptions'=>array(
//                                   'onblur'=>'loadPembayaran($("#FAPendaftaranT_pendaftaran_id").val())',
//                                   'onkeypress' =>"if (jQuery.trim($(this).val()) != ''){if (event.keyCode == 13){loadPembayaran($('#FAPendaftaranT_pendaftaran_id').val());}}",
//                               ),
                           )); 
                echo '<td>';
            // }
            
            ?>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'instalasi_id',array('class'=>'control-label')); ?></td>
            <td>
                <?php echo CHtml::textField('FAPendaftaranT[instalasi_nama]',  ((isset($modPendaftaran->instalasi->instalasi_nama)) ? $modPendaftaran->instalasi->instalasi_nama : null), array('readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('FAPendaftaranT[pendaftaran_id]',$modPendaftaran->pendaftaran_id, array('readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('FAPendaftaranT[pasien_id]',$modPendaftaran->pasien_id, array('readonly'=>true)); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPasienM[nama_bin]', $modPasien->nama_bin, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('FAPendaftaranT[ruangan_nama]', ((isset($modPendaftaran->ruangan->ruangan_nama)) ? $modPendaftaran->ruangan->ruangan_nama : null), array('readonly'=>true)); ?></td>
            
            <td>
                <?php echo CHtml::activeLabel($modPendaftaran, 'carabayar_id',array('class'=>'control-label')) ?>
            </td>
            <td>
                <?php echo CHtml::textField('FAPendaftaranT[carabayar_nama]', (isset($modPendaftaran->carabayar->carabayar_nama) ? $modPendaftaran->carabayar->carabayar_nama : ""), array('readonly'=>true));   ?>
                <?php echo CHtml::hiddenField('FAPendaftaranT[carabayar_id]', $modPendaftaran->carabayar_id, array('readonly'=>true));   ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            
            <td>
                <?php echo CHtml::activeLabel($modPendaftaran, 'penjamin_id',array('class'=>'control-label')) ?>
            </td>
            <td>
                <?php echo CHtml::textField('FAPendaftaranT[penjamin_nama]', (isset($modPendaftaran->penjamin->penjamin_nama) ? $modPendaftaran->penjamin->penjamin_nama : ""), array('readonly'=>true));   ?>
                <?php echo CHtml::hiddenField('FAPendaftaranT[penjamin_id]', $modPendaftaran->penjamin_id, array('readonly'=>true));   ?>
                <?php echo CHtml::hiddenField('FAPendaftaranT[kelaspelayanan_id]',((isset($modPendaftaran->kelaspelayanan_id)) ? $modPendaftaran->kelaspelayanan_id : ''), array('readonly'=>true)); ?></td>
            </td>
        </tr>
    </table>
</fieldset> 
<?php 
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>540,
        'resizable'=>false,
    ),
));
    $modDialogPasien = new BKPasienM('searchPasienRumahsakitV');
    $modDialogPasien->unsetAttributes();
    if(isset($_GET['BKPasienM'])) {
        $modDialogPasien->attributes = $_GET['BKPasienM'];
//        $modDialogPasien->idInstalasi = $_GET['BKPasienM']['idInstalasi'];
        $modDialogPasien->no_pendaftaran = (isset($_GET['BKPasienM']['no_pendaftaran']) ? $_GET['BKPasienM']['no_pendaftaran'] : null);
        $modDialogPasien->tgl_pendaftaran_cari = (isset($_GET['BKPasienM']['tgl_pendaftaran_cari']) ? $_GET['BKPasienM']['tgl_pendaftaran_cari'] : null);
        $modDialogPasien->instalasi_nama = $_GET['BKPasienM']['instalasi_nama'];
        $modDialogPasien->carabayar_nama = (isset($_GET['BKPasienM']['carabayar_nama']) ? $_GET['BKPasienM']['carabayar_nama'] : null);
        $modDialogPasien->ruangan_nama = (isset($_GET['BKPasienM']['ruangan_nama']) ? $_GET['BKPasienM']['ruangan_nama'] : null);
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pendaftaran-t-grid',
            'dataProvider'=>$modDialogPasien->searchPasienRumahsakitV(),
            'filter'=>$modDialogPasien,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogPasien\").dialog(\"close\");
                                            $(\"#FAPendaftaranT_tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
                                            $(\"#FAPendaftaranT_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                            $(\"#FAPendaftaranT_umur\").val(\"$data->umur\");
                                            $(\"#FAPendaftaranT_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");
                                            $(\"#FAPendaftaranT_instalasi_id\").val(\"$data->instalasi_id\");
                                            $(\"#FAPendaftaranT_instalasi_nama\").val(\"$data->instalasi_nama\");
                                            $(\"#FAPendaftaranT_ruangan_nama\").val(\"$data->ruangan_nama\");
                                            $(\"#FAPendaftaranT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                            $(\"#FAPendaftaranT_carabayar_id\").val(\"$data->carabayar_id\");
                                            $(\"#FAPendaftaranT_penjamin_id\").val(\"$data->penjamin_id\");
                                            $(\"#FAPendaftaranT_pasien_id\").val(\"$data->pasien_id\");
                                            $(\"#FAPendaftaranT_penjamin_nama\").val(\"$data->penjamin_nama\");
                                            $(\"#FAPendaftaranT_carabayar_nama\").val(\"$data->carabayar_nama\");
                                            $(\"#FAPendaftaranT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_id\");
                                            $(\"#FATandabuktibayarUangMukaT_darinama_bkm\").val(\"$data->nama_pasien\");

                                            $(\"#FAPasienM_jeniskelamin\").val(\"$data->jeniskelamin\");
                                            $(\"#FAPasienM_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                            $(\"#FAPasienM_nama_pasien\").val(\"$data->nama_pasien\");
                                            $(\"#FAPasienM_nama_bin\").val(\"$data->nama_bin\");
                                            $(\"#FAPendaftaranT_carabayar_nama\").val(\"$data->carabayar_nama\");
                                            $(\"#FAPendaftaranT_penjamin_nama\").val(\"$data->penjamin_nama\");
                                            loadPembayaran($data->pendaftaran_id);

                                        "))',
                    ),
                    array(
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                        'name'=>'nama_pasien',
                        'type'=>'raw',
                        'value'=>'$data->nama_pasien',
                    ),
                    'jeniskelamin',
                    'no_pendaftaran',
                    array(
                        'name'=>'tgl_pendaftaran',
                        'filter'=> 
                        CHtml::activeTextField($modDialogPasien, 'tgl_pendaftaran_cari', array('placeholder'=>'contoh: 15 Jan 2013')),
                    ),
                    array(
                        'name'=>'instalasi_nama',
                        'type'=>'raw',
                    ),
                    array(
                        'name'=>'ruangan_nama',
                        'type'=>'raw',
                    ),
                    array(
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                    ),


            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script type="text/javascript">
function isiDataPasien(data)
{
    $('#FAPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
    $('#FAPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
    $('#FAPendaftaranT_umur').val(data.umur);
    $('#FAPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit);
    $('#FAPendaftaranT_instalasi_nama').val(data.namainstalasi);
    $('#FAPendaftaranT_ruangan_nama').val(data.namaruangan);
    $('#FAPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
    $('#FAPendaftaranT_pasien_id').val(data.pasien_id);
    $('#FAPendaftaranT_carabayar_id').val(data.carabayar_id);
    $('#FAPendaftaranT_penjamin_id').val(data.penjamin_id);
    $('#FAPendaftaranT_kelaspelayanan_id').val(data.kelaspelayanan_id);
    if (typeof data.norekammedik !=  'undefined'){
        $('#FAPasienM_no_rekam_medik').val(data.norekammedik);
    }
    $('#FAPasienM_jeniskelamin').val(data.jeniskelamin);
    $('#FAPasienM_nama_pasien').val(data.namapasien);
    $('#FAPasienM_nama_bin').val(data.namabin);
    $('#FAPendaftaranT_carabayar_nama').val(data.carabayar_nama);
    $('#FAPendaftaranT_penjamin_nama').val(data.penjamin_nama);
}

function loadPembayaran(pendaftaran_id,penjualanresep)
{
    
    <?php $tindakanParam = ',tindakan : 1';?>
    $.post('<?php echo Yii::app()->createUrl('billingKasir/ActionAjax/loadPembayaranVerifikasi');?>', {pendaftaran_id:pendaftaran_id,penjualanResep : penjualanresep<?php echo $tindakanParam;?>}, function(data){
        $("#checkTindakan").attr('checked', true);
        $("#checkAllObat").attr('checked', true);
        setTimeout('checkAllTindakan()', 500);
        setTimeout('checkAll()', 500);
        $('#tblBayarTind tbody').html(data.formBayarTindakan);
        $('#tblBayarOA tbody').html(data.formBayarOa);
        $('#totTagihan').val(formatInteger(data.tottagihan));
        
        $('#TandabuktibayarT_jmlpembayaran').val(formatInteger(data.jmlpembayaran));
        $('#TandabuktibayarT_jmlpembulatan').val(formatInteger(data.jmlpembulatan));
        $('#TandabuktibayarT_uangditerima').val(formatInteger(data.uangditerima));
        $('#TandabuktibayarT_uangkembalian').val(formatInteger(data.uangkembalian));
        $('#TandabuktibayarT_biayamaterai').val(formatInteger(data.biayamaterai));
        $('#TandabuktibayarT_biayaadministrasi').val(formatInteger(data.biayaadministrasi));
        if(data.photopasien != ""){ //set photo
            $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val(data.photopasien);            
            $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
        }else{
            $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
        }
        var norekammedik = $('#FAPasienM_no_rekam_medik').val();
        var no_pendaftaran = $('#FAPendaftaranT_no_pendaftaran').val();
        var nama_pembayar = norekammedik + '-' + no_pendaftaran + '-' + data.namapasien;
        
        if(penjualanresep != undefined)
        {
            var no_resep = $('#no_resep').val();
            nama_pembayar = norekammedik + '-' + no_resep + '-' + data.namapasien;
        }
//        $('#TandabuktibayarT_darinama_bkm').val(data.namapasien);
        $('#TandabuktibayarT_darinama_bkm').val(nama_pembayar);
        $('#TandabuktibayarT_alamat_bkm').val(data.alamatpasien);
        
        var discount = 0;
        discount = unformatNumber($('#totaldiscount_tindakan').val()) + unformatNumber($('#totaldiscount_oa').val());
        $('#disc').val(0);
        $('#discount').val(0);
        $('#tblBayarTind').find('input.currency:text').each(function(){
            $(this).maskMoney({"symbol":"Rp. ","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
        });
        $('#tblBayarOA').find('input.currency:text').each(function(){
            $(this).maskMoney({"symbol":"Rp. ","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
        });
        $('.currency').each(function(){this.value = formatInteger(this.value)});
        //Load Deposit
        $('#deposit').val(formatInteger(data.deposit));
        $('#TandabuktibayarT_uangditerima').focus();
        hitungTotalSemuaTind();
        hitungTotalSemuaOa();
        //$('#tblBayarOA').find('input.currency:text').each(function(){this.value = formatNumber(this.value)});
    }, 'json');
}

function refreshDialogPendaftaran(){
    var instalasiId = $("#BKPendaftaranT_instalasi_id").val();
    var instalasiNama = $("#BKPendaftaranT_instalasi_id option:selected").text();
    $.fn.yiiGridView.update('pendaftaran-t-grid', {
        data: {
            "BKPasienM[idInstalasi]":instalasiId,
            "BKPasienM[instalasi_nama]":instalasiNama,
        }
    });
}
    
function cekInstalasi(){
    var instalasiId = $("#BKPendaftaranT_instalasi_id").val();
    if(instalasiId.length > 0){
        return true;
    }else{
        myAlert("Silahkan pilih instalasi ! ");
        $("#BKPendaftaranT_instalasi_id").focus();
        return false;
    }
}
</script>