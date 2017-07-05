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
            array(
                'header' => 'No',
                'value' => '$row+1'
            ),
			array(
				'header' => 'Tanggal Admisi',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tgladmisi)'
				
			),
            'no_rekam_medik',    
            array(
                'header'=>' Nama Pasien / Alias',
                'value'=>'$data->NamaNamaBIN',
            ),
            array(
				'header' => 'Umur/<br/> Jenis Kelamin',
				'type' => 'raw',
				'value' => '$data->umur."/ <br/>".$data->jeniskelamin'
			),  
            array(
               'header'=>'Alamat',
               'value'=>'$data->AlamatLengkap',
            ),
            'kelaspelayanan_nama',
           // 'nomasukkamar',
            array(
               'name'=>'CaraBayar / Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: center')
            ),
			array(
				'header' => 'Dokter Pemeriksa',
				'value' => '$data->dokterpj_gelardepan." ".$data->dokterpj_nama." ".$data->gelarpj_nama'
			),
            'kunjungan',
            'statuspasien',
            array(
                'header'=>'Diagnosa / Kelompok',
                'value'=>'$data->diagnosa',
            ),
			array(
				'header' => 'Dokter Konsul',
				'value' => '$data->dokterkonsul_gelardepan." ".$data->dokterkonsul_nama." ".$data->gelarkonsul_nama'
			),
			array(
				'header' => 'Tanggal Pulang',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tglpasienpulang)'
				
			),
			'nomasukkamar',
			array(
				'header' => 'Lama Rawat',
				'value' => '$data->lamarawat." ".$data->satuanlamarawat'
				
			),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>