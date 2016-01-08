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
                            'header'=>'Tgl. Rencana Kontrol',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglrenkontrol)',
                        ),
                        array(
                            'header'=>'No. Pendaftaran <br> No. Rekam Kedik',
            //                'name'=>'No. Pendaftaran <br> No. Rekam Kedik',
                            'type'=>'raw',
                            'value'=>'$data->no_pendaftaran. "<br>" .$data->pasien->no_rekam_medik',
                        ),
                        array(
                            'name'=>'nama_pasien',
                            'type'=>'raw',
                            'value'=>'$data->pasien->nama_pasien',
                        ),
                        array(
                            'header'=>'Alamat Pasien <br> RT / RW',
            //                'name'=>'Alamat Pasien <br> RT / RW',
                            'type'=>'raw',
                            'value'=>'$data->pasien->alamat_pasien."<br>RT. ".$data->pasien->rt." / ".$data->pasien->rw ',
                        ),
                        array(
                            'header'=>'No. Telepon <br> No. HP',
            //                'name'=>'No. Telp <br> No. HP',
                            'type'=>'raw',
                            'value'=>'$data->pasien->no_telepon_pasien."<br>". $data->pasien->no_mobile_pasien',
                        ),
                        array(
                            'name'=>'Alamat Email',
                            'type'=>'raw',
                            'value'=>'$data->pasien->alamatemail',
                        ),
                        array(
                            'name'=>'Instalasi / <br/>Ruangan',
                            'type'=>'raw',
                            'value'=>'$data->instalasi->instalasi_nama. " / <br>" .$data->ruangan->ruangan_nama',
                        ),
                        array(
                            'header'=>'Tgl. Pendaftaran',
            //                'name'=>'Tgl. Pendaftaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        ),
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