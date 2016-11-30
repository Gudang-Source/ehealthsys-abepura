<div class="white-container">
    <legend class="rim2">Informasi Pasien <b>Yang Dipindahkan</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

    <?php
     $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
     $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
            $('#daftarPasien-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('daftarPasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Pasien <b>Yang Dipindahkan</b></h6>
        <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'daftarPasien-grid',
                'dataProvider'=>$model->searchPasienYangDipindahkan(),
        //                'filter'=>$model,
                        'template'=>"{summary}\n{items}\n{pager}",

                        'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(  
                            array(
                               'header'=>'Tanggal Pendaftaran/ No Pendaftaran',
                                'type'=>'raw',                                
                                'value'=>'$data->TglNoPendaftaran',
                            ),
                            array(
                                'header'=>'Tanggal Pindah',                                
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatDateTimeForUser($data->tglpindahkamar)'
                            ),
                            array(
                                'header' => 'No Rekam Medik',
                                'value' => '$data->no_rekam_medik'
                            ),
                            
                            array(
                                'header'=>'Nama Pasien',
                                'value'=>'$data->namadepan." ".$data->nama_pasien'
                            ),
                            array(
                                'header'=>'Jenis Kelamin/ Umur',                                
                                'value'=>'$data->jeniskelamin."/ ".$data->umur',
                            ),       
                            array(
                                'header'=>'Jenis Kasus Penyakit',                                
                                'type'=>'raw',
                                'value'=>'$data->jeniskasuspenyakit_nama',
                            ),
                            array(
                                'header'=>'Cara Bayar / Penjamin',
                                'value'=>'$data->caraBayarPenjamin',
                            ),
                            array(
                                'header'=>'Dokter PJP',                                
                                'type'=>'raw',
                                'value'=>'$data->Dokter',
                            ),
                            
                            array(
                                'header'=>'Kelas Pelayanan',                                
                                'type'=>'raw',
                                'value'=>'$data->kelaspelayanan_nama',
                            ),
                            
                            array(
                                'header'=>'Ruangan Tujuan',
              //                  'name'=>'ruangan_nama',
                                'type'=>'raw',
                                'value'=>'$data->ruangan_nama',
                            ),
                           array(
                                'header'=>'Kamar Ruangan',
                                'type'=>'raw',
                                'value'=> function($data){
                                    $pkamar = PindahkamarT::model()->findByPk($data->pindahkamar_id);
                                    
                                    if(count($pkamar) > 0){
                                        if (!empty($pkamar->kamarruangan_id)){
                                            return $pkamar->kamarruangan->kamarruangan_nokamar." - ".$pkamar->kamarruangan->kamarruangan_nobed;
                                        }else{
                                            $mkamar = MasukkamarT::model()->findByPk($pkamar->masukkamar_id);
                                            
                                            if (!empty($mkamar->kamarruangan_id)){
                                                return $mkamar->kamarruangan->kamarruangan_nokamar." - ".$mkamar->kamarruangan->kamarruangan_nobed;
                                            }else{
                                                return '-';
                                            }
                                        }
                                    }
                                }//'$data->kamarruangan_nokamar." - ".$data->kamarruangan_nobed'
                            ),
                           /* array(
                                                        'header'=>'Batal Pindah',
                                                        'type'=>'raw',
                                                        'value'=>'isset($data->masukkamar_id) ?	($data->TindakanDanObat["ada"] ? CHtml::link("Sedang Diperiksa", "#",array("title"=>"Pasien sudah mendapatkan ".$data->TindakanDanObat["msg"]."! Silahkan batalkan di Ruangan Tujuan !")) : CHtml::link("<i class=icon-form-silang></i>","#",array("rel"=>"tooltip","title"=>"Klik Untuk Batal Pindah Kamar","onclick"=>"batalPindahKamar(".$data->pindahkamar_id.",".$data->masukkamar_id.");"))) :
                                                                                                                                                                 ($data->TindakanDanObat["ada"] ? CHtml::link("Sedang Diperiksa", "#",array("title"=>"Pasien sudah mendapatkan ".$data->TindakanDanObat["msg"]."! Silahkan batalkan di Ruangan Tujuan !")) : CHtml::link("<i class=icon-form-silang></i>","#",array("rel"=>"tooltip","title"=>"Klik Untuk Batal Pindah Kamar","onclick"=>"batalPindahKamar(".$data->pindahkamar_id.");")))',
                                                        //TANPA CEK TINDAKAN DAN OBAT >> 'value'=>'$data->masukkamar_id ? CHtml::link("Sudah Masuk Kamar", "#",array("title"=>"Silahkan hubungi ruangan tujuan untuk membatalkan")) : CHtml::link("<i class=icon-remove-sign></i>","#",array("rel"=>"tooltip","title"=>"Klik Untuk Batal Pindah Kamar","onclick"=>"{batalPindahKamar($data->pindahkamar_id,$data->masukkamar_id);}"))',    
                                                        'htmlOptions'=>array('style'=>'text-align:left;'),
                                                     ),*/

                    ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));


        ?>
    </div>
    <?php echo $this->renderPartial('_formPencarian', array('model'=>$model,'format'=>$format)); ?>
    <?php 
    // Dialog untuk Batal Pindah Kamar =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogSuksesBatalPindah',
        'options'=>array(
            'title'=>'Batal Pindah Kamar',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>200,
            'minHeight'=>100,
            'resizable'=>false,
        ),
    ));
    ?>
    <font size ="5"><p><strong>Data Berhasil Disimpan</strong></p></font>
    <?php 
    $this->endWidget();
    //========= end Batal Pindah Kamardialog =============================
    ?>

    <?php 
    // Dialog untuk Batal Pindah Kamar =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogGagalBatalPindah',
        'options'=>array(
            'title'=>'Batal Pindah Kamar',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>200,
            'minHeight'=>100,
            'resizable'=>false,
        ),
    ));
    ?>
    <font size ="5"><p><strong>Data Gagal Disimpan</strong></p></font>
    <?php 
    $this->endWidget();
    //========= end Batal Pindah Kamardialog =============================
    ?>
</div>
<?php
$url = $this->createUrl('BatalPindahKamar');
$mds = Yii::t('mds','Anda yakin akan membatalkan pindah kamar?');
$jscript = <<< JS
function batalPindahKamar(idPindahKamar,idMasukKamar=null)
{
    if(confirm("${mds}"))
    {
        $.post("${url}", { idPindahKamar: idPindahKamar, idMasukKamar: idMasukKamar },
            function(data){
                if(data.status == 'true')
                {
                    $('#dialogSuksesBatalPindah').dialog('open');
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    $('#dialogBatalPindah div.divForForm').html(data.div);
                    setTimeout("$('#dialogSuksesBatalPindah').dialog('close') ",1000);
                }
                else
                {
                    $('#dialogGagalBatalPindah').dialog('open');
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    $('#dialogBatalPindah div.divForForm').html(data.div);
                    setTimeout("$('#dialogSuksesBatalPindah').dialog('close') ",1000);
                }
        }, "json");
    }
}
JS;
Yii::app()->clientScript->registerScript('jsBatalPindah',$jscript, CClientScript::POS_BEGIN);
?>

