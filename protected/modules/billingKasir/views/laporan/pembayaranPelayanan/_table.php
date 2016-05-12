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
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header'=>'Cara Bayar<br/>Penjamin',
                    'type'=>'raw',
                    'value'=>'$data->carabayar_nama.\'<br/>\'.$data->penjamin_nama',
                ),
                array(
                    'header'=>'No. Bukti Bayar<br/>Tanggal Bukti',
                    'type'=>'raw',
                    'value'=>'$data->nobuktibayar.\'<br/>\'.date("d/m/Y H:i:s",strtotime($data->tglbuktibayar))',
                ),
                array(
                    'header'=>'No. Pembayaran',//<br/>Tgl. Pembayaran
                    'type'=>'raw',
                    'value'=>'$data->nopembayaran',//.\'<br/>\'.$data->tglpembayaran
                ),
                array(
                    'header'=>'No. Rekam Medik<br/>No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik.\'<br/>\'.$data->no_pendaftaran',
                ),
                'nama_pasien',
//                array(
//                    'header'=>'Total Biaya Obat Alkes',
//                    'name'=>'totalbiayaoa',
//                    'type'=>'raw',
//                    'htmlOptions'=>array('style'=>'text-align:right;'),
//                    'value'=>'"Rp. ".number_format($data->totalbiayaoa)',
//                ),
                array(
                    'header'=>'Biaya Pelayanan',
                    'name'=>'totalbiayapelayanan',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'value'=>'MyFormatter::formatUang($data->totalbiayapelayanan)',
                ),
//                array(
//                    'header'=>'Uang Muka',
//                    //'name'=>'totalbiayapelayanan',
//                    'type'=>'raw',
//                    'htmlOptions'=>array('style'=>'text-align:right;'),
//                    'value'=>'"Rp. ".number_format(0)',
//                ),
                
                array(
                    'header'=>'Subsidi Asuransi',
                    'name'=>'totalsubsidiasuransi',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'value'=>'MyFormatter::formatUang($data->totalsubsidiasuransi)',
                ),
                array(
                    'header'=>'Subsidi Pemerintah',
                    'name'=>'totalsubsidipemerintah',
                    'type'=>'raw',
                    'value'=>'"Rp. ".number_format($data->totalsubsidipemerintah)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Subsidi RS',
                    'name'=>'totalsubsidirs',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->totalsubsidirs)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Iur Biaya',
                    'name'=>'totaliurbiaya',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->totaliurbiaya)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Total Pembebasan',
                    'name'=>'totalpembebasan',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->totalpembebasan)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Jumlah Bayar',
                    'name'=>'totalbayartindakan',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->totalbayartindakan)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                'statusbayar',
                ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>