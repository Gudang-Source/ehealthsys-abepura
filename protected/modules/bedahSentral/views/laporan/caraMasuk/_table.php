<?php 
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
	$row = '$row+1';
    $sort = false;
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
//            'instalasi_nama',
            array(
                'header' => 'No.',
                'value' => $row
            ),
			array(
				'header' => 'Tanggal Pendaftaran',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
			),
			array(
				'header' => 'No Pendaftaran',
				'type' => 'raw',
				'value' => '$data->no_pendaftaran'
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
				'header' => 'Kelas Pelayanan',
				'value' => '$data->kelaspelayanan_nama'
			),
			array(
				'header' => 'Rujukan',
				'type' => 'raw',
				'value' => '$data->statusmasuk."/ <br/>".$data->asalrujukan_nama'
			),
			array(
				'header' => 'Jenis Kasus Penyakit',
				'value' => '$data->jeniskasuspenyakit_nama'
			),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>