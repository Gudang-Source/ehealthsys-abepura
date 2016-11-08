<?php
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pindahkamar-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>
            array(
                'onKeyPress'=>'return disableKeyPress(event)',
                'onSubmit'=>'return requiredCheck(this)'
            ),
        'focus'=>'#',
        )
    );
$this->widget('bootstrap.widgets.BootAlert'); 
echo $form->errorSummary(array($modPindahKamar));
echo $form->errorSummary(array($modMasukKamar)); ?>
<div class="white-container">
    <legend class="rim2">Transaksi <b>Pindah Kamar</b></legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td><?php echo CHtml::label('Tanggal Pendaftaran', 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td>  <div class="control-label"> <?php echo CHtml::label('No. Rekam Medik <font style = "color:red">*</font>', 'no_rekam_medik',array('class'=>'')); ?> </div></td>
            <td>
                <?php $this->widget('MyJuiAutoComplete',array(
                        'model'=>$modPasienRIV,
                        'attribute'=>'no_rekam_medik',
                        'value'=>'',
                        'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/PasienRawatInap'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 2,
                           'focus'=> 'js:function( event, ui ) {
                                $(this).val( ui.item.label);
                                
                                return false;
                            }',
                            'select'=>'js:function( event, ui ) {
                                  $("#'.CHtml::activeId($modPasienRIV,'tgl_pendaftaran').'").val(ui.item.tgl_pendaftaran);
                                  $("#'.CHtml::activeId($modPasienRIV,'no_pendaftaran').'").val(ui.item.no_pendaftaran);   
                                  $("#'.CHtml::activeId($modPasienRIV,'umur').'").val(ui.item.umur);     
                                  $("#'.CHtml::activeId($modPasienRIV,'jeniskasuspenyakit_nama').'").val(ui.item.jeniskasuspenyakit_nama);
                                  $("#'.CHtml::activeId($modPasienRIV,'no_pendaftaran').'").val(ui.item.no_pendaftaran);   
                                  $("#'.CHtml::activeId($modPasienRIV,'nama_pasien').'").val(ui.item.nama_pasien);     
                                  $("#'.CHtml::activeId($modPasienRIV,'jeniskelamin').'").val(ui.item.jeniskelamin);  
                                  $("#'.CHtml::activeId($modPasienRIV,'no_pendaftaran').'").val(ui.item.no_pendaftaran);  
                                  $("#'.CHtml::activeId($modPasienRIV,'nama_bin').'").val(ui.item.nama_bin);

                                  $("#'.CHtml::activeId($modPindahKamar,'pasien_id').'").val(ui.item.pasien_id);     
                                  $("#'.CHtml::activeId($modPindahKamar,'pendaftaran_id').'").val(ui.item.pendaftaran_id);    
                                  $("#'.CHtml::activeId($modPindahKamar,'masukkamar_id').'").val(ui.item.masukkamar_id);    
                                  $("#'.CHtml::activeId($modPindahKamar,'pasienadmisi_id').'").val(ui.item.pasienadmisi_id);
                                  $("#'.CHtml::activeId($modPindahKamar,'ruangan_id').'").val(ui.item.ruangan_id);
                                      
                                  updateKelasRuangan(ui.item.ruangan_id,"f");
                                  updateKamarRuangan(ui.item.kelaspelayanan_id, true);
                                  
                                  setTimeout(
                                    function(){
                                        $("#'.CHtml::activeId($modPindahKamar,'kelaspelayanan_id').'").val(ui.item.kelaspelayanan_id);
                                        $("#'.CHtml::activeId($modPindahKamar,'kamarruangan_id').'").val(ui.item.kamarruangan_id);
                                    }, 500
                                  );
                                  
                                  $("#'.CHtml::activeId($modMasukKamar,'carabayar_id').'").val(ui.item.carabayar_nama);   
                                  $("#'.CHtml::activeId($modMasukKamar,'penjamin_id').'").val(ui.item.penjamin_nama);     
                                  $("#'.CHtml::activeId($modMasukKamar,'pegawai_id').'").val(ui.item.nama_pegawai);    
                                  $("#'.CHtml::activeId($modMasukKamar,'kelaspelayanan_id').'").val(ui.item.kelaspelayanan_nama);        
                            }'
     
                        ),

                        'htmlOptions'=>array(
                            'readonly'=>false,
                            'placeholder'=>'No. Rekam Medik',
                            'size'=>20,
                            'class'=>'span3 numbers-only',
                            'onkeypress'=>"return $(this).focusNextInputField(event);",
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogDaftarPasien','idTombol'=>'tombolPasienDialog'),
                 )); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::label('Tanggal Admisi', 'tgl_admisi',array('class'=>'control-label')); ?></td>
            <td>
                <?php echo CHtml::activeHiddenField($modPasienRIV, 'pasienadmisi_id', array('readonly'=>true)); ?>
                <?php echo CHtml::activeTextField($modPasienRIV, 'tgladmisi', array('readonly'=>true)); ?>
            </td>


            <td><?php echo CHtml::activeLabel($modPasienRIV, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'umur', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::label('Tanggal Masuk Kamar', 'tgl_masuk_kamar',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'tglmasukkamar', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienRIV, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>


            <td><label class="control-label">No. Pendaftaran</label></td>
            <td>
                <?php echo CHtml::activeTextField($modPasienRIV, 'no_pendaftaran', array('readonly'=>true, 'class'=>'span2')); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPasienRIV, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>

            <td></td>
            <td></td>

            <td><?php echo CHtml::activeLabel($modPasienRIV, 'Alias',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienRIV, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
    </table>
    <fieldset class="box">
        <legend class="rim">Data Pindah Kamar</legend>
            <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
            <table width="100%">
                <tr>
                    <td>
                            <?php echo  $form->textFieldRow($modMasukKamar,'carabayar_id',array('class'=>'span3','readonly'=>TRUE,'value'=>  ((isset($modMasukKamar->carabayar->carabayar_nama)) ? $modMasukKamar->carabayar->carabayar_nama : null)));?>
                            <?php echo  $form->textFieldRow($modMasukKamar,'penjamin_id',array('class'=>'span3','readonly'=>TRUE,'value'=>  ((isset($modMasukKamar->penjamin->penjamin_nama)) ? $modMasukKamar->penjamin->penjamin_nama : null)));?>
                            <?php echo  $form->textFieldRow($modMasukKamar,'kelaspelayanan_id',array('class'=>'span3','readonly'=>TRUE,'value'=>  ((isset($modMasukKamar->kelaspelayanan->kelaspelayanan_nama)) ? $modMasukKamar->kelaspelayanan->kelaspelayanan_nama : null)));?>
                            <?php echo  $form->textFieldRow($modMasukKamar,'pegawai_id',array('class'=>'span3','readonly'=>TRUE,'value'=>  ((isset($modMasukKamar->pegawai->namaLengkap)) ? $modMasukKamar->pegawai->namaLengkap : null)));?>
                            <?php
                                echo  $form->textFieldRow(
                                        $modMasukKamar,
                                        'kamarruangan_id',
                                        array(
                                            'class'=>'span3',
                                            'readonly'=>TRUE,
                                            'value'=>$modMasukKamar->getNoKamarRuangan($modMasukKamar->kamarruangan_id)
                                        )
                                );
                            ?>
                    </td>
                    <td>
                        <?php echo $form->hiddenField($modPindahKamar,'pasien_id');?>
                        <?php echo $form->hiddenField($modPindahKamar,'pendaftaran_id');?>
                        <?php echo $form->hiddenField($modPindahKamar,'pasienadmisi_id');?>
                        <?php echo $form->hiddenField($modPindahKamar,'masukkamar_id');?>
                        <?php
                            echo $form->dropDownListRow(
                                $modPindahKamar,
                                'ruangan_id',
                                CHtml::listData($modPindahKamar->getRuanganItems(array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_ICU)), 'ruangan_id', 'ruangan_nama'),
                                array(
                                    'empty'=>'-- Pilih --',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                    'onChange'=>'updateKelasRuangan(this.value, "t")',
                                    'class'=>'span2'
                                )
                            );
                        ?>
						<div class="control-group">
							<!--Karena kelaspelayanan_id di masukkamar_t wajib diisi-->
							<label class="control-label required">Kelas Pelayanan <span class="required">*</span></label>
							<div class="controls">
								<?php
									echo $form->dropDownList($modPindahKamar,'kelaspelayanan_id', CHtml::listData($modPindahKamar->getKelasItems(Yii::app()->user->getState('ruangan_id')), 'kelaspelayanan_id', 'kelaspelayanan_nama'),                          
										array(
											'empty'=>'-- Pilih --',
											'onkeypress'=>"return $(this).focusNextInputField(event)",
											'onChange'=>'updateKamarRuangan(this.value, true)',
											'class'=>'span2'
										)
									);
								?>
							</div>
						</div>
                        
                        <?php 
                            $listData = array();
                            if (!empty($modPindahKamar->ruangan_id))
                            {
                                $kamarKosong = KamarruanganM::model()->findAllByAttributes(
                                    array(
                                        'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                                        'kelaspelayanan_id'=>$modPasienRIV->kelaspelayanan_id,
                                        'kamarruangan_status'=>true
                                    ), array('order'=>'kamarruangan_id asc')
                                );
                                $listData = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
                            }
                        ?>
                        <div class = "control-group">
                            <?php echo Chtml::label('Kamar Ruangan <font style = "color:red">*</font>', 'kamarruangan_id',array('class'=>'control-label')); ?>
                            <div class = "controls">
                        <?php
                            echo $form->dropDownList(
                                $modPindahKamar,
                                'kamarruangan_id',
                                $listData ,
                                array(
                                    'empty'=>'-- Pilih --',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                    'class'=>'span3 required'
                                )
                            );
                        ?>
                            </div>
                        </div>
                        <div class="control-group ">
                                <?php echo CHtml::label('Tanggal Pindah Kamar <span class=required>*</span>','tglpindahkamar', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php $this->widget('MyDateTimePicker',array(
                                                            'model'=>$modPindahKamar,
                                                            'attribute'=>'tglpindahkamar',
                                                            'mode'=>'date',
                                                            'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,
                                                                                 'class'=>'dtPicker2',
                                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                                 ),
                                    )); ?>
                                    <?php echo $form->error($modPindahKamar, 'tglpindahkamar'); ?>
                                </div>
                            </div>

                        <div class="control-group ">
                            <?php echo $form->labelEx($modPindahKamar,'jampindahkamar', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker',array(
                                                        'model'=>$modPindahKamar,
                                                        'attribute'=>'jampindahkamar',
                                                        'mode'=>'time',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,
                                                                             'class'=>'dtPicker2',
                                                                             'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                             ),
                                )); ?>
                                <?php echo $form->error($modPindahKamar, 'jampindahkamar'); ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
    </fieldset>
    <div class="form-actions">
         <?php
            echo CHtml::htmlButton(
                $modPindahKamar->isNewRecord ? 
                    Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                array(
                    'class'=>'btn btn-primary',
                    'type'=>'submit',
                    'onKeypress'=>'return formSubmit(this,event)'
                )
            );
        ?>
        <?php
            if (isset($_GET['pendaftaran_id'])){
            echo CHtml::htmlButton(
                Yii::t('mds','{icon} Batal',array('{icon}'=>'<i class="entypo-block"></i>')),
                array(
                    'class'=>'btn btn-danger','onclick'=>'konfirmasi()'
                )
            );
              $ulang = 'batalDialog';
            }else{
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            '', 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                $ulang = 'ulang';
            }
        ?>
        <?php
            $tips = array(
                '0' => 'autocomplete-search',
                '1' => 'tanggal',
                '2' => 'time',
                '3' => 'simpan',
                '4' => $ulang
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips' => $tips),true);
            $this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
    </div>
    <?php
        $this->endWidget();
        $url = $this->createUrl('GetKamarKosong',array('encode'=>false,'namaModel'=>'PindahkamarT'));
        $urlKelas = $this->createUrl('GetKelasPelayanan',array('encode'=>false));
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
    // Notifikasi Pasien
    <?php 
        if(isset($smspasien)){
            if($smspasien==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasienRIV->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($modPindahKamar->pindahkamar_id)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'Pindah Kamar', isinotifikasi:'<?php echo $modPasienRIV->nama_pasien; ?> dengan No. RM <?php echo $modPasienRIV->no_rekam_medik; ?> telah pindah kamar pada <?php echo $modPindahKamar->tglpindahkamar ?> ke <?php echo $modPindahKamar->ruangan->ruangan_nama ?>'}; // 16 
        insert_notifikasi(params);
    <?php            
        }
    ?>
})
</script>

<?php
if($tersimpan == 'Ya')
{
    if(isset($is_grid))
    {
?>
    <script>
        parent.location.reload();
    </script>
<?php
    }else{
        $urlReloade = Yii::app()->createUrl('/rawatInap/PasienRawatInap/PindahKamarDariTransaksi');
?>
    <script>
        parent.location.href = '<?php echo $urlReloade;?>';
    </script>
<?php
    }
}
?>

<script>
//function cekValidasi(obj)
//{
//    var is_simpan = true;
//    var no_pendaftaran = $(obj).find('input[name$="[no_pendaftaran]"]').val();
//    
//    if(no_pendaftaran == '')
//    {
//        myAlert("Data pasien masih kosong, coba cek lagi");
//        is_simpan = false;
//    }
//    
//    var kelaspelayanan_id = $(obj).find('select[name$="[kelaspelayanan_id]"]').val();
//    if(kelaspelayanan_id == '')
//    {
//        myAlert("Kelas masih kosong, coba cek lagi");
//        is_simpan = false;
//    }
//
//	return is_simpan;
//}


function updateKelasRuangan(idRuangan, is_status)
{
    jQuery.ajax(
        {
            'type':'POST',
             'url':'<?php echo $urlKelas ?>',
             'cache':false,
             'data':{ruangan_id:idRuangan, is_status:is_status},
             'success':function(html)
             {
                 jQuery("#RIPindahkamarT_kelaspelayanan_id").html(html)
             }
         }
    );    
}

function updateKamarRuangan(idKelas, status)
{
    var idRuangan = $('#pindahkamar-t-form').find('select[name$="[ruangan_id]"]').val();
    jQuery.ajax({'type':'POST',
                 'url':'<?php echo $url ?>',
                 'cache':false,
                 'data':{ ruangan_id:idRuangan, kelaspelayanan_id:idKelas, is_status:status},
                 'success':function(html){
                     jQuery("#RIPindahkamarT_kamarruangan_id").html(html)
                 }
             });
}
function konfirmasi()
{
    myConfirm("<?php echo Yii::t('mds','Do You want to cancel?') ?>","Perhatian!",function(r) {
        if(r)
        {
            window.parent.$('#dialogPindahKamar').dialog('close');
        }
    });
}


</script>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'dialogDaftarPasien',
            'options'=>array(
                'title'=>'Daftar Pasien',
                'autoOpen'=>false,
                'resizable'=>false,
                'modal'=>true,
                'width'=>900,
                'height'=>600,
            ),
        ));
    $modPasienDialog=new RIInfopasienmasukkamarV('searchRI');
    $modPasienDialog->unsetAttributes();
    if(isset($_GET['RIInfopasienmasukkamarV'])){
        $modPasienDialog->attributes = $_GET['RIInfopasienmasukkamarV'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftarpasien-v-grid',
    'dataProvider'=>$modPasienDialog->searchRI(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'filter'=>$modPasienDialog,
    'columns'=>array(   
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPendaftaran",
                                    "onClick" => "
                                        $(\"#dialogDaftarPasien\").dialog(\"close\");

                                        $(\"#RIPasienrawatinapV_tgl_pendaftaran\").val(\"$data->FormatTanggalPendaftaran\");
                                        $(\"#RIPasienrawatinapV_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                        $(\"#RIPasienrawatinapV_umur\").val(\"$data->umur\");
                                        $(\"#RIPasienrawatinapV_tgladmisi\").val(\"$data->FormatTanggalAdmisi \");
                                        $(\"#RIPasienrawatinapV_tglmasukkamar\").val(\"$data->FormatTanggalMasukKamar \");
                                        $(\"#RIPasienrawatinapV_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");

                                        $(\"#RIPasienrawatinapV_jeniskelamin\").val(\"$data->jeniskelamin\");
                                        $(\"#RIPasienrawatinapV_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                        $(\"#RIPasienrawatinapV_nama_pasien\").val(\"$data->nama_pasien\"); 
                                        $(\"#RIPasienrawatinapV_nama_bin\").val(\"$data->nama_bin\");
                                       // $(\"#RIPindahkamarT_tglpindahkamar\").val(\"$data->tglmasukkamar\");
                                        $(\"#RIPindahkamarT_masukkamar_id\").val(\"$data->masukkamar_id \");
                                        $(\"#RIPindahkamarT_pendaftaran_id\").val(\"$data->pendaftaran_id \");

                                        $(\"#RIPindahkamarT_pasien_id\").val(\"$data->pasien_id \");
                                        $(\"#RIPindahkamarT_pasienadmisi_id\").val(\"$data->pasienadmisi_id \");
                                        //$(\"#RIPindahkamarT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_id \");
                                        
                                        $(\"#RIPindahkamarT_ruangan_id\").val(\"$data->ruangan_nama \");

                                        $(\"#RIMasukKamarT_pasienadmisi_id\").val(\"$data->tgladmisi \");
                                        $(\"#RIMasukKamarT_carabayar_id\").val(\"$data->carabayar_nama \");
                                        $(\"#RIMasukKamarT_penjamin_id\").val(\"$data->penjamin_nama \");
                                        $(\"#RIMasukKamarT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_nama \");
                                        $(\"#RIMasukKamarT_pegawai_id\").val(\"$data->nama_pegawai \");
                                        $(\"#RIMasukKamarT_kamarruangan_id\").val(\"$data->NoKamarRuangan \");
                                      

                                    "))',
                    
                ),
                array(
                    'header' => 'Tgl Pendaftaran',
                    'name' => 'tgl_pendaftaran',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                    'filter' => $this->widget('MyDateTimePicker', array(
                    'model'=>$modPasienDialog, 
                    'attribute'=>'tgl_pendaftaran', 
                    'mode' => 'date',    
                    //'language' => 'ja',
                    // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                    'htmlOptions' => array(
                        'id' => 'datepicker_for_due_date',
                        'size' => '10',
                        'style'=>'width:80%'
                    ),
                    'options' => array(  // (#3)                    
                        'dateFormat' => Params::DATE_FORMAT,                    
                        'maxDate' => 'd',
                    ),                    
                ), 
                true),
                ),  
                array(
                    'header' => 'No Pendaftaran',
                    'name' => 'no_pendaftaran',
                    'filter' => Chtml::activeTextField($modPasienDialog, 'no_pendaftaran', array('class'=>'angkahuruf-only'))
                ),                 
                array(
                    'header' => 'No Rekam Medik',
                    'name' => 'no_rekam_medik',
                    'filter' => Chtml::activeTextField($modPasienDialog, 'no_rekam_medik', array('class'=>'numbers-only'))
                ),  
                array(
                    'header' => 'Nama Pasien',
                    'name' => 'nama_pasien',
                    'filter' => Chtml::activeTextField($modPasienDialog, 'nama_pasien', array('class'=>'hurufs-only'))
                ),                 
                /*array(
                    'header'=>'Nama Alias',
                    'type'=>'raw',
                    'value'=>'"$data->nama_bin"',
                ),*/
                array(
                    'header'=>'Cara Bayar '.' / <br/>'.' Penjamin',
                    'type'=>'raw',
                    'value'=>'"$data->carabayar_nama"." / <br/>"."$data->penjamin_nama"',
                    'filter' => Chtml::activeDropDownList($modPasienDialog, 'carabayar_id', Chtml::listData(CarabayarM::model()->findAll(" carabayar_aktif = TRUE ORDER BY carabayar_nama ASC "), 'carabayar_id', 'carabayar_nama'), array('empty'=>'-- Pilih --'))
                ),
                array(
                    'header'=>'Dokter',
                    'type'=>'raw',
                    'name'=>'nama_pegawai',
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                    'filter' => Chtml::activeTextField($modPasienDialog, 'nama_pegawai', array('class'=>'hurufs-only'))
                ),  
                array(
                    'header' => 'Jenis Kasus Penyakit',
                    'name' => 'jeniskasuspenyakit_nama',
                    'filter' => Chtml::activeTextField($modPasienDialog, 'jeniskasuspenyakit_nama', array('class'=>'hurufs-only'))
                ), 
                // 'ruangan_nama',
        //'jeniskasuspenyakit_nama',
        // 'statusperiksa',
                
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
        . '$(".numbers-only").keyup(function() {
                setNumbersOnly(this);
            });
            $(".angkahuruf-only").keyup(function() {
                setAngkaHurufsOnly(this);
            });
            $(".hurufs-only").keyup(function() {
                setHurufsOnly(this);
            });
            reinstallDatePicker();'
        . '}',
    )); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>