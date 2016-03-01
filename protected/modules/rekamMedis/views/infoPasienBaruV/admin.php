<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#rminfo-pasien-baru-v-search').submit(function(){
	$.fn.yiiGridView.update('rminfo-pasien-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Baru</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Pasien Baru</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
            'id'=>'rminfo-pasien-v-grid',
            'dataProvider'=>$model->searchDataPasien(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'mergeHeaders'=>array(
                array(
                    'name'=>'<center>Ubah</center>',
                    'start'=>8, //indeks kolom 3
                    'end'=>9, //indeks kolom 4
                ),
            ),
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
    //		'pasien_id',
    //		'jenisidentitas',
    //		'no_identitas_pasien',
    //		'namadepan',
    //		'nama_pasien',
    //		'nama_bin',


                    array(
                        'header'=>'Instalasi / Tanggal Pendaftaran',
                        'type'=>'raw',
                        'value'=>'"$data->instalasi_nama"." / ".MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                    ),
                    array(
                        'header'=>'Ruangan / Poliklinik',
                        'type'=>'raw',
                        'value'=>'((!empty($data->ruangan_nama)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? CHtml::link("<i class=icon-form-ubah></i> ".$data->ruangan_nama,"javascript:gantiPoli(\'$data->pendaftaran_id\',\'$data->ruangan_id\',\'$data->instalasi_id\',\'$data->pasien_id\',\'$data->nama_pasien\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Poliklinik")) : $data->ruangan_nama) ',
                        'htmlOptions'=>array('style'=>'text-align: center')
                    ),
                    array(
                        'header'=>'No. Rekam Medik / No. Pendaftaran',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return Chtml::link('<i class="icon-form-input"></i>'.$data->no_rekam_medik, Yii::app()->createUrl('rekamMedis/pembuatanDokumenRK/create', array('pasien_id'=>$data->pasien_id, 'tipe'=>3)), array("rel"=>"tooltip","title"=>"Klik untuk Pencatatan Berkas RM Pasien Baru", "target"=>"_blank"))
                                    ." / ".(!empty($data->no_pendaftaran) ? CHtml::link("<i class=icon-form-print></i> ".$data->no_pendaftaran, "javascript:print(\'$data->pendaftaran_id\');",array("rel"=>"tooltip","title"=>"Klik Untuk Print Lembar Poli")) : "-");
                        },
                   'htmlOptions'=>array('style'=>'text-align: center; width:120px')
                    ),
                    array(
                        'header'=>'Nama Pasien / Alias',
                        'type'=>'raw',
                        'value'=>'CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien"))." ".CHtml::link($data->nama_pasien, Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien"))',
                    ),
                    array(
                        'header'=>'Jenis Kelamin / Umur',
                        'type'=>'raw',
                        'value'=>'"$data->jeniskelamin"." / "."$data->umur"',
                    ),
                    array(
                        'header'=>'Alamat',
                        'type'=>'raw',
                        'value'=>'"$data->alamat_pasien"." / "."$data->rt"."/"."$data->rw"',
                    ),
                    array(
                        'header'=>'Cara Bayar / Penjamin',
                        'type'=>'raw',
                        'value'=>'((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? CHtml::link("<i class=icon-form-ubah></i> ".$data->CaraBayarPenjamin," ",array("onclick"=>"ubahCaraBayar(\'$data->pendaftaran_id\',\'$data->nama_pasien\');$(\'#carabayardialog\').dialog(\'open\');return false;",
                                                                                                                                             "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Cara Bayar & Penjamin pasien")) : $data->CaraBayarPenjamin) ',
                    ),
                    array(
                        'header'=>'Kelas Pelayanan',
                        'type'=>'raw',
                        'value'=>'"$data->kelaspelayanan_nama"',
                    ),
                    array(
                            'header'=>'Penanggung Jawab',
                            'type'=>'raw',
                            'value'=>'(!empty($data->penanggungjawab_id) ? CHtml::link($data->pj->nama_pj, Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPenanggungJawab",array("id"=>"$data->penanggungjawab_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data penanggung jawab"))." ".CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPenanggungJawab",array("id"=>"$data->penanggungjawab_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data penanggung jawab")) : CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPenanggungJawab", array("pendaftaran_id"=>$data->pendaftaran_id)), array("rel"=>"tooltip","title"=>"Klik untuk menambah data penanggung jawab"))) ',
                        ),
                    array(
                        'header'=>'Rujukan',
                        'type'=>'raw',
                        'value'=>'(!empty($data->asalrujukan_id) ? CHtml::link($data->asalrujukan->asalrujukan_nama, Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahRujukan",array("id"=>"$data->asalrujukan_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data rujukan"))." ".CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahRujukan",array("id"=>"$data->asalrujukan_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data Rujukan")) : "-") ',
                    ),


            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php $this->renderPartial('_search',array('model'=>$model)); ?>
</div>

    
<?php
    
//========================================= Cara Bayar dialog =============================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'carabayardialog',
    'options'=>array(
        'title'=>'Ganti Cara Bayar dan Penjamin - <span id="titleNamaPasienCaraBayar"></span>',
        'autoOpen'=>false,
        'minWidth'=>480,
        'modal'=>true,
        'resizable'=>false,
        //'hide'=>explode,
    ),
));
echo '<div class="divForFormUbahCaraBayar"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========================================================= end cara bayar dialog =========


//=============================== Ganti Poli Dialog =======================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'ganti_poli',
    'options'=>array(
        'title'=>'Ganti Ruangan Pasien - <span id="titleNamaPasien"></span>',
        'autoOpen'=>false,
        'minWidth'=>400,
        'modal'=>true,
    ),
));
?>
<table>
    <tr>
        <td>Poliklinik</td>
        <td>:</td>
        <td>
            <?php echo CHtml::dropDownList('ruangan_sebelumnya','', array(),array('disabled'=>true));?>
            <?php echo CHtml::hiddenField('ruangan_awal','',array('readonly'=>true));?>
        </td>
    </tr>
    <tr>
        <td>Alasan Perubahan <span class="required">*</span></td>
        <td>:</td>
        <td><?php echo CHtml::textArea('alasanperubahan','', array());?></td>
    </tr>
    <tr>
        <td>Menjadi Poliklinik</td>
        <td>:</td>
        <td><?php echo CHtml::dropDownList('ruangan_id_ganti','ruangan_id_ganti', array(),array('empty'=>'--pilih--',));?></td>
    </tr>
</table>


<?php

echo CHtml::hiddenField('pendaftaran_id');
echo CHtml::hiddenField('pasien_id');
echo CHtml::htmlButton(Yii::t('mds','{icon} Ya',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'simpanRuanganBaru();'));
echo '&nbsp;&nbsp;&nbsp;'.CHtml::htmlButton(Yii::t('mds','{icon} Batal',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                array('class'=>'btn btn-danger', 'type'=>'button','onclick'=>'$(\'#ganti_poli\').dialog(\'close\');'));
												

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php $this->renderPartial("_jsFunctions"); ?>

