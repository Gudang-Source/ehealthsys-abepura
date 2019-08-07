<?php
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
  $row = '$row+1';
  $data = $model->searchLaporanPrint();
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
  
  echo "<style>
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
                    padding:0px;
                    border-spacing: 0px;
                    
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
  
            $itemCssClass = 'table border';
  
} else{
  $data = $model->searchLaporan();
}
?>
<?php $this->widget($table, array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
	'itemsCssClass'=> $itemCssClass,
	'template'=>$template,
	'columns'=>array(
		array(
			'header'=>'No.',
			'value' =>$row,
		),
		array(
			'header'=>'No. Implementasi',
			'value'=>'$data->no_implementasi',
			'type'=>'raw',
		),
		array(
			'header'=>'Tgl Implementasi',
			'value'=>'MyFormatter::formatDateTimeForUser($data->implementasiaskep_tgl)',
			'type'=>'raw',
		),
		array(
			'header'=>'No. Pendaftaran',
			'value'=>'$data->no_pendaftaran',
			'type'=>'raw',
		),
		array(
			'header'=>'Nama Pasien',
			'value'=>'$data->nama_pasien',
			'type'=>'raw',
		),
		array(
			'header'=>'Jenis Kelamin',
			'value'=>'$data->jeniskelamin',
			'type'=>'raw',
		),
		array(
			'header'=>'Nama Perawat',
			'value'=>'$data->nama_pegawai',
			'type'=>'raw',
		),
		array(
			'header'=>'Ruangan',
			'value'=>'$data->ruangan_nama',
			'type'=>'raw',
		),
		array(
			'header'=>'Kelas Pelayanan',
			'value'=>'$data->kelaspelayanan_nama',
			'type'=>'raw',
		),
		array(
			'header'=>'No. Kamar / No. Bed',
			'value'=>'$data->kamarruangan_nokamar . " / ".$data->kamarruangan_nobed',
			'type'=>'raw',
		),
	),
)); ?>