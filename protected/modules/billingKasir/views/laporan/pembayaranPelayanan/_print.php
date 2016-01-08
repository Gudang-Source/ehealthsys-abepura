<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>14));

if ($caraPrint != 'GRAFIK'){
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$dataProv = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $dataProv = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$dataProv,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
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
                    'header'=>'No. Pembayaran<br/>Tgl. Pembayaran',
                    'type'=>'raw',
                    'value'=>'$data->nopembayaran.\'<br/>\'.date("d/m/Y H:i:s",strtotime($data->tglpembayaran))',
                ),
                array(
                    'header'=>'No. Rekam Medik<br/>No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik.\'<br/>\'.$data->no_pendaftaran',
                    'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Jumlah Total',
                ),
                'nama_pasien',
                array(
                    'name'=>'totalbiayaoa',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'value'=>'"Rp. ".number_format($data->totalbiayaoa)',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(totalbiayaoa)',
                ),
                array(
                    'name'=>'totalbiayapelayanan',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'value'=>'"Rp. ".number_format($data->totalbiayapelayanan)',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(totalbiayapelayanan)',
                ),
                
                array(
                    'name'=>'totalsubsidiasuransi',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'value'=>'"Rp. ".number_format($data->totalsubsidiasuransi)',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(totalsubsidiasuransi)',
                ),
                // array(
                //     'name'=>'totalsubsidipemerintah',
                //     'type'=>'raw',
                //     'value'=>'"Rp. ".number_format($data->totalsubsidipemerintah)',
                //     'htmlOptions'=>array('style'=>'text-align:right;'),
                //     'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                //     'footer'=>'sum(totalsubsidipemerintah)',
                // ),
                array(
                    'name'=>'totalsubsidirs',
                    'type'=>'raw',
                    'value'=>'"Rp. ".number_format($data->totalsubsidirs)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(totalsubsidirs)',
                ),
                array(
                    'name'=>'totaliurbiaya',
                    'type'=>'raw',
                    'value'=>'"Rp. ".number_format($data->totaliurbiaya)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(totaliurbiaya)',
                ),
                array(
                    'name'=>'totalpembebasan',
                    'type'=>'raw',
                    'value'=>'"Rp. ".number_format($data->totalpembebasan)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(totalpembebasan)',
                ),
                array(
                    'name'=>'totalbayartindakan',
                    'type'=>'raw',
                    'value'=>'"Rp. ".number_format($data->totalbayartindakan)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(totalbayartindakan)',
                ),
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
    
}

if ($caraPrint == 'GRAFIK')
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 


?>
<table width="100%" style='margin-top:100px;margin-left:auto;margin-right:auto;'>
    <tr>
        <td width="50%">
                <label style='float:left;'>Petugas : <?php echo $data['nama_pegawai']; ?></label>

        </td>
        <td width="50%">
            
<!--                <label style='float:right;'>Tanggal Print : <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></label>-->
            
        </td>
    </tr>
</table>
