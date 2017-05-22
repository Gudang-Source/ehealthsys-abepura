<?php 
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
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
            array(
                    'header' => 'No.',
					
                    'value' => $row
            ),
			array(
				'header' => 'Tanggal Pendaftaran/ <br/>No Pendaftaran',
				'type' => 'raw',
				'value' => 'MyFormatter::formatDateTimeFOrUser($data->tgl_pendaftaran)."/ <br/>".$data->no_pendaftaran'
			),
            'no_rekam_medik',
//            'NamaNamaBIN',
            array (
                'header' => 'Nama pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien',
            ),            
            'umur',           
            
//            'kelaspelayanan_nama',
//            'carabayarPenjamin',
            array(
                'header'=>'Cara Bayar/<br/> Penjamin',
				 'type'=>'raw',
                'value'=>'$data->carabayarPenjamin',
            ),
			array(
              'header'=>'Jenis Kasus Penyakit',
              'type'=>'raw',
              'value'=>'$data->jeniskasuspenyakit_nama',
            ),
//            'jeniskasuspenyakit_nama',
            array(
              'header'=>'Kelas Pelayanan',
              'type'=>'raw',
              'value'=>'$data->kelaspelayanan_nama',
				'footer' => '<b>Total</b>',
				'footerHtmlOptions' => array('style' => 'text-align:right;','colspan' => 8)
            ),
		
            array(
                'header'=>'Iur Biaya',
                'type'=>'raw',
				'name' => 'iurbiaya',
                'value'=>'"Rp".number_format($data->iurbiaya,0,"",".")',
                'htmlOptions' => array('style'=>'text-align:right;'),
				'footer' => 'sum(iurbiaya)',
				'footerHtmlOptions' => array('style' => 'text-align:right;')
            ),
            array(
                'header'=>'Biaya Pelayanan',
                'type'=>'raw',
				'name' => 'total',
                'value'=>'"Rp".number_format($data->total,0,"",".")',
                'htmlOptions' => array('style'=>'text-align:right;'),
				'footer' => 'sum(total)',
				'footerHtmlOptions' => array('style' => 'text-align:right;')
            ),
//            'iurbiaya',
//            'total',
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>