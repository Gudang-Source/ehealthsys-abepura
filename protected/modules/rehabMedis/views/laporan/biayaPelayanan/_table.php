<?php
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
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
  
} else{
  $data = $model->searchTable();
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                    'header' => 'No',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
            ),
            array(
                'header' => 'Tanggal Pendaftaran/ <br/> No Pendaftaran',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br/> ".$data->no_pendaftaran'
            ),
            array(
                'header' => 'No Rekam Medik',
                'value' => '$data->no_rekam_medik'
            ),            
            array(
                'header' => 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien'
            ),
            array(
                'header' => 'Jenis Kelamin/ <br/> Umur',
                'type'=>'raw',
                'value' => '$data->jeniskelamin."/ <br/>".$data->umur',
            ),            
           array(
                'header'=>'Jenis Kasus Penyakit',
                'value'=>'$data->jeniskasuspenyakit_nama',
            ),
            array(
                'header'=>'Nama Tindakan',
                'value'=>'$data->daftartindakan_nama',
            ),
//            'jeniskasuspenyakit_nama',
            array(
                'header'=>'Kelas Pelayanan',
                'value'=>'$data->kelaspelayanan_nama',
            ),
//            'kelaspelayanan_nama',
            array(
                'header'=>'Cara Bayar /<br> Penjamin',
                'type'=>'raw',
                'value'=>'$data->carabayarPenjamin',
            ),
//            'carabayarPenjamin',
            array(
                'header'=>'Iur Biaya',
                'value'=>'"Rp".number_format($data->iurbiaya,0,"",".")',
                'htmlOptions'=>array('style'=>'text-align:right;')
            ),
//            'iurbiaya',
            array(
                'header'=>'Total Biaya Pelayanan',
                'value'=>'"Rp".number_format($data->total,0,"",".")',
                'htmlOptions'=>array('style'=>'text-align:right;')
            ),
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>