<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'htmlOptions'=>array(
            'style'=>'font-size',
            
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'No. Bukti <br> Bayar',
                    'type'=>'raw',
                    'value'=>'$data->nobuktibayar',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),

                ),
                array(
                    'header'=>'Tanggal <br> Bukti Bayar',
                    'type'=>'raw',
                    'value'=>'date("d/m/Y H:i:s",strtotime($data->tglbuktibayar))',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Cara <br> Pembayaran',
                    'type'=>'raw',
                    'value'=>'$data->carapembayaran',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Dari Nama BKM',
                    'value'=>'$data->darinama_bkm',
                ),
                 array(
                    'header'=>'Alamat BKM',
                    'value'=>'$data->alamat_bkm',
                ),
                array(
                    'header'=>'Sebagai Pembayar BKM',
                    'value'=>'$data->sebagaipembayaran_bkm',
                ),
                array(
                    'header'=>'Jumlah Pembulatan',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'value'=>'number_format($data->jmlpembulatan,0,"",".")',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Biaya Administrasi',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'value'=>'"Rp. ".number_format($data->biayaadministrasi,0,"",".")',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Biaya Materai',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'value'=>'"Rp. ".number_format($data->biayamaterai,0,"",".")',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Jumlah Pembayaran',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'value'=>'"Rp. ".number_format($data->jmlpembayaran,0,"",".")',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Uang Diterima',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'value'=>'"Rp. ".number_format($data->uangditerima,0,"",".")',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Uang Kembalian',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'value'=>'"Rp. ".number_format($data->uangkembalian,0,"",".")',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
//                'jmlpembulatan',
//                'biayaadministrasi',
//                'biayamaterai',
//                'uangditerima',
//                'uangkembalian',
                array(
                    'header'=>'Ruangan Kasir',
                    'value'=>'$data->ruangan_nama',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Nama Shift',
                    'value'=>'$data->shift_nama',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>