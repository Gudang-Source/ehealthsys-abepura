<?php 
    $itemCssClass = 'table table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
//            'instalasi_nama',
            array(
              'name' =>'tglmasukpenunjang',
              'value'=>'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)',
            ),
            'no_pendaftaran',
            'no_rekam_medik',
            array(
                'header' => 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien'
            ),            
            'umur',
          //  'jeniskelamin',
            array(
                'header'=>'Ruangan Penunjang',
                'value'=>'$data->ruanganpenunj_nama',
            ),
//            'ruanganpenunj_nama',
//            'catatan_dokter_konsul',
            'statusperiksa',
//            array(
//                   'header'=>'CaraBayar/Penjamin',
//                   'type'=>'raw',
//                   'value'=>'$data->CaraBayarPenjamin',
//                   'htmlOptions'=>array('style'=>'text-align: center')
//            ),  
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>