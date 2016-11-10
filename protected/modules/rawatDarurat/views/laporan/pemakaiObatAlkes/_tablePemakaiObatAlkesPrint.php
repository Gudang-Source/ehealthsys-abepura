<?php
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
   $data = $model->searchPrint();
   $template = "{items}";
   if ($caraPrint=='EXCEL') {
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
//    $data = $model->search();
}
$sort=true;
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                'header' => 'No',
                'value' => '$row+1'
            ),
           array(
                'header' => 'Tanggal Pemakaian',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemakaianobat)'
            ),
             array(
                'header' => 'No Pemakaian',
                'value' => '$data->nopemakaian_obat'
            ),
            array(
                'header' => 'Jenis',
                'value' => '$data->jenisobatalkes_nama'
            ),
            array(
                'header' => 'Kategori',
                'value' => '$data->obatalkes_kategori'
            ),
            array(
                'header' => 'Golongan',
                'value' => '$data->obatalkes_golongan'
            ),            
            array(
                'header' => 'Nama Obat Alkes',
                'value' => '$data->obatalkes_nama'
            ), 
            array(
                'header' => 'Jumlah Pemakaian',
                'value' => '$data->qty_satuanpakai." ".$data->satuankecil_nama',               
            ), 
            array(
                'header' => 'Harga Satuan',
                'value' => '"Rp".number_format($data->harga_satuanpakai,0,"",".")',                                                
                'htmlOptions' => array('style'=>'text-align:right;')
            ), 
            array(
                'header' => 'Sub Total harga',
                'value' => '"Rp".number_format(($data->harga_satuanpakai * $data->qty_satuanpakai),0,"",".")',                
                'htmlOptions' => array('style'=>'text-align:right;')
            ), 
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>