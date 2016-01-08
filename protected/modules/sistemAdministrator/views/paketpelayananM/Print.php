<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

  // $table = 'ext.bootstrap.widgets.BootGridView';
  //   $sort = true;
    // if (isset($caraPrint)) {
    //     $data = $modelTipePaket->searchPrint();
    //     $template = "{items}";
    //     $sort = false;
    //     if ($caraPrint == "EXCEL")
    //         $table = 'ext.bootstrap.widgets.BootExcelGridView';
    // } else{
    //      $data = $model->search();
    //      $template = "{summary}\n{items}\n{pager}";
    // }
    
//$this->widget('ext.bootstrap.widgets.BootGridView',array(
//	'id'=>'sajenis-kelas-m-grid',
//        'enableSorting'=>false,
//	'dataProvider'=>$model->searchPrint(),
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//		////'paketpelayanan_id',
//		array(
//                        'header'=>'ID',
//                        'value'=>'$data->paketpelayanan_id',
//                ),
//		'daftartindakan.daftartindakan_nama',
//		'tipepaket.tipepaket_nama',
//		'ruangan.ruangan_nama',
//		'namatindakan',
//		'subsidiasuransi',
//		/*
//		'subsidipemerintah',
//		'subsidirumahsakit',
//		'iurbiaya',
//		*/
// 
//        ),
//    )); 
?>
<?php $modTipePaket = new SATipePaketM('search'); 
	if(isset($_GET['SAPaketpelayananM'])){
		$modTipePaket->tipepaket_nama=$_GET['SAPaketpelayananM']['tipepaketNama'];
	}
?>
<?php 
      $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $modTipePaket->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $modTipePaket->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    
    $this->widget($table,array( 
    'id'=>'satipe-paket-m-grid', 
    'dataProvider'=>$data, 
    'enableSorting'=>$sort,
    //'filter'=>$modTipePaket, 
    'template'=>$template, 
    'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        ////'tipepaket_id',
//        array( 
//                        'name'=>'tipepaket_id', 
//                        'value'=>'$data->tipepaket_id', 
//                        'filter'=>false, 
//                ),
//        'kelaspelayanan_id',
//        'penjamin_id',
//        'carabayar_id',
        array(
            'header' => 'No',
            'value' => '$row+1'
        ),
                'tipepaket_nama',
        array(
                     'header'=>'Nama Tindakan',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\'sistemAdministrator.views.paketpelayananM._daftarTindakan\',array(\'tipepaket_id\'=>$data->tipepaket_id),true)',
        ),
        //'tipepaket_singkatan',
        /*
        'tipepaket_namalainnya',
        'tglkesepakatantarif',
        'nokesepakatantarif',
        'tarifpaket',
        'paketsubsidiasuransi',
        'paketsubsidipemerintah',
        'paketsubsidirs',
        'paketiurbiaya',
        'nourut_tipepaket',
        'keterangan_tipepaket',
        'tipepaket_aktif',
        */        
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 