<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    $isprint = false;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        $isprint = true;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{pager}{summary}\n{items}";
    }
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
//    'filter'=>$model,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
       'mergeColumns' => array('instalasi_nama', 'ruangan_nama', 'dokter_nama'),
    'columns'=>array(
        array(
          'header'=>'No',
          'value'=>$isprint?'$row':'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
          'type'=>'raw',
        ),
        array(
            'header'=>'Dokter',
            'type'=>'raw',
            'name'=>'dokter_nama',
            'value'=>function($data) {
                $p = PegawaiM::model()->findByAttributes(array('nama_pegawai'=>$data->dokter_nama));
                return $p->namaLengkap;
            }
        ),
          array(
          'header'=>'Status',
          'value'=>'$data->statusdokter',
          'type'=>'raw',
        ),
       
        array(
          'header'=>'No Rekam Medis',
          'value'=>'$data->no_rekam_medik',
          'type'=>'raw',
        ),
        array(
          'header'=>'Nama Pasien',
          'value'=>'$data->nama_pasien',
          'type'=>'raw',
        ),
        array(
          'header'=>'Tgl Tindakan',
          'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_tindakan)',
          'type'=>'raw',
        ),
       
          array(
          'header'=>'Instalasi',
          'value'=>'$data->instalasi_nama',
          'type'=>'raw',
        ),
        array(
          'header'=>'Ruangan',
          'value'=>'$data->ruangan_nama',
          'type'=>'raw',
        ),
         array(
          'header'=>'Jenis Pelayanan',
          'value'=>'$data->daftartindakan_nama',
          'type'=>'raw',
        ),
        array(
          'header'=>'Tarif',
          'value'=>'MyFormatter::formatNumberForPrint($data->tarif_tindakan)',
          'type'=>'raw',
          'htmlOptions'=>array(
              'style'=>'text-align: right',
          ),
        ),
//          array(
//            'header'=>'<center>Harga</center>',
//            'name'=>'tarif_satuan',
//            'type'=>'raw',
//            'value'=>'MyFunction::formatNumber($data->tarif_satuan)',
//            'htmlOptions'=>array('style'=>'text-align:right'),
//            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//            'footer'=>'sum(tarif_satuan)',
//        ),
      
        array(
          'header'=>'Penjamin',
          'value'=>'$data->penjamin_nama',
          'type'=>'raw',
        ),
    ),
       'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 
