<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>10));
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
	'id'=>'laporanclosingkasir-m-grid',
	'dataProvider'=>$dataProv,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Penerimaan</center>',
                'start'=>4, 
                'end'=>5, 
            ),
            array(
                'name'=>'<center>Banyaknya</center>',
                'start'=>9, 
                'end'=>11, 
            ),
        ),
	'columns'=>array(
                 array(
                    'header'=>'Tanggal Closing Kasir',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglclosingkasir)',
                ),
                array(
                    //'name'=>'closingdari',
                    'header'=>'Closing Dari <br>Sampai Dengan',
                    'type'=>'raw',
                    'value'=>'date("H:i:s",strtotime($data->closingdari))." <br>s/d ".date("H:i:s",strtotime($data->sampaidengan))',
                    
                ),
//                'nama_pegawai',
//                'shift_nama',
                array(
                   // 'name'=>'closingsaldoawal',
                    'header' => 'Saldo Awal',
                    'type'=>'raw',
                    'value'=>'number_format($data->closingsaldoawal,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                  //  'name'=>'terimauangmuka',
                    'header' => 'Uang Muka',
                    'type'=>'raw',
                    'value'=>'number_format($data->terimauangmuka,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    //'name'=>'terimauangpelayanan',
                    'header' => 'Uang Pelayanan',
                    'type'=>'raw',
                    'value'=>'number_format($data->terimauangpelayanan,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    //'name'=>'totalpengeluaran',
                    'header' => 'Total Pengeluaran',
                    'type'=>'raw',
                    'value'=>'number_format($data->totalpengeluaran,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    //'name'=>'nilaiclosingtrans',
                    'header' => 'Jumlah Closing',
                    'type'=>'raw',
                    'value'=>'number_format($data->nilaiclosingtrans,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    //'name'=>'totalsetoran',
                    'header' => 'Total Setoran',
                    'type'=>'raw',
                    'value'=>'number_format($data->totalsetoran,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                   // 'name'=>'jmltransaksi',
                    'header' => 'Transaksi',
                    'type'=>'raw',
                    'value'=>'number_format($data->jmltransaksi,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                   // 'name'=>'jmluanglogam',
                    'header' => 'Uang Logam',
                    'type'=>'raw',
                    'value'=>'number_format($data->jmluanglogam,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    //'name'=>'jmluangkertas',
                    'header' => 'Uang Kertas',
                    'type'=>'raw',
                    'value'=>'number_format($data->jmluangkertas,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                   // 'name'=>'piutang',
                    'header' => 'Piutang',
                    'type'=>'raw',
                    'value'=>'number_format($data->piutang,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header' => 'Keterangan Closing',
                    'value' => '$data->keterangan_closing'
                ),
                //'keterangan_closing',
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
}
else if ($caraPrint == 'GRAFIK'){
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
}


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