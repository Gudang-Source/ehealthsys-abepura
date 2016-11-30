<div class="white-container">
    <legend class="rim2">Informasi <b>Riwayat Pasien</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php
     $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
     $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    Yii::app()->clientScript->registerScript('cari cari', "
    $('#daftarPasien-form').submit(function(){
            $.fn.yiiGridView.update('daftarPasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    if(!empty($_GET['succes'])){?>
    <div class="alert alert-block alert-success">
        <a class="close" data-dismiss="alert">×</a>
            <?php if($_GET['succes']==2){ ?> Pemeriksaan Pasien berhasil di batalkan<?php } if($_GET['succes']==1){?>Pasein Berhasil Di Rujuk<?php }?>
    </div>
    <?php } ?>
    <div class="block-tabel">  
        <h6>Tabel <b>Riwayat Pasien</b></h6>    
        <?php $this->widget('bootstrap.widgets.BootAlert');
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarPasien-grid',
            'dataProvider'=>$modPasienMasukPenunjang->searchKonsulGizi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                 array(
                    'header' => 'Tgl Pendaftaran /<br> No Pendaftaran',
                    'type' => 'raw',
                    'value' => '$data->tgl_pendaftaran." / <br>".$data->no_pendaftaran'
                ),        
                'tglmasukpenunjang',
                'no_rekam_medik',
                 array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->namadepan." ".$data->nama_pasien',
                ),
                'alamat_pasien',
                array(
                    'header'=>'Cara Bayar <br> / Penjamin',
                    'type'=>'raw',
                    'value'=>'$data->caraBayarPenjamin',    
                    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
               ),
                array(
                    'header'=>'Dokter',
                    'type'=>'raw',
                    'value'=>function($data) use (&$admisi) {
                       // if (!empty($admisi)) return $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama;
                        return $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama;
                    },
                    'htmlOptions'=>array(
                       'style'=>'text-align:center;',
                       'class'=>'rajal'
                   )
                ),  
                'jeniskasuspenyakit_nama',
                array(
                    'header'=>'Status Periksa',
                    'type'=>'raw',
                    'value'=>'$data->statusperiksa',
               ),            
                'ruanganasal_nama',                
                                              
                            
               
               array(
                    'header'=>'Riwayat Pasien',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<i class=\"icon-form-riwayatpasien\"></i>",Yii::app()->createUrl("/gizi/InformasiRiwayatPasienGizi/RiwayatPasien&id",array("id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id)), array("rel"=>"tooltip","title"=>"Klik untuk Rencana Pemeriksaan"))', 'htmlOptions'=>array('style'=>'text-align: center; width:40px')
               ),
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php
        $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
        'id'=>'daftarPasien-form',
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
    )); ?>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td width="33%">
                    <div class="control-group">
                        <?php echo $form->labelEx($modPasienMasukPenunjang,'tglmasukpenunjang', array('class'=>'control-label')) ?>
                        <div class="controls">  
                           <?php 
                           $modPasienMasukPenunjang->tgl_awal = MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tgl_awal);
                           $modPasienMasukPenunjang->tgl_akhir = MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tgl_akhir);
                           $this->widget('MyDateTimePicker',array(
                                               'model'=>$modPasienMasukPenunjang,
                                               'attribute'=>'tgl_awal',
                                               'mode'=>'date',
      //                                          'maxDate'=>'d',
                                               'options'=> array(
                                               'dateFormat'=>Params::DATE_FORMAT,
                                              ),
                                               'htmlOptions'=>array('readonly'=>true,
                                               'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                          )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label(' Sampai Dengan',' s/d', array('class'=>'control-label')) ?>
                        <div class="controls">  
                         <?php $this->widget('MyDateTimePicker',array(
                                              'model'=>$modPasienMasukPenunjang,
                                              'attribute'=>'tgl_akhir',
                                              'mode'=>'date',
     //                                         'maxdate'=>'d',
                                              'options'=> array(
                                              'dateFormat'=>Params::DATE_FORMAT,
                                             ),
                                              'htmlOptions'=>array('readonly'=>true,
                                              'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                         )); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $form->textFieldRow($modPasienMasukPenunjang,'no_rekam_medik',array('class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'autofocus'=>true, 'placeholder'=>'Ketik no. rekam medik')); ?>
                    <?php echo $form->textFieldRow($modPasienMasukPenunjang,'no_pendaftaran',array('class'=>'span3 angkahuruf-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik no. pendaftaran')); ?>
                    <?php echo $form->textFieldRow($modPasienMasukPenunjang,'nama_pasien',array('class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik nama pasien')); ?>
                </td>
                <td>
                    <?php 
                                            $mods = LookupM::getItems('statusperiksa');
                                            unset($mods['BATAL PERIKSA']);
                                            echo $form->dropDownListRow($modPasienMasukPenunjang,'statusperiksa', $mods, array('empty'=>'-- Pilih --')); ?>
                                           <?php  /*<div class="control-group ">
                                                    <label for="namaPasien" class="control-label">
                                                       Dokter Pemeriksa
                                                      </label>
                                                    <div class="controls">
                                                        <?php echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState('ruangan_id'), 'pegawai_aktif'=>true), array('order'=>'nama_pegawai')), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                                                    </div>
                                                </div> */ ?>
                                            <?php echo $form->dropDownListRow($modPasienMasukPenunjang,'carabayar_id', CHtml::listData($modPasienMasukPenunjang->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                'ajax' => array('type'=>'POST',
                                                                                    'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($modPasienMasukPenunjang))), 
                                                                                    'update'=>'#'.CHtml::activeId($modPasienMasukPenunjang,'penjamin_id').''  //selector to update
                                                                                ),
                                                        )); ?>

                                            <?php echo $form->dropDownListRow($modPasienMasukPenunjang,'penjamin_id', CHtml::listData($modPasienMasukPenunjang->getPenjaminItems($modPasienMasukPenunjang->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                </td>

            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
            ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
            <?php 
              $content = $this->renderPartial('../tips/informasiRiwayatPasien',array(),true);
              $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>
        </div>
    </fieldset>  
    <?php $this->endWidget();?>
</div>
<script type="text/javascript">

function batalperiksa(idpendaftaran)
{
   myConfirm('Anda yakin akan membatalkan pemeriksaan gizi pasien ini?','Perhatian!',
    function(r){
        if(r){
           $.post('<?php echo $this->createUrl('BatalPeriksaPasienLuar')?>',{idpendaftaran:idpendaftaran},
                function(data){
                    if(data.status=='success'){
                         window.location = "<?php echo $this->createUrl('index&succes=2')?>";
                    }
                },'json'
            );
        }
    }); 
//    if(alasan==''){
//        myAlert('Anda Belum Mengisi Alasan Pembatalan');
//    }else{
//        $.post('<?php //echo Yii::app()->createUrl('rawatInap/pasienRawatInap/BatalRawatInap');?>', $('#formAlasan').serialize(), function(data){
////            if(data.error != '')
////                myAlert(data.error);
////            $('#'+data.cssError).addClass('error');
//            if(data.status=='success'){
//                batal();
//                myAlert('Data Berhasil Disimpan');
//                location.reload();
//            }else{
//                myAlert(data.status);
//            }
//        }, 'json');
//   }     
}
</script>

<?php
//========= Dialog Detail Anamnesa Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailAnamnesa',
    'options' => array(
        'title' => 'Data Anamnesa Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialogAnamnesa" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
//=======================================================================
?>

<?php
//========= Dialog Detail Konsultasi Gizi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialogGizi" id="detailDialogGizi" width="100%" height="500">
</iframe>
<?php $this->endWidget(); ?>
