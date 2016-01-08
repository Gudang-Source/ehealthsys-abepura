<?php $this->widget('bootstrap.widgets.BootAlert'); ?> 

<fieldset class="box">
    <legend class="rim">Data Pasien</legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('readonly'=>true)); ?></td>
            <td><div class=" control-label"><?php echo CHtml::activeLabel($modPendaftaran, 'instalasi_id',array('class'=>'no_rek')); ?></div></td>
            <td>
                <?php
                if(!empty($modPendaftaran->instalasi_id)){
                    echo CHtml::textField('BKPendaftaranT[instalasi_id]', $modPendaftaran->instalasi->instalasi_nama, array('readonly'=>true));
                }else{
                    echo CHtml::dropDownList('BKPendaftaranT[instalasi_id]', NULL, CHtml::listData($modPendaftaran->Instalasis, 'instalasi_id', 'instalasi_nama'), array('empty'=>'-- Pilih --', 'onchange'=>'refreshDialogPendaftaran();', 'onkeypress'=>"return $(this).focusNextInputField(event)"));
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
            <td><?php echo CHtml::textField('BKPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly'=>true)); ?></td>
            
            <td>
                <?php //echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?>
               <label class="control-label no_rek" >No. Rekam Medik</label>
            </td>
            <td>
                <?php //echo CHtml::textField('BKPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true)); ?>
                <?php 
                    if (!empty($modPasien->no_rekam_medik)) { 
                    echo CHtml::textField('BKPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true));
                    }else{
                    $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'BKPasienM[no_rekam_medik]',
                                    'value'=>$modPasien->no_rekam_medik,
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.Yii::app()->createUrl('billingKasir/ActionAutoComplete/daftarPasienInstalasi').'",
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
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKPendaftaranT[umur]', $modPendaftaran->umur, array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label no_rek')); ?></td>
            <td><?php //echo CHtml::textField('BKPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly'=>true)); 
                    $this->widget('MyJuiAutoComplete', array(
                                           'name'=>'BKPasienM[nama_pasien]',
                                           'value'=>$modPasien->nama_pasien,
                                           'source'=>'js: function(request, response) {
                                                          $.ajax({
                                                              url: "'.Yii::app()->createUrl('billingKasir/ActionAutoComplete/daftarPasienberdasarkanNama').'",
                                                              dataType: "json",
                                                              data: {
                                                                  daftarpasien:true,
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
            ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKPendaftaranT[jeniskasuspenyakit_nama]',isset($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama)?$modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama:'-', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKPasienM[jeniskelamin]', $modPasien->jeniskelamin, array('readonly'=>true)); ?></td>   
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'instalasi_id',array('class'=>'control-label')); ?></td>
            <td>
                <?php echo CHtml::textField('BKPendaftaranT[instalasi_nama]',isset($modPendaftaran->instalasi->instalasi_nama)?$modPendaftaran->instalasi->instalasi_nama:'-', array('readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('BKPendaftaranT[pendaftaran_id]',$modPendaftaran->pendaftaran_id, array('readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('BKPendaftaranT[pasien_id]',$modPendaftaran->pasien_id, array('readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('BKPendaftaranT[pasienadmisi_id]',$modPendaftaran->pasienadmisi_id, array('readonly'=>true)); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKPasienM[nama_bin]', $modPasien->nama_bin, array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('BKPendaftaranT[ruangan_nama]', isset($modPendaftaran->ruangan->ruangan_nama)?$modPendaftaran->ruangan->ruangan_nama:'-', array('readonly'=>true)); ?></td>
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
        $modDialogPasien->idInstalasi = isset($_GET['BKPasienM']['idInstalasi'])?$_GET['BKPasienM']['idInstalasi']:'';
        $modDialogPasien->no_pendaftaran = isset($_GET['BKPasienM']['no_pendaftaran'])?$_GET['BKPasienM']['no_pendaftaran']:'';
        $modDialogPasien->tgl_pendaftaran_cari = isset($_GET['BKPasienM']['tgl_pendaftaran_cari'])?$_GET['BKPasienM']['tgl_pendaftaran_cari']:'';
        $modDialogPasien->instalasi_nama = isset($_GET['BKPasienM']['instalasi_nama'])?$_GET['BKPasienM']['instalasi_nama']:'';
        $modDialogPasien->carabayar_nama = isset($_GET['BKPasienM']['carabayar_nama'])?$_GET['BKPasienM']['carabayar_nama']:'';
        $modDialogPasien->ruangan_nama = isset($_GET['BKPasienM']['ruangan_nama'])?$_GET['BKPasienM']['ruangan_nama']:'';
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
                                            $(\"#BKPendaftaranT_tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
                                            $(\"#BKPendaftaranT_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                            $(\"#BKPendaftaranT_umur\").val(\"$data->umur\");
                                            $(\"#BKPendaftaranT_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");
                                            $(\"#BKPendaftaranT_instalasi_id\").val(\"$data->instalasi_id\");
                                            $(\"#BKPendaftaranT_instalasi_nama\").val(\"$data->instalasi_nama\");
                                            $(\"#BKPendaftaranT_ruangan_nama\").val(\"$data->ruangan_nama\");
                                            $(\"#BKPendaftaranT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                            $(\"#BKPendaftaranT_carabayar_id\").val(\"$data->carabayar_id\");
                                            $(\"#BKPendaftaranT_penjamin_id\").val(\"$data->penjamin_id\");
                                            $(\"#BKPendaftaranT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_id\");
                                            $(\"#BKPendaftaranT_pasien_id\").val(\"$data->pasien_id\");
                                            $(\"#BKTandabuktibayarUangMukaT_darinama_bkm\").val(\"$data->nama_pasien\");

                                            $(\"#BKPasienM_jeniskelamin\").val(\"$data->jeniskelamin\");
                                            $(\"#BKPasienM_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                            $(\"#BKPasienM_nama_pasien\").val(\"$data->nama_pasien\");
                                            $(\"#BKPasienM_nama_bin\").val(\"$data->nama_bin\");
                                            $(\"#BKPendaftaranT_carabayar_nama\").val(\"$data->carabayar_nama\");
                                            $(\"#BKPendaftaranT_penjamin_nama\").val(\"$data->penjamin_nama\");
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
    $('#BKPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
    $('#BKPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
    $('#BKPendaftaranT_umur').val(data.umur);
    $('#BKPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit);
    $('#BKPendaftaranT_instalasi_nama').val(data.namainstalasi);
    $('#BKPendaftaranT_ruangan_nama').val(data.namaruangan);
    $('#BKPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
    $('#BKPendaftaranT_pasien_id').val(data.pasien_id);
    $('#BKPendaftaranT_pasienadmisi_id').val(data.pasienadmisi_id);
    if (typeof data.norekammedik !=  'undefined'){
        $('#BKPasienM_no_rekam_medik').val(data.norekammedik);
    }
    $('#BKPasienM_jeniskelamin').val(data.jeniskelamin);
    $('#BKPasienM_nama_pasien').val(data.namapasien);
    $('#BKPasienM_nama_bin').val(data.namabin);
    
    //$('#BKTandabuktibayarUangMukaT_jmlpembayaran').focus();
    //$('#BKTandabuktibayarUangMukaT_jmlpembayaran').select();    
}

function loadPembayaran(pendaftaran_id)
{
    $.post('<?php echo Yii::app()->createUrl('billingKasir/ActionAjax/loadPembayaranUangMuka');?>', {pendaftaran_id:pendaftaran_id}, function(data){
        $('#TandabuktibayarT_jmlpembayaran').val(data.jmlpembayaran);
        $('#totTagihan').val(formatInteger(data.tottagihan));
        $('#totPembebasan').val(formatInteger(data.totpembebasan));
        
        var norekammedik = $('#BKPasienM_no_rekam_medik').val();
        var no_pendaftaran = $('#BKPendaftaranT_no_pendaftaran').val();
        var nama_pembayar = norekammedik + '-' + no_pendaftaran + '-' + data.namapasien;
        $('#BKTandabuktibayarUangMukaT_jmlpembayaran').val(formatInteger(0));
        $('#BKTandabuktibayarUangMukaT_uangditerima').val(formatInteger(0));
        $('#BKTandabuktibayarUangMukaT_jmlpembulatan').val(formatInteger(data.jmlpembulatan));
        $('#BKTandabuktibayarUangMukaT_uangkembalian').val(formatInteger(data.uangkembalian));
        $('#BKTandabuktibayarUangMukaT_biayamaterai').val(formatInteger(data.biayamaterai));
        $('#BKTandabuktibayarUangMukaT_biayaadministrasi').val(formatInteger(data.biayaadministrasi));
        $('#BKTandabuktibayarUangMukaT_darinama_bkm').val(data.namapasien);
        $('#BKTandabuktibayarUangMukaT_darinama_bkm').val(nama_pembayar);
        $('#BKTandabuktibayarUangMukaT_alamat_bkm').val(data.alamatpasien);
        $('#BKPasienM_photopasien').val(data.photopasien);
        $('#BKTandabuktibayarUangMukaT_jmlpembayaran').focus();
        
        if(data.photopasien != ""){ //set photo
            $("#<?php echo CHtml::activeId($modPasien,"photopasien");?>").val(data.photopasien);            
            $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
        }else{
            $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
        }
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