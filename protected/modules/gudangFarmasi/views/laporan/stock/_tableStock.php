<?php
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
    $row = '$row+1';
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
  $data = $model->search();
}
?>
<?php $this->widget($table, array(
	'id'=>'laporan-grid',
	'dataProvider'=>$data,
        'itemsCssClass'=>$itemCssClass,
        'template'=>$template,
       'mergeHeaders'=>array(
            array(
                'name'=>'<center>Jumlah</center>',
                'start'=>6, //indeks kolom 3
                'end'=>8, //indeks kolom 4
            ),
        ),
	'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' =>$row,
//                        'footer'=>'<b>Total:</b>',
                        'footerHtmlOptions'=>array('colspan'=>6, 'style'=>'text-align:right;'),
                        'type'=>'raw',
                         'htmlOptions'=>array(
                            'style'=>'text-align:right;padding-right:10%;'
                        ),
                    ),
                    array(
                        'header' => 'Jenis Obat',
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
                        'header'=>'Kode',
                        'value'=>'$data->obatalkes_kode',
                    ),
                    array(
                        'header'=>'Nama Obat Alkes',
                        'value'=>'$data->obatalkes_nama',
                    ),                    
                    array(
                        'name'=>'qty_in',
                        'type'=>'raw',
                        'header'=>'<center>Stok Masuk</center>',
                        'value'=>'number_format($data->qty_in,0,"",".")." ".$data->satuankecil_nama',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:center;'),
//                        'footer'=>'sum(qty_in)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
                    array(
                        'name'=>'qty_out',
                        'type'=>'raw',
                        'header'=>'<center>Stok Keluar</center>',
                        'value'=>'number_format($data->qty_out,0,"",".")." ".$data->satuankecil_nama',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:center;'),
//                        'footer'=>'sum(qty_out)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
                    array(
                        'name'=>'qty_current',
                        'type'=>'raw',
                        'header'=>'<center>Stok Akhir</center>',
                        'value'=>'number_format($data->qty_current,0,"",".")." ".$data->satuankecil_nama',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:center;width:100px;'),
//                        'footer'=>'sum(qty_current)',
                        
//                        'footer'=>number_format($model->totalqtystok_in),
                    ),
//                    array(
//                        'header'=>'Harga Jual',
//                        'value'=>'number_format($data->hargajual_oa)',
//                        'footer'=>number_format($model->totalhargajual),
//                    ),
//                    array(
////                        'header'=>'Total Harga',
////                        'value'=>'number_format($data->hargajual_oa * $data->qty)',
////                        'footer'=>number_format($model->totalharga),
//                        'name'=>'totalharga',
//                        'type'=>'raw',
//                        'header'=>'Total Harga',
//                        'value'=>'number_format($data->hargajual_oa * $data->qty)',
//                        'htmlOptions'=>array('style'=>'text-align:right;'),
//                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                        'footer'=>'sum(totalharga)',
//                    ),
	),
)); ?>