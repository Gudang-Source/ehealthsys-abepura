
<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

//$this->widget('ext.bootstrap.widgets.BootGridView',array(
//	'id'=>'sajenis-kelas-m-grid',
//        'enableSorting'=>false,
//	'dataProvider'=>$model->searchPrint(),
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//		////'paketbmhp_id',
//		array(
//                        'header'=>'ID',
//                        'value'=>'$data->paketbmhp_id',
//                ),
//		'daftartindakan.daftartindakan_nama',
//		'tipepaket.tipepaket_nama',
//		'satuankecil.satuankecil_nama',
//		'obatalkes.obatalkes_nama',
//		'qtypemakaian',
//		'qtystokout',
//		'hargapemakaian',
//		'kelompokumur.kelompokumur_nama',
//        ),
//    )); 
?>

<?php // $modTipePaket = new SATipePaketM('search'); ?>
<?php 
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
//        array(
//            'header' => 'No',
//            'value' => '$row+1'
//        ),
//                'tipepaket_nama',
//        array(
//                     'header'=>'Nama Tindakan',
//                     'type'=>'raw',
//                     'value'=>'$this->grid->getOwner()->renderPartial(\"'.$this->path_view.'"_daftarTindakan\',array(\'tipepaket_id\'=>$data->tipepaket_id),true)',
//        ),
//        array(
//                     'header'=>'Nama Obat Alkes',
//                     'type'=>'raw',
//                     'value'=>'$this->grid->getOwner()->renderPartial(\"'.$this->path_view.'"_daftarObatAlkes\',array(\'tipepaket_id\'=>$data->tipepaket_id),true)',
//        ),
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
        array(
            'header'=>'No',
            'value' => '$row+1'
            ),
		array(
			'header'=>'Tipe Paket',
			'type'=>'raw',
			'value'=>'$data->tipepaket->tipepaket_nama',
			'filter'=>CHtml::activeDropdownList($model,'tipepaket_id',CHtml::listData(SATipePaketM::getItems(),'tipepaket_id','tipepaket_nama'),array('empty'=>'')),
		),
		array(
			'header'=>'Kelompok Umur',
			'type'=>'raw',
			'value'=>'isset($data->kelompokumur->kelompokumur_nama) ? $data->kelompokumur->kelompokumur_nama : "-"',
			'filter'=>CHtml::activeDropdownList($model,'kelompokumur_id',CHtml::listData(SAKelompokUmurM::getItems(),'kelompokumur_id','kelompokumur_nama'),array('empty'=>'')),
		),
		array(
			'header'=>'Daftar Tindakan',
			'type'=>'raw',
			'value'=>'isset($data->daftartindakan->daftartindakan_nama) ? $data->daftartindakan->daftartindakan_nama : "-"',
			'filter'=>CHtml::activeTextField($model,'daftartindakan_nama'),
		),
		array(
			'header'=>'Kode Obat / Alkes',
			'type'=>'raw',
			'value'=>'isset($data->obatalkes->obatalkes_kode) ? $data->obatalkes->obatalkes_kode : "-"',
			'filter'=>CHtml::activeTextField($model,'obatalkes_kode'),
		),
		array(
			'header'=>'Nama Obat / Alkes',
			'type'=>'raw',
			'value'=>'isset($data->obatalkes->obatalkes_nama) ? $data->obatalkes->obatalkes_nama : "-"',
			'filter'=>CHtml::activeTextField($model,'obatalkes_nama'),
		),
		array(
			'header'=>'Satuan Kecil',
			'type'=>'raw',
			'value'=>'isset($data->satuankecil->satuankecil_nama) ? $data->satuankecil->satuankecil_nama : "-"',
			'filter'=>CHtml::activeDropdownList($model,'satuankecil_id',CHtml::listData(SASatuankecilM::getItems(),'satuankecil_id','satuankecil_nama'),array('empty'=>'')),
		),
		array(
			'name'=>'qtypemakaian',
			'type'=>'raw',
			'value'=>'MyFormatter::formatNumberForPrint($data->qtypemakaian)',
			'filter'=>false,
		),
		array(
			'name'=>'hargapemakaian',
			'type'=>'raw',
			'value'=>'MyFormatter::formatNumberForPrint($data->hargapemakaian)',
			'filter'=>false,
		),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 