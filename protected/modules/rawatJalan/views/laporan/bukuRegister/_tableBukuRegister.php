<?php 
     $itemCssClass = 'table table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
	$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
		$row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
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
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		array(
			'header' => 'No',
			'value' => $row,
		),
//            'instalasi_nama',
            'no_pendaftaran',
            'no_rekam_medik',
            // 'NamaNamaBIN',
            array(
                   'header'=>'Nama Pasien',
                   'type'=>'raw',
                   //'value'=>'$data->NamaNamaBIN',
                    'value'=>'$data->namadepan." ".$data->nama_pasien',
            ),              
            'umur',
          //  'jeniskelamin',
            'nama_perujuk',
            array(
                   'header'=>'CaraBayar/Penjamin',
                   'type'=>'raw',
                   'value'=>'$data->CaraBayarPenjamin',
                   'htmlOptions'=>array('style'=>'text-align: center')
            ),  
            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>