<div class="white-container">
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#formSearch').submit(function(){
	$.fn.yiiGridView.update('ppinfokontrolpasien-grid', {
		data: $(this).serialize()
	});
    return false;
});
");
?>
<style type="text/css">
input[readonly]{
    background-color: #F5F5F5;
    border-color: #DDDDDD;
    cursor: auto;
}
</style>
    <legend class="rim2">Informasi <b>Rencana Kontrol</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Rencana Kontrol</b></h6>
        <div class="table-responsive">   
            <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'ppinfokontrolpasien-grid',
                    'dataProvider'=>$model->searchKontrolPasien(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(
            //			'tglrenkontrol',
                        array(
                            'header'=>'Tgl Rencana Kontrol',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglrenkontrol)',
                        ),
                        array(
                            'header'=>'Tgl Pendaftaran/<br>No Pendaftaran',
            //                'name'=>'Tgl. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran',
                        ),
                        array(
                            'header'=>'No Rekam Medik',
            //                'name'=>'No. Pendaftaran <br> No. Rekam Kedik',
                            'type'=>'raw',
                            'value'=>'$data->pasien->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'name'=>'nama_pasien',
                            'type'=>'raw',
                            'value'=>'isset($data->pasien->namadepan)?$data->pasien->namadepan." ".$data->pasien->nama_pasien:" ".$data->pasien->nama_pasien',
                        ),
                        array(
                            'header'=>'Alamat',
                           // 'name'=>'pasien.alamat_pasien',
                            'type'=>'raw',
                            'value'=>'$data->pasien->alamat_pasien',
                        ),
                        array(
                            'header'=>'No Telepon/<br>No HP',
            //                'name'=>'No. Telp <br> No. HP',
                            'type'=>'raw',
                            'value'=>'$data->pasien->no_telepon_pasien."/<br>".$data->pasien->no_mobile_pasien',
                        ),
                       /* array(
                            'name'=>'Alamat Email',
                            'type'=>'raw',
                            'value'=>'$data->pasien->alamatemail',
                        ),*/
                        array(
                            'name'=>'Instalasi',
                            'type'=>'raw',
                            'value'=>'$data->instalasi->instalasi_nama',
                        ),
                        array(
                            'name'=>'Ruangan',
                            'type'=>'raw',
                            'value'=>'$data->ruangan->ruangan_nama',
                        ),
                        array(
                            'header'=>'Daftar Rawat <br/> Jalan',
                            'type'=>'raw',
                            'value'=>'CHtml::link("<i class=\'icon-form-rj\'></i> ", 
                                "index.php?r=pendaftaranPenjadwalan/PendaftaranRawatJalan/index&pasien_id=$data->pasien_id",array("id"=>"$data->pasien_id",
                                    "title"=>"Klik Untuk Mendaftarkan ke Rawat Jalan","rel"=>"tooltip"))',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                     /*   array(
                            'header'=>'Daftar Rawat <br/> Darurat',
                            'type'=>'raw',
                            'value'=>'CHtml::link("<i class=\'icon-form-rd\'></i> ", 
                                "index.php?r=pendaftaranPenjadwalan/PendaftaranRawatDarurat/index&pasien_id=$data->pasien_id",array("id"=>"$data->pasien_id",
                                    "title"=>"Klik Untuk Mendaftarkan ke Rawat Darurat","rel"=>"tooltip"))',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),*/
                    ),
                    'afterAjaxUpdate'=>'function(id, data){
                            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                    }',
            )); ?>
        </div>
    </div>
    <fieldset class="search-form box">
    <?php
    $this->renderPartial('_search',
        array(
            'model'=>$model,'format'=>$format
        )
    );
    ?> 
    <!-- search-form -->
    </fieldset>
</div>