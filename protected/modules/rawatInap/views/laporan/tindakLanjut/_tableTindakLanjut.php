<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
//            'instalasi_nama',
//            'carakeluar',
            array(
                'header'=>'Tindak Lanjut',
                'type'=>'raw',
                'value'=>'(empty($data->pasienpulang_id))?"PULANG":$data->carakeluar',
            ),
            array(
                'header' => 'Tanggal Pendaftaran/ <br/> No Pendaftaran',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran'
            ),   
            'no_rekam_medik',
            array(
                'header'=>'Nama Pasien',
                'value'=>'$data->namadepan." ".$data->nama_pasien',
            ),
            array(
                'header' => 'Jenis Kelamin/ <br/> Umur',
                'type' => 'raw',
                'value' => '$data->jeniskelamin."/ <br/>".$data->umur'
            ),            
            array(
                'header'=>'Alamat Lengkap',
                'value'=>'$data->AlamatLengkap',
            ),
            'kelaspelayanan_nama',
          /*  array(
              'header'=>'Ruangan',
              'type'=>'raw',
              'value'=>'$data->ruangan_nama',
            ),*/
//            array(
//              'header'=>'No. Masuk Kamar',
//              'type'=>'raw',
//              'value'=>'$data->NomasukKamar',
//            ),
//            'nomasukkamar',
//            array(
//                   'header'=>'CaraBayar/Penjamin',
//                   'type'=>'raw',
//                   'value'=>'$data->CaraBayarPenjamin',
//                   'htmlOptions'=>array('style'=>'text-align: center')
//            ),
            'kunjungan',
             array(
                'header'=>'Nama Diagnosa',
                'type'=>'raw',
                //'value'=>'(!empty($data->diagnosa_nama))?$data->diagnosa_nama:""',
              'value' => '$this->grid->getOwner()->renderPartial("tindakLanjut/_listDiagnosa",array("pendaftaran_id"=>$data->pendaftaran_id),true)'
            ),
            
//            'kelurahan_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>