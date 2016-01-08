
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>12));      

  $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'tipepaket_id',
		array(
                        'name'=>'carabayar_id',
                        'filter'=>  CHtml::listData(SAPendaftaranT::model()->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'),
                        'value'=>'$data->carabayar->carabayar_nama',
                ),
		array(
                        'name'=>'penjamin_id',
                        'filter'=>  CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = TRUE'), 'penjamin_id', 'penjamin_nama'),
                        'value'=>'$data->penjamin->penjamin_nama',
                ),
		array(
                        'name'=>'kelaspelayanan_id',
                        'filter'=>  CHtml::listData(SAPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                        'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                ),
		'tipepaket_nama',
		'tipepaket_singkatan',
//                'tarifpaket',
//		'tipepaket_nama',
//		'tipepaket_singkatan',
	
//		'tipepaket_namalainnya',
		'tglkesepakatantarif',
//		'nokesepakatantarif',
//		'tarifpaket',
                 array(
                    'header'=>'Tarif Paket',
                    'name'=>'tarifpaket',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->tarifpaket)',
                ),
                 array(
                    'header'=>'Paket Subsidi Asuransi',
                    'name'=>'paketsubsidiasuransi',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->paketsubsidiasuransi)',
                ),
//		'paketsubsidiasuransi',
                array(
                    'header'=>'Paket Subsidi Pemerintah',
                    'name'=>'paketsubsidipemerintah',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->paketsubsidipemerintah)',
                ),
//		'paketsubsidipemerintah',
                array(
                    'header'=>'Paket Subsidi RS',
                    'name'=>'paketsubsidirs',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->paketsubsidirs)',
                ),
//		'paketsubsidirs',
                 array(
                    'header'=>'Paket Iur Biaya',
                    'name'=>'paketiurbiaya',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->paketiurbiaya)',
                ),
//		'paketiurbiaya',
//		'nourut_tipepaket',
//		'keterangan_tipepaket',
//		'tipepaket_aktif',
		
 
        ),
    )); 
?>