<h6>Tabel 10 <b>Besar Penyakit</b></h6>
<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTableLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
    'id'=>'PPInfoKunjungan-v',
    'dataProvider'=>$data,
//    'filter'=>$model,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-condensed',
//    'mergeColumns' => array('instalasi_nama'),
    'columns'=>array(
        array(
            'header' => 'No',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
            'header'=>'Kode Diagnosa',
            'type'=>'raw',
            'value'=>'$data->diagnosa_kode',
        ),
        array(
            'header'=>'Nama Diagnosa',
            'type'=>'raw',
            'value'=>'$data->data',
        ),
        'jumlah',


        /*
        'ruangan_nama',
        'instalasi_id',
         * 'diagnosa_id',
        'instalasi_nama',*/
    ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

<?php //$this->widget('ext.bootstrap.widgets.BootGridView',array(
//	'id'=>'PPInfoKunjungan-v',
//	'dataProvider'=>$data,
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//            'no_rekam_medik',    
//            'NamaNamaBIN',
//            'jeniskasuspenyakit_nama',
//             array(
//               'name'=>'no_pendaftaran',
//               'type'=>'raw',
//               'value'=>'$data->no_pendaftaran',
//               'htmlOptions'=>array('style'=>'text-align: center; width:120px')
//            ),
//            'alamat_pasien',
//            'nama_pegawai',
//            array(
//               'name'=>'CaraBayar/Penjamin',
//               'type'=>'raw',
//               'value'=>'$data->CaraBayarPenjamin',
//               'htmlOptions'=>array('style'=>'text-align: center')
//            ),            
//            array(
//               'name'=>'ruangan_nama',
//               'type'=>'raw',
//               'value'=>'$data->ruangan_nama',
//               'htmlOptions'=>array('style'=>'text-align: center')
//            ),
//            array(
//               'name'=>'statusperiksa',
//               'type'=>'raw',
//               'value'=>'$data->statusperiksa',
//               'htmlOptions'=>array('style'=>'text-align: center')
//            ),
//	),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//)); ?>