<?php 
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$row='$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
    $sort = false;
    $row='$row+1';
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL"){
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
  if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
  
        echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass = 'table border';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No.',
                'value' => $row
            ),
			array(
				'header' => 'Tanggal Pendaftaran/ <br/> No Pendaftaran',
				'type'=>'raw',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br/>".$data->no_pendaftaran'
			),			
			array(
                'header'=>'Tanggal Masuk Penunjang/<br/> No Masuk Penunjang',
                'type'=>'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."/<br/> ".$data->no_masukpenunjang'
            ),
            array(
                'header'=>'No Rekam Medik',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik',
            ),
            array(
                'header'=>'Nama Pasien',
                'type'=>'raw',
                'value'=>'$data->namadepan." ".$data->nama_pasien',
            ),       
			array(
				'header' => 'Tempat, Tanggal Lahir',
				'type' => 'raw',
				'value' => '$data->tempat_lahir.", ".MyFormatter::formatDateTimeForUser($data->tanggal_lahir)'
			),
            array(
                'header'=>'Jenis Kelamin/ <br/>Umur',
                'type'=>'raw',
                'value'=>'$data->jeniskelamin."/<br/>".$data->umur',
            ),
            array(
                'header'=>'Alamat',
                'type'=>'raw',
                'value'=>'$data->alamat_pasien',
            ),
            array(
                'header'=>'Instalasi Asal/<br/> Ruangan Asal',
                'type'=>'raw',
                'value'=>'$data->InstalasiRuangan',
            ),
            array(
               'header'=>'Cara Bayar/<br/>Penjamin',
               'type'=>'raw',
               'value'=>'$data->CaraBayarPenjamin',
               'htmlOptions'=>array('style'=>'text-align: left')
            ), 
			array(
				'header' => 'Diagnosa',
				'value' => '$data->diagnosa_nama'
			),			
			array(
				'header' => 'Dokter Operator',
				'value' => '$data->dokteroperator_glrdepan." ".$data->dokteroperator_nama." ".$data->dokteroperator_glrblkg'
			),
			array(
				'header' => 'Dokter Anastesi',
				'value' => '$data->dokteranastesi_glrdepan." ".$data->dokteranastesi_nama." ".$data->dokteranastesi_glrblkg'
			),
			array(
				'header' => 'Dokter Konsul',
				'value' => '$data->dokterkonsul_glrdepan." ".$data->dokterkonsul_nama." ".$data->dokterkonsul_glrblkg'
			),
			array(
				'header' => 'Tanggal Operasi',
				'value' => 'MyFormatter::formatDateTimeForUser($data->mulaioperasi)'
			),
			array(
				'header' => 'Tindakan',
				'value' => '$data->operasi_nama'
			),
		//array(
		//		'header'=>'Kunjungan',
		//		'name' => 'kunjungan'
		//	),
//            array(
//                'header'=>'Jenis Pemeriksaan',
//                'type'=>'raw',
//                'value'=>'$this->grid->getOwner()->renderPartial(\'sensus/_jenis\', array(\'id\'=>$data->pendaftaran_id))',
//            ),
//            array(
//                'header'=>'Nama Pemeriksaan',
//                'type'=>'raw',
//                'value'=>'$this->grid->getOwner()->renderPartial(\'sensus/_nama\', array(\'id\'=>$data->pendaftaran_id))',
//            ),
//               'pemeriksaanrad_jenis',
//               'pemeriksaanrad_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>